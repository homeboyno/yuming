<?php

namespace frontend\components;

use \Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Sidebar extends Widget {
    public $sidebar;

    public $options = [];

    public $separator = "\n";

    public $layout = '
    <div class="sidebar">
        <p class="title">{title}</p>
        <div class="items">{items}</div>
    </div>
    ';

    public function validateSidebar() {
        if (!is_array($this->sidebar)) 
            throw new Error('错误的Sidebar配置');
        if (!isset($this->sidebar["title"])) 
            throw new Error('Sidebar["title"]必须配置');
        if (!isset($this->sidebar["items"]) || !is_array($this->sidebar["items"])) 
            throw new Error('Sidebar["items"]必须配置且是数组');
    }

    public function renderItems() {
        $items = [];
        foreach ($this->sidebar["items"] as $item) {
            if (isset($item["items"])) {
                $itemOptions = ["class" => "categray"];
                $result = Html::tag("div", $this->renderChildItems($item["items"]), ["class" => "categray-wrapper"]);
                $name = Html::tag("p", $item["name"]);
                $items[] = Html::tag('div', $name . $result, $itemOptions);
            } else {
                $a = Html::a($item["name"], $item["url"]);
                $itemOptions = ["class" => "item"];
                if ($this->isActive($item["url"]))
                    Html::addCssClass($itemOptions, "active");
    
                $items[] = Html::tag('div', $a, $itemOptions);
            }
        }

        return implode($this->separator, $items);
    }

    public function renderChildItems($items) {
        $result = [];
        foreach ($items as $item) {
            $a = Html::a($item["name"], $item["url"]);
            $itemOptions = ["class" => "item"];
            if ($this->isActive($item["url"]))
                Html::addCssClass($itemOptions, "active");

            $result[] = Html::tag('div', $a, $itemOptions);
        }

        return implode($this->separator, $result);
    }

    public function isActive($url) {
        $baseUrl = "/" . Yii::$app->request->getPathInfo();
        if ($baseUrl == "/news/index") {
            return $this->matchByVariable($url, 'type');
        } else if ($baseUrl == "/company/index") {
            return $this->matchByVariable($url, 'id');
        } else if ($baseUrl == "/fund/index") {
            return $this->matchByVariable($url, 'basetype');
        } else if (in_array($baseUrl, ["/fund/condition", "/fund/process", "/fund/must-know", "/fund/risk-notify"])) {
            return $url == "/fund/condition";
        } else {
            return $baseUrl == $url;
        }
    }

    public function matchByVariable($url, $name) {
        $variable = Yii::$app->request->get($name);
        $matches = null;
        preg_match("/$name=(\d+)/", $url, $matches);
        return is_array($matches) && isset($matches[1]) ? $matches[1] == $variable : false;

    }

    public function run() {
        $this->validateSidebar();
        $content = preg_replace_callback("/{\\w+}/", function ($matches) {
            $content = $this->renderSection($matches[0]);

            return $content === false ? $matches[0] : $content;
        }, $this->layout);

        return $content;
    }

    public function renderSection($name)
    {
        switch ($name) {
            case '{title}':
                return $this->sidebar["title"];
            case '{items}':
                return $this->renderItems();
            default:
                return false;
        }
    }
}