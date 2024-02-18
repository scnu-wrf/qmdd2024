
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务预订明细</h1></div>
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">  
                <label style="margin-right:20px;">
                    <span>服务类别：</span>
                    <?php echo downList($server_type_list,'id','f_uname','server_type'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>审核状态：</span>
                    <?php echo downList($state,'f_id','F_NAME','state'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>下单时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start" name="start" value="<?php echo Yii::app()->request->getParam('start');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end" name="end" value="<?php echo Yii::app()->request->getParam('end');?>">
                </label>
                <label style="margin-right:10px">
                    <span>关键字：</span>
                    <input type="text" style="width:200px;" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入资源名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align: center;">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('service_code');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('t_stypename');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('data_name');?></th>
                        <th style="text-align: center;">预订数量</th>
                        <th style="text-align: center;">营业额</th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center"><?php echo $v->service_code; ?></td>
                        <td style="text-align: center"><?php echo $v->t_stypename; ?></td>
                        <td style="text-align: center"><?php echo $v->data_name; ?></td>
                        <td style="text-align: center"><?php echo $v->count; ?></td>
                        <td style="text-align: center"><?php echo $v->amount; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="javascript:;" onclick="fnLog(<?php echo $v->qmdd_server_set_list_id;?>);" title="查看记录">查看记录</a>
                        </td>
                    </tr>
<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>

$(function(){
	
	var $star=$('#start');
    var $end=$('#end');
    $star.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});
// 查看预订记录
var fnLog=function(list_id){
    $.dialog.open('<?php echo $this->createUrl("log",array('state'=>$state_v,'start'=>$start,'end'=>$end,'typeId'=>$server_type));?>&list_id='+list_id,{
        id:'jilu',
        lock:true,
        opacity:0.3,
        title:'预订记录',
        width:'95%',
        height:'95%',
        close: function () {}
    });
};

</script>