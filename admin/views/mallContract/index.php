
<div class="box">
    <div class="box-title c">
      <h1><i class="fa fa-table"></i>商品采购价设置</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="pricing" value="<?php echo Yii::app()->request->getParam('pricing');?>">
                <label style="margin-right:10px;">
                    	<span>有效时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="star_time" name="star_time" value="<?php echo Yii::app()->request->getParam('star_time');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo Yii::app()->request->getParam('end_time');?>">
                </label>
                <label style="margin-right:10px;">
                    	<span>审核状态：</span>
                		<?php echo downList($base_code,'f_id','F_NAME','state'); ?>
                </label>
                <label style="margin-right:10px;">
                    	<span>关键字：</span>
                		<input style="width:200px;" class="input-text"  placeholder="请输入编码/合同编号/合同标题" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('c_code');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('c_no');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('c_title');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('supplier_id');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('f_check');?></th>
                        <th style="text-align:center; width:70px;"><?php echo $model->getAttributeLabel('star_time');?></th>
                        <th style="text-align:center; width:70px;"><?php echo $model->getAttributeLabel('end_time');?></th>
                        <th style="text-align:center; width:70px;"><?php echo $model->getAttributeLabel('update_date');?></th>
                        <th style="text-align:center">操作</th>
                    </tr>
                    <?php 
					 if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                    	<td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->c_code; ?></td>
                        <td><?php echo $v->c_no; ?></td>
                        <td><?php echo $v->c_title; ?></td>
                        <td><?php echo $v->supplier_name; ?></td>
                        <td><?php if($v->f_check!=null){ echo $v->base_code->F_NAME; } ?></td>
                        <td><?php echo $v->star_time; ?></td>
                        <td><?php echo $v->end_time; ?></td>
                        <td><?php echo $v->update_date; ?></td>
                        <td>
                        	<a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
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
    $(function(){
        var $star_time=$('#star_time');
        var $end_time=$('#end_time');
        $star_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
        });
    });

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
