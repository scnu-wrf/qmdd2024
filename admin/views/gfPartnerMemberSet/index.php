
<div class="box">
    <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: middle;float: right; margin-right: 10px;"><i class="fa fa-refresh"></i>刷新</a>
    <div class="box-title c"><h1><i class="fa fa-table"></i>当前界面：会员 》会员设置 》成员入会模板设置</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="<?=$_REQUEST['type']==403?'current':'';?>"><a href="<?php echo $this->createUrl('index',array('type'=>403));?>">个人</a></li>
                <li class="<?=$_REQUEST['type']==404?'current':'';?>"><a href="<?php echo $this->createUrl('index',array('type'=>404));?>">单位</a></li>
            </ul>
        </div>
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create',array('type'=>$_REQUEST['type']));?>"><i class="fa fa-plus"></i>添加</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入模板编号或模板名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style=''>序号</th>
                        <th style=''><?php echo $model->getAttributeLabel('type');?></th>
                        <th style=''><?php echo $model->getAttributeLabel('code');?></th>
                        <th style=''><?php echo $model->getAttributeLabel('title');?></th>
                        <th style=''><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th style=''><?php echo $model->getAttributeLabel('rules');?></th>
                        <th style=''><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th style=''>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php 
    $index = 1;
    foreach($arclist as $v){
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style=''><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style=''><?php if($v->units!=null){ echo $v->units->F_NAME; } ?></td>
                        <td style=''><?php echo $v->code; ?></td>
                        <td style=''><?php echo $v->title; ?></td>
                        <td style=''><?php if($v->project_list!=null){ echo $v->project_list->project_name; } ?></td>
                        <td style=''><?php if($v->rule!=null){ echo $v->rule->F_NAME; } ?></td>
                        <td style=''><?php echo $v->club_name; ?></td>
                        <td style=''>
                            <!-- <a class="btn" href="<?php //echo $this->createUrl('gfPartnerMemberInputset/index',array('pid' => $v->id ,'ptype' => $v->type));?>" title="录入属性列表">属性列表</a> -->
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
