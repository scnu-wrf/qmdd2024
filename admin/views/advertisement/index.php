<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>广告列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>广告类型：</span>
                    <select id="type" name="type">
                        <option value="">请选择</option>
                        <?php foreach($adver_name as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('type')!==null && Yii::app()->request->getParam('type')!==''  && Yii::app()->request->getParam('type')==$v->id){?> selected<?php }?>><?php echo $v->adv_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>发布单位：</span>
                    <input id="club" style="width:200px;" class="input-text" placeholder="请输入单位名称" type="text" name="club" value="<?php echo Yii::app()->request->getParam('club');?>">
                </label>
                <label style="margin-right:20px;">
                    <span>审核状态：</span>
                    <select id="state" name="state">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('state')!==null && Yii::app()->request->getParam('state')!==''  && Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>显示状态：</span>
                    <select id="online" name="online">
                        <option value="">请选择</option>
                        <option value="1"<?php if(Yii::app()->request->getParam('online')!==null && Yii::app()->request->getParam('online')!==''  && Yii::app()->request->getParam('online')==1){?> selected<?php }?>>上线</option>
                        <option value="0"<?php if(Yii::app()->request->getParam('online')!==null && Yii::app()->request->getParam('online')!==''  && Yii::app()->request->getParam('online')==0){?> selected<?php }?>>下线</option>
                    </select>
                </label>
                <br>
                <label style="margin-right:10px;">
                    <span>上线日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入广告标题 / 广告编码" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>排序：</span>
                    <select id="sorttype" name="sorttype">

                        <option value="">请选择</option>
                        <option value="online"<?php if(Yii::app()->request->getParam('sorttype')=='online'){?>selected<?php }?>>上线先后</option>
                    </select>
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
                        <th><?php echo $model->getAttributeLabel('advertisement_pic');?></th>
                        <th><?php echo $model->getAttributeLabel('ADVER_TITLE');?></th>
                        <th><?php echo $model->getAttributeLabel('advertisement_type');?></th>
                        <th><?php echo $model->getAttributeLabel('ADVER_DATE_START');?></th>
                        <th><?php echo $model->getAttributeLabel('ADVER_DATE_END');?></th>
                        <th><?php echo $model->getAttributeLabel('advertisement_number');?></th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th><?php echo $model->getAttributeLabel('show_all_club');?></th>
                        <th><?php echo $model->getAttributeLabel('state');?></th>
                        <th><?php echo $model->getAttributeLabel('ADVER_STATE');?></th>
                        <th>操作</th>
                    </tr>
                </thead>

                    <?php $basepath=BasePath::model()->getPath(174);?>
                    <?php $base_code_arr=array(); foreach($base_code as $v){ $base_code_arr[$v->f_id]=$v->F_NAME;}?>
                    <?php if(Yii::app()->request->getParam('type')>0 && Yii::app()->request->getParam('sorttype')=='online'){ $adver_name=AdverName::model()->getOne(Yii::app()->request->getParam('type')); $dispay_num=$adver_name->dispay_num;}?>
					<?php 
                    $i=1; 
                    $index = 1;
                    foreach($arclist as $v){ ?>
                    <tr class="<?php if(Yii::app()->request->getParam('type')>0 && Yii::app()->request->getParam('sorttype')=='online'){ if(($dispay_num=='' || $i<=$dispay_num) && $v->select_id==1){ ?>showed<?php }}?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php if(!empty($v->advertisement_pic)) { ?><a href="<?php echo $basepath->F_WWWPATH.$v->advertisement_pic; ?>" target="_blank"><img style="max-height:50px; max-width:50px;" src="<?php echo $basepath->F_WWWPATH.$v->advertisement_pic; ?>"></a><?php } ?></td>
                        <td><?php echo $v->ADVER_TITLE; ?><?php if(Yii::app()->request->getParam('type')>0 && Yii::app()->request->getParam('sorttype')=='online'){ if(($dispay_num=='' || $i<=$dispay_num) && $v->select_id==1){ ?><span style="color:#f00;">(正在展示)</span><?php }}?></td>
                        <td><?php echo $v->ADVER_NAME; ?></td>
                        <td><?php echo $v->ADVER_DATE_START; ?></td>
                        <td><?php echo $v->ADVER_DATE_END; ?></td>
                        <td><?php echo $v->advertisement_number; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->show_all_club); ?>"></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo $v->ADVER_STATE_name; ?></td>
                        <td>
        <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
        <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
<?php $i++; $index++;} ?>
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
        var end_input=$dp.$('end_date')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
    });
});
</script>