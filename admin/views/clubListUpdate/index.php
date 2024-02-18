<div class="box">
    <div class="box-title c">
      <h1><i class="fa fa-table"></i>单位管理列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加单位</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>状态：</span>
                    <select name="state">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>团体类型：</span>
                    <select name="type" id="type">
                        <option value="">请选择</option>
                        <?php foreach($partnertype as $v){?>
                        <option value="<?php echo $v->f_id; ?>"<?php if(Yii::app()->request->getParam('type')!=null && Yii::app()->request->getParam('type')==$v->f_id){ ?> selected<?php } ?>><?php echo $v->F_NAME;?></option>
                        <?php } ?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务地区：</span>
                    <select name="province"></select><select name="city"></select><select name="area"></select>
                    <script>new PCAS("province","city","area","<?php echo Yii::app()->request->getParam('province');?>","<?php echo Yii::app()->request->getParam('city');?>","<?php echo Yii::app()->request->getParam('area');?>");</script>
                </label>
                <br>
                <label style="margin-right:10px;">
                    <span>创办时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
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
                        <th><?php echo $model->getAttributeLabel('club_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_logo_pic');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('partnership_name');?></th>
                        <th><?php echo $model->getAttributeLabel('individual_enterprise_name');?></th>
                        <th><?php echo $model->getAttributeLabel('news_clicked');?></th>
                        <th><?php echo $model->getAttributeLabel('book_club_num');?></th>
                        <th><?php echo $model->getAttributeLabel('state_name');?></th>
                        <th><?php echo $model->getAttributeLabel('apply_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $basepath=BasePath::model()->getPath(123);?>
					<?php foreach($arclist as $v){ ?>
                    <tr> 	
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>           
                        <td><?php echo CHtml::link($v->club_code, array('update', 'id'=>$v->id)); ?></td>
                        <td><div style="max-width:70px; max-height:70px;overflow:hidden;"><a href="<?php echo $basepath->F_WWWPATH.$v->club_logo_pic; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v->club_logo_pic; ?>" style="max-height:70px; max-width:70px;"></a></div></td>
                        <td><?php echo CHtml::link($v->club_name, array('update', 'id'=>$v->id)); ?></td>
                        <td id="partnership_name"><?php echo $v->partnership_name; ?></td>
                        <td><?php echo $v->individual_enterprise_name; ?></td>
                        <td><?php echo $v->news_clicked;?></td>
                        <td><?php echo $v->book_club_num;?></td>
                        <td><?php  echo $v->state_name;  ?></td>
                        <td><?php echo $v->apply_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('clubProject/index',array('pid' => $v->id,'club_name' => $v->club_name));?>" title="单位项目">单位项目</a>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
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
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
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