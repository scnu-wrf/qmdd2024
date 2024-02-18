<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>直播备案审核列表</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-search" style="border:none; margin:0">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入直播编号 / 标题" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('code');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('logo');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('title');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('live_start');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('live_end');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('state_time');?></th>
                        <th style="text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr>
                        <td><?php echo CHtml::link($v->code, array('update_checkin_audit', 'id'=>$v->id)); ?></td>
                        <td><a href="<?php echo $base_path->F_WWWPATH.$v->logo; ?>" target="_blank"><img src="<?php echo $base_path->F_WWWPATH.$v->logo; ?>" width="100"></a></td>
                        <td><?php echo CHtml::link($v->title, array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo $v->live_start; ?></td>
                        <td><?php echo $v->live_end; ?></td>
                        <td><?php echo $v->state_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_checkin_audit', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
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
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>