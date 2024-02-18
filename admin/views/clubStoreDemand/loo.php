<div class="box">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th width="50%">服务主题</th>
                        <th width="50%">服务时间</th>
                    </tr>
                </thead>
                <tbody>
               <?php foreach($arclist as $s){ ?>
                        <tr>
                            <td width="50%">
                                <?php if(!empty($s->project_list->project_name)){ echo $s->project_list->project_name.'-';} ?><?php if(!empty($s->reply_service_name)){ echo $s->reply_service_name;} ?>
                            </td>
                            <td width="50%"><?php if(!empty($s->reply_service_datailed_time!='')){ echo $s->reply_service_datailed_time;} ?></td>
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
</script>