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
                <label style="margin-right:10px;">
                    <span>编号/标题：</span>
                    <input id="searchtext" style="width:200px;" class="input-text" type="text" name="searchtext" value="<?php echo Yii::app()->request->getParam('searchtext');?>">
                </label>

                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <!-- <input id="is_excel" type="hidden" name="is_excel" value="0">
                <button class="btn btn-blue" type="button" onclick="javascript:excel();" >导出</button> -->
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check" style="text-align:center!important;"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center;">序号</th>
                        <?php
                        if($_REQUEST['rtype_id']==1182){
                            $temp = $model->appeaAttributeLabels();
                            foreach( $model->appealLabelsOfList() as $v){
                                echo "<th style='text-align:center;'>". $temp[$v] ."</th>";
                            }
                        }else{
                            $temp = $model->attributeLabels();
                            foreach( $model->labelsOfList() as $v){
                                echo "<th style='text-align:center;'>". $temp[$v] ."</th>";
                            }
                        }
                        ?>
                        <th style="text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
					<?php 
                    $i=1; 
                    $index = 1;
                    foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item" style="text-align:center;"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                       
                        <?php
                        if($_REQUEST['rtype_id']==1182){
                            $temp = $model->appeaAttributeLabels();
                            foreach( $model->appealLabelsOfList() as $fv){
                                $s = '';
                                if ($fv=='report_type_id'){
                                    $s = ReportVersion::model()->getName($v->$fv);
                                }elseif($fv=='type'){
                                    $s = BaseCode::model()->getName($v->$fv);
                                }elseif($fv=='state'){
                                    $s = $v->stateName->F_SHORTNAME;
                                }else{
                                   $s= $v->$fv ;
                                }
                                echo "<td style='text-align:center'>". $s ."</td>";
                            }
                        }else{
                            $temp = $model->attributeLabels();
                            foreach( $model->labelsOfList() as $fv){
                                $s = '';
                                if ($fv=='report_type_id'){
                                    $s = ReportVersion::model()->getName($v->$fv);
                                }elseif($fv=='type'){
                                    $s = BaseCode::model()->getName($v->$fv);
                                }elseif($fv=='state'){
                                    $s = $v->stateName->F_SHORTNAME;
                                }else{
                                   $s= $v->$fv ;
                                }
                                echo "<td style='text-align:center'>". $s ."</td>";
                            }
                        }
                        ?>
                        <td style="text-align:center;">
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="详细"><i class="fa fa-edit"></i></a>
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
// function excel(){
// 	$("#is_excel").val(1);
// 	$("#submit_button").click();
// }
</script>