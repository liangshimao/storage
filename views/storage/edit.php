<?php
use yii\helpers\Url;
?>
<div class="pad_10">
    <div class="common-form">
        <form name="myform" action="<?php echo Url::toRoute(['/storage/edit','id'=>$model->id]); ?>" method="post" id="myform">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <th width="100">冷库名称：</th>
                    <td><input type="text" name="storage[name]" value="<?=$model->name?>" class="form-control-table width-160" id="User-name" style="display: inline" ></td>
                </tr>
                <tr>
                    <th width="100">备注信息：</th>
                    <td><input type="text" name="storage[comment]" value="<?=$model->comment?>" class="width-160 form-control" id="User-alias" style="display: inline"></td>
                </tr>

                <tr>
                    <th width="100">排序：</th>
                    <td><input type="text" name="storage[sort]" maxlength="11" value="<?=$model->sort?>" class="width-160 form-control" id="User-sort" style="display: inline"></td>
                </tr>
                <tr>
                    <th width="100">状态：</th>
                    <td>
                        <input type="radio" name="storage[status]" value="0" <?=$model->status==0?'checked':'';?>>正常
                        <input type="radio" name="storage[status]" value="1" <?=$model->status==1?'checked':'';?>>禁止
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
                data:"id=<?=$model->id?>",
                url:"<?=Url::toRoute('/storage/checkname_ajax')?>",
                success:function(status){
                    if(status =="200"){
                        return false;
                    }else{
                        return true;
                    }
                },
                onerror:"名称已经存在！",
                onwait:"正在验证..."
            }).defaultPassed();
        $("#User-alias").formValidator({onshow:"请输入备注,没有可不填",onfocus:"请输入备注",oncorrect:"输入正确"});
        $("#User-sort").formValidator({onshow:"请输入排序号",onfocus:"号码越小位置越靠前",oncorrect:"输入正确"})
            .regexValidator({regexp:"^[0-9]{1,10}$",onerror:"排序号码只能为整数"});
    });
</script>
