<?php
use yii\helpers\Url;
?>

<div class="pad_10">
    <div class="common-form">
        <form id="myform" action="<?=Url::toRoute(['/user/editpwd'])?>" method="post">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <th width="100">原密码：</th>
                    <td><input type="password" name="oldPassword" id='old-password' maxlength="11" class="form-control-table width-160">
                        <div id="checked" style="display: inline"></div>
                    </td>
                </tr>
                <tr>
                    <th width="100">新密码：</th>
                    <td><input type="password" name="password" id='User-password' class="form-control-table width-160">
                    </td>
                </tr>
                <tr>
                    <th width="100">确认新密码：</th>
                    <td><input type="password" name="repassword" id='User-repassword' class="form-control-table width-160"></td>
                </tr>
            </table>
            <input type="submit" id="dosubmit" class="dialog" name="dosubmit" value="提交" style="display:none;"/>
        </form>
    </div>
</div>
<script>
    $(function(){
        $.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){
            window.top.art.dialog({content: msg, lock: true, width: '250', height: '80'}, function () {
                this.close();
                $(obj).focus();
            })
        }});
        $("#old-password").formValidator({onshow: "请输入原密码",onfocus:"请输入原密码",oncorrect:"输入正确"})
            .inputValidator({min:1,onerrormin: "原密码不能为空！"})
            .ajaxValidator({
                type:"GET",
                url:"<?=Url::toRoute('/user/checkpwd_ajax')?>",
                success:function(data){
                    var result = JSON.parse(data);
                    if(result.data.status == 0){
                        return false;
                    }else{
                        return true;
                    }
                },
                onerror:"原密码输入错误！",
                onwait:"正在验证..."
            });

        $("#User-password").formValidator({onshow:"请输入新密码",onfocus:"请输入新密码",oncorrect:"输入正确"}).inputValidator({min:6,max:20,onerror:"新密码长度为6-20位"});
        $("#User-repassword").formValidator({onshow:"请输入确认新密码",onfocus:"请输入确认新密码",oncorrect:"输入正确"}).compareValidator({desid:"User-password",operateor:"=",onerror:"两次输入的密码不一致"}).inputValidator({min:6,max:20,onerror:"重复新密码长度为6-20位"});
    });

</script>
