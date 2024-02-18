<?php 
    if(empty($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(empty($_REQUEST['type'])){
        $_REQUEST['type']=0;
    }
    if(!isset($_REQUEST['title'])){
        $_REQUEST['title']=0;
    }
    if(!empty($model->game_id)){
        $game_list=GameList::model()->find('id='.$model->game_id);
    }
    else {
        $game_list=GameList::model()->find('id='.$_REQUEST['game_id']);
    }
    $sh = $game_list->state;
    $disabled = ($sh==721 || $sh==373) ? '' : 'disabled';
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》赛事发布 》<?php echo $game_list->game_title; ?> 》竞赛规程 》<?php echo (empty($model->id)) ? '添加' : '/详情'; ?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameIntroduction/index', array('game_id'=>$_REQUEST['game_id'],'type'=>$_REQUEST['type'],'title'=>$_REQUEST['title']));?>');"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <?php echo $form->hiddenField($model, 'game_id', array('class' => 'input-text','value'=>$_REQUEST['game_id'])); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table border="0" cellspacing="1" cellpadding="0" class="product_publish_content">
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'intro_title'); ?></td>
                        <td width="85%"><?php echo ($sh==721 || $sh==373) ? $form->textField($model, 'intro_title', array('class' => 'input-text')) : $model->intro_title; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'intro_content'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'intro_content_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_intro_content_temp', '<?php echo get_class($model);?>[intro_content_temp]');</script>
                            <?php if($sh==371 || $sh==372)echo '<script>var ue = UE.getEditor("editor_GameIntroduction_intro_content_temp");ue.ready(function() {ue.setDisabled();});</script>'; ?>
                            <?php echo $form->error($model, 'intro_content_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <table class="mt15">
                <tr>
                    <td style="width:15%;">可执行操作</td>
                    <td colspan="3">
                        <?php
                            if($game_list->state==721 || $game_list->state==373) {
                                echo show_shenhe_box(array('baocun'=>'下一步'));
                                echo '<button class="btn" type="button" onclick="we.back();">取消</button>';
                            }
                        ?>
                        <input type="hidden" name="type" value="<?php echo $_REQUEST['type'];?>">
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
