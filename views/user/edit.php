<?php
use yii\helpers\Url;
?>
<div class="pad_10">
    <div class="common-form">
        <form name="myform" action="<?php echo Url::toRoute(['/user/edit','id'=>$model->id]); ?>" method="post" id="myform">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <th width="100">用户名：</th>
                    <td><input type="text" name="user[name]" value="<?=$model->name;?>" class="form-control-table width-160" id="User-username" style="display: inline" ></td>
                </tr>
                <tr>
                    <th width="100">真实姓名：</th>
                    <td><input type="text" name="user[realname]" value="<?=$model->realName;?>" class="width-160 form-control" id="User-realname" style="display: inline"></td>
                </tr>
                <tr>
                    <th width="100">手机号：</th>
                    <td><input type="text" name="user[mobile]" maxlength="11" value="<?=$model->mobile;?>" class="width-160 form-control" id="User-mobile" style="display: inline"></td>
                </tr>
                <tr>
                    <th width="100">状态：</th>
                    <td>
                        <input type="radio" name="user[status]" value="0" <?=$model->status==0?'checked':'';?>>正常
                        <input type="radio" name="user[status]" value="1" <?=$model->status==1?'checked':'';?>>禁止
                    </td>
                </tr>
            </table>
            <div style="display: none;" class="btn"><input type="submit" id="dosubmit" class="dialog" name="dosubmit" value="提交"/></div>
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
        $("#User-username").formValidator({onshow: "请输入用户名,用户名由字母和数字组成",onfocus:"请输入用户名",oncorrect:"输入正确"})
            .inputValidator({min: 3, max:30,onerrormin: "用户名至少需要3个字符！",onerrormax:"用户名词长度必须在1-30范围内!"})
            .regexValidator({regexp:"^[0-9a-zA-Z-_]{3,20}$",onerror:"用户名只能为数字和字母"})
            .ajaxValidator({
                type:"GET",
                data:"id=<?=$model->id?>",
                url:"<?=Url::toRoute('/user/checkname_ajax')?>",
                success:function(status){
                    if(status =="200"){
                        return false;
                    }else{
                        return true;
                    }
                },
                onerror:"用户名已经存在！",
                onwait:"正在验证..."
            }).defaultPassed();
        $("#User-realname").formValidator({onshow:"请输入真实姓名",onfocus:"请输入真实姓名",oncorrect:"输入正确"}).inputValidator({min:1,onerror:"真实姓名不能为空"}).defaultPassed();
        $("#User-mobile").formValidator({onshow:"请输入手机号",onfocus:"请输入手机号",oncorrect:"输入正确"})
            .regexValidator({regexp:"^1[35678][0-9]{9}$",onerror:"手机号码不正确"})
            .ajaxValidator({
                type:"GET",
                data:"id=<?=$model->id?>",
                url:"<?=Url::toRoute('/user/checkphone_ajax')?>",
                success:function(status){
                    if(status =="200"){
                        return false;
                    }else{
                        return true;
                    }
                },
                onerror:"该手机号已经注册！",
                onwait:"正在验证..."
            }).defaultPassed();
    });
</script>