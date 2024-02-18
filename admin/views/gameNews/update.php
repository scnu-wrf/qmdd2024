<?php if($flag==1){
    $txt='编辑';
} else{
    $txt='添加';
}
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名》赛事动态》动态发布》<a class="nav-a"><?php echo $txt; ?></a></h1>
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
                            <?php echo $form->dropDownList($model, 'news_type', Chtml::listData(BaseCode::model()->getCode(882), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchang(this)')); ?>
                            <?php echo $form->error($model, 'news_type', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                        <td width="35%">
                            <span id="club_box"><?php if($model->club_id!=null){?><span><?php echo $model->club_names;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name'); ?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span><?php } ?></span>
                            <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'news_code'); ?></td>
                        <td><?php echo $model->news_code;?></td>
                        <td><?php echo $form->labelEx($model, 'game_id'); ?></td>
                        <td><?php echo $form->hiddenField($model, 'game_id', array('class' => 'input-text')); ?>
                            <span id="game_box"><?php echo $model->game_names;?></span>
                            <input id="game_select_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'game_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'news_title'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'news_title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'news_title', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'news_date_start'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'news_date_start', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'news_date_start', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'news_date_end'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'news_date_end', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'news_date_end', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'order_num'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'order_num', array('class' => 'input-text','style'=>'width:36%')); ?>
                            <?php echo $form->error($model, 'order_num', $htmlOptions = array()); ?>
                        </td>
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
                        <td colspan="3">
                          <?php echo $form->textArea($model,'news_introduction', array('class' => 'input-text', 'maxlength'=>'140' )); ?>
                          <p>*简短介绍，最多可输入140个字符，含数字特殊符号：-&nbsp;/&nbsp;\&nbsp;等；</p>
                          <?php echo $form->error($model, 'news_introduction', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr >

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
                                <input style="margin-left:5px;" id="picture_select_btn" class="btn" type="button" value="图库选择" >
                                <script>we.uploadpic('<?php echo get_class($model);?>_news_pic','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'news_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr id='show_pic_line'  style="display:none;"><!--news_type=884时显示，此外为多图，链接game_news_pic表-->
                        <td>
                            <?php
                                echo $form->labelEx($model, 'game_news_pic');
                                $model->id=empty($model->id) ?0 : $model->id;
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
                                                    <textarea oninput="LimitText(this)" onpropertychange="LimitText(this)" name="game_news_pic[<?php echo $v['id'];?>][intro]" class="input-text" style="width:80%;height:80px;" maxlength="500" placeholder="请输入图片介绍... 500字以内"><?php echo $v['introduce'];?></textarea>
                                            </td>
                                                <td width="50"><a class="btn" href="javascript:;" onclick="fnDelPic(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                        <script>pic_num=<?php echo $v['id'];?>;</script>
                                    <?php }?>
                                </table>
                            </div>
                                <script>we.uploadpic('<?php echo get_class($model);?>_game_news_pic','<?php echo $picprefix;?>','','',function(e1,e2){fnscrollPic(e1.savename,e1.allpath);},50);</script>
                            <?php echo $form->error($model, 'game_news_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr><!--子图片结束-->
                    <tr id='show_video_line' style="display:none;"><!--news_type=885时显示,此外表，链接game_news_pic表-->
                        <td>
                            <?php
                                echo $form->labelEx($model, 'news_video');
                            //$model->id=empty($model->id) ?0 : $model->id;
                            //$game_news_video=GameNewsPic::model()->findAll('game_news_id='.$model->id);
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
                                <div class="upload fl">
                                <script>var materialVideoUrl='<?php echo $this->createUrl('gfMaterial/upvideo');?>';
                                we.materialVideo(function(data){ $('#GameNews_news_video').val(data.id).trigger('blur'); $('#video_box').html('<a href="'+data.allpath+'" target="_blank">'+data.title+'</a>'); },'上传',61,24);</script></div>
                                <input style="margin-left:5px;" id="video_select_btn" class="btn fl" type="button" value="选择视频">
                            </div>
                            <?php echo $form->error($model, 'news_video', $htmlOptions = array()); ?>
                        </td>
                    </tr><!--视频结束-->
                    <tr id="news_content" style="display:none;"><!--news_type=883时显示-->
                        <td><?php echo $form->labelEx($model, 'news_content'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'news_content_temp', array('class' => 'input-text')); ?>
                            <script>
                                we.editor('<?php echo get_class($model);?>_news_content_temp', '<?php echo get_class($model);?>[news_content_temp]','500','50%');
                                // var ue = UE.getEditor("editor_GameNews_news_content_temp");ue.ready(function() {ue.getEditor({initialFrameHeight:100,initialFrameWidth:400 });});
                            </script>
                            <script type="text/javascript">
                                //var editor = new UE.getEditor({initialFrameHeight:100,initialFrameWidth:400 });
                            </script>
                            <?php echo $form->error($model, 'news_content_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title"><td colspan="2">操作信息</td></tr>
                <tr>
                    <td colspan="2">
                        <span>
                            <input type="checkbox" id="check-1" onclick="fnAgreement(this);" class="checkbox" value="" style="vertical-align: sub;">
                            <label for="check-1">已阅读并同意</label>
                            <a href="javascript:;" target="_blank">《动态发布须知》</a>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td width="15%">可执行操作</td>
                    <td>
                        <?php
                          echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));
                        ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->

        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    we.tab('.box-detail-tab li','.box-detail-tab-item');
    fnAgreement('#check-1');
    var club_id=0;
    var $game_id=$('#GameNews_game_id');
    $('#game_select_btn').on('click', function(){
        var club_id=$('#GameNews_club_id').val();
        $.dialog.data('game_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gameList");?>&club_id='+club_id,{
            id:'saishi',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
           close: function () {
                if($.dialog.data('game_id')>0){
                    $game_id.val($.dialog.data('game_id')).trigger('blur');
                    $('#GameNews_news_date_start').val($.dialog.data('star'));
                    $('#GameNews_news_date_end').val($.dialog.data('end'));
                    $('#game_box').html($.dialog.data('game_title'));
                }
            }
        });
    });
    //限制图集简介字数
function LimitText(op){
     maxlimit = 500;
     var textval=$(op).val();
     if (textval.length > maxlimit) {
         $(op).val(textval.substring(0, maxlimit));
         we.msg('minus', '字数不得多于500！');
     }
}
    $('#GameNews_news_date_start').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $('#GameNews_news_date_end').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    var project_id=0;

    // 滚动图片处理
    var $GameNews_game_news_pic=$('#GameNews_game_news_pic');
    var $game_news_pic=$('#game_news_pic');
    var $upload_pic_game_news_pic=$('#upload_pic_game_news_pic');
    var $upload_box_scroll_pic_img=$('#upload_box_scroll_pic_img');

    // 上传完成时图片处理
    var fnscrollPic=function(savename,allpath){
        pic_num++;
        $game_news_pic.append('<tr><td width="150"><input type="hidden" name="game_news_pic['+pic_num+'][id]" value="null" ><input type="hidden" name="game_news_pic['+pic_num+'][pic]" value="'+savename+'" ><a class="picbox" data-savepath="'+savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"></a></td><td><textarea oninput="LimitText(this)" onpropertychange="LimitText(this)" name="game_news_pic['+pic_num+'][intro]" class="input-text" style="width:80%;height:80px;" maxlength="500" placeholder="请输入图片介绍... 500字以内"></textarea></td><td width="50"><a class="btn" href="javascript:;" onclick="fnDelPic(this);" title="删除"><i class="fa fa-trash-o"></i></a>');
    };

    var fnDelPic=function(op){
        $(op).parent().parent().remove();
    }

    selectOnchang('#GameNews_news_type');
    function selectOnchang(obj){
    //     console(obj);
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


$(function(){



        // 添加图片到$model->game_news_pic;
        var arr1=[];
        $upload_pic_game_news_pic.find('a').each(function(){
            arr1.push($(this).attr('data-savepath'));
        });
        $game_news_pic.val(we.implode(',',arr1));
        $upload_box_scroll_pic_img.show();

    // 选择视频
    var $video_box=$('#video_box');
    var $GameNews_news_video=$('#GameNews_news_video');
    $('#video_select_btn').on('click', function(){
        var club_id=$('#GameNews_club_id').val();
        $.dialog.data('video_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/material", array('type'=>253));?>&club_id='+club_id,{
            id:'shipin',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('material_id')>0){
                    $GameNews_news_video.val($.dialog.data('material_id')).trigger('blur');
                    $video_box.html('<a href="'+$.dialog.data('v_path')+'" target="_blank">'+$.dialog.data('material_title')+'</a>');
                }
            }
        });
    });

});

	//从图库选择图片
var $Single=$('#GameNews_news_pic');
    $('#picture_select_btn').on('click', function(){
		//var club_id=$('#GfSite_user_club_id').val();&club_id='+club_id
        $.dialog.data('app_icon', 0);
        $.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type'=>252,'fd'=>189));?>',{
            id:'picture',
            lock:true,
            opacity:0.3,
            title:'请选择素材',
            width:'100%',
            height:'90%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $Single.val($.dialog.data('app_icon')).trigger('blur');

                    $('#upload_pic_GameNews_news_pic').html('<a href="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'"  width="100"></a>');

                   // $('#Gfapp_app_icon_x').val($.dialog.data('dataX')).trigger('blur');
                    //$('#Gfapp_app_icon_y').val($.dialog.data('dataY')).trigger('blur');
                    //$('#Gfapp_app_icon_w').val($.dialog.data('dataWidth')).trigger('blur');
                    //$('#Gfapp_app_icon_h').val($.dialog.data('dataHeight')).trigger('blur');
               }

            }
        });
});
</script>
