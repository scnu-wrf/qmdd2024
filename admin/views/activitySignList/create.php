<?php
    $activity_list=ActivityList::model()->find('id='.$_REQUEST['activity_id']);
    $activity_list_data=ActivityListData::model()->find('id='.$_REQUEST['activity_data_id']);
    $count=ActivitySignList::model()->count('activity_id='.$_REQUEST['activity_id'].' and activity_data_id='.$_REQUEST['activity_data_id']);
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》活动报名 》活动报名 》添加报名</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('activitySignList/index');?>');"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <?php  echo $form->hiddenField($model, 'activity_id', array('value'=>$activity_list->id));?>
                <?php echo $form->hiddenField($model, 'activity_data_id', array('value'=>$activity_list_data->id));?>
            	<table id="t1" style="table-layout:auto;background:none;">
                    <tr>
                        <td style="width:10%;"><?php echo $form->labelEx($model, 'activity_id'); ?>：</td>
                        <td style="width:40%;" class="red">
                            <?php echo $activity_list->activity_title;?>
                            <?php echo $form->error($model, 'activity_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:10%;">项目：</td>
                        <td style="width:40%;"><?php echo $activity_list_data->project_name;?></td>
                        <td>活动时间：</td>
                        <td><?php echo $activity_list_data->activity_time.'-'.$activity_list_data->activity_time_end;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'activity_data_id'); ?>：</td>
                        <td class="red"><?php echo $activity_list_data->activity_content;?></td>
                        <td>可报名人数：</td>
                        <td><?php echo $activity_list_data->apply_number;?></td>
                    </tr>
                    <tr>
                        <td>活动费用(元)：</td>
                        <td><?php echo $activity_list_data->activity_money;?></td>
                        <td>报名审核方式：</td>
                        <td><?php if(!is_null($activity_list_data->check_way))echo $activity_list_data->check_way->F_NAME; ?></td>
                    </tr>
                    <tr>
                        <td>报名年龄(最小)：</td>
                        <td>
                            <?php echo $activity_list_data->min_age;?>&nbsp;
                            <?php echo ActivityList::model()->getAge(strtotime($activity_list_data->min_age)).'周岁';?>
                        </td>
                        <td>报名年龄(最大)：</td>
                        <td>
                            <?php echo $activity_list_data->max_age;?>&nbsp;
                            <?php echo ActivityList::model()->getAge(strtotime($activity_list_data->max_age)).'周岁';?>
                        </td>
                    </tr>
                </table>
                <table class="mt15" id="activity_sign_data" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="5">报名信息</td>
                        <td>
                            <input type="button" class="btn" onclick="add_tag();" value="添加"></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;width:calc(100% / 6);">序号</td>
                        <td style="text-align:center;width:calc(100% / 6);">GF账号</td>
                        <td style="text-align:center;width:calc(100% / 6);">姓名</td>
                        <td style="text-align:center;width:calc(100% / 6);">性别</td>
                        <td style="text-align:center;width:calc(100% / 6);">联系电话</td>
                        <td style="text-align:center;width:calc(100% / 6);">操作</td>
                    </tr>
                    <tr data_index="0">
                        <td>1</td>
                        <input name="add_tag[0][sign_gfid]" type="hidden">
                        <td><input name="add_tag[0][sign_account]" class="input-text" onchange="accountOnchang(this)"></td>
                        <td><input name="add_tag[0][sign_name]" class="input-text" style="border:none;cursor: unset;" readonly></td>
                        <td>
                            <input type="hidden" name="add_tag[0][sign_sex]" class="input-text" >
                            <span clss="sex"></span>
                        </td>
                        <td><input name="add_tag[0][sige_phone]" class="input-text" ></td>
                        <td>
                            <!-- <a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a> -->
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <table class="mt15">
                <tr>
                    <td width="10%;">可执行操作</td>
                    <td colspan="3">
                        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <?php echo show_shenhe_box(array('tongguo'=>'提交审核'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    var number=<?php echo json_encode($activity_list_data->apply_number);?>
</script>
<script>
    var min_age=<?php echo json_encode($activity_list_data->min_age);?>
</script>
<script>
    var max_age=<?php echo json_encode($activity_list_data->max_age);?>
</script>
<script>
    var count=<?php echo $count;?>
</script>
<script>
    
    function add_tag(){
        var num=parseInt($("#activity_sign_data tr").last().attr('data_index'))+1;
        num=isNaN(num)?0:num;
        if(num>=(number-count)){
            we.msg('minus', '只可报名'+(number-count)+'人');
            return false;
        }
        var html =
        '<tr data_index="'+num+'">'+
            '<td>'+(num+1)+'</td>'+
            '<input name="add_tag['+num+'][sign_gfid]" type="hidden">'+
            '<td><input name="add_tag['+num+'][sign_account]" class="input-text" onchange="accountOnchang(this)"></td>'+
            '<td><input name="add_tag['+num+'][sign_name]" class="input-text" readonly style="border:none;cursor: unset;"></td>'+
            '<td><input type="hidden" name="add_tag['+num+'][sign_sex]" class="input-text" ><span clss="sex"></span></td>'+
            '<td><input name="add_tag['+num+'][sige_phone]" class="input-text" ></td>'+
            '<td>'+
                '<a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a>'+
            '</td>'+
        '</tr>';
        num++;
        $('#activity_sign_data').append(html);
    }

    var remove_arr=[];
    function delete_data(obj){
        $(obj).parent().parent().remove();
    }
    
    // 验证账号
    function accountOnchang(obj){
        var changval=$(obj).val();
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('validate');?>&gf_account='+changval+'&activity_id='+<?= $_REQUEST['activity_id'];?>+'&activity_data_id='+<?= $_REQUEST['activity_data_id'];?>,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                var gfid='',ZSXM='',real_sex='',real_sex_name='',PHONE='';
                if(data.status==1){
                    if(data.real_birthday<=min_age&&data.real_birthday>=max_age){
                        gfid=data.GF_ID;
                        ZSXM=data.ZSXM;
                        real_sex=data.real_sex;
                        real_sex_name=data.real_sex_name;
                        PHONE=data.PHONE;
                    }else{
                        $(obj).val('');
                        we.msg('minus', '您输入的GF账号，不符合年龄要求');
                        return false;
                    }
                }else{
                    $(obj).val('');
                    we.msg('minus', data.msg);
                }
                $(obj).parent().prev().val(gfid);
                $(obj).parent().next().find('input').val(ZSXM);
                $(obj).parent().next().next().find('input').val(real_sex);
                $(obj).parent().next().next().find('span').html(real_sex_name);
                $(obj).parent().next().next().next().find('input').val(PHONE);
            }
        });
    }
</script>