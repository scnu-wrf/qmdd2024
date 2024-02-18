
<div class="box">
  <div class="box-title c">
    <h1>当前界面：系统》系统设置》视频分类</h1>
  </div>
  <div class="box-content">
    <div class="box-header"><a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a> <!--<a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>--></div>

    <!--<div class="box-search">
      <form action="<?php //echo Yii::app()->request->url;?>" method="get">
        <input type="hidden" name="r" value="<?php //echo Yii::app()->request->getParam('r');?>">
        <label style="margin-right:10px;"> <span>关键字：</span>
          <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="请输入分类名称" value="<?php //echo Yii::app()->request->getParam('keywords');?>">
        </label>
        <label style="margin-right:10px;"> <span>商品分类：</span>
          <input style="width:200px;" class="input-text" type="text" placeholder="请输入分类编码" name="code" value="<?php //echo Yii::app()->request->getParam('code');?>">
        </label>
        <button class="btn btn-blue" type="submit">查询</button>
      </form>
    </div>-->

    <div class="box-table">
      <table class="list">
        <thead>
          <tr>
            <!--<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>-->
            <th >序号</th>
            <th ><?php echo $model->getAttributeLabel('tn_code');?></th>
            <th ><?php echo $model->getAttributeLabel('base_f_id');?></th>
            <th ><?php echo $model->getAttributeLabel('sn_name');?></th>
            <th ><?php echo $model->getAttributeLabel('if_menu_dispay');?></th>
            <th >操作</th>  
          </tr>
        </thead>
        <tbody>
          <?php $index = 1; ?>
          <?php $basepath=BasePath::model()->getPath(159);?>
          <?php foreach($arclist as $v){ ?>
          <tr>
            <!--<td class="check check-item"><input class="input-check" type="checkbox" value="<?php //echo CHtml::encode($v->id); ?>"></td>-->
            <td><?php echo $index ?></td>
            <td><?php echo $v->tn_code; ?></td>
            <td><?php if(!empty($v->base_f_id))echo $v->ordertype->F_NAME; ?></td>
            <td><?php echo $v->sn_name; ?></td>
            <td><?php 
			if($v->if_menu_dispay==1){
				echo'显示';
			}else{
				echo'不显示';
		    }
			?></td>
            <td><a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑">编辑</a> <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a></td>
          </tr>
            <?php $index++; ?>   
          <?php } ?>
        </tbody>
      </table>
    </div>
    <!--box-table end-->
    <div class="box-page c">
      <?php $this->page($pages); ?>
    </div>
  </div>
  <!--box-content end--> 
</div>
<!--box end--> 
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
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
</script>