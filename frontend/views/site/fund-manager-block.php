<div class="media">
    <a class="pull-left to-right" href="#pablo">
        <div class="avatar">
            <img class="media-object" src="<?=$model->portrait?>" alt="<?=$model->name?>">
        </div>
    </a>
    <div class="media-body">
        <h4 class="media-heading"><span style="color:#1a3a6bbf;"><?=$model->position?></span> <?=$model->name?></h4>
        <p><?=$model->detail?></p>
    </div>
</div>
<style>
@media (max-width: 768px) {
    .avatar {
        width: 40px!important;
        height: 40px!important;
    }
}
</style>