<?php  if (!isset($_REQUEST['lang_type'])) {$_REQUEST['lang_type']=0;}
 $title='系统>权限管理>'.get_session('club_name').'>用户授权';
  if ($_REQUEST['lang_type']==0)  $title='系统>权限管理>平台单位授权';
 ?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php echo $title;?></h1></div><!--box-title end-->
    <div class="box-content">
    <div class="box-header">
    <a class="btn" href="<?php echo $this->createUrl('create',array('lang_type'=>$_REQUEST['lang_type']));?>"><i class="fa fa-plus"></i>添加</a>
    <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
    <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="clubadmin/index">
                <input type="hidden" name="lang_type" value="<?php echo $_REQUEST['lang_type']; ?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->

<div class="box-table">
    <table class="list">
    <thead>
        <tr>
            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
            <th class="list-id"><?php echo $model->getAttributeLabel('admin_gfaccount');?></th>
            <th>用户名称</th>
            <th>用户类型</th>
            <th>授权角色</th>
            <th><?php echo $model->getAttributeLabel('customer_service');?></th>
            <th>授权日期</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
<?php foreach($arclist as $v){ ?>
<tr>
    <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
    <td><?php echo CHtml::link($v->admin_gfaccount, array('id'=>$v->id,'lang_type'=>$v->lang_type)); ?></td>
    <td><?php echo CHtml::link($v->admin_gfid!=0?$v->admin_gfnick:$v->club_name, array('id'=>$v->id,'lang_type'=>$v->lang_type)); ?></td>
    <td><?php echo CHtml::link($v->admin_gfaccount, array('id'=>$v->id,'lang_type'=>$v->lang_type)); ?></td>

    <td><?php echo $v->role_name; ?></td>
    <td><?php echo $v->customer_service==1?'是':'否'; ?></td>
    <td><?php echo $v->last_login; ?></td>
    <td>
        <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'lang_type'=>$v->lang_type));?>" title="编辑"><i class="fa fa-edit"></i></a>
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
var resetUrl = '<?php echo $this->createUrl('resetPassword', array('id'=>'ID'));?>';

// 发送邀请
var resetPass=function(pid){
    we.loading('show');
    $.ajax({
        type: 'get',      
        url: '<?php echo $this->createUrl('resetPassword');?>',
        dataType: 'json',
        success: function(data) {
        
            if(data.status==1){
                we.loading('hide');
                $.dialog.list['addlianmeng'].close();
                we.success(data.msg, data.redirect);
            }else{
                we.loading('hide');
                we.msg('minus', data.msg);
            }
        }
    });
    return false;
};
</script>
