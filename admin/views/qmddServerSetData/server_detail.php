<?php
if(!isset($_REQUEST['title'])){
    $_REQUEST['title']=0;
}
?>
<div class="box">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <div class="box-content">
        <div class="box-table">
            <table width="100%" border="0">
                <tr>
                    <input type="button" class="btn" value="导出">&nbsp;
                    <input type="button" class="btn" value="打印">&nbsp;
                    <?php foreach($arclist as $s){ ?>
                        <?php
                            if($s->server_set_type==521){
                                if($s->down==0){
                                    echo '<input type="button" class="btn" onclick="down_btn('.$s->down.','.$s->id.')" value="关闭">';
                                }else{
                                    echo '<input type="button" class="btn" onclick="down_btn('.$s->down.','.$s->id.')" value="打开">';
                                }
                            }
                        ?>
                    <?php } ?>
                </tr>
            </table>
            <table class="list mt15">
                <thead>
                    <tr>
                        <th style="width:20%;">服务流水号</th>
                        <th style="width:20%;">服务项目</th>
                        <th style="width:20%;">预订人</th>
                        <th style="width:20%;">服务来源</th>
                        <th style="width:20%;">操作</th>
                    </tr>
                </thead>
                <tbody>
               <?php foreach($arclist as $s){ ?>
                        <tr>
                            <td><?php echo $s->order_num!=0?$s->order_num:'-'; ?></td>
                            <td><?php echo $s->order_project_name!=''?$s->order_project_name:'-'; ?></td>
                            <td><?php echo $s->order_name!=''?$s->order_name:'-'; ?></td>
                            <td><?php echo $s->order_account!=''?$s->server_set_typename:'-'; ?></td>
                            <td><?php echo $s->order_account!=''?'订单信息':'-'; ?></td>
                        </tr>
               <?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
    </div><!--box-content end-->
    <?php $this->endWidget(); ?>
</div><!--box end-->
<script>
    $(function(){
        api = $.dialog.open.api;
        if (!api) return;
        // 操作对话框
        api.button({ name: '关闭' });
    });
    var down_btn=function($down,$id){
        var content='';
        var a=0;
        if($down==0){
            content='是否关闭<?php echo $_REQUEST['title'];?>服务日程，关闭后前端将不可在预订该服务？';
            a=1;
        }
        else{
            content='是否打开<?php echo $_REQUEST['title'];?>服务日程，打开后前端将可在预订该服务？';
            a=0;
        }
        if(confirm(content)){
            saveLevel1();
        }
        function saveLevel1(){
            // var form=$('#item_level').serialize();
            
            we.loading('show');
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('save_server_detail');?>&id='+$id+'&down='+a,
                // data: $down,
                dataType: 'json',
                success: function(data) {
                    we.loading('hide');
                    if(data.status==1){
                        we.success(data.msg, data.redirect);
                        $.dialog.data('id', 1);
                        $.dialog.close();
                    }else{
                        we.msg('minus', data.msg);
                    }
                }
            });
            return false;
            // $.dialog.close();
        }
    }
</script>