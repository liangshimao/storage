<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 16-12-7
 * Time: 下午4:50
 */
?>
<div class="pad_10">
    <div class="common-form">
        <table width="100%" class="table_form contentWrap">
            <tr>
                <th width="100">用户名：</th>
                <td><?= $user->name ?></td>
            </tr>
            <tr>
                <th>上次登陆时间：</th>
                <td><?= $user->loginTime ?></td>
            </tr>
            <tr>
                <th>上次登陆IP：</th>
                <td><?= $user->ip ?></td>
            </tr>
            <tr>
                <th width="100">真实姓名：</th>
                <td><?= $user->realName ?></td>
            </tr>
            <tr>
                <th width="100">手机号：</th>
                <td><?= $user->mobile ?></td>
            </tr>
            <tr>
                <th width="100">状态：</th>
                <td><?= $user->status == 1 ? '禁用' : '正常' ?></td>
            </tr>
        </table>
    </div>
</div>
