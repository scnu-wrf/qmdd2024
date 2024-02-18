<div class="box">
    <div class="box-title c">
        <h1>当前界面：项目 》平台项目管理 》竞赛项目设置</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create_game_project_setting'),'添加');?>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入项目编码或赛事项目">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <!-- <th class="list-id">序号</th> -->
                        <th><?php echo $model->getAttributeLabel('CODE');?></th>
                        <th><?php echo $model->getAttributeLabel('project_name1');?></th>
                        <th><?php echo $model->getAttributeLabel('project_name2');?></th>
                        <th><?php echo $model->getAttributeLabel('game_model');?></th>
                        <th><?php echo $model->getAttributeLabel('game_sex');?></th>
                        <th><?php echo $model->getAttributeLabel('game_age');?></th>
                        <th><?php echo $model->getAttributeLabel('game_weight');?></th>
                        <th><?php echo $model->getAttributeLabel('game_man_num');?></th>
                        <th><?php echo $model->getAttributeLabel('game_team_num');?></th>
                        <th><?php echo $model->getAttributeLabel('game_team_mem_num');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php //echo $v->id; ?>" disabled></td>
                            <!-- <td><span class="num num-1"><?php //echo $index ?></span></td> -->
                            <td><?php echo $v->CODE; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style='width:15%;'>
                                <?php echo show_command('修改',$this->createUrl('update_game_project_setting', array('id'=>$v->id,'fater_id'=>$v->id)),'编辑');?>
                                <?php //echo show_command('删除','\''.$v->id.'\'');?>
                            </td>
                        </tr>
                        <?php
                            $project_list = ProjectListGame::model()->findAll('project_id='.$v->id);
                            if(!empty($project_list))foreach($project_list as $v2){
                        ?>
                            <tr>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v2->id); ?>"></td>
                                <!-- <td><span class="num num-1"><?php //echo $index ?></span></td> -->
                                <td><?php echo $v2->project_code; ?></td>
                                <td></td>
                                <td><?php echo $v2->game_item; ?></td>
                                <td>
                                    <?php
                                        if(!empty($v2->game_model)){
                                            $game_model = BaseCode::model()->findAll('f_id in('.$v2->game_model.')');
                                            $str = '';
                                            if(!empty($game_model))foreach($game_model as $gm){
                                                if(!empty($str)) $str .= ',';
                                                $str .= $gm->F_NAME;
                                            }
                                            echo $str;
                                        }
                                    ?>
                                </td>
                                <td><?php if(!empty($v2->game_sex)) echo $v2->base_sex->F_NAME; ?></td>
                                <td><?php if(!empty($v2->game_age)) echo $v2->base_age->F_NAME; ?></td>
                                <td><?php if(!empty($v2->game_weight)) echo $v2->base_weight->F_NAME; ?></td>
                                <td><?php if(!empty($v2->game_man_num)) echo $v2->base_man_num->F_NAME; ?></td>
                                <td><?php if(!empty($v2->game_team_num)) echo $v2->base_team_num->F_NAME; ?></td>
                                <td><?php if(!empty($v2->game_team_mem_num)) echo $v2->base_team_man_num->F_NAME; ?></td>
                                <td style='width:15%;'>
                                    <?php echo show_command('修改',$this->createUrl('update_game_project_setting', array('id'=>$v2->id)),'编辑');?>
                                    <?php echo show_command('删除','\''.$v2->id.'\'');?>
                                </td>
                            </tr>
                        <?php }?>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete1', array('id'=>'ID'));?>';
</script>