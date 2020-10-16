<?php
use yii\helpers\Url;
?>
<div class="pad_10">
    <div class="common-form">
        <form name="myform" action="<?php echo Url::toRoute('/box/add'); ?>" method="post" id="myform">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <th width="100">包装名称：</th>
                    <td><input type="text" name="box[name]" value="" class="form-control-table width-160" id="User-name" style="display: inline" ></td>
                </tr>
                <tr>
                    <th width="100">单位：</th>
                    <td><input type="text" name="box[unit]" value="" class="width-160 form-control" id="User-alias" style="display: inline"></td>
                </tr>

                <tr>
                    <th width="100">价格：</th>
                    <td><input type="text" name="box[price]" maxlength="11" value="0.00" class="width-160 form-control" id="User-mobile" style="display: inline"></td>
                </tr>
                <tr>
                    <th width="100">排序：</th>
                    <td><input type="text" name="box[sort]" maxlength="11" value="0" class="width-160 form-control" id="User-sort" style="display: inline"></td>
                </tr>
                <tr>
                    <th width="100">状态：</th>
                    <td>
                        <input type="radio" name="box[status]" value="0" checked>正常
                        <input type="radio" name="box[status]" value="1">禁止
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
        $("#User-name").formValidator({onshow: "请输入包装名称",onfocus:"请输入包装名称",oncorrect:"输入正确"})
            .inputValidator({min: 2, max:10,onerrormin: "名称至少需要2个汉字！",onerrormax:"用户名词长度必须在2-10范围内!"})
            .ajaxValidator({
                type:"GET",
                url:"<?=Url::toRoute('/box/checkname_ajax')?>",
                success:function(status){
                    if(status =="200"){
                        return false;
                    }else{
                        return true;
                    }
                },
                onerror:"名称已经存在！",
                onwait:"正在验证..."
            });
        $("#User-alias").formValidator({onshow:"请输入单位,没有可不填",onfocus:"请输入单位",oncorrect:"输入正确"});
        $("#User-mobile").formValidator({onshow:"请输入价格，选填",onfocus:"请输入价格",oncorrect:"输入正确"})
            .regexValidator({regexp:"^[0-9]{1,6}(\.[0-9]{1,2})?$",onerror:"价格格式错误"});
        $("#User-sort").formValidator({onshow:"请输入排序号",onfocus:"号码越小位置越靠前",oncorrect:"输入正确"})
            .regexValidator({regexp:"^[0-9]{1,10}$",onerror:"排序号码只能为整数"});
    });
</script>
