<?php
    if(empty($_REQUEST['club_id'])){
        $_REQUEST['club_id']=0;
    }
    if(empty($_REQUEST['title'])){
        $_REQUEST['title']='';
    }
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php echo $_REQUEST['title']; ?>应收费用详细</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <!-- <div class="box-search">
            <form action="<?php echo $this->createUrl('update_list'); ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <input type="hidden" name="id" value="<?php echo Yii::app()->request->getParam('id'); ?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input type="text" style="width:200px" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div> -->
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-table">
            <table class="list" style="table-layout:auto;">
                <thead>
                    <tr>
                        <th style="text-align:center;" class="check"><input id="j-checkall" class="input-check" type="checkbox" value="全选"><span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span></th>
                        <th style="text-align:center;">序号</th>
                        <th style="text-align:center;">账号</th>
                        <th style="text-align:center;">会员姓名</th>
                        <th style="text-align:center;">会员等级</th>
                        <th style="text-align:center;">金额</th>
                    </tr>
                </thead>
                <tbody>
                <?php $num=1; foreach($arclist as $v){ ?>
                    <tr data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->id; ?>" data-title="<?php echo $v->gf_name; ?>">
                        <td style="text-align:center;" class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align:center;"><?php echo $num; ?></td>
                        <td style="text-align:center;"><?php echo $v->gf_id; ?></td>
                        <td style="text-align:center;"><?php echo $v->gf_name; ?></td>
                        <td style="text-align:center;"><?php echo $v->levelname; ?></td>
                        <td style="text-align:center;"><?php echo $v->scale_amount; ?></td>
                    </tr>
                <?php $num++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
        <?php $this->endWidget();?>
    </div>
    <div class="box-page c"><?php //$this->page($pages); ?></div>
</div>