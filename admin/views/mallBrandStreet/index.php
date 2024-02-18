<div class="box">
    <div class="box-title c">
    <h1>当前界面：商城》品牌管理》商城品牌管理</h1>
     <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    
    </div>
    <div class="box-content">
    	<div class="box-header"  style="display:none;">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>是否上线：</span>
                    <select id="online" name="online">
                        <option value="">请选择</option>
                        <option value="649"<?php if(Yii::app()->request->getParam('online')!==null && Yii::app()->request->getParam('online')!==''  && Yii::app()->request->getParam('online')==649){?> selected<?php }?>>是</option>
                        <option value="648"<?php if(Yii::app()->request->getParam('online')!==null && Yii::app()->request->getParam('online')!==''  && Yii::app()->request->getParam('online')==648){?> selected<?php }?>>否</option>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="品牌名称/所属商家">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <!--<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>-->
                        <th class="list-id">序号</th>
                        <th>品牌LOGO</th>
                        <th>品牌名称</th>
                        <th>品牌类型</th>
                        <th>所属商家</th>
                        <th>状态</th>
                        <th>是否上线</th>
                        <th>审核时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                   <?php $basepath=BasePath::model()->getPath(167);?>
                   
                   <?php $index = 1; ?>
<?php if (is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
    <!--<td class="check check-item"><input class="input-check" type="checkbox" value="<?php //echo CHtml::encode($v->brand_id); ?>"></td>-->
    <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>

    <td><?php if(!empty($v->brand_logo_pic)){?><a href="<?php echo $basepath->F_WWWPATH.$v->brand_logo_pic; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v->brand_logo_pic; ?>" style="max-height:50px; max-width:50px;"></a><?php }?></td>
    <td><?php echo $v->brand_title; ?></td>
    <td><?php if(!empty($v->base_code_brand_type_id->F_NAME)) echo $v->base_code_brand_type_id->F_NAME;?></td>
    <td><?php if(!empty($v->ClubList_record->club_name)) echo $v->ClubList_record->club_name;?></td>
    <td><?php if(!empty($v->base_code_state->F_NAME)) echo $v->base_code_state->F_NAME;?></td>
    <td>
	<?php if(empty($v->brand_state)) echo '否';?>
	<?php if(!empty($v->base_code_yes_no->F_NAME)) echo $v->base_code_yes_no->F_NAME;?></td>
    <td><?php echo $v->f_userdate; ?></td>
    <td>
       
      <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->brand_id,'action'=>'index_brand_manage'));?>" title="查看">查看</a>
      
      <?php if($v->brand_state == 648 || empty($v->brand_state)){?>
       <a href="javascript:;" onclick="to_on_line(<?php echo $v->brand_id;?>)" class="btn">上线</a>
      <?php }else{?>
       <a href="javascript:;" onclick="to_off_line(<?php echo $v->brand_id;?>)" class="btn">下线</a>
      <?php }?>   
        </td>
    </tr>
                    
  <?php $index++; ?>                  
                    
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('brand_id'=>'ID'));?>';
</script>
<script>
$(function(){
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        var end_input=$dp.$('end_date')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
    });
});

function to_on_line(id) {
		
      var can1 = function(){
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('on_line');?>',
			data: {id: id},
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
       }
	
			$.fallr('show', {
            buttons: {
                button1: {text: '是', danger: true, onclick: can1},
                button2: {text: '否'}
            },
			
            content: '确定上线吗？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
	
	}
	
	
  function to_off_line(id) {
		
      var can1 = function(){
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('off_line');?>',
			data: {id: id},
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
       }
	
			$.fallr('show', {
            buttons: {
                button1: {text: '是', danger: true, onclick: can1},
                button2: {text: '否'}
            },
			
            content: '确定下线吗？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
	
	}
</script>