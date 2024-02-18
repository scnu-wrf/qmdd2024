<div class="box" div style="font-size: 9px">
    <div class="box-title c">
        <h1>当前界面：动动约 》资源审核 》<?php echo (!isset($_REQUEST['state'])) ? '服务者审核' : '审核未通过列表'; ?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if(empty($_REQUEST['state'])) {?>
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('index_stay_state'); ?>">
                待审核：<span class="red"><?php echo $state_count; ?></span>
            </a>
        </div>
        <?php }?>
        <div class="box-search" style=" border:none;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <label style="margin-right:20px;">
                    <span>日期：</span>
                    <input style="width:120px;" type="text" class="input-text click_time" id="state_time_start" name="state_time_start" value="<?php echo $state_time_start; ?>">
                    <span>-</span>
                    <input style="width:120px;" type="text" class="input-text click_time" id="state_time_end" name="state_time_end" value="<?php echo $state_time_end; ?>">
                </label>
                <!-- <label style="margin-right:20px;">
                    <span>审核状态：</span>
                    <?php //echo downList($base_code,'f_id','F_NAME','state'); ?>
                </label> -->
                <!-- <label style="margin-right:20px;">
                    <span>服务类别：</span>
                    <?php // echo downList($type_id,'id','f_uname','type_id'); ?>
                </label> -->
                <!-- <label style="margin-right:20px;">
                    <span>按等级：</span>
                    <?php //echo downList($type_code,'f_id','card_name','type_code'); ?>
                </label> -->
				<!-- <label style="margin-right:20px;">
                    <span>登记项目：</span>
                    <?php // echo downList($project_list,'id','project_name','project'); ?>
                </label> -->
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="编号 / 账号 / 姓名" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="width:25px;" class="check">序号</th>
                        <th><?php echo $model->getAttributeLabel('qcode');?></th>
                        <!-- <th><?php //echo $model->getAttributeLabel('qualification_gfaccount');?></th> -->
                        <th><?php echo $model->getAttributeLabel('person_id');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_project_name');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_type');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_title');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_level');?></th>
                        <!-- <th><?php //echo $model->getAttributeLabel('qmdd_user_type1');?></th> -->
                        <!-- <th><?php //echo $model->getAttributeLabel('head_pic');?></th> -->
                        <th><?php echo $model->getAttributeLabel('servic_site_name');?></th>
                        <th><?php echo $model->getAttributeLabel('check_state');?></th>
                        <th><?php echo $model->getAttributeLabel('state_time');?></th>
                        <!-- <th><?php // echo $model->getAttributeLabel('club_id1');?></th> -->
                        <th><?php echo $model->getAttributeLabel('process_preson_id');?></th>
                        <th style="width:9%;">操作</th>

                    </tr>
                </thead>
                <tbody>
                <?php
                    // $basepath=BasePath::model()->getPath(267);
                    $index = 1;
				    foreach($arclist as $v){
                ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->qcode; ?></td>
                        <!-- <td><?php //echo $v->qualification_gfaccount; ?></td> -->
                        <td><?php if($v->person_id) echo $v->qualification_name; ?></td>
                        <td><?php echo $v->qualification_project_name; ?></td>
                        <td><?php echo $v->qualification_type; ?></td>
                        <td><?php echo $v->qualification_title; ?></td>
                        <td><?php echo $v->qualification_level_name; ?></td>
                        <!-- <td><?php //if(!empty($v->qmdd_user_type)) echo $v->qmdd_user_type->t_name; ?></td> -->
                        <!-- <td>
                            <a href="<?php //echo $basepath->F_WWWPATH.$v->head_pic; ?>" target="_blank">
                                <div style="width:50px; height:50px;overflow:hidden;">
                                    <img src="<?php //echo $basepath->F_WWWPATH.$v->head_pic; ?>" width="50">
                                </div>
                            </a>
                        </td> -->
                        <td><?php echo $v->servic_site_name; ?></td>
                        <td><?php echo $v->check_state_name; ?></td>
                        <td><?php echo $v->state_time; ?></td>
                        <!-- <td><?php // if(!empty($v->club_list)) echo $v->club_list->club_name; ?><!-- </td> -->
                        <td><?php echo $v->process_preson_account.' / '.$v->process_preson_nick; ?></td>
                        <td>
                            <?php
                                // if(empty($_REQUEST['state'])) {
                                    echo show_command('审核',$this->createUrl('update_check', array('id'=>$v->id)),'查看');
                                // }
                                // else{
                                //     echo show_command('修改',$this->createUrl('update', array('id'=>$v->id)),'编辑');
                                //     echo '&nbsp;';
                                //     echo show_command('删除','\''.$v->id.'\'');
                                // }
                            ?>
                        </td>
                    </tr>
                <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    $('.click_time').on('click',function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>