<?php
use app\models\User;
use common\models\Company;
use common\models\Edite;
use common\models\Education;
use common\models\Fund;
use common\models\News;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

// $user = Yii::$app->user->identity;
// $isGuest = (gettype($user) != 'object') || $user->type == 3; // 没取到model即未登录

$navbar = [
    "home" => [ "name" => Yii::t('app',"首页"), "link" => "/" ],
    "introduction" => [ "name" => Yii::t('app',"公司简介"), "link" => "/site/about" ],
    "environment" => [ "name" => Yii::t('app',"考试环境"), "link" => "/site/test-environment" ],
    "evalute" => [ "name" => Yii::t('app',"客户评价"), "link" => "/site/client-evaluate" ],
    "function" => [ "name" => Yii::t('app',"培训业务"), "link" => "/site/train-fonction" ],
    "test" => [ "name" => Yii::t('app',"人才测评"), "link" => "/site/personnel-test" ],
    "contact" => [ "name" => Yii::t('app',"联系我们"), "link" => "/site/contact-us" ]
    // "ushinef" => [
    //     "name" => Yii::t('app',"走进友山"),
    //     "items" => [
    //         Edite::editeList()[Edite::EDITE_ABOUT_USHINEF] => "/site/about-ushinef",
    //         Yii::t('app',"领导介绍") => "/site/executive",
    //         Yii::t('app',"基金经理") => "/site/fund-manager",
    //         Edite::editeList()[Edite::EDITE_RISK_CONTROL] => "/site/risk-control",
    //         Edite::editeList()[Edite::COMPlIANCE_MANAGEMENT] => "/site/compliance-management",
    //         Yii::t('app',"企业荣誉") => "/site/history",
    //         Edite::editeList()[Edite::EDITE_UNION] => "/site/union",
    //         Edite::editeList()[Edite::EDITE_PARTY] => "/site/party",
    //         Edite::editeList()[Edite::EDITE_TALENT_CONSTRUCTION] => "/site/talent-construction",
    //         // Yii::t('app',"信息技术") => "/site/interfation",
    //     ],
    // ],
    // "fund" => [
    //     "name" => Yii::t('app',"旗下基金"),
    //     "options" =>
    //         $isGuest ? ["data-toggle" => "modal", "data-target" => "#ContractModal"] :
    //         (
    //             $user->riskscore == null ?
    //             ["data-toggle" => "modal", "data-target" => "#RiskControlModal", "onClick" => "window.location='/user/risk-test'"] :
    //             []
    //         ),
    //     "items" => (function($isGuest, $user) {
    //         $result = [];
    //         if (!$isGuest && $user->riskscore != NULL)
    //             $result["推荐基金"] = '/fund/recommand';
    //         $result = [
    //             "证券投资基金" => "/fund/index?basetype=" . Fund::BASE_TYPE_GUPIAO,
    //             "证券FOF类基金" => "/fund/index?basetype=" . Fund::BASE_TYPE_DANYI,
    //             "非主营类基金" => "/fund/index?basetype=" . Fund::BASE_TYPE_GUQUAN,
    //         ];
    //         return $result;
    //     })($isGuest, $user),
    //     "displaySubmenu" => !($isGuest || $user->riskscore == null)
    // ],
    // "company" => [
    //     "name" => Yii::t('app',"联系友山"),
    //     "items" => (function() {
    //         $companys = Company::find()->where(['isShow' => true])->orderBy("weight desc")->asArray()->all();
    //         $result = [];
    //         foreach ($companys as $key => $company) {
    //           $result[Yii::t('app',$company["name"])] = Url::to(["company/index", "id" => $company['id']]);
    //         }
    //         return $result;
    //     })()
    // ],
    // "news" => [
    //     "name" => Yii::t('app',"友山动态"),
    //     "items" => (function() {
    //         // $result = News::typeToUrl();
    //         unset($result["友山观点"]);
    //         return $result;
    //     })()
    // ],
    // "education" => [ "name" => Yii::t('app',"投资者教育"), "link" => "/education" ]

];

?>
    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="my-container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
<?php if (in_array(Yii::$app->request->url, ["/", "/user/login", "/user/register", "/user/forgot-password"])): ?>
                        <a class="navbar-brand-phone"  href="/">
                        </a>
<?php else: ?>
                        <a class="navbar-brand" href="/">
                        </a>
<?php endif; ?>
            </div>
            <div class="collapse navbar-collapse" id="navigation">
                <ul class="nav navbar-nav navbar-right">
<?php
    /**
     *  <ul class="nav nav-tabs">
     *   <li role="presentation" class="dropdown">
     *       <a class="dropdown-toggle" data-toggle="dropdown" href="#">
     *           Dropdown <span class="caret">
     *       </span>
     *       </a>
     *       <ul class="dropdown-menu">
     *       ...
     *       </ul>
     *   </li>
     *   ...
     *   </ul>
     */

    foreach ($navbar as $item) {
        // 有items项，如果有displaySubmenu项，该项不为false
        $displaySubmenu = isset($item["items"]) && (!isset($item["displaySubmenu"]) || $item["displaySubmenu"] != false);

        // link
        if (isset($item["dom"])) {
            $a = $item["dom"];
        } else {
            $options = $displaySubmenu ? ["class" => "dropdown-toggle", "data-toggle" => "dropdown"] : [];
            if (isset($item["options"])) {
                // \yii\helpers\Html::addCssClass($options["class"], $item["options"]);
                $options = \yii\helpers\ArrayHelper::merge($options, $item["options"]);
            }
            if ($displaySubmenu) {
                $a = Html::a($item["name"] . '<span class="caret"></span>', isset($item["link"]) ? $item["link"] : "#", $options);
            } else {
                $a = Html::a($item["name"], isset($item["link"]) ? $item["link"] : "#", $options);
            }
        }

        // Submenu
        $submenu = []; $submenuString = "";
        if ($displaySubmenu) {
            foreach ($item["items"] as $name => $link) {
                $submenu[] = Html::tag("li", Html::a($name, $link));
            }
            $submenuString = Html::tag("ul", join($submenu), ["class" => "dropdown-menu"]);
        }

        echo Html::tag("li", $a . $submenuString, $displaySubmenu ? ["class" => "dropdown"] : []);
    }
?>
                </ul>
            </div>
        </div>
    </nav>

<style>
.navbar-header .popover{
    height:0!important;
}
.my-container{
    padding-right: 15px;
    padding-left: 15px;
    margin-right: 70px;
    margin-left: 50px;
}
.navbar .navbar-right > li > a{
    font-size: 1.1em;
    color: #000000;
}
.nav.navbar-nav.navbar-right{
    max-width: 50%;
}
#portrait{
    float:left;
}
.navbar-brand-phone{
    position: relative;
    height: 70px;
    line-height: 30px;
    color: inherit;
    padding: 10px 15px;
    display:inline-block;
    width:175px;
    background:url("/images/ushineLogo.svg");
    background-size:cover;
    background-repeat:no-repeat;
    background-origin:content-box;
}
.navbar-brand{
    height: 70px!important;
    color: inherit;
    display:inline-block;
    width:175px;
    background:url("/images/ushineLogo_1.svg");
    /* background:url("/images/ushinef-logo-3.svg"); */
    background-size:cover;
    background-repeat:no-repeat;
    background-origin:content-box;
}
@media (max-width: 1440px) {
    .my-container{
    padding-right: 25px;
    padding-left: 5px;
    margin-right: 0px;
    margin-left: 0px;
    }
}
@media (max-width: 1024px) {
    .nav.navbar-nav.navbar-right{
    max-width: 100%;
    }
}
@media (max-width: 768px) {
    .my-container{
    padding-right: 0px;
    padding-left: 5px;
    }
    .nav.navbar-nav.navbar-right{
    max-width: 100%;
    }
    #portrait{
    float:right;
    }
    .my-container>.navbar-header{
        width:100%
    }
    .navbar-brand-phone{
        background:url("/images/ushinefLogo.svg");
        background-size:90px 38px;
        background-repeat:no-repeat;
        background-origin:content-box;
    }
    .navbar-brand{
        background-size:90px 38px;
        background-repeat:no-repeat;
        background-origin:content-box;
    }
}
</style>
