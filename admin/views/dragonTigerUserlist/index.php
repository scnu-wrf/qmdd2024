
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>龙虎考核</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：
                        <select name="keyword" id="keywordname">
                            <option value="0">可输入字段</option>
                            <option value="1">GF帐号</option>
                            <option value="2">用户名</option>
                            <option value="3">考核编号</option>
                        </select>
                    </span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <label style="margin-right:20px;">
                    <span>考核状态(是否通过)：</span>
                    <select name="if_pass">
                        <option value="">请选择</option>
                        <?php foreach($if_pass as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('if_pass')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
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
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('check_number');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('gf_account');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('member_type');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('grade');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('if_pass');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
               
<?php 
$index = 1;
foreach($arclist as $v){ 
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->order_num; ?></td>
                        <td style='text-align: center;'><?php echo $v->check_number; ?></td>
                        <td style='text-align: center;'><?php echo $v->gf_account; ?></td>
                        <td style='text-align: center;'><?php echo $v->gf_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->member_type_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->grade_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->project_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->if_pass_name; ?></td>
                        <td style='text-align: center;'>

                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>

                        </td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages);?></div>
        
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
