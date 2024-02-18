<style>
    .box-table .list tr th,.box-table .list tr td{
        text-align: center;
    }
    .box-title h4{
        display: inline-block;
        width: auto;
        color: #444;
        font-size:12px;
        line-height: 30px;
    }
    .lode_po{
        color:#333;
    }
    .lode_po:hover{
        color:red;
    }
</style>
<div class="box">
    <div class="box-title c">
        <h4>
            <span>
                <a href="../../admin/index.php?act=main" class="lode_po" onclick="parent.location.reload();"><i class="fa fa-home"></i>当前界面：</a>服务管理->
                <a href="<?php echo $this->createUrl('qmddServerTimePriceInfo/index'); ?>" class="lode_po">服务时间与价格设置列表</a>
            </span>
        </h4>
    </div><!--box-title end-->
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
                    <span>服务类型：</span>
                    <?php echo downList($ftypeid,'id','t_name','ftypeid'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入服务标题或服务编号">
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
                        <th><?php echo $model->getAttributeLabel('tp_code');?></th>
                        <th><?php echo $model->getAttributeLabel('tp_name');?></th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th><?php echo $model->getAttributeLabel('f_typeid');?></th>
                        <th><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->tp_code; ?></td>
                            <td><?php echo $v->tp_name; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->t_name; ?></td>
                            <td><?php echo $v->add_time; ?></td>
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