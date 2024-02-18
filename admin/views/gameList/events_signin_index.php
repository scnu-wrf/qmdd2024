<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>报到管理</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入关键字">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align: center;">序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_title');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_time');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1;
                 foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->game_title; ?></td>
                        <td style='text-align: center;'><?php echo $v->game_time; ?></td>
                        <!-- <td style='display: none;'><?php //echo $v->game_type; ?></td> -->
                        <td style='text-align: center;'> <!-- display:inline-flex;-->
                            <a class="btn" href="<?php echo $this->createUrl('GameSignList/event_mem_index', array('game_id'=>$v->id,'game_name'=>$v->game_title)); ?>"  title="报名名单">报名名单</a>
                            <a class="btn" href="<?php echo $this->createUrl('gfServiceData/events_signin_index',array('game_id'=>$v->id,'game_name'=>$v->game_title)); ?>"  title="报到名单">报到名单</a>
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
</script>
<script>
    $(function(){
        var $servic_time_star=$('#servic_time_star');
        var $servic_time_end=$('#servic_time_end');
        $servic_time_star.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $servic_time_end.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });
    
</script>