<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》GF商城上下架管理》<a class="nav-a">商品下架审核</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('mallLowerSet/index_check');?>">待审核(<span class="red"><b><?php echo $num; ?></b></span>)</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>审核日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text"  placeholder="请输入方案编码/标题" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                        <th style="width:25px;">序号</th>
                        <th style="width:10%;"><?php echo $model->getAttributeLabel('event_code');?></th>
                        <th style="width:20%;"><?php echo $model->getAttributeLabel('event_title');?></th>
                        <th><?php echo $model->getAttributeLabel('supplier_id');?></th>
                        <th><?php echo $model->getAttributeLabel('down_time');?></th>
                        <th>操作</th>
                    </tr>
<?php $index=1; foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->event_code; ?></td>
                        <td><?php echo $v->event_title; ?></td>
                        <td><?php echo $v->supplier_name; ?></td>
                        <td><?php echo $v->down_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_check', array('id'=>$v->id,'flag'=>'exam'));?>" title="详情">查看</a>
                          
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
$(function(){
    var $star_time=$('#start');
    var $end_time=$('#end');
    $star_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});
</script>
