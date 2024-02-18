<div class="box">
    <div class="box-title c">
        <span>
            <a href="../../admin/index.php?act=main" class="lode_po" onclick="parent.location.reload();"><i class="fa fa-home"></i>当前界面：</a>赛事/活动/培训 ->
            <a href="#" class="lode_po">赛事管理</a> ->
            <a href="#" class="lode_po">赛事历史列表</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <span style="float:right;">
                <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            </span>
        </div><!--box-header end-->
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="game_type" value="<?php echo Yii::app()->request->getParam('game_type');?>">
                <div id="select6">
                    <label>
                        <span>关键字：</span>
                        <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编码或标题">
                    </label>
                    <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                </div>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <!-- <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th> -->
                        <th style='text-align: center;width:24px;'>序号</th>
                        <th style='text-align: center;width:9%;'><?php echo $model->getAttributeLabel('game_code');?></th>
                        <th style='text-align: center;width:15%'><?php echo $model->getAttributeLabel('game_title');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_club_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_area');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_level');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('dispay_time');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('signup_time');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_state');?></th>
                        <th style='text-align: center;width:8%'><?php echo $model->getAttributeLabel('publish_time');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){?>
                        <tr>
                            <!-- <td class="check check-item"><input class="input-check" type="checkbox" value="<?php //echo CHtml::encode($v->id); ?>"></td> -->
                            <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td style='text-align: center;'><?php echo $v->game_code; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_title; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_club_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->area_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->level_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->dispay_star_time.'<br>'.$v->dispay_end_time; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_statec; ?></td>
                            <td style='text-align: center;'><?php echo $v->Signup_date.'<br>'.$v->Signup_date_end; ?></td>
                            <td style='text-align: center;'>
                                <?php
                                    $left = substr($v->publish_time,0,10);
                                    $right = substr($v->publish_time,11);
                                    echo $left.'<br>'.$right;
                                ?>
                            </td>
                            <td style='text-align: center;'> <!-- display:inline-flex;-->
                                <?php echo show_command('详情',$this->createUrl('update_history', array('id'=>$v->id,'type'=>$v->game_type,'p_id'=>0))); ?>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->