<?php

use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = '门店统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-buyer-create">
    <div class="box">
        <div class="box-body">
            <div class="box-header"><h3 class="box-title">本月业绩</h3></div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>理疗卡种类</th>
                    <?php
                    foreach ($data[0] as $cardInfo) {
                        echo '<th>' . $cardInfo['name'] . '</th>';
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>售出数量</td>
                    <?php
                    foreach ($data[0] as $cardInfo) {
                        echo '<td>' . $data[1]['count' . $cardInfo['id']] . '</td>';
                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card-buyer-create">
    <div class="box">
        <div class="box-body">
            <div class="box-header"><h3 class="box-title">员工本月业绩</h3></div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>理疗卡种类</th>
                    <?php
                    foreach ($data[0] as $cardInfo) {
                        echo '<th>' . $cardInfo['name'] . '</th>';
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data[3] as $employee) {
                    echo '<tr><td>' . $employee['username'] . '</td>';
                    foreach ($data[0] as $cardInfo) {
                        echo '<td>' . $data[4]['count' . $employee['id'] . '_' . $cardInfo['id']] . '</td>';
                    }
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card-buyer-create">
    <div class="box">
        <div class="box-body">
            <div class="box-header"><h3 class="box-title">全年业绩</h3></div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>理疗卡种类</th>
                    <?php
                    foreach ($data[0] as $cardInfo) {
                        echo '<th>' . $cardInfo['name'] . '</th>';
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>售出数量</td>
                    <?php
                    foreach ($data[0] as $cardInfo) {
                        echo '<td>' . $data[2]['count' . $cardInfo['id']] . '</td>';
                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
