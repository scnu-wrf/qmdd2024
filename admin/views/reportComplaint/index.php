<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>投诉举报</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <!--  <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a> -->
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>  -->
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>投诉类型：</span>
                    <select id="type" name="type">
                        <option value="">请选择</option>
                        <?php foreach($type_name as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('type')!==null && Yii::app()->request->getParam('type')!==''  && Yii::app()->request->getParam('type')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                 <label style="margin-right:20px;">
                    <span>受理状态：</span>
                    <select id="state" name="state">
                        <option value="">请选择</option>
                        <?php foreach($state_name as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('state')!==null && Yii::app()->request->getParam('state')!==''  && Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>编号/标题：</span>
                    <input id="searchtext" style="width:200px;" class="input-text" type="text" name="searchtext" value="<?php echo Yii::app()->request->getParam('searchtext');?>">
                </label>

                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
                <button class="btn btn-blue" type="button" onclick="javascript:excel();" >导出</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <?php
                        $temp = $model->attributeLabels();
                        foreach( $model->labelsOfList() as $v){
                            echo "<th>". $temp[$v] ."</th>";
                        }
                        ?>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $base_code_arr=array(); foreach($state_name as $v){ $base_code_arr[$v->f_id]=$v->F_NAME;}?>
                    <?php if(Yii::app()->request->getParam('type')>0 && Yii::app()->request->getParam('sorttype')=='online'){ $adver_name=AdverName::model()->getOne(Yii::app()->request->getParam('type')); $dispay_num=$adver_name->dispay_num;}?>
					<?php 
                    $i=1; 
                    $index = 1;
                    foreach($arclist as $v){ ?>
                    <tr class="<?php if(Yii::app()->request->getParam('type')>0 && Yii::app()->request->getParam('sorttype')=='online'){ if(($dispay_num=='' || $i<=$dispay_num) && $v->select_id==1){ ?>showed<?php }}?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                       
                        <?php
                        $temp = $model->attributeLabels();
                        foreach( $model->labelsOfList() as $fv){
                            $s = '';
                            if ($fv=='report_type_id'){
                                $s = ReportVersion::model()->getName($v->$fv);
                            }elseif($fv=='state' || $fv=='type'){
                                $s = BaseCode::model()->getName($v->$fv);
                            }else{
                               $s= $v->$fv ;
                            }
                            echo "<td>". $s ."</td>";
                        }
                        ?>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="详细"><i class="fa fa-edit">详细</i></a>
                        </td>
                    </tr>
<?php $i++; $index++;} ?>
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
        var end_input=$dp.$('end_date')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
    });
});
function excel(){
	$("#is_excel").val(1);
	$("#submit_button").click();
}
</script>