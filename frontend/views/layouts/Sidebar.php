<?php
//定义菜单链接地址
use yii\helpers\Url;
use yii\db\Query;
use common\models\News;
use common\models\Fund;
use common\models\Company;

// $company = (new Query())->select(["id", "name"])->from("company")->where(['isShow' => true])->orderBy("weight desc")->all();
// $company = array_map(function($item) {
//     return [
//         "name" => Yii::t('app', $item["name"]),
//         "url" => '/company/index?id=' . $item['id']
//     ];
// }, $company);

return [
    'siteSidebar' => [
        "title" => Yii::t('app','走进友山'),
        "items" => [
            [
                "name" => Yii::t('app',"公司简介"),
                "url" => "/site/about-ushinef",
            ],
            [
                "name" => Yii::t('app',"考场环境"),
                "url" => "/site/executive",
            ],
            [
                "name" => Yii::t('app',"客户评价"),
                "url" => "/site/fund-manager",
            ],
            [
                "name" => Yii::t('app',"培训业务"),
                "url" => "/site/risk-control",
            ],
            [
                "name" => Yii::t('app',"人才测评"),
                "url" => "/site/compliance-management",
            ],
            [
                "name" => Yii::t('app',"联系我们"),
                "url" => "/site/history",
            ],
        ]
    ],
    // "userSidebar" => [
    //     "title" => Yii::t('app','用户信息'),
    //     "items" => [
    //         [
    //             "name" => Yii::t("app", "我的基金"),
    //             "url" => "/user/share",
    //         ],
    //         [
    //             "name" => Yii::t("app", "我的预约"),
    //             "url" => "/user/appointment",
    //         ],
    //         [
    //             "name" => Yii::t("app", "更改密码"),
    //             "url" => "/user/update-password",
    //         ],
    //         [
    //             "name" => Yii::t("app", "更改信息"),
    //             "url" => "/user/user-info",
    //         ],
    //         [
    //             "name" => Yii::t("app", "风险测试"),
    //             "url" => "/user/risk-test",
    //         ],
    //     ]
    // ],
    // "newsSidebar" => [
    //     "title" => Yii::t('app','友山动态'),
    //     "items" => [
	// 		[
    //             "name" => Yii::t('app',"公司新闻"),
    //             "url" => "/news/index?type=" . News::NEWS_COMPANY_NEWS,
    //         ],
	// 		[
    //             "name" => Yii::t('app',"公司公告"),
    //             "url" => "/news/index?type=" . News::NEWS_COMPANY_NOTIFYS,
    //         ],
	// 		// [
    //   //           "name" => Yii::t('app',"策略报告"),
    //   //           "url" => "/news/index?type=" . News::NEWS_REPORT,
    //   //       ],
	// 		[
    //             "name" => Yii::t('app',"友山视角"),
    //             "url" => "/news/index?type=" . News::NEWS_RESEARCH,
    //         ],
    //     ]
    // ],
    // "companySidebar" => [
    //     "title" => Yii::t('app','联系友山'),
    //     "items" => $company
    // ],
    // "fundSidebar" => [
    //     "title" => Yii::t('app','旗下基金'),
    //     "items" => [
    //         [
    //             "name" => "认购相关",
    //             "url" => "/fund/condition"
    //         ],
    //         [
    //             "name" => "推荐基金",
    //             "url" => "/fund/recommand"
    //         ],
    //         [
    //             "name" => "证券投资基金",
    //             "items" => [
    //                 [
    //                     "name" => '股票类基金',
    //                     "url" => "/fund/index?basetype=" . Fund::BASE_TYPE_GUPIAO,
    //                 ],
    //                 [
    //                     "name" => '固定收益类基金',
    //                     "url" => "/fund/index?basetype=" . Fund::BASE_TYPE_GUSHOU,
    //                 ],
    //                 [
    //                     "name" => '混合类基金',
    //                     "url" => "/fund/index?basetype=" . Fund::BASE_TYPE_HUNHE,
    //                 ],
    //                 [
    //                     "name" => '期货及衍生品类基金',
    //                     "url" => "/fund/index?basetype=" . Fund::BASE_TYPE_QIHUO,
    //                 ],
    //                 [
    //                     "name" => '其他类基金',
    //                     "url" => "/fund/index?basetype=" . Fund::BASE_TYPE_OTHER,
    //                 ],
    //             ],
    //         ],
    //         [
    //             "name" => "证券FOF类基金",
    //             "items" => [
    //                 [
    //                     "name" => '投向单一资产管理计划的基金',
    //                     "url" => "/fund/index?basetype=" . Fund::BASE_TYPE_DANYI,
    //                 ],
    //                 [
    //                     "name" => '母基金',
    //                     "url" => "/fund/index?basetype=" . Fund::BASE_TYPE_MU,
    //                 ],
    //             ],
    //         ],
    //         [
    //             "name" => "非主营类基金",
    //             "items" => [
    //                 [
    //                     "name" => '股权类基金',
    //                     "url" => "/fund/index?basetype=" . Fund::BASE_TYPE_GUQUAN,
    //                 ],
    //                 [
    //                     "name" => '债权类基金',
    //                     "url" => "/fund/index?basetype=" . Fund::BASE_TYPE_ZHAIQUAN,
    //                 ],
    //             ]
    //         ],
	// 	]
    // ]
];
