<?php


use kartik\grid\GridView;
use backend\assets\IonIconsAsset;

/* @var $this yii\web\View */
/* @var $leftUser common\models\User */
/* @var $rightUser common\models\User */

IonIconsAsset::register($this);
$this->title = '我的收益';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="customer-index">
	<section class="content">
		<div class="row">
			<div class="col-lg-6 col-sm-12">
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?=\Yii::$app->user->identity->total_bonus ?></h3>

						<p>历史总收益</p>
					</div>
					<div class="icon">
						<i class="ion ion-social-yen"></i>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-sm-12">
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?=\Yii::$app->user->identity->available_bonus ?></h3>

						<p>当前可用收益</p>
					</div>
					<div class="icon">
						<i class="ion ion-social-yen"></i>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>
