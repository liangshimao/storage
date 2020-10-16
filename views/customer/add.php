<?php
use yii\helpers\Url;
?>
<div class="pad_10">
    <div class="common-form">
        <form name="myform" action="<?php echo Url::toRoute('/customer/add'); ?>" method="post" id="myform">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <th width="100">客户姓名：</th>
                    <td><input type="text" name="customer[name]" value="" class="form-control-table width-160" id="User-name" style="display: inline" ></td>
                </tr>
                <tr>
                    <th width="100">其他姓名：</th>
                    <td><input type="text" name="customer[alias]" value="" class="width-160 form-control" id="User-alias" style="display: inline"></td>
                </tr>
                <tr>
                    <th width="100">手机号：</th>
                    <td><input type="text" name="customer[mobile]" maxlength="11" value="" class="width-160 form-control" id="User-mobile" style="display: inline"></td>
                </tr>
                <tr>
                    <th width="100">排序：</th>
                    <td><input type="text" name="customer[sort]" maxlength="11" value="0" class="width-160 form-control" id="User-sort" style="display: inline"></td>
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
        $("#User-name").formValidator({onshow: "请输入客户姓名",onfocus:"请输入客户姓名",oncorrect:"输入正确"})
            .inputValidator({min: 2, max:6,onerrormin: "用户名至少需要2个汉字！",onerrormax:"用户名词长度必须在1-6范围内!"})
            .ajaxValidator({
                type:"GET",
                url:"<?=Url::toRoute('/customer/checkname_ajax')?>",
                success:function(status){
                    if(status =="200"){
                        return false;
                    }else{
                        return true;
                    }
                },
                onerror:"客户名已经存在！",
                onwait:"正在验证..."
            });
        $("#User-alias").formValidator({onshow:"请输入其他姓名,没有可不填",onfocus:"请输入其他姓名",oncorrect:"输入正确"});
        $("#User-mobile").formValidator({onshow:"请输入手机号",onfocus:"请输入手机号",oncorrect:"输入正确"})
            .regexValidator({regexp:"^1[35678][0-9]{9}$",onerror:"手机号码不正确"});
        $("#User-sort").formValidator({onshow:"请输入排序号",onfocus:"号码越小位置越靠前",oncorrect:"输入正确"})
            .regexValidator({regexp:"^[0-9]{1,10}$",onerror:"排序号码只能为整数"});
    });
</script>
