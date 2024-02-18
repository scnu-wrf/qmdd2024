<?php
 $url="action=edit&club_id=".$_REQUEST['club_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>社区、合作伙伴相关</title>
</head>
<body>   
<div >
<div style="font-size: 16px">
<a href="..\qmdd\club_detail.php?<?php echo $url ?>" >基本信息</a></li>
|<a href="../qmdd2018/index.php?r=clubProject/index&<?php echo $url ?>" >项目信息</a></li>
|<a href="../qmdd2018/index.php?r=clubQualification/index&<?php echo $url ?>">资质人信息</a></li>
|<a href="../qmdd2018/index.php?r=clubQualificationInvite/index&<?php echo $url ?>">资质邀请管理信息</a></li>

</div>
<div class="box" div style="font-size: 9px">
    <div class="box-content">
        <div class="box-header">资质人信息--->>
    <a class="btn" href="<?php echo $this->createUrl('create',array('club_id'=>$_REQUEST['club_id']));?>">
            <i class="fa fa-plus"></i>添加</a>   
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
                <input  type="hidden" name="club_id" value="<?php echo $_REQUEST['club_id']; ?>">
                <button class="btn btn-blue" type="submit">查询</button>
         
               </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th><?php echo $model->getAttributeLabel('qcode');?></th>
                        <th><?php echo $model->getAttributeLabel('account');?></th>
                        <th><?php echo $model->getAttributeLabel('name');?></th>
                        <th><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th><?php echo $model->getAttributeLabel('type_name');?></th>
                        <th><?php echo $model->getAttributeLabel('level_name');?></th>
                        <th><?php echo $model->getAttributeLabel('state_name');?></th>
                        <th><?php echo $model->getAttributeLabel('uDate');?></th>
                        <th><?php echo $model->getAttributeLabel('start_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
    <tr>
        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
      <td><?php echo CHtml::link($v->qualifications_person->qualification_gf_code, 
         array('update', 'id'=>$v->id,'club_id'=>$v->club_id)); ?></td>
        <td><?php echo CHtml::link($v->qualifications_person->qualification_gfaccount, array('update', 'id'=>$v->id,'club_id'=>$v->club_id)); ?></td>
        <td><?php echo $v->qualifications_person->qualification_name; ?></td>
        <td><?php echo $v->project_name; ?></td>
        <td><?php echo $v->type_name; ?></td>
        <td><?php echo $v->qualifications_person->qualification_level_name; ?></td>
        <td><?php echo $v->state_name; ?></td>
        <td><?php echo $v->qualification_invite->uDate; ?></td>
        <td><?php echo $v->qualification_invite->start_time; ?></td>
        <td>
     <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'club_id'=>$v->club_id));?>" title="编辑"><i class="fa fa-edit"></i></a>
            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>