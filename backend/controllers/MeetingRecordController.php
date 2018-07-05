<?php

namespace backend\controllers;

use Yii;
use backend\models\MeetingRecord;
use backend\models\MeetingRecordSearch;
use backend\models\MeetingRecordForm;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * MeetingRecordController implements the CRUD actions for MeetingRecord model.
 */
class MeetingRecordController extends Controller
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
        				'roles' => ['meetingRecord'],
        			]
        		],
        	],
        ];
    }

    /**
     * Lists all MeetingRecord models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MeetingRecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

//     /**
//      * Displays a single MeetingRecord model.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionView($id)
//     {
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
//     }

    /**
     * Creates a new MeetingRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MeetingRecordForm();

	    if ($model->load(Yii::$app->request->post())) {
	    	$model->file = UploadedFile::getInstance($model, 'file');
            $record = new MeetingRecord();
            $record->meeting_date = $model->meetingDate;
            $record->topic = $model->topic;
            $record->file_type = $model->fileType;
            $record->org_name = $model->file->baseName . "." . $model->file->extension;
            $record->file_path = $model->upload();
            if ($record->file_path != null && $record->save()) {
	            $model->sendMail($record);
	            return $this->redirect(['index']);
            }
	    }
	
	    return $this->render('create', [
	        'model' => $model,
	    ]);
    }
    
    /**
     * Download the meeting record file.
     * @return mixed
     */
    public function actionDownload($id)
    {
		$record = $this->findModel($id);
		Yii::$app->response->sendFile($record->file_path, $record->org_name);
    }

//     /**
//      * Updates an existing MeetingRecord model.
//      * If update is successful, the browser will be redirected to the 'view' page.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionUpdate($id)
//     {
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }
//     }

//     /**
//      * Deletes an existing MeetingRecord model.
//      * If deletion is successful, the browser will be redirected to the 'index' page.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionDelete($id)
//     {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

    /**
     * Finds the MeetingRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MeetingRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MeetingRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
