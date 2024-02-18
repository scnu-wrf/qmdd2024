
<div class="box">
    <div class="box-title c">
            <h1>当前界面：商城》GF商城上下架管理》<a class="nav-a"><?php if($_REQUEST['pricing']==351){echo '赛事报名费列表';}else{echo '商品上架列表';} ?></a></h1>
            <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
        </div><!--box-title c end-->
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'新增上架'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="pricing" value="<?php echo Yii::app()->request->getParam('pricing');?>">
                <label style="margin-right:20px;">
                    <span>状态：</span>
                    <?php echo downList($state,'f_id','F_NAME','state'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="方案编码/标题" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('event_code');?></th>
                                <th width="10%"><?php echo $model->getAttributeLabel('event_title');?></th>
                        <th width="15%">上架商品</th>
                        <th><?php echo $model->getAttributeLabel('mall_member_price_id');?></th>
                        <th>显示时间</th>
                        <th>销售时间</th>
                        <th><?php echo $model->getAttributeLabel('f_check');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('update_date');?></th>
                        <th style="text-align:center">操作</th>
                    </tr>
                <?php foreach($arclist as $v){ ?>
                    <tr>
                    	<td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->event_code; ?></td>
                        <td><?php echo $v->event_title; ?></td>
                        <td>
                    <?php $sale=MallPriceSetDetails::model()->findAll('set_id='.$v->id);
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
                        <td><?php if(!empty($v->base_code)) echo $v->base_code->F_NAME; ?></td>
                        <td><?php echo $v->update_date; ?></td>
                        <td>
                            <?php if($v->f_check<>371 && $v->f_check<>372){?>
                        	<a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                            <?php } ?>
                            <?php if($v->f_check==371){?>
                            <a class="btn" href="<?php echo $this->createUrl('update_check', array('id'=>$v->id,'flag'=>'index'));?>" title="详情">查看</a>
                            <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancel);" title="撤销提交">撤销</a>
                        <?php } ?>
                            <?php
                                if($_REQUEST['pricing']==351){
                                    echo '<a class="btn" href="javascript:;" onclick="refresh('.$v->id.');" title="刷新"><i class="fa fa-refresh"></i>刷新</a>';
                                }
                            ?>
                        </td>
                    </tr>
                   <?php } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    function refresh(id){
        we.loading('show');
        $.ajax({
            type:'post',
            url:'<?php echo $this->createUrl('refresh'); ?>&id='+id,
            dataType:'json',
            success: function(data){
                we.loading('hide');
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>
