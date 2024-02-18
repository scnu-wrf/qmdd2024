<style type="text/css">
    #introduct_temp_content {
        width: 85%;
        height: 20px;
        float: left;
        overflow-x: hidden;
        overflow-y: hidden;
    }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约 》资源登记 》服务者登记 》<?php echo (empty($model->id)) ? '添加' : '详情'; ?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15" style="table-layout:auto;">
                <?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text', 'value'=>empty($model->id) ? get_session('club_id') : $model->club_id)); ?>
                <?php echo $form->hiddenField($model, 'qualification_code_project'); ?>
                <?php echo $form->hiddenField($model, 'qualification_code_type'); ?>
                <?php echo $form->hiddenField($model, 'qualification_code_year'); ?>
                <?php echo $form->hiddenField($model, 'qualification_code_num'); ?>
                <?php echo $form->hiddenField($model, 'qualification_gfaccount'); ?>
                <?php echo $form->hiddenField($model, 'qualification_identity_num'); ?>
                <?php echo $form->hiddenField($model, 'qualification_gf_code'); ?>
                <?php // echo $form->hiddenField($model, 'qualification_title'); ?>
                <?php echo $form->hiddenField($model, 'achi_h_ratio'); ?>
                <?php echo $form->hiddenField($model, 'anchored_project_id'); ?>
                <?php // echo $form->hiddenField($model, 'anchored_project_name'); ?>
                <?php echo $form->hiddenField($model, 'qualification_score'); ?>
                <?php echo $form->hiddenField($model, 'gfid'); ?>
                <?php echo $form->hiddenField($model, 'email'); ?>
                <?php echo $form->hiddenField($model, 'start_date'); ?>
                <?php echo $form->hiddenField($model, 'end_date'); ?>
                <?php // echo $form->hiddenField($model, 'qcode'); ?>

                <?php echo $form->hiddenField($model, 'servic_site_id'); ?>
                <?php echo $form->hiddenField($model, 'area_address'); ?>
                <?php echo $form->hiddenField($model, 'area_country'); ?>
                <?php echo $form->hiddenField($model, 'area_province'); ?>
                <?php echo $form->hiddenField($model, 'area_city'); ?>
                <?php echo $form->hiddenField($model, 'area_district'); ?>
                <?php echo $form->hiddenField($model, 'area_township'); ?>
                <?php echo $form->hiddenField($model, 'area_street'); ?>
                <?php echo $form->hiddenField($model, 'Longitude'); ?>
                <?php echo $form->hiddenField($model, 'latitude'); ?>
                <?php // echo $form->hiddenField($model, 'servic_site_name'); ?>
                <?php echo $form->hiddenField($model, 'phone'); ?>
                <?php echo $form->hiddenField($model, 'navigatio_address'); ?>
                    <tr class="table-title">
                        <td colspan="4">登记服务者</td>
                    </tr>
                    <tr>
                    <td style="width: 15%;"><?php echo $form->labelEx($model,'qualification_type_id'); ?></td>
                        <td style="width: 35%;">
                            <select name="QmddServerPerson[qualification_type_id]" id="QmddServerPerson_qualification_type_id">
                                <option value="">请选择</option>
                                <?php
                                    // echo $form->dropDownList($model, 'qualification_type_id', CHtml::listData(QmddServerUsertype::model()->getType(2), 'id', 'f_uname'), array('prompt'=>'请选择'));
                                    // echo downList(QmddServerUsertype::model()->getType(2), 'id', 'f_uname','QmddServerPerson[qualification_type_id]');
                                    $list = QmddServerUsertype::model()->findAll('t_server_type_id=2');
                                    if(!empty($list))foreach($list as $ls){
                                        $se = ($ls->id==$model->qualification_type_id) ? 'selected' : '';
                                        echo '<option value="'.$ls->id.'" attrtype="'.$ls->service_type.'" '.$se.'>'.$ls->f_uname.'</option>';
                                    }
                                ?>
                            </select>
                        </td>
                        <td style="width:15%;"><?php echo $form->labelEx($model,'qcode'); ?></td>
                        <td style="width:35%;"><span id="qcode"><?php echo $model->qcode; ?></span></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'person_id'); ?></td>
                        <td>
                            <?php
                                echo $form->hiddenField($model, 'person_id');
                                echo $form->hiddenField($model, 'qualificate_id');
                                echo $form->hiddenField($model, 'qualification_name');
                            ?>
                            <span id="person_box">
                                <?php if(!empty($model->qualification_name)) { ?>
                                    <span class="label-box"><?php echo $model->qualification_name;?></span>
                                <?php } ?>
                            </span>
                            <input id="person_select_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'person_id', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model,'qualification_project_id'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model,'qualification_project_id'); ?>
                            <span id="qualification_project_name"><?php echo $model->qualification_project_name; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'qualification_title'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'qualification_title'); ?>
                            <span id="qualification_title"><?php echo $model->qualification_title;?></span>
                        </td>
                        <td><?php echo $form->labelEx($model, 'qualification_level'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model,'qualification_level'); ?>
                            <?php echo $form->hiddenField($model,'qualification_level_name'); ?>
                            <span id="qualification_level_name"><?php echo $model->qualification_level_name;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'servic_site_name'); ?></td>
                        <td colspan="3">
                            <input id="site_select_btn" class="btn" type="button" value="请选择" style="vertical-align: bottom;">
                            <?php echo $form->textField($model, 'servic_site_name', array('class' => 'input-text','style'=>'width:80%;')); ?>
                            <?php echo $form->error($model,'servic_site_name',$htmlOptions=array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'head_pic'); ?><br><span class="msg">1张<br>图片格式530*530<br>文件大小≤2M</span></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'head_pic', array('class' => 'input-text')); ?>
                            <?php $basepath=BasePath::model()->getPath(267);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <div id="img_box"><?php if($model->head_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_head_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->head_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->head_pic;?>" style="max-width:100px; max-height:100px;"></a></div><?php }?>
                            </div>
                            <script>we.uploadpic('<?php echo get_class($model);?>_head_pic', '<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'head_pic', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'qualification_image'); ?><br><span class="msg">5张<br>图片格式1080*1080<br>文件大小≤2M</span></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'qualification_image',array('class' => 'input-text')); ?>
                            <?php $basepath=BasePath::model()->getPath(268);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <div class="upload_img fl" id="upload_pic_qualification_image">
                                <?php foreach($qualification_image as $v) if($v) {?>
                                    <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;">
                                        <i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i>
                                    </a>
                                <?php }?>
                            </div>
                            <script>we.uploadpic('<?php echo get_class($model);?>_qualification_image','<?php echo $picprefix;?>','','',function(e1,e2){fnScrollpic(e1.savename,e1.allpath);},5);</script>
                            <?php echo $form->error($model, 'qualification_image', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr class="table-title">
                        <td colspan="4">
                           <span style="display: block; float: left; width: 95%;">服务者介绍</span>
                            <span><input class="btn" type="button" onclick="editIntroduct(<?php echo $model->id; ?>);" title="编辑" value="编辑"></span>
                        </td>
                    </tr>
                    <tr>
                        <?php echo $form->hiddenField($model, 'introduct_temp',array('class' => 'input-text')); if($model->introduct_temp != '') { ?>
                        <td colspan="4" id="introduct_temp_td">
                            <div id="introduct_temp_content"><?php echo $model->introduct_temp; ?></div><a type="btn" id="showIntroduct">...显示</a>
                        </td>
                        <td colspan="4" id="introduct_temp_td1" style="display: none;">
                            <div><?php echo $model->introduct_temp.'<a type="btn" id="hiddenIntroduct">收起</a>'; ?></div>
                        </td>
                        <?php }else { echo '<td colspan="4"></td>'; } ?>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <?php echo $form->hiddenField($model, 'introduct_temp', array('class' => 'input-text')); ?><p style="text-align: right;">临时使用，编辑页面完成时删除</p>
                            <script>
                                we.editor('<?php echo get_class($model);?>_introduct_temp', '<?php echo get_class($model);?>[introduct_temp]');
                                <?php if($model->check_state==372) echo 'var ue=UE.getEditor("editor_QmddServerPerson_introduct_temp");ue.ready(function() {ue.setDisabled();})'; ?>
                            </script>
                            <?php echo $form->error($model, 'introduct_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
        	</div><!--box-detail-tab-item end-->
            <div class="mt15">
                <table style="table-layout:auto;">
                    <tr>
                        <td><?php echo $form->labelEx($model,'check_state1'); ?></td>
                        <td><?php echo $model->check_state_name; ?></td>
                    </tr>
                    <?php if($model->check_state!=721 && $model->check_state!=371) {?>
                    <tr>
                        <td><?php echo $form->labelEx($model,'reasons_failure'); ?></td>
                        <td><?php echo $model->reasons_failure; ?></td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td style="width:15%;">操作</td>
                        <td style="width:85%;">
                            <?php
                                $btn_txt = ($model->check_state==721 || $model->check_state==373 || $model->check_state==1538) ? '保存' : '撤销申请';
                                echo show_shenhe_box(array('baocun'=>$btn_txt));
                                if($model->check_state==721 || $model->check_state==373 || $model->check_state==1538){
                                    echo show_shenhe_box(array('shenhe'=>'提交审核'));
                                }//$model->check_state==371 ||
                            ?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    ///模拟界面切换
    // we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
    //     if(index==3){}
    //     return true;
    // });

    // $(function (){
    //     typeOnchang();
    // });

    // function typeOnchang(){
    //     var type=$('#QmddServerPerson_qualification_type_id').val();
    //     if(type!=1){
    //         $('#site_detail').show();
    //     } else {
    //         $('#site_detail').hide();
    //     }
    // }

    // 文字折叠效果
    $("#showIntroduct").on('click', function(){
        $("#introduct_temp_td").hide();
        $("#introduct_temp_td1").show();
    });
    $("#hiddenIntroduct").on('click', function(){
        $("#introduct_temp_td").show();
        $("#introduct_temp_td1").hide();
    });

    // 滚动图片处理
    var $qualification_image=$('#QmddServerPerson_qualification_image');
    var $upload_pic_qualification_image=$('#upload_pic_qualification_image');
    var $upload_box_qualification_image=$('#upload_box_qualification_image');
    // 添加或删除时，更新图片
    var fnUpdateScrollpic=function(){
        var arr=[];
        $upload_pic_qualification_image.find('a').each(function(){
            arr.push($(this).attr('data-savepath'));
        });
        $qualification_image.val(we.implode(',',arr));
        $upload_box_qualification_image.show();
        if(arr.length>=5) {
            $upload_box_qualification_image.hide();
        }
    };

    // 上传完成时图片处理
    var fnScrollpic=function(savename,allpath){
        $upload_pic_qualification_image.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>');
        fnUpdateScrollpic();
    };

    // 编辑服务者介绍
    function editIntroduct(id) {
        // alert(id);
        var url = '<?php echo $this->createurl('update_introduct'); ?>&id='+id;
        var title = '详情介绍';
        $.dialog.data('id', 0);
        $.dialog.open(url, {
            id:'introduct',
            lock:true,
            opacity:0.3,
            title:title,
            width:'70%',
            height:'70%',
            close: function() {
                if($.dialog.data("id") > 0) {
                    $('#QmddServerPerson_introduct_temp').val($.dialog.data('introduct_temp'));
                }
            }
        });
    }

    // 选择场地
    $('#site_select_btn').on('click', function(){
        var club_id = $('#QmddServerPerson_club_id').val();
        var person_id = $('#QmddServerPerson_person_id').val();
        var project_id = $('#QmddServerPerson_qualification_project_id').val();
        if(club_id==''){
            we.msg('minus', '抱歉，系统没有获取到发布单位');
            return false;
        }
        if(person_id==''){
            we.msg('minus', '请先选择<span class="red">服务者</span>');
            return false;
        }
        $.dialog.data('site_id', 0);
        // $.dialog.open('<?php //echo $this->createUrl("select/qmddgfSite");?>&club_id='+club_id+'&project_id='+project_id,{
        $.dialog.open('<?php echo $this->createUrl("select/gfSite");?>&club_id='+club_id+'&project_id='+project_id,{
            id:'changdi',
            lock:true,
            opacity:0.3,
            title:'场地选择',
            width:'60%',
            height:'60%',
            close: function () {
                if($.dialog.data("site_id")>0){
                    // qmddgfSite字段  旧
                    // $('#QmddServerPerson_servic_site_id').val($.dialog.data('site_id'));
                    // $('#QmddServerPerson_area_address').val($.dialog.data('address'));
                    // //$('#QmddServerPerson_area_country').val($.dialog.data('country'));
                    // $('#QmddServerPerson_area_province').val($.dialog.data('province'));
                    // $('#QmddServerPerson_area_city').val($.dialog.data('city'));
                    // $('#QmddServerPerson_area_district').val($.dialog.data('district'));
                    // $('#QmddServerPerson_area_township').val($.dialog.data('township'));
                    // $('#QmddServerPerson_area_street').val($.dialog.data('street'));
                    // $('#QmddServerPerson_Longitude').val($.dialog.data('longitude'));
                    // $('#QmddServerPerson_latitude').val($.dialog.data('latitude'));
                    // $('#QmddServerPerson_servic_site_name').val($.dialog.data('site_name'));
                    // $('#QmddServerPerson_phone').val($.dialog.data('contact_phone'));
                    // $('#QmddServerPerson_navigatio_address').val($.dialog.data('site_location'));

                    // gfSite字段  新
                    $('#QmddServerPerson_servic_site_id').val($.dialog.data('site_id'));
                    $('#QmddServerPerson_area_address').val($.dialog.data('site_address'));
                    $('#QmddServerPerson_area_country').val($.dialog.data('country'));
                    $('#QmddServerPerson_area_province').val($.dialog.data('site_province'));
                    $('#QmddServerPerson_area_city').val($.dialog.data('site_city'));
                    $('#QmddServerPerson_area_district').val($.dialog.data('site_district'));
                    $('#QmddServerPerson_area_township').val($.dialog.data('site_township'));
                    $('#QmddServerPerson_area_street').val($.dialog.data('site_street'));
                    $('#QmddServerPerson_Longitude').val($.dialog.data('site_longitude'));
                    $('#QmddServerPerson_latitude').val($.dialog.data('site_latitude'));
                    $('#QmddServerPerson_servic_site_name').val($.dialog.data('site_name'));
                    $('#QmddServerPerson_phone').val($.dialog.data('site_phone'));
                    $('#QmddServerPerson_navigatio_address').val($.dialog.data('site_location'));
                }
            }
        });
    });

    // function personOnchang(){
    //     var person_id=$('#QmddServerPerson_qualificate_id').val();
    //     var project_id=$('#QmddServerPerson_qualification_project_id').val();
    //     html_img='';
    //     if (person_id>0) {
    //         $.ajax({
    //             type: 'post',
    //             url: '<?php //echo $this->createUrl('select_person');?>&person_id='+person_id,
    //             data: {person_id:person_id},
    //             dataType: 'json',
    //             success: function(data) {
    //                 if(data!=''){
    //                     $('#QmddServerPerson_gfid').val(data.gfid);
    //                     $('#QmddServerPerson_phone').val(data.phone);
    //                     //$('#QmddServerPerson_qcode').val(data.qcode);
    //                     $('#QmddServerPerson_email').val(data.email);
    //                     $('#QmddServerPerson_qualification_name').val(data.qualification_name);
    //                     $('#QmddServerPerson_qualification_gfaccount').val(data.qualification_gfaccount);
    //                     $('#QmddServerPerson_qualification_code_project').val(data.qualification_code_project);
    //                     $('#QmddServerPerson_qualification_code_type').val(data.qualification_code_type);
    //                     $('#QmddServerPerson_qualification_code_year').val(data.qualification_code_year);
    //                     $('#QmddServerPerson_qualification_code_num').val(data.qualification_code_num);
    //                     $('#QmddServerPerson_qualification_gf_code').val(data.qualification_gf_code);
    //                     $('#QmddServerPerson_qualification_identity_num').val(data.qualification_identity_num);
    //                     $('#QmddServerPerson_qualification_title').val(data.qualification_title);
    //                     $('#QmddServerPerson_qualification_code').val(data.qualification_code);

    //                     $('#QmddServerPerson_qualification_time').val(data.qualification_time);
    //                     $('#QmddServerPerson_synopsis').val(data.synopsis);
    //                     $('#QmddServerPerson_qualification_level').val(data.qualification_level);
    //                     $('#QmddServerPerson_qualification_level_name').val(data.qualification_level_name);
    //                     $('#QmddServerPerson_qualification_score').val(data.qualification_score);
    //                     $('#QmddServerPerson_start_date').val(data.start_date);
    //                     $('#QmddServerPerson_end_date').val(data.end_date);

    //                     $('#level_box').text(data.qualification_level_name);
    //                     //$('#qcode').text(data.qcode);
    //                     //编辑器赋值
    //                     $('#QmddServerPerson_introduct_temp').val(data.introduct);
    //                     var editor = UE.getEditor('editor_QmddServerPerson_introduct_temp');
    //                     editor.setContent(data.introduct);
    //                 }else{
    //                     $('#QmddServerPerson_person_id').val('');
    //                     we.msg('minus', '抱歉，没有获取到该服务者的信息');
    //                 }
    //             }
    //         });
    //     }
    // }

    // 选择服务者
    // qualification_level
    // qualification_identity_num
    // qualification_title
    $('#person_select_btn').on('click', function(){
        var club_id = $('#QmddServerPerson_club_id').val();
        var type_id = $('#QmddServerPerson_qualification_type_id').val();
        var type_id2 = $('#QmddServerPerson_qualification_type_id').find("option:selected").attr("attrtype");
        // var type=$('#QmddServerPerson_qualification_type_id').val();
        if(club_id==''){
            we.msg('minus', '抱歉，系统没有获取到发布单位');
            return false;
        }
        if(type_id==''){
            we.msg('minus', '请先选择<span class="red">服务类别</span>');
            return false;
        }
        // console.log(type_id,type_id2);
        // if(type==''){
        //     we.msg('minus', '请先选择服务类型');
        //     return false;
        // }
        $.dialog.data('person_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/serverPerson");?>&club_id='+club_id+'&service_type='+type_id2,{
            id:'fuwuzhe',
            lock:true,
            opacity:0.3,
            width:'80%',
            height:'80%',
            title:'服务者选择',
            close: function () {
                // console.log($.dialog.data('anchored_project_id'),$.dialog.data('anchored_project_name'));
                if($.dialog.data('club_person_id')>0 && $.dialog.data('person_id')>0){
                    $('#person_box').html('<span class="label-box">'+$.dialog.data('person_name')+'</span>');
                    $('#QmddServerPerson_person_id').val($.dialog.data('club_person_id'));
                    $('#QmddServerPerson_qualificate_id').val($.dialog.data('person_id'));
                    $('#QmddServerPerson_gfid').val($.dialog.data('gfid'));
                    $('#QmddServerPerson_email').val($.dialog.data('email'));
                    // $('#qualification_type').html('<span class="label-box">'+$.dialog.data('service_type_name')+'</span>');
                    $('#QmddServerPerson_qualification_gfaccount').val($.dialog.data('account'));
                    $('#qualification_gfaccount').html('<span class="label-box">'+$.dialog.data('account')+'</span>');
                    // $('#QmddServerPerson_qcode').val($.dialog.data('type_code'));
                    // $('#qcode').html('<span class="label-box">'+$.dialog.data('type_code')+'</span>');
                    $('#QmddServerPerson_qualification_project_id').val($.dialog.data('project_id'));
                    $('#qualification_project_name').html('<span class="label-box">'+$.dialog.data('project_name')+'</span>');
                    $('#QmddServerPerson_qualification_level').val($.dialog.data('qualification_level'));
                    $('#QmddServerPerson_qualification_level_name').val($.dialog.data('qualification_level_name'));
                    $('#qualification_level_name').html('<span class="label-box">'+$.dialog.data('qualification_level_name')+'</span>');
                    $('#QmddServerPerson_qualification_title').val($.dialog.data('qualification_title'));
                    $('#qualification_title').html('<span class="label-box">'+$.dialog.data('qualification_title')+'</span>');
                    $('#QmddServerPerson_qualification_gf_code').val($.dialog.data('qualification_gf_code'));
                    $('#qualification_gf_code').html($.dialog.data('qualification_gf_code'));
                    $('#QmddServerPerson_anchored_project_id').val($.dialog.data('anchored_project_id'));
                    // $('#anchored_project_name').html($.dialog.data('anchored_project_name'));
                    $('#QmddServerPerson_start_date').val($.dialog.data('start_date'));
                    $('#QmddServerPerson_end_date').val($.dialog.data('end_date'));
                    // $('#QmddServerPerson_qualification_identity_num').val($.dialog.data('qualification_identity_type'));
                    // $('#QmddServerPerson_qualification_title').val($.dialog.data('qualification_identity_type_name'));
                }
            }
        });
    });

    // // 添加视频
    // var $QmddServerPerson_video_list = $('#QmddServerPerson_video_list');
    // var $product_list=$('#product_list');
    // $('#product_add_btn').on('click', function(){
    //     $.dialog.data('material_id', 0);
    //     $.dialog.open('<?php //echo $this->createUrl("select/material", array('type'=>253));?>',{
    //         id:'shangpin',
    //         lock:true,
    //         opacity:0.3,
    //         title:'选择具体内容',
    //         width:'500px',
    //         height:'60%',
    //         close: function () {
    //             //console.log($.dialog.data('product_id'));
    //             if($.dialog.data('material_id')>0){
    //                 if($('#product_item_'+$.dialog.data('material_id')).length==0){
    //                     $QmddServerPerson_video_list.val($.dialog.data('material_id')).trigger('blur');;
    //                     $product_list.append('<tr id="product_item_'+$.dialog.data('material_id')+'">'+
    //                         '<td>'+$.dialog.data('material_title')+'</td>'+
    //                         '<td>'+'<div class="video_list" data-id="'+$.dialog.data('material_id')+'" id="upload_pic_sub_product_list_'+$.dialog.data('material_id')+'">'+
    //                         'http://tv.gf41.net/video_file/'+$.dialog.data('material_code')+'</div>'+
    //                         '<td style="display:none;" id="box_sub_product_list_'+$.dialog.data('material_id')+'"></td>'+
    //                         '<td><a onclick="fnDeleteProduct(this);" href="javascript:;">删除</a></td>'+
    //                     '</tr>');
    //                     we.uploadpic('sub_product_list_'+$.dialog.data('material_id'), '<?php //echo $picprefix;?>');
    //                     fnUpdateProduct();
    //                 }
    //             }
    //         }
    //     });
    //     //$product_list.append('');
    // });

    fnUpdateProduct();
    var fnUpdateProduct=function(){
        var arr=[];
        var id;
        $product_list.find('div.video_list').each(function(){
            id=$(this).attr('data-id');
            arr.push(id);
        });
        $QmddServerPerson_video_list.val(we.implode(',', arr)).trigger('blur');
    };

    var fnDeleteProduct=function(op){
        $(op).parent().parent().remove();
        fnUpdateProduct();
    };

    // 初始的$('#QmddServerPerson_navigatio_address')失效的替代
    function clickArea(){
        $.dialog.data('maparea_address', '');
        $.dialog.open('<?php echo $this->createUrl("select/mapArea");?>',{
            id:'diqu',
            lock:true,
            opacity:0.3,
            title:'选择服务地区',
            width:'907px',
            height:'504px',
            close: function () {;
                if($.dialog.data('maparea_address')!=''){
                    $('#QmddServerPerson_navigatio_address').val($.dialog.data('maparea_address'));
                    $('#QmddServerPerson_area_country').val($.dialog.data('country'));
                    $('#QmddServerPerson_area_province').val($.dialog.data('province'));
                    $('#QmddServerPerson_area_city').val($.dialog.data('city'));
                    $('#QmddServerPerson_area_district').val($.dialog.data('district'));
                    $('#QmddServerPerson_area_street').val($.dialog.data('street'));
                    $('#QmddServerPerson_Longitude').val($.dialog.data('maparea_lng'));
                    $('#QmddServerPerson_latitude').val($.dialog.data('maparea_lat'));
                }
            }
        });
    }

    $(function(){
        // 选择服务地区
        $('#QmddServerPerson_navigatio_address').on('click', function(){
            $.dialog.data('maparea_address', '');
            $.dialog.open('<?php echo $this->createUrl("select/mapArea");?>',{
                id:'diqu',
                lock:true,
                opacity:0.3,
                title:'选择服务地区',
                width:'907px',
                height:'504px',
                close: function () {;
                    if($.dialog.data('maparea_address')!=''){
                        $('#QmddServerPerson_navigatio_address').val($.dialog.data('maparea_address'));
                        $('#QmddServerPerson_area_country').val($.dialog.data('country'));
                        $('#QmddServerPerson_area_province').val($.dialog.data('province'));
                        $('#QmddServerPerson_area_city').val($.dialog.data('city'));
                        $('#QmddServerPerson_area_district').val($.dialog.data('district'));
                        $('#QmddServerPerson_area_street').val($.dialog.data('street'));
                        $('#QmddServerPerson_Longitude').val($.dialog.data('maparea_lng'));
                        $('#QmddServerPerson_latitude').val($.dialog.data('maparea_lat'));
                    }
                }
            });
        });
    });
</script>

