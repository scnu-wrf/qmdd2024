<style>.box-detail-tab li { width: 120px; }</style>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/4d1403b2/jquery.yiiactiveform.js"></script>
<div class="box">
    <div id="t0" class="box-title c">
        <span>
            <a href="../../admin/index.php?act=main" class="lode_po" onclick="parent.location.reload();"><i class="fa fa-home"></i>当前界面：</a>赛事/活动/培训 -> 赛事管理 ->
            <a href="<?php echo $this->createUrl('gameList/index'); ?>" class="lode_po">赛事列表</a> -> 发布
            <?php if(!empty($model->id)) {?>
                -> <a href="<?php echo $this->createUrl('gameList/update',array('id'=>$model->id)); ?>" class="lode_po"><?php echo $model->game_title; ?></a> -> 运动员报名须知
            <?php }?>
        </span>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/index');?>');"><i class="fa fa-reply"></i>返回赛事列表</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <?php if($model->id!=''){?>
            <div class="box-detail-tab">
                <ul class="c">
                    <?php $action=Yii::app()->controller->getAction()->id;?>
                    <li><a href="<?php echo $this->createUrl('gameList/update',array('id'=>$model->id));?>">基本信息</a></li>
                    <li><a href="<?php echo $this->createUrl('gameListData/index',array('game_id'=>$model->id,'title'=>$model->game_title,'type'=>$model->game_type));?>">竞赛项目</a></li>
                    <li><a href="<?php echo $this->createUrl('gameIntroduction/index',array('game_id'=>$model->id,'title'=>$model->game_title,'type'=>$model->game_type));?>">竞赛规程</a></li>
                    <li class="current"><a href="<?php echo $this->createUrl('gameList/member_notice',array('id'=>$model->id)); ?>">运动员报名须知</a></li>
                    <li><a href="<?php echo $this->createUrl('gameList/team_notice',array('id'=>$model->id)); ?>">裁判员报名须知</a></li>
                </ul>
            </div><!--box-detail-tab end-->
        <?php }?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table id="t1" class="mt15">
                    <tr>
                        <td style="font-weight: bold;"><?php echo $form->labelEx($model,'member_notice');?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->textarea($model,'member_notice',array('class'=>'input-text','style'=>'height: 300px;width:98%;')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <?php if($model->state==721) {?>
                                <button class="btn btn-blue" type="submit" onclick="submitType='baocun'">保存</button>
                            <?php }?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script type="text/javascript">
    /*<![CDATA[*/
    jQuery(function($) {
        jQuery('#active-form').yiiactiveform({'validateOnSubmit':true,'afterValidate':function(form,data,hasError){
            if(!hasError||(submitType=="baocun")){
                we.overlay("show");
                $.ajax({
                    type:"post",
                    url:form.attr("action"),
                    data:form.serialize()+"&submitType="+submitType,
                    dataType:"json",
                    success:function(d){
                        if(d.status==1){
                            we.success(d.msg, d.redirect);
                        }else{
                            we.error(d.msg, d.redirect);
                        }
                    }
                });
            }else{
                var html="";
                var items = [];
                for(item in data){
                    items.push(item);
                    html+="<p>"+data[item][0]+"</p>";
                }
                we.msg("minus", html);
                var $item = $("#"+items[0]);
                $item.focus();
                $(window).scrollTop($item.offset().top-10);
            }
        }})
    });
    /*]]>*/
</script>