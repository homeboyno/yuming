<?php

frontend\assets\AboutAsset::register($this);

?>
<div class="us-title">
    <h2>走进友山</h2>
    <p><?=$name?></p>
</div>
<div>
    <iframe class="edite" onload="this.height=this.contentWindow.document.body.scrollHeight"  src="/edite/view?type=edite&id=<?=$id ?>"></iframe>
</div>
