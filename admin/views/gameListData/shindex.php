<?php
   check_request('game_type',0);
   check_request('game_id',0);
   check_request('title',0);
   $gamelist=GameList::model()->find('id='.$_REQUEST['game_id']);
 ?>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i><?php echo $gamelist->game_title.' /' ?>赛事项目列表</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/shlist');?>');"><i class="fa fa-reply"></i>返回审核列表</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab">
            <ul class="c">
                <?php $action=Yii::app()->controller->getAction()->id;?>
                <li><a href="<?php echo $this->createUrl('gameList/shupdate',array('id'=>$_REQUEST['game_id'],'type'=>$gamelist->game_type));?>">基本信息</a></li>
                <?php if($gamelist->game_type==163) {?>
                    <li class="current"><a href="<?php echo $this->createUrl('gameListData/shindex',array('game_id'=>$_REQUEST['game_id'],'title'=>$gamelist->game_title,'type'=>$gamelist->game_type));?>">竞赛项目</a></li>
                <?php }?>
                <li><a href="<?php echo $this->createUrl('gameIntroduction/index',array('game_id'=>$_REQUEST['game_id'],'title'=>$gamelist->game_title,'type'=>$gamelist->game_type));?>">竞赛规则</a></li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="game_id" value="<?php echo $_GET["game_id"];?>">
                <label style="margin-right:20px;">
                    <span>赛事模式：</span>
                    <select name="game_mode">
                        <option value="">请选择</option>
                        <?php foreach($game_mode as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('game_mode')!=null && Yii::app()->request->getParam('game_mode')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>按项目：</span>
                    <select name="project_id">
                        <option value="">请选择</option>
                        <?php foreach($project_id as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('project_id')!=null && Yii::app()->request->getParam('project_id')==$v->id){?> selected<?php }?>><?php echo $v->project_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号/竞赛项目名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_data_code');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_data_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_mode');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_money');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('number_of');?></th>
                      
                         <th style='text-align: center;'><?php echo $model->getAttributeLabel('signup_dateing');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('uDate');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
				<?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->game_data_code; ?></td>
                        <td style='text-align: center;'><?php echo $v->project_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->game_data_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->game_mode_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->game_money; ?></td>
                        <td style='text-align: center;'><?php 
                        echo ($v->game_player_team==665) ? $v->number_of_member_min.' / '.$v->number_of_member :$v->min_num_team.' / '.$v->max_num_team
                           ; ?></td>
                        <td style='text-align: center;'>
                        <?php echo $v->signup_date.' / '.$v->signup_date_end; ?></td>
                        <td style='text-align: center;'><?php echo $v->uDate; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('shupdate', array('id'=>$v->id,'game_id'=>$_REQUEST['game_id'],'title'=>$gamelist->game_title,'type'=>$gamelist->game_type));?>" title="详情"><i class="fa fa-edit"></i></a>
                           
                        </td>
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
</script>