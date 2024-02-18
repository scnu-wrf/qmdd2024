<style>
    .box-search div{ display:inline-block; }
    #keywords{ margin-left: 12px; }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名》排名榜》排名等级设置</h1>
    </div><!--box-title end-->
    <div class="box-header">
        <a class="btn" href="<?php echo $this->createUrl('index_create');?>"><i class="fa fa-plus"></i>添加</a>
        <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
    </div>
    <div class="box-content">
        <div class="box-search">
            <!-- <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span> -->
            <!-- 返回按钮 -->
        </div><!--box-head end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;' width="40%">等级名称</th>
                        <th style='text-align: center;' width="40%">相应赛事等级</th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td style='text-align: center;'>
                                <span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span>
                            </td>
                            <td style='text-align: center;'><?php echo $v->F_ShowName; ?></td>
                            <td style='text-align: center;'><?php echo $v->F_NAME; ?></td>
                            <td style='text-align: center;'>
                                <?php echo show_command('修改',$this->createUrl('index_update', array('id'=>$v->f_id))); ?>
                                <?php echo show_command('删除',$v->f_id); ?>
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
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
});
</script>