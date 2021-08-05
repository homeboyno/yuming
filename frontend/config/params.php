<?php
return [
    'adminEmail' => 'admin@example.com',
    "sidebar" => [
        "site/about" => ["name" => "公司介绍", "ename" => "About US", "level" => 1],
        "news/index" => ["name" => "公司动态", "ename" => "News", "level" => 1],
        "news/detail" => ["name" => "新闻内容", "ename" => "NewsDetail", "level" => 2, "undo" => "news/index"]
    ]
];
