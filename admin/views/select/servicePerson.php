<?php if (!isset( $_REQUEST['code_type'] ) ) { $_REQUEST['code_type']='';}?>

<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
        <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
        <input type="hidden" name="club_id" value="<?php echo Yii::app()->request->getParam('club_id');?>">
        <input type="hidden" name="project_id" value="<?php echo Yii::app()->request->getParam('project_id');?>">
        <input type="hidden" name="qualification_code_type" value="<?php echo $_REQUEST['code_type'];?>">
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
                        <th>点击选择</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
    <tr data-id="<?php echo $v->select_id; ?>" 
    data-title="<?php echo $v->select_title; ?>-<?php echo $v->qualifications_person->qualification_project_name; ?>-<?php echo $v->qualifications_person->qualification_type; ?>" 
    data-type-code="<?php if(!empty($v->qualifications_person->mall_products_type_sname)) echo $v->qualifications_person->mall_products_type_sname->id; ?>" 
    data-start-date="<?php echo $v->qualifications_person->start_date; ?>" 
    data-end-date="<?php echo $v->qualifications_person->end_date; ?>" 
    data-project-id="<?php echo $v->project_id; ?>" 
    data-project-name="<?php echo $v->qualifications_person->qualification_project_name;?>"
    data-gfid="<?php echo $v->qualifications_person->gfid; ?>" 
    data-account="<?php echo $v->qualifications_person->qualification_gfaccount;?>"
    data-name="<?php echo $v->qualifications_person->qualification_name;?>"
    >
        <td><?php echo $v->select_title; ?>-<?php echo $v->qualifications_person->qualification_project_name; ?>-<?php echo $v->qualifications_person->qualification_type; ?></td>
    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
$(function(){
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button({  name: '取消'});
    $('.box-table tbody tr').on('click', function(){
        var $this=$(this);
        $.dialog.data('service_person_id', $this.attr('data-id'));
        $.dialog.data('service_person_title', $this.attr('data-title'));
        $.dialog.data('service_person_start_date', $this.attr('data-start-date'));
        $.dialog.data('service_person_end_date', $this.attr('data-end-date'));
        $.dialog.data('service_person_type_code', $this.attr('data-type-code'));
        $.dialog.data('service_person_project_id', $this.attr('data-project-id'));
        $.dialog.data('service_person_project_name', $this.attr('data-project-name'));
        $.dialog.data('service_gfid', $this.attr('data-gfid'));
        $.dialog.data('service_account', $this.attr('data-account'));
        $.dialog.data('service_name', $this.attr('data-name'));

        $.dialog.close();
    });
});
</script>