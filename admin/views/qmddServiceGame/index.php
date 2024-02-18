
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-home"></i>当前界面：动动约>服务资源登记><a class="nav-a">赛事服务资源登记</a></h1>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php if(get_session('club_id')<>1){ ?>
    		<a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a> 
        <?php } ?> 
            <?php //echo show_command('添加',$this->createUrl('create')); ?> 
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>"> 
                <table width="100%">   
                	<tr>
                    	<td width="100">登记时间：</td>
                        <td>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                		</td>
                    	<td width="100">服务区域：</td>
                        <td>
                    <select name="province"></select><select name="city"></select><select name="area"></select>
                    <script>new PCAS("province","city","area","<?php echo Yii::app()->request->getParam('province');?>","<?php echo Yii::app()->request->getParam('city');?>","<?php echo Yii::app()->request->getParam('site_address');?>");</script>
                		</td>
                </tr>
                <tr>
                	<td><label>按项目：</label></td>
                    <td>
                    <label><?php echo downList($project_list,'id','project_name','project'); ?></label>
                    &nbsp;&nbsp;<label><span>审核状态：</span>
                    <?php echo downList($base_code,'f_id','F_NAME','state'); ?></label>
                	</td>
                    <td><label>关键字：</label></td>
                    <td><label><input type="text" style="width:200px;" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入资源编码 / 资源名称"></label>
                <button class="btn btn-blue" type="submit">查询</button>
                	</td>
                </tr>
            </table>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <?php if(get_session('club_id')<>1){ ?><th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th><?php } ?>
                        <th class="check">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('service_code');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('title');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('server_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('imgUrl');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('state_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('uDate');?></th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $basepath=BasePath::model()->getPath(175);?>
<?php 
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <?php if(get_session('club_id')<>1){ ?>
                        <td class="check check-item"><?php if(get_session('club_id')==$v->club_id) {?><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"><?php } ?></td>
                    <?php } ?>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center"><?php echo $v->service_code; ?></td>
                        <td style="text-align: center"><?php echo $v->title; ?></td>
                        <td style="text-align: center"><?php echo $v->server_name; ?></td>
                        <td style="text-align: center"><?php echo $v->project_name; ?></td>
                        <td style="text-align: center"><a href="<?php echo $basepath->F_WWWPATH.$v->imgUrl; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v->imgUrl; ?>" style="max-height:50px; max-width:50px;"></a></td>
                        <td style="text-align: center"><?php echo $v->club_name; ?></td>
                        <td style="text-align: center"><?php echo $v->state_name; ?></td>
                        <td style="text-align: center"><?php echo $v->uDate; ?></td>
                        <?php if(get_session('club_id')<>1){ ?>
                        <td style='text-align: center;'>
                        	<?php if($v->state==372 && get_session('club_id')==$v->club_id) { ?>
                        	<a class="btn" onClick="fnSave_Sourcer(<?php echo $v->id;?>);" href="javascript:;" title="更新服务资源">设置服务资源</a>
						<?php } ?>
                        <?php $sourcer=QmddServerSourcer::model()->find('t_typeid=3 AND s_name_id='.$v->id);
						if(!empty($sourcer) && ($sourcer->state==372) && get_session('club_id')==$v->club_id){?>
                            <a class="btn" onClick="fnDel_Sourcer(<?php echo $v->id;?>);" href="javascript:;" title="撤销服务资源">撤销</a>
                         <?php } ?>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <?php if(get_session('club_id')==$v->club_id) {?><a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a><?php } ?>
                        </td>
                        <?php } else { ?>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                        </td>
                        <?php } ?>
                    </tr>
<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
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