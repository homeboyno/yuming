
<!-- breadcrumb area start -->
<?php
    $item = Yii::$app->params['sidebar'][$this->context->id . '/' . $this->context->action->id]; //通过控制器id和action id获取视图属性
?>

<div id="papri-breadcrumb-area" class="papri-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content-box">
                    <h2><?=$item['ename']?></h2>
                    <ul class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="/" title="Home"><i class="fa fa-home"></i> Home</a>
                        </li>
                        <?php if($item['level'] == 1): ?>
                            <li class="breadcrumb-item active"><?=$item['name']?></li>
                        <?php else: ?>
                            <li class="breadcrumb-item active"><?=Yii::$app->params['sidebar'][$item['undo']]['name']?></li>
                            <li class="breadcrumb-item active"><?=$item['name']?></li>

                        <?php endif; ?>



                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->

<style>
    /* breadcrumb area css */

    .papri-breadcrumb-area {
        background-position: center center;
        background-size: cover;
        position: relative;
        background-image: url(../images/banner.jpg);
        padding: 100px 0;
    }

    .papri-breadcrumb-area:before {
        content: '';
        background: rgba(9, 9, 9, .80);
        left: 0px;
        top: 0;
        width: 100%;
        height: 100%;
        position: absolute;
    }

    .breadcrumb-content-box h2 {
        color: #fff;
        font-size: 70px;
        font-weight: 500;
        margin-bottom: 10px;
        text-transform: capitalize;
    }

    .breadcrumb-content-box .breadcrumb {
        background: inherit;
        padding: 0;
        margin: 0;
    }

    .breadcrumb .breadcrumb-item {
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
    }

    .breadcrumb-content-box .breadcrumb .breadcrumb-item,
    .breadcrumb-content-box .breadcrumb-item.active a,
    .breadcrumb-content-box .breadcrumb .breadcrumb-item.active {
        color: #fff;
        text-transform: capitalize;
        margin-right: 10px;
    }

    .papri-breadcrumb-area .breadcrumb .breadcrumb-item a {
        color: #ffffff;
        text-transform: capitalize;
    }

    .papri-breadcrumb-area .breadcrumb-item + .breadcrumb-item::before {
        color: #fff;
        content: "\f178";
        font-family: FontAwesome;
        margin-right: 10px;
    }
</style>