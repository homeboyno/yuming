<div class="card card-stats">
    <div class="card-header" data-background-color="primary">
        <i class="material-icons"><?=$icon?></i>
    </div>
    <div class="card-title">
        <p class="category"><?=$apartment?></p>
    </div>
    <div class="card-content">
        <table class="table">
            <thead>
                <tr>
                    <th>名称</th>
                    <th>职位</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($execs as $model): ?>
                <tr>
                    <td><?=$model["name"]?></td>
                    <td><?=$model["position"]?></td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>