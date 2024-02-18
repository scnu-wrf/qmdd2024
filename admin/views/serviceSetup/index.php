<?php if (!isset($_REQUEST['lang_type'])) {$_REQUEST['lang_type']=0;} ?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>客服列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create',array('lang_type'=>$_REQUEST['lang_type']));?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a class="btn" href="javascript:;" onclick="saveLevel1();"><i class="fa fa-save"></i>保存</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="clubadmin/index">
                <input type="hidden" name="lang_type" value="<?php echo $_REQUEST['lang_type']; ?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号或姓名">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <form action="" id="item_level">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('admin_gfaccount');?></th>
                        <th><?php echo $model->getAttributeLabel('admin_gfnick');?></th>
                        <th><?php echo $model->getAttributeLabel('club_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('admin_level');?></th>
                        <th class="check" style="width:3%">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index=1; foreach($arclist as $v){ ?>
                    <tr>
                        <td><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo CHtml::link($v->admin_gfaccount, array('id'=>$v->id,'lang_type'=>$v->lang_type)); ?></td>
                        <td><?php echo CHtml::link($v->admin_gfnick, array('id'=>$v->id,'lang_type'=>$v->lang_type)); ?></td>
                        <td><?php echo $v->club_code; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->role_name; ?></td>
                        <td class="check check-item">
                            <input <?php if(strpos($v->admin_level_type,'887') !== false){?>checked="checked"<?php }?> name="type_item<?php echo $index; ?>" class="input-check" type="checkbox" value="<?php echo $v->id; ?>">
                            <input type="hidden" name="type_che<?php echo $index; ?>" value="<?php echo $v->id; ?>">
                        </td>
                    </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
            </form>
        </div><!--box-table end-->
    <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    // var saveLevel1 = '<?php echo $this->createUrl('saveLevel', array('id'=>'ID'));?>';

    function saveLevel1(){
        var form=$('#item_level').serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('saveLevel');?>',
            data: form,
            dataType: 'json',
            success: function(data) {
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
