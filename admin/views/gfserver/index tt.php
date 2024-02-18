<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务器列表</h1></div><!--box-title end-->

    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="water-list c">
            <ul>
                <?php foreach($arclist as $v){ ?>
                <li>
                    <div class="pic"><div><table><tr><td><img src="<?php echo $v->server_code; ?>
  <?php //echo $v->w_pic; ?>">
                    </td></tr></table></div></div>
              <div class="title"><?php //echo $v->w_title; ?></div>
                    <div class="area"><?php //echo $v->base_code->F_NAME; ?></div>
                    <div class="xy">X轴：<?php echo $v->server_code; ?>%；Y轴：<?php echo $v->server_name; ?>%</div>
                   <div class="bar">
                        <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                        <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div><!--water-list end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>