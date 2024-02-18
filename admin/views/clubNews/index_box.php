<div class="box">
    <div class="box-title c">
        <span><h1>当前界面：资讯》资讯管理》各单位动态查询</h1></span>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <label style="margin-right:10px;">
                    <span>上下线日期：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>类型：</span>
                    <?php echo downList($news_type,'f_id','F_NAME','news_type'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>是否上线：</span>
                    <?php echo downList($online,'f_id','F_NAME','online'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="编号/标题/单位名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <span>&nbsp;
                <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
                </span>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="width:25px; text-align:center;">序号</th>
                        <th width="5%">类型</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('news_code');?></th>
                        <th style="width:100px;"><?php echo $model->getAttributeLabel('news_pic');?></th>
                        <th width="15%"><?php echo $model->getAttributeLabel('news_title');?></th>
                        <th><?php echo $model->getAttributeLabel('state');?></th>
                        <th style="width:120px;">上下线时间</th>
                        <th>是否上线</th>
                        <th width="5%"><?php echo $model->getAttributeLabel('news_clicked');?></th>
                        <th width="12%"><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(124);?>
<?php 
$index = 1;
foreach($arclist as $v){ 
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->news_type_name; ?></td>
                        <td><?php echo $v->news_code; ?></td>
                        <td><a href="<?php echo $basepath->F_WWWPATH.$v->news_pic; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v->news_pic; ?>" style="max-height:100px; max-width:100px;"></a></td>
                        <td><?php echo $v->news_title; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo $v->news_date_start; ?><br>
                            <?php echo $v->news_date_end; ?></td>
                        <?php $now=date('Y-m-d H:i:s');$fl=0;
                        if($now>$v->news_date_start && $now<$v->news_date_end) $fl=1; ?>
                        <td><?php echo ($fl==1) ? '是' : '否'; ?></td>
                        <td><?php echo $v->news_clicked; ?></td>
                        <td><?php echo $v->news_club_name; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('box_check', array('id'=>$v->id));?>" id="a1">查看</a>
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
$(function(){
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
	$start_time.on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});});
    $end_time.on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});});
});

function setText(a1){
document.getElementById("a1").style.textDecoration="underline";
}

</script>
