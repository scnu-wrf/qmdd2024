<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》资源登记》<a class="nav-a">场地登记</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top: 15px;">
            <ul class="c">
                <li style="width:150px;"><a href="<?=$this->createUrl('index')?>">登记中</a></li>
                <li class="current" style="width:150px;"><a href="<?=$this->createUrl('index_list')?>">已登记</a></li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
                <label style="margin-right:20px;">
                    <span>登记项目：</span>
                    <?php echo downList($project,'project_id','project_name','project'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>是否可售：</span>
                    <?php echo downList($is_sale,'f_id','F_NAME','is_sale'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="资源编码 / 资源名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th style='text-align: center; width:25px;'>序号</th>
                        <th width="12%"><?php echo $model->getAttributeLabel('site_id');?></th>
                        <th width="12%"><?php echo $model->getAttributeLabel('site_code');?></th>
                        <th width="12%"><?php echo $model->getAttributeLabel('site_name');?></th>
                        <th><?php echo $model->getAttributeLabel('site_type');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th>是否可售</th>
                        <th>是否发布</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
                 foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php if(!empty($v->site)) echo $v->site->site_name; ?></td>
                        <td><?php echo $v->site_code; ?></td>
                        <td><?php echo $v->site_name; ?></a></td>
                        <td><?php if(!empty($v->sitetype)) echo $v->sitetype->F_NAME; ?></td>
                        <td><?php if(!empty($v->project_id)) $project_list=ProjectList::model()->findAll('id in (' . $v->project_id . ')'); ?>
                        <?php if(!empty($project_list)) foreach($project_list as $p) echo $p->project_name.' '; ?>
                        </td>
<?php $sur=0;$setl=0;
 $sourcer=QmddServerSourcer::model()->find('t_typeid=1 AND s_name_id='.$v->id);
 if(!empty($sourcer)) $setlist=QmddServerSetList::model()->findAll('server_sourcer_id='.$sourcer->id);
if(!empty($sourcer) && ($sourcer->state==372)) $sur=1;
if(!empty($setlist)) $setl=1; ?>
                        <td><?php echo ($sur==1) ? '是' : '否'; ?></td>
                        <td><?php echo ($setl==1) ? '是' : '否'; ?></td>
                        <td>
                        <?php if($sur==1){ ?>
                            <a class="btn" onClick="fnDel_Sourcer(<?php echo $v->id;?>);" href="javascript:;" title="取消可售">取消可售</a>
                        <?php } else{ ?>
                        	<a class="btn" onClick="fnSave_Sourcer(<?php echo $v->id;?>);" href="javascript:;" title="设为可售">设为可售</a>
                        <?php } ?>
                            <a class="btn" href="<?php echo $this->createUrl('update_list', array('id'=>$v->id,'list'=>'list'));?>" title="详情">详情</a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除">删除</a>
                        </td>
                    </tr>
                <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
<script>

	//设置服务资源
function fnSave_Sourcer(id){
      $.ajax({
        type: 'get',
        url: '<?php echo $this->createUrl("save_Sourcer");?>',
        data: {id: id},
        dataType:'json',
        success: function(data) {
          if (data.status==1){
            //we.success(data.msg, data.redirect);
			we.msg('minus', data.msg);
            setTimeout(we.reload(), 2000);
          }else{
            we.msg('minus', data.msg);
          }
       },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
        }
    });
}

//撤销服务资源
function fnDel_Sourcer(id){
      $.ajax({
        type: 'get',
        url: '<?php echo $this->createUrl("del_Sourcer");?>',
        data: {id: id},
        dataType:'json',
        success: function(data) {
          if (data.status==1){
            //we.success(data.msg, data.redirect);
			we.msg('minus', data.msg);
            setTimeout(we.reload(), 2000);

          }else{
            we.msg('minus', data.msg);
          }
       },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
        }
    });
}
</script>