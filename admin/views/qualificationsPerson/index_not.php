
<?php //var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>当前界面：服务者 》服务者入驻 》取消/审核未通过</span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <?php echo show_command('批删除','','删除'); ?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
    
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                  <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state'); ?>">
                <label style="margin-right:10px;">
                    <span>操作时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input type="text" style="width:200px" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入账号/姓名">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('qualification_type_id') ?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_project_name') ?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_gfaccount') ?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_name') ?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_sex') ?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_identity_num') ?></th>
                        <th><?php echo $model->getAttributeLabel('area_code') ?></th>
                        <th><?php echo $model->getAttributeLabel('logon_way') ?></th>
                        <th><?php echo $model->getAttributeLabel('check_state') ?></th>
                        <?php if(empty($_REQUEST['state'])){?>
                            <th>操作时间</th>
                        <?php }else{?>
                            <th>申请时间</th>
                        <?php }?>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v) {?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
                            <td><?php echo $v->qualification_type; ?></td>
                            <td><?php echo $v->qualification_project_name; ?></td>
                            <td><?php echo $v->qualification_gfaccount; ?></td>
                            <td><?php echo $v->qualification_name; ?></td>
                            <td><?php if(!empty($v->qualification_sex))echo $v->base_sex->F_NAME; ?></td>
                            <td><?php echo $v->qualification_title; ?></td>
                            <td>
                                <?php 
                                    $area_code='';
                                    if(!empty($v->area_code))$t_region=TRegion::model()->findAll('id in('.$v->area_code.')');
                                    if(!empty($t_region))foreach($t_region as $t){
                                        $area_code.=$t->region_name_c;
                                    }
                                    echo $area_code; 
                                ?>
                            </td>
                            <td><?php echo $v->logon_way_name; ?></td>
                            <td><?php echo $v->check_state_name; ?></td>
                            <?php if(empty($_REQUEST['state'])){?>
                                <td><?php echo substr($v->state_time,0,10).'<br>'.substr($v->state_time,11); ?></td>
                            <?php }else{?>
                                <td><?php echo substr($v->uDate,0,10).'<br>'.substr($v->uDate,11); ?></td>
                            <?php }?>
                            <td>
                                <!-- <a class="btn" href="<?php //echo $this->createUrl('update_examine',array('id'=>$v->id)); ?>" title="编辑"><i class="fa fa-edit"></i></a> -->
                                <!-- <a class="btn" href="javascript:;" onclick="we.dele('<?php //echo $v->id; ?>',deleteUrl)" title="删除"><i class="fa fa-trash-o"></i></a> -->

                                <?php echo show_command('详情',$this->createUrl('update_examine', array('id'=>$v->id))); ?>
                                <?php echo show_command('删除','\''.$v->id.'\''); ?>
                            </td>
                        </tr>
                    <?php $index++; }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div>
<script>
    $(function(){
        var $lock_date_start=$('#lock_date_start,#start_date');
        var $lock_date_end=$('#lock_date_end,#end_date');
        $lock_date_start.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $lock_date_end.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });
    function on_exam(){
        var exam = $('.exam p span').text();
        // if(exam>0){
            $('#state').val(1);
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('click_submit').click();
        // }
    }
    var deleteUrl = '<?php echo $this->createUrl('delete',array('id'=>'ID')); ?>';
</script>