<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>" >
                <input type="hidden" name="type" value="<?php echo $_GET["type"];?>" >
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="club" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th colspan="6">点击选择</th>
                    </tr>
                    <tr>
                        <td width="20%" style="text-align:center">资源编号</td>
                        <td width="25%" style="text-align:center">资源名称</td>
                        <td width="15%" style="text-align:center">资源等级</td>
                        <td width="10%" style="text-align:center">服务项目</td>
                        <td width="10%" style="text-align:center">服务类别</td>
                        <td style="text-align:center">归属场地</td>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){
 if(!empty($v->project_ids)) $project = ProjectList::model()->findAll('id in('.$v->project_ids.')'); ?>
                    <tr data-id="<?php echo $v->id;?>" data-name="<?php echo $v->s_name;?>" data-code="<?php echo $v->s_code;?>" data-attr="<?php echo $v->s_value;?>" data-type="<?php if(!empty($v->s_usertype)) echo $v->s_usertype->f_uname;?>" data-level="<?php echo $v->s_levelname;?>" data-project="<?php if(!empty($project))foreach($project as $p) echo $p->project_name; ?>">
                        <td><?php echo $v->s_code; ?></td>
                        <td width="30%"><?php echo $v->s_name; ?></td>
                        <td width="15%"><?php echo $v->s_levelname;?></td>
                        <td>
                        <?php if(!empty($project))foreach($project as $p) echo $p->project_name.' '; ?>
                        </td>
                        <td width="15%"><?php if(!empty($v->s_usertype)) echo $v->s_usertype->f_uname;?></td>
                        <td width="15%"><?php if(!empty($v->qmddperson)) echo $v->qmddperson->servic_site_name;?></td>
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
    api.button(
        {
            name: '取消'
        }
    );
    $('.box-table tbody tr').on('click', function(){
        var $this=$(this);
        $.dialog.data('product_id', $this.attr('data-id'));
        $.dialog.data('product_name', $this.attr('data-name'));
        $.dialog.data('product_code', $this.attr('data-code'));
		$.dialog.data('product_attr', $this.attr('data-attr'));
		$.dialog.data('s_type', $this.attr('data-type'));
		$.dialog.data('level', $this.attr('data-level'));
        $.dialog.data('project', $this.attr('data-project'));
        $.dialog.close();
    });
});
</script>