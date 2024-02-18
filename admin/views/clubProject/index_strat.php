<style>
    .box-table .list tr th,.box-table .list tr td{
        text-align: center;
    }
</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>战略伙伴成员待审核列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入项目名称 / 单位名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list"><!--此处项目，链接club_project表-->
                <tr class="table-title" style="text-align:center;">
                    <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                    <td>序号</td>
                    <td><?php echo $model->getAttributeLabel('project_name');?></td>
                    <td><?php echo $model->getAttributeLabel('club_name');?></td>
                    <td><?php echo $model->getAttributeLabel('level_name');?></td>
                    <td><?php echo $model->getAttributeLabel('approve_state');?></td>
                    <td><?php echo $model->getAttributeLabel('auth_state');?></td>
                    <td><?php echo $model->getAttributeLabel('state');?></td>
                    <td><?php echo $model->getAttributeLabel('valid_until');?></td>
                    <td><?php echo $model->getAttributeLabel('add_time');?></td>  
                    <td>操作</td>
                </tr>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->level_name; ?></td>
                        <td><?php echo $v->approve_state_name; ?></td>
                        <td><?php echo $v->auth_state_name; ?></td>
                        <td><?php echo $v->refuse_state_name; ?></td>
                        <td><?php echo $v->valid_until; ?></td>
                        <td><?php echo $v->add_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_examine', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                <?php $index++; } ?>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
