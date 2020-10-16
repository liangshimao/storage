<?php
use yii\helpers\Url;
use app\widgets\GoLinkPager;

?>
<link href="/css/form.css" rel="stylesheet">

<div class="search-nav">
    <form class="form-inline" action="<?= Url::toRoute('/user/index') ?>" method="get">
        <div class="form-group input-group-sm">
            <label for="txtName">用户名：</label>
            <input class="form-control ipt" id="txtName" placeholder="用户名" name="name" value="<?= empty($name) ? '' : $name ?>">
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
        <th>用户名</th>
        <th>真实姓名</th>
        <th>手机号</th>
        <th>状态</th>
        <th>注册时间</th>
        <th>最后登录时间</th>
        <th>登陆IP</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php $k=($pages->limit) * ($pages->page);foreach ($info as $val): ?>
        <tr>
            <td><?= ++$k; ?></td>
            <td><?= $val->name; ?></td>
            <td><?= $val->realName; ?></td>
            <td><?= $val->mobile; ?></td>
            <td><?php echo $val->status == 0 ? '<i class="glyphicon glyphicon-ok-sign font-green">' : '<i class="glyphicon glyphicon-remove-sign font-red">' ?></td>
            <td><?= $val->addTime; ?></td>
            <td><?= $val->loginTime; ?></td>
            <td><?= $val->ip; ?></td>
            <td>
                <a class="btn btn-warning buttonbtn btn-info button"
                   href="javascript:window.parent.edit(1,'修改用户信息','<?php echo Url::toRoute(['/user/edit', 'id' => $val->id]); ?>', 600, 300)"><i
                        class="glyphicon glyphicon-edit"></i> 修改</a>
                <?php if($val->id != 1):?>
                <a class="btn btn-danger button"
                   href="javascript:confirmurl('<?= Url::toRoute(['/user/delete', 'id' => $val->id]); ?>', '确定要刪除<?=$val->realName?>吗?')"><i
                        class="glyphicon glyphicon-trash"></i>删除</a>
                <?php endif;?>
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
        omnipotent('edit','<?=Url::toRoute('/user/add')?>', '添加用户', 600, 350, 0);
    }

</script>