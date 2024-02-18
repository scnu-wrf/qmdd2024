
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名》赛事动态》<a class="nav-a">发布待审核</a></h1>
        <span class="back"><a class="btn" href="<?php echo Yii::app()->request->url;?>"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
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
                        <th><?php echo $model->getAttributeLabel('apply_date');?></th>
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
                        <td><?php echo $v->apply_date; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_submit', array('id'=>$v->id));?>" title="详情">查看</a>
                            <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancel);" title="撤销申请">撤销</a>
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
var cancel = '<?php echo $this->createUrl('cancelSubmit', array('id'=>'ID'));?>';
</script>