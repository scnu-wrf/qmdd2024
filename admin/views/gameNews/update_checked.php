
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名》赛事动态》发布待审核》<a class="nav-a">动态详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回列表</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="table-title">
                    <tr>
                        <td>动态信息</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'news_type'); ?></td>
                        <td width="35%">
                            <?php echo $form->dropDownList($model, 'news_type', Chtml::listData(BaseCode::model()->getCode(882), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchang(this)','disabled'=>'true')); ?>
                            <?php echo $form->error($model, 'news_type', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                        <td width="35%">
                            <span id="club_box"><?php if($model->club_id!=null){?><span><?php echo $model->club_names;?></span><?php } ?></span>
                            <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'news_code'); ?></td>
                        <td><?php echo $model->news_code;?></td>
                        <td><?php echo $form->labelEx($model, 'game_id'); ?></td>
                        <td><?php echo $form->hiddenField($model, 'game_id', array('class' => 'input-text')); ?>
                            <span id="game_box"><?php echo $model->game_names;?></span>
                            <?php echo $form->error($model, 'game_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'news_title'); ?></td>
                        <td colspan="3"><?php echo $model->news_title;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'news_date_start'); ?></td>
                        <td><?php echo $model->news_date_start;?></td>
                        <td><?php echo $form->labelEx($model, 'news_date_end'); ?></td>
                        <td><?php echo $model->news_date_end;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_num'); ?></td>
                        <td colspan="3"><?php echo $model->order_num;?></td>
                    </tr>
                </table>
                <table class="mt15 table-title">
                    <tr>
                        <td>动态内容</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'news_introduction'); ?></td>
                        <td colspan="3"><?php echo $model->news_introduction;?>
                          <p>*简短介绍，最多可输入30个字符，含数字特殊符号：-&nbsp;/&nbsp;\&nbsp;等；</p>
                          <?php echo $form->error($model, 'news_introduction', $htmlOptions = array()); ?>
                        </td>                        
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'news_pic'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'news_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(189);$picprefix=''; if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->news_pic!=''){?>
                                <div class="upload_img fl" id="upload_pic_GameNews_news_pic">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->news_pic;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->news_pic;?>" width="100">
                                    </a>
                                </div>
                            <?php }?>
                        </td>
                    </tr>
                    <tr id='show_pic_line'  style="display:none;"><!--news_type=884时显示，此外为多图，链接game_news_pic表-->
                        <td>
                            <?php
                                echo $form->labelEx($model, 'game_news_pic'); 
                                $model->id=empty($model->id) ? 0 : $model->id;
                                $game_news_pic=GameNewsPic::model()->findAll('game_news_id='.$model->id);
                            ?>
                        </td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'game_news_pic', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_game_news_pic">
                                <?php $basepath=BasePath::model()->getPath(189);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; } ?>
                                <script>
								var pic_num=0;
                                </script>
                                <table id="game_news_pic">
                                    <?php if(!empty($game_news_pic))foreach($game_news_pic as $v){?>
                                        <tr>
                                            <td width="150">
                                                <input type="hidden" name="game_news_pic[<?php echo $v['id'];?>][id]" value="<?php echo $v['id'];?>" >
                                                <input type="hidden" name="game_news_pic[<?php echo $v['id'];?>][pic]" value="<?php echo $v['news_pic'];?>" >
                                                <a class="picbox" data-savepath="<?php echo $v['news_pic'];?>" href="<?php echo $basepath->F_WWWPATH.$v['news_pic'];?>" target="_blank">
                                                    <img src="<?php echo $basepath->F_WWWPATH.$v['news_pic'];?>" width="100">
                                                </a>
                                            </td>
                                            <td>
                                                    <textarea oninput="LimitText(this)" onpropertychange="LimitText(this)" name="game_news_pic[<?php echo $v['id'];?>][intro]" class="input-text" style="width:80%;height:80px;" maxlength="100" placeholder="请输入图片介绍... 100字以内" readonly><?php echo $v['introduce'];?></textarea>
                                            </td>
                                        </tr>
                                        <script>pic_num=<?php echo $v['id'];?>;</script>
                                    <?php }?>
                                </table>
                            </div>
                        </td>
                    </tr><!--子图片结束-->
                    <tr id='show_video_line' style="display:none;"><!--news_type=885时显示,此外表，链接game_news_pic表-->
                        <td>
                            <?php
                                echo $form->labelEx($model, 'news_video'); 
                            ?>
                        </td>
                        <td colspan="3" style="padding:30px 15px;">
                            <?php echo $form->hiddenField($model, 'news_video', array('class' => 'input-text')); ?>
                            <div class="c">
                                <span id="video_box" class="fl">
                                    <?php if($model->news_video!=null){?>
                                        <span class="label-box">
                                            <a href="<?php echo $model->gf_material->v_file_path.$model->gf_material->v_name;?>" target="_blank">
                                                <?php if($model->gf_material->v_title!=''){ 
                                                    echo $model->gf_material->v_title;
                                                }else{ 
                                                    echo $model->gf_material->v_name;
                                                }?>
                                            </a>
                                        </span>
                                    <?php }?>
                                </span>
                            </div>
                            <?php echo $form->error($model, 'news_video', $htmlOptions = array()); ?>
                        </td>
                    </tr><!--视频结束-->
                    <tr id="news_content" style="display:none;"><!--news_type=883时显示-->
                        <td><?php echo $form->labelEx($model, 'news_content'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'news_content_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_news_content_temp', '<?php echo get_class($model);?>[news_content_temp]');</script>
                            <?php echo $form->error($model, 'news_content_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
<?php if($model->state==371){ ?>
            <table class="mt15 table-title"><tr> <td>操作信息</td></tr></table>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td><?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td width="15%">可执行操作</td>
                    <td>
                        <?php
                        echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));
                        ?>
                    </td>
                </tr>
            </table>
<?php } ?>
            <table class="showinfo">
            <tr>
                <th style="width:20%;">操作时间</th>
                <th style="width:20%;">操作人</th>
                <th style="width:20%;">状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php echo $model->uDate; ?></td>
                <td><?php echo $model->state_qmddname; ?></td>
                <td><?php echo $model->state_name; ?></td>
                <td><?php echo $model->reasons_failure; ?></td>
            </tr>
        </table>
        </div><!--box-detail-bd end-->
        
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
$(function(){
setTimeout(function(){ UE.getEditor('editor_VideoLive_intro_temp').setDisabled('fullscreen'); }, 500);


    selectOnchang('#GameNews_news_type');
    function selectOnchang(obj){ 
         //console.log($(obj).val());
        var show_id=$(obj).val();
        if (show_id==884) { 
            $("#show_pic_line").show();
            $("#show_video_line").hide();
            $("#news_content").hide();
        }else if (show_id==885){
            $("#show_video_line").show();
            $("#show_pic_line").hide();
            $("#news_content").hide();
        } else if (show_id==883) {
            $("#show_video_line").hide();
            $("#show_pic_line").hide();
            $("#news_content").show();

        }
    };
});
        

</script> 
