<?php
$this->title = '备忘日历';
?>

<?= \yii2fullcalendar\yii2fullcalendar::widget(array(
    'events'=> $events,
    'options' => [
        'lang' => 'zh-CN',
    ],
));