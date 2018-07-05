<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = '模拟测试';
?>
<div class="site-index">

<div class="container">
	<div class="row">
		<?= Html::a('完全填充下一级', ['push-fully'], ['class' => 'btn btn-success']) ?>
		<?= Html::a('随机填充下一级', ['push-random'], ['class' => 'btn btn-success']) ?>
		<?= Html::a('重置测试', ['reset-test'], ['class' => 'btn btn-danger']) ?>
		<?= Html::a('查看团队', ['show-team'], ['class' => 'btn btn-default']) ?>
	</div>
</div>
<br>
    <div class="box">
    	<div class="box-body">
	<table class="table table-bordered">
	  <thead>
	    <tr>
	      <th>最高等级</th>
	      <th>客户数</th>
	      <th>销售额（不含立返）</th>
	      <th>成本总额</th>
	      <th>提成总额</th>
	      <th>总差额</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <td><?=$level ?></td>
	      <td><?=$userCount ?></td>
	      <td><?=$sellAmount ?></td>
	      <td><?=$costAmount ?></td>
	      <td><?=$bonusAmount ?></td>
	      <td><?=$diffAmount ?></td>
	    </tr>
	  </tbody>
	</table>
	</div></div>
</div>
