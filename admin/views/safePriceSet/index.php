
<div class="box">
    <div class="box-title c">
      <h1><i class="fa fa-table"></i>保险上架列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>新增方案</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <table width="100%">   
                	<tr>
                    	<td width="100">供应商：</td>
                        <td>
                    <input style="width:200px;" class="input-text"  placeholder="请输入供应商" type="text" name="supplier" value="<?php echo Yii::app()->request->getParam('supplier');?>">
                		</td>
                    	<td width="100">上下线日期：</td>
                        <td>
                    <input style="width:120px;" class="input-text" type="text" id="star_time" name="star_time" value="<?php echo Yii::app()->request->getParam('star_time');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo Yii::app()->request->getParam('end_time');?>">
                </label>
                		</td>
                </tr>
                <tr>
                	<td><label>审核状态：</label></td>
                    <td>
                    <label><?php echo downList($base_code,'f_id','F_NAME','state'); ?></label>
                    &nbsp;&nbsp;<label><span style="margin-right:20px;">上线状态：</span>
                    <?php echo downList($userstate,'f_id','F_NAME','userstate'); ?></label>
                	</td>
                    <td><label>关键字：</label></td>
                    <td><label><input style="width:200px;" class="input-text"  placeholder="请输入方案编码/标题" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>"></label>
                <button class="btn btn-blue" type="submit">查询</button>
                	</td>
                </tr>
            </table>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th width="10%" style="text-align:center"><?php echo $model->getAttributeLabel('event_code');?></th>
                        <th width="15%" style="text-align:center"><?php echo $model->getAttributeLabel('event_title');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('supplier_id');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('if_user_state');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('f_check');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('star_time');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('end_time');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('update_date');?></th>
                        <th style="text-align:center">操作</th>
                    </tr>
                    <?php 
					 if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                    	<td class="check check-item"><?php if($v->f_check<>371 && $v->f_check<>372){?><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"><?php } ?></td>
                        <td><?php echo $v->event_code; ?></td>
                        <td><?php echo $v->event_title; ?></td>
                        <td><?php echo $v->supplier_name; ?></td>
                        <td><?php if($v->if_user_state!=null){ $if_user_state=array(648=>'否', 649=>'是'); echo $if_user_state[$v->if_user_state]; } ?></td>
                        <td><?php if($v->f_check!=null){ echo $v->base_code->F_NAME; } ?></td>
                        <td><?php echo $v->star_time; ?></td>
                        <td><?php echo $v->end_time; ?></td>
                        <td><?php echo $v->update_date; ?></td>
                        <td>
                        	<a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <?php if($v->f_check<>371 && $v->f_check<>372){?>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                            <?php } ?>
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
