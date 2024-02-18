<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>评论列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <label style="margin-right:20px;">
                    <span>信息类型：</span>
                    <select name="type">
                        <option value="">请选择</option>
                        <?php foreach($type as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('type')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>审核状态：</span>
                    <select name="state">
                        <option value="">请选择</option>
                        <?php foreach($state as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：
                        <select name="keyword" id="keywordname">
                            <option value="0">可输入字段</option>
                            <option value="1">信息标题</option>
                            <option value="2">评论人帐号</option>
                            <option value="3">评论人昵称</option>
                        </select>
                    </span>
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
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('type_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('communication_news_title');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('communication_gfaccount');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('communication_gfnick');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('communication_type');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('communication_praise');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('if_dispay_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state_qmddname');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state_time');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('uDate');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(130);?>
<?php 
$index = 1;
foreach($arclist as $v){ 
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->type_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->communication_news_title; ?></td>
                        <td style='text-align: center;'><?php echo $v->communication_gfaccount; ?></td>
                        <td style='text-align: center;'><?php echo $v->communication_gfnick; ?></td>
                        <td style='text-align: center;'><?php if($v->base_code_type!=null){echo $v->base_code_type->F_NAME;} ?></td>
                        <td style='text-align: center;'><?php echo $v->communication_praise; ?></td>
                        <td style='text-align: center;'><?php echo $v->if_dispay_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->state_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->state_qmddname; ?></td>
                        <td style='text-align: center;'><?php echo $v->state_time; ?></td>
                        <td style='text-align: center;'><?php echo $v->uDate; ?></td>
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
