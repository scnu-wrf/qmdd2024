<?php //var_dump(get_where_club_project('club_id',''))?>
<div class="box">
    <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: middle;float: right; margin-right: 10px;"><i class="fa fa-refresh"></i>刷新</a>
    <div class="box-title c"><h1><?=$_REQUEST['type']==403?'当前界面 》 会员 》 个人成员管理 》 个人成员查询':'当前界面 》 会员 》 单位成员管理 》 单位成员查询'?></h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="type" value="<?php echo Yii::app()->request->getParam('type');?>">
				<!-- <label style="margin-right:20px;">
                    <span>会员类型：</span>
                    <?php //echo downList($type,'f_id','F_NAME','type'); ?>
                </label> -->
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project_id'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>入会时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="effective_start_time" name="effective_start_time" value="<?php if(empty(Yii::app()->request->getParam('effective_start_time'))){if(Yii::app()->request->getParam('index')==1&&Yii::app()->request->getParam('state')!=1){echo date("Y-m-d");}}else{echo Yii::app()->request->getParam('effective_start_time');}?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="effective_end_time" name="effective_end_time" value="<?php if(empty(Yii::app()->request->getParam('effective_end_time'))){if(Yii::app()->request->getParam('index')==1&&Yii::app()->request->getParam('state')!=1){echo date("Y-m-d");}}else{echo Yii::app()->request->getParam('effective_end_time');}?> ">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入会员编号/<?=$_REQUEST['type']==403?'姓名':'名称';?>/账号/项目">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <?php if($_REQUEST['type']==403){?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th style="">序号</th>
                            <th style=""><?php echo $model->getAttributeLabel('code');?></th>
                            <th style="">GF账号</th>
                            <th style="">姓名</th>
                            <th style=""><?= $model->getAttributeLabel('sex');?></th>
                            <th style=""><?= $model->getAttributeLabel('native');?></th>
                            <th style=""><?= $model->getAttributeLabel('apply_phone');?></th>
                            <th style=""><?php echo $model->getAttributeLabel('project_id');?></th>
                            <th style=""><?php echo $model->getAttributeLabel('partner_id');?></th>
                            <th style="">状态</th>
                            <th style="">入会时间</th>
                            <th style="">操作</th>
                        <?php }else{ ?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th style="">序号</th>
                            <th style=""><?php echo $model->getAttributeLabel('code');?></th>
                            <th style="">单位账号</th>
                            <th style="">服务平台名称</th>
                            <th style=""><?php echo $model->getAttributeLabel('company_type_id');?></th>
                            <th style=""><?php echo $model->getAttributeLabel('club_region');?></th>
                            <th style="">联系人</th>
                            <th style=""><?php echo $model->getAttributeLabel('apply_phone');?></th>
                            <th style=""><?php echo $model->getAttributeLabel('partner_id');?></th>
                            <th style="">状态</th>
                            <th style="">入会时间</th>
                            <th style="">操作</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
    $index = 1;
    foreach($arclist as $v){ 
?>
                    <tr>
                        <?php if($_REQUEST['type']==403){?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td style=""><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td style=""><?php echo $v->code; ?></td>
                            <td style=""><?php echo $v->gf_account; ?></td>
                            <td style=""><?php echo $v->zsxm ; ?></td>
                            <td style=""><?php echo $v->sex; ?></td>
                            <td style=""><?php echo $v->native; ?></td>
                            <td style=""><?php echo $v->apply_phone; ?></td>
                            <td style=""><?php echo $v->project_name; ?></td>
                            <td style=""><?php echo $v->partner_name; ?></td>
                            <td style=""><?php echo $v->state_name; ?></td>
                            <td style=""><?php echo $v->update; ?></td>
                            <td style="">
                                <?php 
                                    $s1='<a class="btn" href="'.$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type)).'" ';
                                    $s1.=' title="编辑"><i class="fa fa-edit"></i></a>';
                                    // echo $s1;
                                    echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); 
                                ?>
                            </td>
                        <?php }else{ ?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td style=""><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td style=""><?php echo $v->code; ?></td>
                            <td style=""><?php $c=!empty($v->club_list->club_code)?$v->club_list->club_code:''; echo $c; ?></td>
                            <td style=""><?php echo $v->club_name; ?></td>
                            <td style=""><?php echo $v->company_type; ?></td>
                            <td style=""><?php echo $v->club_region; ?></td>
                            <td style=""><?php echo $v->zsxm; ?></td>
                            <td style=""><?php echo $v->apply_phone; ?></td>
                            <td style=""><?php echo $v->partner_name; ?></td>
                            <td style=""><?php echo $v->state_name; ?></td>
                            <td style=""><?php echo $v->update; ?></td>
                            <td style="">
                                <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); ?>
                            </td>
                        <?php } ?>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    $(function(){
        var $effective_start_time=$('#effective_start_time');
        var $effective_end_time=$('#effective_end_time');
        $effective_start_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $effective_end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });

    function on_exam(){
        var exam = $('.exam p span').text();
        if(exam>0){ 
            $('#state').val(371);
            $('#index').val('');
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('submit_button').click();
        }
    }

    function excel(){
        $("#is_excel").val(1);
        $("#submit_button").click();
        $("#is_excel").val(0);
    }
</script>