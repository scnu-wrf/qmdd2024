
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》GF商城上下架管理》<a class="nav-a">商品上架审核</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('mallPriceSet/index_check');?>">待审核(<span class="red"><b><?php echo $num; ?></b></span>)</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="pricing" value="<?php echo Yii::app()->request->getParam('pricing');?>">
                <label style="margin-right:10px;">
                    <span>审核日期：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                        <span>状态：</span>
                        <?php echo downList($base_code,'f_id','F_NAME','state'); ?>
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
                        <th style='width:25px; text-align: center;'>序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('event_code');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('event_title');?></th>
                        <th width="15%">上架商品</th>
                        <th><?php echo $model->getAttributeLabel('mall_member_price_id');?></th>
                        <th>显示时间</th>
                        <th>销售时间</th>
                        <th><?php echo $model->getAttributeLabel('f_check');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('reasons_time');?></th>
                        <th><?php echo $model->getAttributeLabel('reasons_adminID');?></th>
                        <th style="text-align:center">操作</th>
                    </tr>
<?php $index = 1;
if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->event_code; ?></td>
                        <td><?php echo $v->event_title; ?></td>
                        <td>
                <?php $sale=MallPriceSetDetails::model()->findAll('set_id='.$v->id.' AND flash_sale=0');
                    $sale_num=count($sale);
                    $sale_text='';
                    if($sale_num>3){
                        for($i=0;$i<3;$i++){
                        $sale_text.=$sale[$i]['product_name'].'<br>';
                        }
                        $sale_text.='...';
                    } else {
                        for($i=0;$i<$sale_num;$i++){
                        $sale_text.=$sale[$i]['product_name'].'<br>';
                        }
                    }
                            echo $sale_text; ?></td>
                        <td><?php echo $v->mall_member_price_name; ?></td>
                        <td><?php echo $v->star_time; ?><br><?php echo $v->end_time; ?></td>
                        <td><?php echo $v->start_sale_time; ?><br><?php echo $v->down_time; ?></td>
                        <td><?php if($v->f_check!=null) echo $v->base_code->F_NAME; ?></td>
                        <td><?php echo $v->reasons_time; ?></td>
                        <td><?php echo $v->reasons_admin_nick; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_check', array('id'=>$v->id,'flag'=>'pass'));?>" title="详情">查看</a>
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
