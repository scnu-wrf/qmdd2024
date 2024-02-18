
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名》赛事动态》<a class="nav-a">动态列表</a></h1>
        <span class="back"><a class="btn" href="<?php echo Yii::app()->request->url;?>"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>上下线日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>类型：</span>
                    <?php echo downList($news_type,'f_id','F_NAME','news_type'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="编号/标题/赛事名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center; width:25px;'>序号</th>
                        <th style="width:10%;"><?php echo $model->getAttributeLabel('news_code');?></th>
                        <th><?php echo $model->getAttributeLabel('news_type');?></th>
                        <th style="width:20%;"><?php echo $model->getAttributeLabel('news_title');?></th>
                        <th style="width:20%;"><?php echo $model->getAttributeLabel('game_names');?></th>
                        <th><?php echo $model->getAttributeLabel('state');?></th>
                        <th>上下线时间</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('news_clicked');?></th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $index = 1;
                        foreach($arclist as $v){
                    ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->news_code; ?></td>
                        <td><?php echo $v->news_type_name; ?></td>
                        <td><?php echo $v->news_title; ?></td>
                        <td><?php echo $v->game_names; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo $v->news_date_start; ?><br><?php echo $v->news_date_end; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->news_clicked; ?></td>
                        <td><?php echo $v->club_names; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_checked', array('id'=>$v->id));?>" title="详情">查看</a>
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
    var $star_time=$('#start_date');
    var $end_time=$('#end_date');
    $star_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>