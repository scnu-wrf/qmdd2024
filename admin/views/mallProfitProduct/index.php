<div class="box">
    <div class="box-content">
        <div class="box-title c">
            <h1>当前界面：商城》毛利管理》<a class="nav-a">商品毛利查询</a></h1>
            <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
        </div><!--box-title c end-->
        <div class="box-content">
            <div class="box-search">
                <form action="<?php echo Yii::app()->request->url;?>" method="get">
                    <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                    <label style="margin-right:10px;">
                        <span>关键字：</span>
                        <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="商品编号/商品名称">
                    </label>
                    <button class="btn btn-blue" type="submit">查询</button>
                </form>
            </div><!--box-search end-->
            <div class="box-table">
                <table class="list">
                    <thead>
                        <tr>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th style="text-align:center;width:25px;">序号</th>
                            <th><?php echo $model->getAttributeLabel('product_code');?></th>
                            <th><?php echo $model->getAttributeLabel('product_name');?></th>
                            <th><?php echo $model->getAttributeLabel('json_attr');?></th>
                            <th><?php echo $model->getAttributeLabel('info_id');?></th>
                            <th>适用销售时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
<?php $index = 1;
foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->product_code; ?></td>
                            <td><?php echo $v->product_name; ?></td>
                            <td><?php echo $v->json_attr; ?></td>
                            <td><?php if(!empty($v->info)) echo $v->info->f_name; ?></td>
                            <td><?php echo $v->star_time; ?><br><?php echo $v->end_time; ?></td>
                            <td>
                                <a class="btn" href="javascript:;" onclick="fnLog(<?php echo $v->id;?>);" title="明细">毛利明细</a>
                            </td>
                        </tr>
                        <?php $index++; } ?>
                    </tbody>
                </table>
            </div><!--box-table end-->
            <div class="box-page c"><?php $this->page($pages); ?></div>
        </div>
    </div><!--box-content-->
</div><!--box end-->
<script>
// 查看毛利明细
var fnLog=function(detail_id){
    $.dialog.open('<?php echo $this->createUrl("log");?>&detail_id='+detail_id,{
        id:'jilu',
        lock:true,
        opacity:0.3,
        title:'查看毛利明细',
        width:'95%',
        height:'95%',
        close: function () {}
    });
};
</script>