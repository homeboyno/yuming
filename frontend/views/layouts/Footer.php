<?php
use \yii\helpers\Html;

$this->registerJs('$(\'[data-toggle="popover"]\').popover()');
?>
<footer class="footer footer-white footer-big us-footer">
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-4 col-xs-12" style="margin-top: 16px;text-align: center;">
                    <a href="/">
                        <img src="/images/ushineLogo.png" alt="友山基金" height="50">
                    </a>
                    <p style="margin-top: 20px">友山教育 西南考试教育领军企业</p>
                </div>
                <div class="col-md-offset-1 col-md-2 hidden-xs" style="margin-top:31px;">
                    <!-- <h3>XXX</h3> -->
                    <ul class="links-vertical">
                        <li><a href="/site/about-ushinef">xxx</a></li>
                        <li><a href="/site/executive">xxx</a></li>
                        <li><a href="/site/fund-manager">xxx</a></li>
                        <!-- <li><a href="/site/risk-control">xxx</a></li> -->
                    </ul>
                </div>
                <div class="col-md-2 hidden-xs" style="margin-top:31px;">
                    <!-- <h3>XXX</h3> -->
                    <ul class="links-vertical">
                        <li><a href="/news/index?type=0">xxx</a></li>
                        <li><a href="/news/index?type=2">xxx</a></li>
                        <li><a href="/news/index?type=5">xxx</a></li>
                        <!-- <li><a href="/news/index?type=6">xxx</a></li> -->
                    </ul>
                </div>
                <p>联系我们:</p>
                <div class="col-md-3 hidden-xs">
                    <ul class="social-buttons">
                        <li>
                            <a data-toggle="popover" href="javascript:void(0)"  data-placement="left auto" data-content="0851-86918866" class="btn btn-just-icon btn-simple" style="color: #337ab7">
                                <i class="fa fa-fw fa-phone"></i>
                            </a>
                        </li>
                        <li>
                            <a data-container="body" href="javascript:void(0)" data-toggle="popover"  data-placement="auto" data-html="true" data-content="<a href='mailto:ushinef@ushinef.com'>ushinef@ushinef.com</a>" class="btn btn-just-icon btn-simple" style="color: #457DCA">
                                <i class="fa fa-fw fa-envelope"></i>
                            </a>
                        </li>
                        <li>
                            <a data-container="body" href="javascript:void(0)" data-toggle="popover"  data-placement="auto" data-html="true" data-content="<a href='http://wpa.qq.com/msgrd?v=3&amp;uin=2226488136&amp;site=qq&amp;menu=yes' target='_blank'>2226488136</a>" class="btn btn-just-icon btn-simple" style="color: #00bcd4">
                                <i class="fa fa-fw fa-qq"></i>
                            </a>
                        </li>
                        <li>
                            <a data-container="body" href="javascript:void(0)"  data-toggle="popover" data-placement="right auto" data-html="true" data-content="<img src='/images/QRCode.jpg' style='width: 100px;height:100px;margin-bottom: 0px'>" class="btn btn-just-icon btn-simple" style="color: #42B909">
                                <i class="fa fa-fw fa-wechat"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4  hidden-xs" style="padding:15px">
                <span>黔ICP备xxxxxxxx号</span>
                <!-- <span style="margin-left: 1em">
                    <?=$this->render("../layouts/changeLanguage.php"); ?>
                </span> -->
            </div>
            <div class="copyright col-md-offset-2 col-md-6">
                &copy; <script>document.write(new Date().getFullYear())</script>
                <a data-toggle='modal'  data-target='#legal'>友山教育权利所有，</a> 
                <a data-toggle='modal'  data-target='#copyright'>翻版必究。</a> 
            </div>
        </div>
    </div>
</footer>


<style>
.popover.left>.arrow:after {
    bottom: -20px;}
.popover.right>.arrow:after {
    bottom: -20px;}
.popover.top>.arrow:after {
        margin-left: 0;
    }
.popover.bottom>.arrow:after {
        margin-left: 0;
}
</style>
