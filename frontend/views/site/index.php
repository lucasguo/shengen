<?php
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = '厦门市圣恩医疗科技有限公司';

$asset = \frontend\assets\ZerothAsset::register($this);
$assetPath = $asset->baseUrl;
?>


<div class="body3">
    <div class="main zerogrid">
        <!-- content -->
        <article id="content">
            <div class="wrapper row">
                <section class="col-3-4">
                    <div class="wrap-col">
                        <h2 class="under">肝康保(BILT治疗仪)</h2>
                        <div class="wrapper">
                            <p>
                                采用BILT专利技术开发的新一代理疗设备，荣获国家多项发明专利，被列入国家中医药管理局中医诊疗设备推荐名单，设备应用<b>脉动生物信息技术</b>（与人体心脏搏动节律同步），提取使用者的心率信号，发出与使用者心率节律相同的脉动近红外线、红光共振光谱照射人体体表部位（穴位），增加组织对能量的渗透吸收。产品应用安全、操作简单、易掌握等特点，既融入了中医特色疗法又符合使用的方便性。有效减少用药，控制治疗成本，降低药物对身体的副作用，提高身体免疫力，是目前慢性病康复的理想方法。
                            </p>
                        </div>
                    </div>
                </section>
                <section class="col-1-4">
                    <div class="wrap-col">
                        <img src="css/images/intro.png"/>
                    </div>
                </section>
            </div>
            <div class="wrapper row">
                <section class="col-1-3">
                    <div class="wrap-col">
                        <h3><span class="dropcap">A</span>学术新闻<span>&nbsp;</span></h3>
                        <p class="pad_bot1">第六届《全国肝脏疾病新观念新技术学习班》学术会议 中国 . 福州</p>
                    </div>
                </section>
                <section class="col-1-3">
                    <div class="wrap-col">
                        <h3><span class="dropcap">B</span>产品动态<span>&nbsp;</span></h3>
                        <p class="pad_bot1">肝康保《BILT治疗仪》市场需求解析</p>
                    </div>
                </section>
                <section class="col-1-3">
                    <div class="wrap-col">
                        <h3><span class="dropcap">C</span>健康知识<span>&nbsp;</span></h3>
                        <p>肝病的演变过程与病历认知，教你了解肝病三步曲！</p>
                        <p>肝康保《BILT治疗仪》慢性肝病的最佳物理疗法！</p>
                    </div>
                </section>
            </div>

        </article>
    </div>
</div>
<div class="body4">
    <div class="main zerogrid">
        <article id="content2">
            <div class="wrapper row">
                <section class="col-3-4">
                    <div class="wrap-col">
                        <h4>联系方式</h4>
                        <ul class="address">
                            <li><span>地址:</span>长江商务大厦（长浩路270号）</li>
                            <li><span>电话:</span><?= Yii::$app->params['contactPhone']?></li>
                            <li><span>邮箱:</span><a href="#"><?= Yii::$app->params['adminEmail']?></a></li>
                        </ul>
                    </div>
                </section>
                <section class="col-1-4">
                    <div class="wrap-col">
                        <h4>微信公众号</h4>
                        <img class="img-responsive" src="css/images/qrcode.jpg">
                    </div>
                </section>
            </div>
        </article>
        <!-- content end -->
    </div>
</div>


