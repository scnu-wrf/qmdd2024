<?php
    if(!empty($model->dispay_star_time=='0000-00-00 00:00:00')){
        $model->dispay_star_time='';
    }
    if(!empty($model->dispay_end_time=='0000-00-00 00:00:00')){
        $model->dispay_end_time='';
    }
    if(!empty($model->market_time=='0000-00-00 00:00:00')){
        $model->market_time='';
    }
    if(!empty($model->market_time_end=='0000-00-00 00:00:00')){
        $model->market_time_end='';
    }
    $disabled = !empty($_REQUEST['disabled']) ? 'disabled' : '';
    $genggai = !empty($_REQUEST['genggai']) ? true : false;
?>
<script>
    var materialVideoUrl='<?php echo $this->createUrl('gfMaterial/upvideo');?>';
</script>
<div class="box">
    <div id="t0" class="box-title c">
        <h1>当前界面：培训/活动 》活动发布 》发布 》<?php echo (empty($model->id)) ? '添加' : '/详情'; ?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php $form = $this->beginWidget('CActiveForm', get_form_list2('baocun')); ?>
        <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="current">基本信息</li>
                <li>课程介绍</li>
            </ul>
        </div>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table id="t1" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td width="10%;">
                            <?php echo $form->labelEx($model, 'course_type_id'); ?>
                            /
                            <?php echo $form->labelEx($model, 'course_type2_id'); ?>
                        </td>
                        <td colspan="3">
                            <?php echo $form->dropDownList($model, 'course_type_id', Chtml::listData(ClubStoreType::model()->findAll('f_id in(1506)'), 'id', 'type'), array('prompt'=>'请选择','onchange'=>'changeData(this)','disabled'=>$disabled)); ?>
                            <select name="ClubStoreCourse[course_type2_id]" id="ClubStoreCourse_course_type2_id" <?= $disabled; ?>>
                                <option value="">请选择</option>
                                <?php if(!empty($model->course_type_id)){?>
                                    <?php
                                        $data = ClubStoreType::model()->findAll('fater_id='.$model->course_type_id);
                                        $content='';
                                        foreach($data as $vl){
                                            $content.='<option value="'.$vl->id.'" '.($vl->id==$model->course_type2_id?'selected':'').'>'.$vl->classify.'</option>';
                                        }
                                        echo $content;
                                    ?>
                                <?php }?>
                            </select>
                            <?php echo $form->error($model, 'course_type_id', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'course_type2_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="10%;"><?php echo $form->labelEx($model, 'course_code'); ?></td>
                        <td width="40%;"><?php echo $model->course_code; ?></td>
                        <td width="10%;"><?php echo $form->labelEx($model, 'course_club_name'); ?></td>
                        <td width="40%;">
                            <?php
                                if(empty($model->id)){
                                    $course_club_id=get_session('club_id');
                                    $course_club_code=get_session('club_code');
                                    $course_club_name=get_session('club_name');
                                }else{
                                    $course_club_id=$model->course_club_id;
                                    $course_club_code=$model->course_club_code;
                                    $course_club_name=$model->course_club_name;
                                }
                                echo $form->hiddenField($model, 'course_club_id', array('class' => 'input-text','value'=>$course_club_id));
                                echo $form->hiddenField($model, 'course_club_code', array('class' => 'input-text','value'=>$course_club_code));
                                echo $form->hiddenField($model, 'course_club_name', array('class' => 'input-text','value'=>$course_club_name));
                                echo $course_club_name;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'course_title'); ?></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'course_title', array('class' => 'input-text','disabled'=>$disabled));
                                echo $form->error($model, 'course_title', $htmlOptions = array());
                            ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'is_online'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'is_online', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'is_online', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'dispay_star_time'); ?>
                            <?php echo $form->labelEx($model, 'dispay_end_time', array('style'=>'display:none;')); ?>
                        </td>
                        <td colspan="3">
                            <?php
                                if($genggai==1&&$model->dispay_end_time<date('Y-m-d H:i:s')){
                                    echo $form->textField($model, 'dispay_star_time', array('class' => 'input-text','disabled'=>'disabled','style'=>'width:150px;','placeholder'=>'显示开始时间')) ;
                                }else{
                                    echo $form->textField($model, 'dispay_star_time', array('class' => 'input-text','disabled'=>$disabled,'style'=>'width:150px;','placeholder'=>'显示开始时间')) ;
                                }
                             ?>
                            -
                            <?php echo $form->textField($model, 'dispay_end_time', array('class' => 'input-text','disabled'=>$disabled,'style'=>'width:150px;','placeholder'=>'显示截止时间')) ; ?>
                            <?php echo $form->error($model, 'dispay_star_time', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'dispay_end_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'course_small_pic'); ?></td>
                        <td id="dpic_course_small_pic">
                            <?php
                                echo $form->hiddenField($model, 'course_small_pic', array('class' => 'input-text fl'));
                                $basepath=BasePath::model()->getPath(298);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->course_small_pic!=''){
                            ?>
                            <div class="upload_img fl" id="upload_pic_ClubStoreCourse_course_small_pic">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->course_small_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->course_small_pic;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                            <?php if($disabled==''){ ?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_course_small_pic','<?php echo $picprefix;?>');</script>
                            <?php }?>
                            <?php echo $form->error($model, 'course_small_pic', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'course_big_pic'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'course_big_pic', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_ClubStoreCourse_course_big_pic">
                                <?php
                                    $basepath=BasePath::model()->getPath(299);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                    if(!empty($course_big_pic))foreach($course_big_pic as $v) {
                                ?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="50">
                                    <?php if($disabled==''){ ?>
                                        <i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i>
                                    <?php }?>
                                </a>
                                <?php }?>
                            </div>
                            <?php if($disabled==''){ ?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_course_big_pic','<?php echo $picprefix;?>','','',function(e1,e2){fnscrollPic(e1.savename,e1.allpath);},50);</script>
                            <?php }?>
                            <?php echo $form->error($model, 'course_big_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">课程信息</td>
                    </tr>
                    <tr>
                        <td width="10%;"><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td colspan="3">
                            <?php echo $form->dropDownList($model, 'project_id', Chtml::listData($project, 'project_id', 'project_name'), array('prompt' => '请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="10%;"><?php echo $form->labelEx($model, 'course_grade'); ?></td>
                        <td width="40%;">
                            <?php echo $form->dropDownList($model, 'course_grade', Chtml::listData(BaseCode::model()->getCode(1530), 'f_id', 'F_NAME'), array('prompt' => '请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'course_grade', $htmlOptions = array()); ?>
                        </td>
                        <td width="10%;"><?php echo $form->labelEx($model, 'course_money'); ?></td>
                        <td width="40%;">
                            <?php echo $form->textField($model, 'course_money', array('class' => 'input-text mony','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'course_money', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'market_time'); ?>
                            <?php echo $form->labelEx($model, 'market_time_end', array('style'=>'display:none;')); ?>
                        </td>
                        <td colspan="3">
                            <?php echo  $form->textField($model, 'market_time', array('class' => 'input-text','disabled'=>$disabled,'style'=>'width:150px;','placeholder'=>'销售开始日期')) ; ?>
                            -
                            <?php echo $form->textField($model, 'market_time_end', array('class' => 'input-text','disabled'=>$disabled,'style'=>'width:150px;','placeholder'=>'销售截止日期')) ; ?>
                            <?php echo $form->error($model, 'market_time', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'market_time_end', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <div class="mt15">
                    <table class="mt15" id="course_data">
                        <tr class="table-title">
                            <td colspan="5">课程列表</td>
                            <?php if($disabled==''){ ?>
                                <td>
                                    <span><input type="button" class="btn" onclick="add_tag();" value="添加"></span>
                                </td>
                            <?php }?>
                        </tr>
                        <tr>
                            <td>序号</td>
                            <td>课程缩略图</td>
                            <td>视频标题</td>
                            <td>视频时长</td>
                            <td>视频内容</td>
                            <?php if($disabled==''){?>
                                <td>操作</td>
                            <?php }?>
                        </tr>
                        <?php $basepath=BasePath::model()->getPath(301);$picprefix1='';if($basepath!=null){ $picprefix1=$basepath->F_CODENAME;}?>
                        <?php
                            if(!empty($list_data)){
                                $num=0;
                                foreach($list_data as $d){
                        ?>
                        <tr class="course_data" data_index="<?= $num;?>" >
                            <input class="input-text" name="add_tag[<?= $num;?>][data_id]" type="hidden" value="<?= $d->id?>" <?= $disabled!=''?'disabled':'';?>>
                            <td><?php echo $num+1;?></td>
                            <td>
                                <input id="add_tag_video_pic_<?= $num;?>" class="video_pic" name="add_tag[<?= $num;?>][video_pic]" type="hidden" value="<?= $d->video_pic;?>" <?= $disabled!=''?'disabled':'';?>>
                                <?php if(!empty($d->video_pic)){?>
                                    <div class="upload_img fl" id="upload_pic_add_tag_video_pic_<?= $num;?>">
                                        <a class="picbox" data-savepath="<?php echo $d->video_pic;?>" href="<?php echo $basepath->F_WWWPATH.$d->video_pic;?>" target="_blank">
                                            <img src="<?php echo $basepath->F_WWWPATH.$d->video_pic;?>" width="100">
                                        </a>
                                    </div>
                                <?php }?>
                                <?php if($disabled==''){ ?>
                                    <script>we.uploadpic("add_tag_video_pic_<?= $num;?>", "<?php echo $picprefix1;?>");</script>
                                <?php }?>
                            </td>
                            <td>
                                <input name="add_tag[<?= $num;?>][video_title]" class="input-text" value="<?= $d->video_title;?>" <?= $disabled!=''?'disabled':'';?>>
                            </td>
                            <td>
                                <input id="video_duration_<?= $num;?>" name="add_tag[<?= $num;?>][video_duration]" class="input-text" style="border: none;cursor: context-menu;" readonly value="<?= $d->video_duration;?>" <?= $disabled!=''?'disabled':'';?>>
                                <video id="video_html_<?= $num;?>" src="" style="display:none;" controls oncanplaythrough="myFunction(this)" ></video>
                            </td>
                            <td>
                                <input id="video_<?= $num;?>" name="add_tag[<?= $num;?>][video_id]" class="input-text" type="hidden" value="<?= $d->video_id;?>" <?= $disabled!=''?'disabled':'';?>>
                                <div class="c">
                                    <span id="video_box_<?= $num;?>" class="fl">
                                        <?php
                                            if(!empty($d->video_id)){
                                                $gf_material=GfMaterial::model()->find('id='.$d->video_id);
                                        ?>
                                            <span class="label-box">
                                            <a href="<?php if(!empty($gf_material))echo $gf_material->v_file_path.$gf_material->v_name;?>" target="_blank">
                                                <?php if(!empty($gf_material))echo $gf_material->v_name;?>
                                            </a>
                                            </span>
                                        <?php }?>
                                    </span>
                                    <div class="upload fl">
                                        <?php if($disabled==''){ ?>
                                            <script>
                                                we.materialVideo(function(data){
                                                    $('#video_<?= $num;?>').val(data.id).trigger('blur');
                                                    $('#video_box_<?= $num;?>').html('<span class="label-box">'+data.name+'</span>');
                                                    $("#video_html_<?= $num;?>").after('<video id="video_html_<?= $num;?>" src="'+data.allpath+'" style="display:none;" controls oncanplaythrough="myFunction(this)" ></video>').remove();
                                                },'上传',61,24);
                                            </script>
                                        <?php }?>
                                    </div>
                                </div>
                            </td>
                            <?php if($disabled==''){?>
                                <td>
                                    <a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a>
                                </td>
                            <?php }?>
                        </tr>
                        <?php $num++;}}else{?>
                            <tr class="course_data"  data_index="0" >
                                <input class="input-text" name="add_tag[0][data_id]" type="hidden" value="-1">
                                <td>1</td>
                                <td>
                                    <input id="add_tag_video_pic_0" class="video_pic" name="add_tag[0][video_pic]" type="hidden">
                                    <div id="box_add_tag_video_pic_0" style="margin-left:0.5rem;">
                                    <script>we.uploadpic("add_tag_video_pic_0", "<?php echo $picprefix1;?>");</script></div>
                                </td>
                                <td>
                                    <input name="add_tag[0][video_title]" class="input-text">
                                </td>
                                <td>
                                    <input id="video_duration_0" name="add_tag[0][video_duration]" class="input-text" style="border: none;cursor: context-menu;" readonly>
                                    <video id="video_html_0" src="" controls oncanplaythrough="myFunction(this)" style="display:none;" ></video>
                                </td>



                                <td class="up_btn">
                                    <input id="video_0" name="add_tag[0][video_id]" class="input-text" type="hidden">
                                    <span class="f1">
                                        <div class="up_progress"  style="width: 200px;height: 25px;line-height: 25px;background-color:#f7f7f7;box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);border-radius:4px;background-image:linear-gradient(to bottom,#f5f5f5,#f9f9f9);display:none;">
                                            <div class="up_finish" style="width: 0%;background-color: #149bdf;background-image:linear-gradient(45deg,rgba(255,255,255,0.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,0.15) 50%,rgba(255,255,255,0.15) 75%,transparent 75%,transparent);background-size:40px 40px;height: 100%;color: #fff;text-align: right;padding-right: 5px;box-sizing: border-box;" progress="0"></div>
                                        </div>
                                    </span>
                                    <div class="upload fl" style="display: none;">
                                        <input name="fileCode" id="fileCode" value="162_ccv" type="hidden" />
                                        <script>
                                            we.materialVideo(function(data){
                                                $('#video_0').val(data.id).trigger('blur');
                                                $('#video_box_0').html('<span class="label-box">'+data.name+'</span>');
                                                $("#video_html_0").after('<video id="video_html_0" src="'+data.allpath+'" style="display:none;" controls oncanplaythrough="myFunction(this)" ></video>').remove();
                                            },'上传',"<?php echo $this->createUrl('GfMaterial/saveMaterial');?>");
                                        </script>
                                    </div>
                                    <span class="fl video_box"></span>
                                    <div class="upload fl">
                                        <script>
                                            we.materialVideoNew("<?php echo $this->createUrl('GfMaterial/saveMaterial');?>");
                                        </script>
                                    </div>
                                    <!-- <input style="margin-left:5px;" class="btn fl video_select_btn" type="button" value="选择视频"> -->
                                    <input type="hidden" class="input-text up_source" name="programs_list[new][video_source_id]" value="null" />
                                    <input type="hidden" class="input-text" name="programs_list[new][video_format]" />
                                    <input type="hidden" class="input-text" name="programs_list[new][video_duration]" />
                                </td>





                                <td>
                                    <a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
                <?php echo $form->hiddenField($model, 'remove_data_ids');?>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
                <table>
                    <tr>
                        <td style="height:400px;">
                            <?php echo $form->hiddenField($model, 'explain_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_explain_temp', '<?php echo get_class($model);?>[explain_temp]');</script>
                            <?php echo $form->error($model, 'explain_temp', $htmlOptions = array()); ?>

                            <?php echo $form->hiddenField($model, 'explain_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_explain_temp', '<?php echo get_class($model);?>[explain_temp]');</script>
                            <?php echo $form->error($model, 'explain_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <table class="mt15">
                <tr>
                    <td width="10%;">可执行操作</td>
                    <td colspan="3" class="sub_box">
                        <?php if($genggai==1){?>
                            <button id="genggai" onclick="submitType='genggai'" class="btn btn-blue" type="submit">保存更改</button>
                        <?php }else{?>
                            <?php if($model->state==721){?>
                                <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                                <button id="xiabu" class="btn btn-blue" onclick="submitType='xiabu'" type="submit" >下一步</button>
                                <button id="shenhe" onclick="submitType='shenhe'" class="btn btn-blue" type="submit" style="display:none;"> 提交审核</button>
                            <?php }elseif($model->state==371){?>
                                <?php if(!empty($_REQUEST['index'])&&$_REQUEST['index']=='submit'){?>
                                    <button id="quxiao" onclick="submitType='quxiao'" class="btn btn-blue" type="submit">撤销</button>
                                <?php }else{?>
                                    <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过')); ?>
                                <?php }?>
                            <?php }elseif($model->state==373){?>
                                <button id="cxbj" onclick="submitType='cxbj'" class="btn btn-blue" type="submit" >重新编辑</button>
                            <?php }else{?>
                                <?php echo $model->state_name; ?>
                            <?php }?>
                        <?php }?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<?php
function get_form_list2($submit='=='){
    return array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    if(!hasError||(submitType=="'.$submit.'")){
                        if(sType=="xiabu"){
                            $(".box-detail-tab li").eq(1).click();
                        }else{
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
                        }
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
                }',
            )
        );
  }
?>
<script>
    $(function(){
        if($("#upload_pic_ClubStoreCourse_course_big_pic .picbox").length>=5){
            $("#upload_box_ClubStoreCourse_course_big_pic").hide();
        }

        var sType='';
        var disabled= <?php echo json_encode($disabled)?>;
        if(disabled!=''){
            setTimeout(function(){ UE.getEditor('editor_ClubStoreCourse_explain_temp').setDisabled('fullscreen'); }, 500);
        }
    })

    function changeData(obj) {
        var show_id = $(obj).val();
        var content='<option value="">请选择</option>';
        $("#ClubStoreCourse_course_type2_id").html(content);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('clubStoreCourse/getListData'); ?>',
            data: {id: show_id},
            dataType: 'json',
            success: function(data) {
                $.each(data,function(k,info){
                    content+='<option value="'+info.id+'">'+info.classify+'</option>'
                })
                $("#ClubStoreCourse_course_type2_id").html(content);
            }
        });
    }

    function myFunction(ele) {
        var data_index=$(ele).parents(".course_data").attr('data_index');
        var hour = parseInt((ele.duration)/3600);
        var minute = parseInt((ele.duration%3600)/60);
        var second = Math.ceil(ele.duration%60);
        $("#video_duration_"+data_index+"").val(hour+":"+minute+":"+second);
    }

    $(".box-detail-tab li").on("click",function(){
        if($(this).hasClass('current')){
            return false;
        }
        $("*").removeClass('current');
        $(this).addClass('current');
        $(".box-detail-tab-item").hide();
        $(".box-detail-tab-item").eq($(this).index()).show();
        if($(this).index()==1){
            $("#xiabu").hide();
            $("#shenhe").show();
        }else{
            $("#xiabu").show();
            $("#shenhe").hide();
        }
    })
    $(document).on("click",".btn-blue",function(){
        sType=$(this).attr("id");
    })

    // 选择显示开始时间
    $('#ClubStoreCourse_dispay_star_time').on('click', function() {
        var end_input=$dp.$('ClubStoreCourse_dispay_end_time')
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'ClubStoreCourse_dispay_end_time\')}'});
    });
    // 选择显示截止时间
    $('#ClubStoreCourse_dispay_end_time').on('click', function() {
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'ClubStoreCourse_dispay_star_time\')}'});
    });

    // 选择销售开始时间
    $('#ClubStoreCourse_market_time').on('click', function() {
        var end_input=$dp.$('ClubStoreCourse_market_time_end')
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'ClubStoreCourse_market_time_end\')}'});
    });
    // 选择销售截止时间
    $('#ClubStoreCourse_market_time_end').on('click', function() {
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'ClubStoreCourse_market_time\')}'});
    });



    // 滚动图片处理
    var $course_big_pic=$('#ClubStoreCourse_course_big_pic');
    var $upload_pic_ClubStoreCourse_course_big_pic=$('#upload_pic_ClubStoreCourse_course_big_pic');
    var $upload_box_ClubStoreCourse_course_big_pic=$('#upload_box_ClubStoreCourse_course_big_pic');

    // 添加或删除时，更新图片
    var fnUpdatescrollPic=function(){
        var arr1=[];
        $upload_pic_ClubStoreCourse_course_big_pic.find('a').each(function(){
            arr1.push($(this).attr('data-savepath'));
        });
        $course_big_pic.val(we.implode(',',arr1));
        $upload_box_ClubStoreCourse_course_big_pic.show();
        if(arr1.length>=5) {
            $upload_box_ClubStoreCourse_course_big_pic.hide();
        }
    };
    // 上传完成时图片处理
    var fnscrollPic=function(savename,allpath){
        $upload_pic_ClubStoreCourse_course_big_pic.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
        fnUpdatescrollPic();
    };


    function add_tag(){
        var num=parseInt($(".course_data").last().attr('data_index'))+1;
        num=isNaN(num)?0:num;
        var html =
            '<tr class="course_data"  data_index="'+num+'">'+
                '<input name="add_tag['+num+'][data_id]" type="hidden" value="-1">'+
                '<td>'+(num+1)+'</td>'+
                '<td>'+
                    '<input id="add_tag_video_pic_'+num+'" class="video_pic" name="add_tag['+num+'][video_pic]" type="hidden">'+
                    '<div id="box_add_tag_video_pic_'+num+'" style="margin-left:0.5rem;">'+
                    '<script>we.uploadpic("add_tag_video_pic_'+num+'", "<?php echo $picprefix1;?>");<\/script></div>'+
                '</td>'+
                '<td>'+
                    '<input name="add_tag['+num+'][video_title]" class="input-text">'+
                '</td>'+
                '<td>'+
                    '<input id="video_duration_'+num+'" name="add_tag['+num+'][video_duration]" class="input-text" style="border: none;cursor: context-menu;" readonly>'+
                    '<video id="video_html_'+num+'" src="" style="display:none;" controls oncanplaythrough="myFunction(this)"></video>'+
                '</td>'+
                '<td>'+
                    '<input id="video_'+num+'" name="add_tag['+num+'][video_id]" type="hidden">'+
                    '<div class="c">'+
                        '<span id="video_box_'+num+'" class="fl"></span>'+
                        '<div class="upload fl" id="sc_'+num+'">';
                        html+='</div>'+
                    '</div>'+
                '</td>'+
                '<td>'+
                    '<a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a>'+
                '</td>'+
            '</tr>';
        $('#course_data').append(html);
        we.materialVideo2(
            function(data){
                $("#video_"+num+"").val(data.id).trigger("blur");
                $("#video_box_"+num+"").html("<span class='label-box'>"+data.name+"</span>");
                $("#video_html_"+num+"").after('<video id="video_html_'+num+'" src="'+data.allpath+'" style="display:none;" controls oncanplaythrough="myFunction(this)" ></video>').remove();
            },61,24,"上传",num
        );

    }



    var remove_arr=[];
    function delete_data(obj){
        var removeValue=$(obj).parent().prev().attr("value");
        if(removeValue>0){
            remove_arr.push(removeValue);
        }
        $("#ClubStoreCourse_remove_data_ids").val(remove_arr.join(','))
        $(obj).parents('.course_data').remove();
    }

    function isRealNum(obj){
        // isNaN()函数 把空串 空格 以及NUll 按照0来处理 所以先去除
        val=$(obj).val();
        if(val === "" || val ==null){
            return false;
        }
        if(isNaN(val)){
            $(obj).val('');
            $(obj).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
            we.msg('minus','只能输入数字');
        }else{
            $(obj).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
        }
    } 

    $(document).on('blur','.mony',function(){
        var c=$(this);
        var reg = /^[0-9]+([.]{1}[0-9]{1,2})?$/;
        if(!reg.test(c.val())){
            var temp_amount=c.val().replace(reg,'');
            we.msg('minus',"\u53ea\u80fd\u586b\u6570\u5b57\uff0c\u4e14\u6700\u591a\u4e24\u4f4d\u5c0f\u6570\u70b9");
            $(this).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
            $(this).val(temp_amount.replace(/[^\d\.]/g,''));
        }else{
            $(this).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
        }
    });

    var is_click=false;
    $("#genggai").on("click",function(){
        if(!is_click){
            var can1 = function(){
                is_click=true;
                $("#genggai").click();
            }
            $.fallr('show', {
                buttons: {
                    button1: {text: '确定', danger: true, onclick: can1},
                    button2: {text: '取消'}
                },
                content: '是否确定',
                // icon: 'trash',
                afterHide: function() {
                    we.loading('hide');
                }
            });
            return false;
        }
        is_click=false;
    })






// 视频素材上传
we.materialVideo2 = function(fnback, width, height, buttonText,index) {
    if(width==undefined){width=89;}
    if(height==undefined){height=29;}
    if(buttonText==undefined){buttonText='本地上传';}
    var op='up'+new Date().getTime()+parseInt(Math.random()*100000);
    var html='<input id="upload_'+op+'" type="file" name="uploadify">';
    // document.write(html);
    $("#sc_"+index+"").append(html);
    $('#upload_'+op).uploadifive({
        //'debug': true,
        'formData': {},
        'multi': true,
        'uploadLimit':0,
        'uploadScript': materialVideoUrl,
        'fileTypeExts': '*.mp4',
        'width': width,
        'height': height,
        'buttonText': buttonText,
        //'overrideEvents': ['onUploadError'],
        //'onUploadError': onUploadError,
        'onUploadComplete': function(file, data) {
            console.log(data);
            var data = $.parseJSON(data);
            if (data.status==1) {
                if(fnback==undefined || fnback==''){
                    $('#material-main').prepend('<li>'+
                        '<div class="pic"><a href="'+data.allpath+'"><img data-src="'+data.allpath+'" src="'+baseUrl+'/static/admin/img/i-video.png"></a></div>'+
                        '<div class="title">'+
                            '<input class="input-check check-item" type="checkbox" value="'+data.id+'">'+
                            '<input id="title-'+data.id+'" class="input-text" type="text" value="'+data.title+'" readonly>'+
                        '</div>'+
                        '<div class="info">'+
                            '<div class="duration">'+data.duration+'</div>'+
                            '<div class="date">'+data.date+'</div>'+
                        '</div>'+
                        '<div class="bar">'+
                            '<a class="fa fa-pencil" href="javascript:;" onclick="fnChangeTitle(\''+data.id+'\', this);"></a>'+
                            '<a class="fa fa-exchange" href="javascript:;" onclick="fnChangeGroupShow(\''+data.id+'\', this);"></a>'+
                            '<a class="fa fa-download" href="'+data.allpath+'" target="_blank"></a>'+
                            '<a class="fa fa-trash-o" href="javascript:;" onclick="we.dele(\''+data.id+'\', deleteUrl);"></a>'+
                        '</div>'+
                    '</li>');
                }else{
                    fnback.call(this,data);
                }
            } else {
                we.msg('error', data.msg);
            }
            //alert(typeof(datas));
        }
    });
};


// 文件上传
</script>