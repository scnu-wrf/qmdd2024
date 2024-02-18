<div class="box">
  <div class="box-title c">
    <h1><span> <i class="fa fa-home"></i>当前界面：直播》直播设置》<a class="nav-a">邀请卡设置</a></span></h1>
    <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span> </div>
  <!--box-title end-->
  <div class="box-content">
    <div class="box-header"> <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a> <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> </div>
    <!--box-header end-->
    <div class="box-search">
<!--      <form action="<?php //echo Yii::app()->request->url;?>" method="get">
        <input type="hidden" name="r" value="<?php //echo Yii::app()->request->getParam('r');?>">
        <label style="margin-right:10px;"> <span>关键字：</span>
          <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php //echo Yii::app()->request->getParam('keywords');?>">
        </label>
        <button class="btn btn-blue" type="submit">查询</button>
      </form>
    </div>-->
    <!--box-search end-->
    <div class="box-table">
    
      <table class="list">
        <thead>
          <tr>
            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
            <th>序号</th>
            <th><?php echo $model->getAttributeLabel('card_code');?></th>
            <th><?php echo $model->getAttributeLabel('card_name');?></th>
            <th><?php echo $model->getAttributeLabel('card_img');?></th>
            <th><?php echo $model->getAttributeLabel('state');?></th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <?php $index = 1; foreach($arclist as $v){?>
          <tr>
            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
            <td><span class="num num-1"><?php echo $index; ?></span></td>
            <td><?php echo $v->card_code; ?></td>
            <td><?php echo $v->card_name; ?></td>
            <td>
                                           <div class="upload_img fl" id="upload_pic_inviteCardSet_card_img">
                                <?php if(!empty($v->card_img)) {?>
                                    <a href="<?php echo BasePath::model()->get_www_path().$v->card_img;?>" target="_blank"><img src="<?php echo BasePath::model()->get_www_path().$v->card_img;?>" width="50"></a>
                                <?php }?>
                            </div>
                    
                        </td>
            <td><?php
		     echo $v->state == 649  ?  '是' : '否';
	
			  ?></td>
            
            

            <td><a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a> <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a></td>
          </tr>
          <?php $index++; } ?>
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
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
</script> 
