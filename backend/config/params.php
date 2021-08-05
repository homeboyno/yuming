<?php
// 后端菜单一级
use common\models\News;

return [
	'adminEmail' => 'admin@example.com',
	'sidebar' => [
		// ['label' => '控制面板', 'url' => ['/dashboard/default/overview'], 'icon' => 'dashboard', 'active' => true,
		// 	'linkOptions' => ['expanded' => "true", 'data-load' => '#dashboard-content']
		// ],
	    ['label' => '页面编辑', 'url' => ['/edite/index'], 'icon' => 'image'],
	    // ['label' => '基金产品', 'url' => ['/fund/index'], 'icon' => 'timeline'],
	    ['label' => '新闻', 'icon' => 'wallpaper', 'items' => [
	        ['label' => '公司新闻', 'url' => ['/news/index', 'NewsSearch[type]' => News::NEWS_COMPANY_NEWS]]
	    //     // ['label' => '友山观点', 'url' => ['/news/index', 'NewsSearch[type]' => News::NEWS_COMPANY_VIEWS]],
		// 	['label' => '公司公告', 'url' => ['/news/index', 'NewsSearch[type]' => News::NEWS_COMPANY_NOTIFYS]],
		// 	['label' => '策略报告', 'url' => ['/news/index', 'NewsSearch[type]' => News::NEWS_REPORT]],
		// 	['label' => '友山视角', 'url' => ['/news/index', 'NewsSearch[type]' => News::NEWS_RESEARCH]],
	    ]]
		// ['label' => '投资者教育', 'url' => ['/education/index'], 'icon' => 'school'],
		// ['label' => '基金经理', 'url' => ['/fund-manager/index'], 'icon' => 'assignment_ind'],
		// ['label' => '领导介绍', 'url' => ['/executive/index'], 'icon' => 'event_seat'],
		// ['label' => '分公司信息', 'url' => ['/company/index'], 'icon' => 'account_balance'],
		// ['label' => '预约信息', 'url' => ['/appointment/index'], 'icon' => 'date_range'],
		// ['label' => '企业荣誉', 'url' => ['/glory/index'], 'icon' => 'golf_course'],
		// ['label' => '用户管理', 'url' => ['/user/index'], 'icon' => 'perm_identity'],
		// ['label' => '权限管理', 'icon' => 'vpn_key', 'items' => [
		// 	['label' => '用户授权', 'url' => ['/admin/assignment']],
		// 	['label' => '角色权限', 'url' => ['/admin/role']],
		// 	['label' => '权限编辑', 'url' => ['/admin/permission']],
		// 	['label' => '路径权限', 'url' => ['/admin/route'],
		// 		'linkOptions' => ['expanded' => "true", 'data-load' => '#dashboard-content']
		// 	],
		// ]],
	],
	'dashboardInitPage' => '@backend/views/site/index',
];
