<div class="box">
    <div class="box-title c">
        <span><h1>当前界面：资讯》资讯发布》发布待审核</h1></span>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <!-- <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div> --><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <label style="margin-right:20px;">
                    <span>类型：</span>
                    <select name="news_type">
                        <option value="">请选择</option>
                        <?php foreach($news_type as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('news_type')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="编号/标题">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                </span>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th width="4%">序号</th>
                        <th width="5%">类型</th>
                        <th width="9%"><?php echo $model->getAttributeLabel('news_code');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('news_pic');?></th>
                        <th><?php echo $model->getAttributeLabel('news_title');?></th>
                        <th style='display: none;'><?php echo $model->getAttributeLabel('club_id');?></th>
                        <!-- 隐藏 俱乐部 表头代码 -->
                        <th width="5%" style="display: none;"><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th width="7%" style="display: none;"><?php echo $model->getAttributeLabel('state');?></th>
                        <!-- <th><?php echo $model->getAttributeLabel('news_clicked');?></th> -->
                        <!-- 保存 点击量 表头代码 -->
                        <th width="12%">上下线时间</th>
                        <!-- 备份 -->
                        <!-- <th><?php echo $model->getAttributeLabel('news_date_start');?></th> -->
                        <!-- <th><?php echo $model->getAttributeLabel('news_date_end');?></th> -->
                        <!-- 备份 -->
                        <!-- <th><?php echo $model->getAttributeLabel('uDate');?></th> -->
                        <th width="12%"><?php echo $model->getAttributeLabel('apply_time');?></th>
                        <th width="12%">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(124);?>
<?php 
$index = 1;
foreach($arclist as $v){ 
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->news_type_name; ?></td>
                        <td><?php echo $v->news_code; ?></td>
                        <td><a href="<?php echo $basepath->F_WWWPATH.$v->news_pic; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v->news_pic; ?>" style="max-height:100px; max-width:100px;"></a></td>
                        <td style='text-align:left;'><?php echo $v->news_title; ?></td>
                        <td style='display: none;'><?php echo $v->news_club_name; ?></td>
                        <!-- 隐藏 俱乐部 代码 -->
                        <td style="display: none;"><?php echo $v->order_num; ?></td>
                        <td style="display: none;"><?php echo $v->state_name; ?></td>
                        <td style='display: none;'><?php echo $v->news_clicked; ?></td>
                        <!-- 隐藏 点击量 代码 -->
                        <td><?php echo $v->news_date_start; ?><br>
                            <?php echo $v->news_date_end; ?></td>
                        <td><?php echo $v->apply_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('report_update', array('id'=>$v->id));?>">详情</a>&nbsp;
                            <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancel);" title="撤销申请">撤销</a>
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
    var cancel = '<?php echo $this->createUrl('cancelSubmit', array('id'=>'ID'));?>';
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    $(function(){
        var $start_time=$('#start_date');
        var $end_time=$('#end_date');
        $start_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
    });
</script>