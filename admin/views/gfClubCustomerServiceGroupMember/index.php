<?php if (!isset($_REQUEST['lang_type'])) {$_REQUEST['lang_type']=0;} ?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>客服列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
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
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('service_no');?></th>
                        <th style='text-align: center;'>客服账号</th>
                        <th style='text-align: center;'>客服姓名</th>
                        <th style='text-align: center;'>客服昵称</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('service_level');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('group_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('phone');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('add_date');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index=1; foreach($arclist as $v){ ?>
					<?php 
						$sql="select u.ZSXM as admin_name,q.admin_gfaccount,q.admin_gfnick,q.last_login from gf_user_1 u,qmdd_administrators q where q.id=".$v->admin_id." and q.admin_gfid=u.GF_ID";
						$server=Yii::app()->db->createCommand($sql)->queryRow();
					?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->service_no; ?></td>
                        <td style='text-align: center;'><?php echo $server["admin_gfaccount"]; ?></td>
                        <td style='text-align: center;'><?php echo $server["admin_name"]; ?></td>
                        <td style='text-align: center;'><?php echo $v->admin_nick; ?></td>
                        <td style='text-align: center;'><?php echo $v->service_level_name; ?></td>
						<td style='text-align: center;'><?php echo $v->group_name; ?></td>
						<td style='text-align: center;'><?php echo $v->phone; ?></td>
						<td style='text-align: center;'><?php echo $v->state_name; ?></td>
						<td style='text-align: center;'><?php echo $v->add_date; ?></td>
						<td style='text-align: center;'>
							<a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>">编辑</a>
							<?php if($v->state==649){?>
                            <a class="btn" href="javascript:;" onclick="we.operate('<?php echo $v->id;?>', disableUrl,'确定停用吗？')">停用</a>
							<?php }else{?>
							<a class="btn" href="javascript:;" onclick="we.operate('<?php echo $v->id;?>', enableUrl,'确定启用吗？')">启用</a>
							<?php }?>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);">删除</a>
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
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
var disableUrl = '<?php echo $this->createUrl('disable', array('id'=>'ID'));?>';
var enableUrl = '<?php echo $this->createUrl('enable', array('id'=>'ID'));?>';
</script>
