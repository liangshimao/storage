<?php
use yii\helpers\Url;
use app\widgets\GoLinkPager;

?>
<link href="/css/form.css" rel="stylesheet">

<div class="search-nav">
    <form class="form-inline" action="<?= Url::toRoute('/box/index') ?>" method="get">
        <div class="form-group input-group-sm">
            <label for="txtName">包装名：</label>
            <input class="form-control ipt" id="txtName" placeholder="包装名" name="name" value="<?= empty($name) ? '' : $name ?>">
        </div>
        <div class="form-group">
            <button class="btn btn-default" id="btnSearch" type="submit"><i class="glyphicon glyphicon-search"></i> 查询</button>
            <button class="btn btn-default" id="btnSearch" type="button" onclick="add()"><i class="glyphicon glyphicon-plus-sign"></i> 新增</button>
        </div>
    </form>
</div>

<table class="table table-bordered table-striped table-hover table-condensed">
    <thead>
    <tr>
        <th>ID</th>
        <th>包装名称</th>
        <th>单位</th>
        <th>价格</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php $k=($pages->limit) * ($pages->page);foreach ($info as $val): ?>
        <tr>
            <td><?= ++$k; ?></td>
            <td><?= $val->name; ?></td>
            <td><?= $val->unit; ?></td>
            <td><?= $val->price; ?></td>
            <td><?= $val->sort; ?></td>
            <td><?php echo $val->status == 0 ? '<i class="glyphicon glyphicon-ok-sign font-green">' : '<i class="glyphicon glyphicon-remove-sign font-red">' ?></td>
            <td>
                <a class="btn btn-warning buttonbtn btn-info button"
                   href="javascript:window.parent.edit(1,'修改包装信息','<?php echo Url::toRoute(['/box/edit', 'id' => $val->id]); ?>', 600, 300)"><i
                        class="glyphicon glyphicon-edit"></i> 修改</a>

                <a class="btn btn-danger button"
                   href="javascript:confirmurl('<?= Url::toRoute(['/box/delete', 'id' => $val->id]); ?>', '确定要刪除<?=$val->name?>吗?')"><i
                        class="glyphicon glyphicon-trash"></i>删除</a>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="pull-right">
    <?php echo GoLinkPager::widget(['pagination' => $pages,'go' => false]);?>
</div>

<script type="text/javascript">
    /**
     * 添加用户
     */
    function add()
    {
        omnipotent('edit','<?=Url::toRoute('/box/add')?>', '添加包装', 600, 350, 0);
    }

</script>