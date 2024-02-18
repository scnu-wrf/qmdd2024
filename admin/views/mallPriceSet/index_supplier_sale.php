
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商品上架》<a class="nav-a">上架方案列表</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="pricing" value="<?php echo Yii::app()->request->getParam('pricing');?>">
                <label style="margin-right:10px;">
                    <span>显示时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>销售时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_time" name="start_time" value="<?php echo $start_time;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo $end_time;?>">
                </label>
                <label style="margin-right:10px;">
                        <span>上下线状态：</span>
                    <select id="userstate" name="userstate">
                        <option value="">请选择</option>
                        <option value="649"<?php if(Yii::app()->request->getParam('userstate')!==null && Yii::app()->request->getParam('userstate')!==''  && Yii::app()->request->getParam('userstate')==649){?> selected<?php }?>>上线</option>
                        <option value="648"<?php if(Yii::app()->request->getParam('userstate')!==null && Yii::app()->request->getParam('userstate')!==''  && Yii::app()->request->getParam('userstate')==648){?> selected<?php }?>>下线</option>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    	<span>&nbsp;&nbsp;&nbsp;关键字：</span>
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
                        <th width="15%"><?php echo $model->getAttributeLabel('event_title');?></th>
                        <th><?php echo $model->getAttributeLabel('if_user_state');?></th>
                        <th>显示时间</th>
                        <th>销售时间</th>
                        <th><?php echo $model->getAttributeLabel('f_check');?></th>
                        <th style="width:70px;">操作时间</th>
                        <th style="text-align:center">操作</th>
                    </tr>
<?php $index = 1;
if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->event_code; ?></td>
                        <td><?php echo $v->event_title; ?></td>
                        <td><?php if($v->if_user_state!=null){ $if_user_state=array(648=>'下线', 649=>'上线'); echo $if_user_state[$v->if_user_state]; } ?></td>
                        <td><?php echo $v->star_time; ?><br><?php echo $v->end_time; ?></td>
                        <td><?php echo $v->start_sale_time; ?><br><?php echo $v->down_time; ?></td>
                        <td><?php if($v->f_check!=null) echo $v->base_code->F_NAME; ?></td>
                        <td><?php echo $v->reasons_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_supplier_check', array('id'=>$v->id,'flag'=>'sale'));?>" title="详情">查看</a>
                            <?php if($v->if_user_state==649){ ?>
                            <a class="btn" href="javascript:;" onclick="we.down('<?php echo $v->id;?>', downUrl);" title="下线处理">下线</a>
                        <?php } else{ ?>
                            <a class="btn" href="javascript:;" onclick="we.online('<?php echo $v->id;?>', onlineUrl);" title="上线处理">上线</a>
                        <?php }?>
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>

var downUrl = '<?php echo $this->createUrl('down', array('id'=>'ID'));?>';
var onlineUrl = '<?php echo $this->createUrl('online', array('id'=>'ID'));?>';
$(function(){
    var $start_time=$('#start_time');
    var $end_time=$('#end_time');
    var $start=$('#start');
    var $end=$('#end');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});

</script>
