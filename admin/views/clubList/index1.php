<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位资产</h1></div><!--box-title end-->
    <div class="box-content">
        <!--div class="box-header">
            <a class="btn" href="<php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a-->
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <!--a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
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
                        <th class="list-id">序号</th>
                        <th><?php echo $model->getAttributeLabel('club_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('beans');?></th>
                        <th><?php echo $model->getAttributeLabel('club_credit');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php
$index = 1;
 foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->club_code; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->beans; ?></td>
                        <td><?php echo $v->club_credit; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('beansHistory/index',array('pid' => $v->id, 'beans' => $v->beans));?>" title="体育豆详细记录">体育豆详细</a>
                            <a class="btn" href="<?php echo $this->createUrl('gfCreditHistory/index',array('pid' => $v->id, 'credit' => $v->club_credit));?>" title="积分详细记录">积分详细</a>
                            
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