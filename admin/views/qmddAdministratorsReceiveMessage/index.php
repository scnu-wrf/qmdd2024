
<div class="box">
    <div class="box-title c">
        <h1><span>当前界面：消息中心</span></h1>
        <span class="back">
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>发送时间：</span>
                    <input style="width:100px;" class="input-text" type="text" id="start_time" name="start_time" value="<?php echo $start_time;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo $end_time;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead> 
                    <tr>
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th >序号</th>
                        <th ><?php echo $model->getAttributeLabel('s_clubname');?></th>
                        <th ><?php echo $model->getAttributeLabel('m_title');?></th>
                        <th style="width:300px;"><?php echo $model->getAttributeLabel('m_message');?></th>
                        <th ><?php echo $model->getAttributeLabel('read_time');?></th>
                        <th ><?php echo $model->getAttributeLabel('s_time');?></th>
                        <th >操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input type="checkbox" class="input-check" value="<?php echo CHtml::encode($v->id);?>"></td>
                        <td ><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td ><?php echo $v->s_clubname; ?></td>
                        <td ><?php echo $v->m_title; ?></td>
                        <td style="width:300px;" title="<?= $v->m_message;?>">
                            <?php 
                                echo '<span style="display:inline-block;width: 300px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$v->m_message.'</span>';
                            ?>
                        </td>
                        <td ><?php echo is_null($v->read_time)?'未读':'已读'; ?></td>
                        <td ><?php echo $v->s_time; ?></td>
                        <td >
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele(<?php echo $v->id;?>, deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
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
    $(function(){
        var $start_time=$('#start_time');
        var $end_time=$('#end_time');
        $start_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });

</script>
