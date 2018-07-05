<?php

namespace backend\controllers;

use backend\models\AmendForm;
use backend\models\AmendRecord;
use backend\models\AmendRecordSearch;
use backend\models\MachineMaster;
use backend\models\MachinePart;
use backend\models\PartType;
use Yii;
use backend\models\Part;
use backend\models\PartSearch;
use yii\base\InvalidParamException;
use yii\base\InvalidValueException;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PartController implements the CRUD actions for Part model.
 */
class PartController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        	'access' => [
        		'class' => AccessControl::className(),
        		'rules' => [
        			[
        				'allow' => true,
        				'roles' => ['manageMachine'],
        			]
        		],
        	],
        ];
    }

    /**
     * Lists all Part models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Part model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new AmendRecordSearch();
        $searchModel->before_part_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $canFix = false;
        $model = $this->findModel($id);
        if ($model->status == Part::STATUS_NORMAL && MachinePart::findOne(['part_id' => $model->id]) != null) {
            $canFix = true;
        }
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'canFix' => $canFix,
        ]);
    }

    /**
     * Creates a new Part model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Part();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Part model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Part model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAmend()
    {
        $fromPart = true;
        $machineId = Yii::$app->request->get('machineId');
        if ($machineId == null) {
            $partId = $machineId = Yii::$app->request->get('partId');
            if ($partId == null) {
                throw new InvalidParamException('无效请求');
            }
            $machineId = MachinePart::findOne(['part_id' => $partId]);
        } else {
            $fromPart = false;
            $partId = AmendRecord::PART_OTHER;
        }

        $machine = MachineMaster::findOne($machineId);
        $machineSn = $machine->machine_sn;
        if ($machine == null) {
            throw new InvalidParamException('无效请求');
        }
        $partIds = ArrayHelper::getColumn(MachinePart::find()->select('part_id')->where(['machine_id' => $machineId])->asArray()->all(), 'part_id');
        $partOptions = [];
        foreach ($partIds as $id) {
            $part = Part::findOne($id);
            $type = PartType::findOne($part->part_type);
            $partOptions[$id] = $type->part_name . ' ' . $part->part_sn;
        }
        $partOptions[AmendRecord::PART_OTHER] = AmendRecord::PART_OTHER_NAME;
        $model = new AmendForm();
        $model->oldPartId = $partId;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->oldPartId  != AmendRecord::PART_OTHER) {
                $exist = MachinePart::findOne(['machine_id' => $machineId, 'part_id' => $model->oldPartId]);
                if ($exist == null) {
                    throw new InvalidValueException('Hack attend');
                }
            }
            $txn = Yii::$app->db->beginTransaction();
            $success = true;
            $record = new AmendRecord();
            $record->ament_type = $model->amendType;
            $record->comment = $model->comment;
            $record->before_part_id = $model->oldPartId;
            $record->machine_id = $machineId;
            if ($model->amendType == AmendRecord::TYPE_REPLACE) {
                $oldPart = Part::findOne($model->oldPartId);
                $oldPart->status = Part::STATUS_BROKEN;
                if ($oldPart->save()) {
                    $part = new Part();
                    $part->part_sn = $model->newPartSn;
                    $part->part_type = $oldPart->part_type;
                    $part->status = Part::STATUS_NORMAL;
                    if ($part->save()) {
                        MachinePart::deleteAll(['machine_id' => $machineId, 'part_id' => $model->oldPartId]);
                        $rel = new MachinePart();
                        $rel->machine_id = $machineId;
                        $rel->part_id = $part->id;
                        $rel->part_type_id = $part->part_type;
                        if ($rel->save()) {
                            $record->after_part_id = $part->id;
                            if (!$record->save()) {
                                $success = false;
                            }
                        } else {
                            $success = false;
                        }
                    } else {
                        $success = false;
                    }
                } else {
                    $success = false;
                }
            } else {
                if (!$record->save()) {
                    $success = false;
                }
            }
            if ($success) {
                $txn->commit();
                Yii::$app->session->setFlash('success', '成功添加维修记录');
                if ($fromPart) {
                    return $this->redirect(['index']);
                } else {
                    return $this->redirect(['/machine/index']);
                }
            } else {
                $txn->rollBack();
                Yii::$app->session->setFlash('error', '保存维修记录失败，请联系管理员');
            }
        }

        return $this->render('amend', [
            'model' => $model,
            'fromPart' => $fromPart,
            'partOptions' => $partOptions,
            'machineSn' => $machineSn,
        ]);
    }

    /**
     * Finds the Part model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Part the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Part::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
