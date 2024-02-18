<?php  if (!isset($_REQUEST['service_type'])) {$_REQUEST['service_type']=521;} ?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create',array('service_type'=>$_REQUEST['service_type']));?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>服务项目：</span>
                    <select name="project">
                        <option value="">请选择</option>
                        <?php foreach($project_list as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('project')!=null && Yii::app()->request->getParam('project')==$v->id){?> selected<?php }?>><?php echo $v->project_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>状态：</span>
                    <select name="state">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('state')!==null && Yii::app()->request->getParam('state')!==''  && Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务类型：</span>
                    <select name="type_code">
                        <option value="">请选择</option>
                        <?php foreach($type_code as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('type_code')!=null && Yii::app()->request->getParam('type_code')==$v->id){?> selected<?php }?>><?php echo $v->sn_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务地区：</span>
                    <select name="province"></select><select name="city"></select><select name="area"></select>
                    <script>new PCAS("province","city","area","<?php echo Yii::app()->request->getParam('province');?>","<?php echo Yii::app()->request->getParam('city');?>","<?php echo Yii::app()->request->getParam('area');?>");</script>
                </label>
                <br>
                <label style="margin-right:10px;">
                    <span>开始时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入服务编号/标题" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('service_code');?></th>
                        <th><?php echo $model->getAttributeLabel('imgUrl');?></th>
                        <th><?php echo $model->getAttributeLabel('title');?></th>
                        <th><?php echo $model->getAttributeLabel('type_code');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('state');?></th>
                        <th><?php echo $model->getAttributeLabel('uDate');?></th>
                        <th><?php echo $model->getAttributeLabel('deal');?></th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <!-- <th><?php echo $model->getAttributeLabel('site_contain');?></th> -->
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $basepath=BasePath::model()->getPath(135);
                        $index = 1;
                        foreach($arclist as $v){
                    ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo CHtml::link($v->service_code, array('update', 'id'=>$v->id)); ?></td>
                        <td><a href="<?php echo $basepath->F_WWWPATH.$v->imgUrl; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v->imgUrl; ?>" style="max-height:100px; max-width:100px;"></a></td>
                        <td><?php echo CHtml::link($v->title, array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo $v->type_name; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo $v->uDate; ?></td>
                        <td><?php echo $v->deal; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <!-- <td><?php echo $v->site_contain; ?></td> -->
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
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
$(function(){
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});
</script>