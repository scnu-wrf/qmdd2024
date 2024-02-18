<?php 
   check_request('game_type',0);
   check_post('data_id',0);
   check_post('data_type',0);
?>
<style>
    .box-search div{ display:inline-block; }
    #keywords{ margin-left: 12px; }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》赛事发布 》取消/审核不通过</h1>
        <span style="float:right;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
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
        <ul class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;width:24px;'>序号</th>
                        <th style='text-align: center;width:9%;'><?php echo $model->getAttributeLabel('game_code');?></th>
                        <th style='text-align: center;width:15%'><?php echo $model->getAttributeLabel('game_title');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_level');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_area');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_time1');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_club_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state1');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){?>
                        <tr>
                            <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td style='text-align: center;'><?php echo $v->game_code; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_title; ?></td>
                            <td style='text-align: center;'><?php echo $v->level_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->area_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_time.'<br>'.$v->game_time_end; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_club_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->state_name; ?></td>
                            <td style='text-align: center;'>
                                <?php echo show_command('详情',$this->createUrl('failshow', array('id'=>$v->id,'type'=>$v->game_type,'p_id'=>0)),'查看'); ?>
                                <?php echo show_command('删除','\''.$v->id.'\'') ?>
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