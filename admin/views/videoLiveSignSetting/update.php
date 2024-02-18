<?php
    $basepath=BasePath::model()->getPath(276);$picprefix='';
    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
?>
<div class="box">
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <?php if(empty($model->id)) {?>
                <table style="table-layout:auto;">
                    <tr>
                        <td style="width:12%;">选择直播：</td>
                        <td colspan="3">
                            <?php //echo downList($video_live,'id','title','VideoLiveSignSetting[video_live_id]','id="VideoLiveSignSetting_video_live_id" onchange="changeVideoid(this);"',$model->video_live_id); ?>
                            <select name="VideoLiveSignSetting[video_live_id]" id="VideoLiveSignSetting_video_live_id" style="margin-top:2px;">
                                <option value="<?php echo $video_live->id; ?>"><?php echo $video_live->title; ?></option>
                            </select>
                            <select name="VideoLiveSignSetting[video_live_programs_id]" id="VideoLiveSignSetting_video_live_programs_id" style="margin-top:2px;">
                                <option value="">请选择</option>
                            </select>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td style="width:12%;">增加对象：</td>
                        <td colspan="3">
                            <span><a href="javascript:;" class="btn" onclick="clickAccount();">选择</a></span>
                        </td>
                    </!-->
                </table>
                <?php }else{
                    echo '<input type="hidden" id="video_live_id" name="VideoLiveSignSetting[video_live_id]" value="'.$model->video_live_id.'">';
                    echo '<input type="hidden" id="video_live_programs_id" name="VideoLiveSignSetting[video_live_programs_id]" value="'.$model->video_live_programs_id.'">';
                }?>
                <?php echo $form->error($model, 'video_live_id', $htmlOptions = array()); ?>
                <table id="account_list" class="mt15">
                    <tr class="table-title" style="text-align: center;">
                        <td style="padding:5px;">打赏对象账号</td>
                        <td style="padding:5px;">名称/姓名</td>
                        <td style="padding:5px;">用户角色</td>
                        <td style="padding:5px;">自定义名称</td>
                        <td style="padding:5px;">自定义头像</td>
                        <td style="padding:5px;">
                            <span>排序</span>&nbsp;&nbsp;
                            <span class="span_tip">
                                <a href="javascript:;" class="dis_rounds"><i class="fa fa-question"></i></a>
                                <div class="tip" style="width:100px;">
                                    <p>值越大排在越前</p>
                                    <i class="t"></i>
                                </div>
                            </span>
                        </td>
                        <td style="padding:5px;">操作</td>
                    </tr>
                    <?php
                        $num = 1;
                        $model->id = empty($model->id) ? 0 : $model->id;
                        $model->video_live_programs_id = empty($model->video_live_programs_id) ? 0 : $model->video_live_programs_id;
                        $video_sign = VideoLiveSign::model()->findAll('video_live_sign_setting_id='.$model->id);
                        if(!empty($video_sign))foreach($video_sign as $vs){
                    ?>
                        <tr class="acc_len" style="text-align:center;">
                            <input type="hidden" name="account_list[<?php echo $num; ?>][gf_account]" value="<?php echo $vs->gf_account; ?>">
                            <input type="hidden" name="account_list[<?php echo $num; ?>][gf_name]" value="<?php echo $vs->gf_name; ?>">
                            <input type="hidden" name="account_list[<?php echo $num; ?>][gf_zsxm]" value="<?php echo $vs->gf_zsxm; ?>">
                            <input type="hidden" name="account_list[<?php echo $num; ?>][id]" value="<?php echo $vs->id; ?>">
                            <td><?php echo $vs->gf_account; ?></td>
                            <td><?php echo $vs->gf_name; ?></td>
                            <td><?php echo (strlen($vs->gf_account)>6) ? '直播发布者' : '嘉宾'; ?></td>
                            <td><input type="text" class="input-text" name="account_list[<?php echo $num; ?>][show_name]" maxlength="5" placeholder="5个字符以内" value="<?php echo $vs->show_name; ?>"></td>
                            <td>
                                <input id="VideoLiveSign_show_icon_<?php echo $num; ?>" class="input-text fl" type="hidden" name="account_list[<?php echo $num; ?>][show_icon]" value="<?php echo $vs->show_icon;?>">
                                    <div class="upload_img fl" id="upload_pic_VideoLiveSign_show_icon_<?php echo $num; ?>">
                                        <?php if(!empty($vs->show_icon)){?>
                                            <a href="<?php echo $basepath->F_WWWPATH.$vs->show_icon;?>" target="_blank">
                                                <img src="<?php echo $basepath->F_WWWPATH.$vs->show_icon;?>" width="100">
                                            </a>
                                        <?php }?>
                                    </div>
                                <script>we.uploadpic('VideoLiveSign_show_icon_<?php echo $num; ?>','<?php echo $picprefix; ?>');</script>
                            </td>
                            <td><input type="text" class="input-text" name="account_list[<?php echo $num; ?>][sort_num]" value="<?php echo $vs->sort_num; ?>"></td>
                            <td>
                                <a href="javascript:;" class="btn" onclick="clickAccount();">添加</a>
                                <a href="javascript:;" class="btn" onclick="onDelete(this);">删除</a>
                            </td>
                        </tr>
                    <?php $num++; }?>
                </table>
                <table class="mt15">
                    <tr>
                        <td style="text-align: center;"><?php echo show_shenhe_box(array('baocun'=>'保存')); ?></td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    var video_live_id = $('#VideoLiveSignSetting_video_live_id');
    var programs_id = $('#VideoLiveSignSetting_video_live_programs_id');
    changeVideoid(video_live_id);
    function changeVideoid(obj){
        var obj = $(obj).val();
        if(obj>0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('returnPrograms'); ?>&id='+obj,
                dataType: 'json',
                success: function(data){
                    // console.log(data);
                    var s_html = '<option value>请选择</option>';
                    var k_html = '';
                    if(data[0]!=''){
                        for(var i=0;i<data[0].length;i++){
                            s_html += '<option value="'+data[0][i]['id']+'"';
                            if(data[0][i]['id']==<?php echo $model->video_live_programs_id; ?>){
                                s_html += 'selected';
                            }
                            s_html += '>'+data[0][i]['title']+'</option>';
                        }

                        $('#type_502').remove();
                        var num = $('.acc_len').length;
                        k_html = 
                            '<tr id="type_502" class="acc_len" style="text-align:center;">'+
                                '<input type="hidden" name="account_list['+num+'][gf_account]" value="'+data[1].code+'">'+
                                '<input type="hidden" name="account_list['+num+'][gf_name]" value="'+data[1].name+'">'+
                                '<input type="hidden" name="account_list['+num+'][gf_zsxm]" value="">'+
                                '<input type="hidden" name="account_list['+num+'][id]" value="null">'+
                                '<td>'+data[1].code+'</td>'+
                                '<td>'+data[1].name+'</td>'+
                                '<td>直播发布者</td>'+
                                '<td><input type="text" class="input-text" name="account_list['+num+'][show_name]" maxlength="5" placeholder="5个字符以内"></td>'+
                                '<td>'+
                                    '<input id="<?php echo get_class($model);?>_show_icon_'+num+'" class="input-text fl" type="hidden" name="account_list['+num+'][show_icon]" value="'+data[1].logo+'">'+
                                    '<div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_show_icon_'+num+'"></div>'+
                                    '<span id="box_<?php echo get_class($model);?>_show_icon_'+num+'"></span>'+
                                '</td>'+
                                '<td><input type="text" class="input-text" name="account_list['+num+'][sort_num]" value=""></td>'+
                                '<td><a href="javascript:;" class="btn" onclick="clickAccount();">添加</a></td>'+
                            '</tr>';
                        if($('#type_502').length==0){
                            $('#account_list').append(k_html);
                        }
                        we.uploadpic('<?php echo get_class($model);?>_show_icon_'+num,'<?php echo $picprefix; ?>');
                    }
                    else{
                        $('#type_502').remove();
                    }
                    programs_id.html(s_html);
                },
                error: function(request){
                    console.log('错误');
                }
            });
        }
    }

    function clickAccount(){
        var num = $('.acc_len').length;
        $.dialog.data('GF_ID', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>',{
            id:'huiyuan',
            lock:true,
            opacity:0.3,
            title:'选择会员',
            width:'500px',
            height:'60%',
            close: function () {
                var g_html = '';
                if($.dialog.data('GF_ID')>0){
                    g_html += 
                        '<tr class="acc_len" style="text-align:center;">'+
                            '<input type="hidden" name="account_list['+num+'][gf_account]" value="'+$.dialog.data('GF_ACCOUNT')+'">'+
                            '<input type="hidden" name="account_list['+num+'][gf_name]" value="'+$.dialog.data('GF_NAME')+'">'+
                            '<input type="hidden" name="account_list['+num+'][gf_zsxm]" value="'+$.dialog.data('zsxm')+'">'+
                            '<input type="hidden" name="account_list['+num+'][id]" value="null">'+
                            '<td>'+$.dialog.data('GF_ACCOUNT')+'</td>'+
                            '<td>'+$.dialog.data('GF_NAME')+'</td>'+
                            '<td>嘉宾</td>'+
                            '<td><input type="text" class="input-text" name="account_list['+num+'][show_name]" maxlength="5" placeholder="5个字符以内"></td>'+
                            '<td>'+
                                '<input id="<?php echo get_class($model);?>_show_icon_'+num+'" class="input-text fl" type="hidden" name="account_list['+num+'][show_icon]">'+
                                '<div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_show_icon_'+num+'"></div>'+
                                '<span id="box_<?php echo get_class($model);?>_show_icon_'+num+'"></span>'+
                            '</td>'+
                            '<td><input type="text" class="input-text" name="account_list['+num+'][sort_num]" value=""></td>'+
                            '<td><a href="javascript:;" class="btn" onclick="clickAccount();">添加</a> <a href="javascript:;" class="btn" onclick="onDelete(this);">删除</a></td>'+
                        '</tr>';
                    $('#account_list').append(g_html);
                    we.uploadpic('<?php echo get_class($model);?>_show_icon_'+num,'<?php echo $picprefix; ?>');
                }
            }
        });
    }

    function onDelete(op){
        var a = confirm('是否删除?');
        if(a==true){
            $(op).parent().parent().remove();
        }
    }

    $('.btn-blue').on('click',function(){
        if($('#video_live_id').val()=='' || video_live_id.val()==''){
            we.msg('minus','请选择直播');
            return false;
        }
        if($('#video_live_programs_id').val()=='' || programs_id.val()==''){
            we.msg('minus','请选择直播节目');
            return false;
        }
        if($('.acc_len').length==0){
            we.msg('minus','请选择打赏对象');
            return false;
        }
        else{
            setTimeout(function() {
                parent.location.reload();
            }, 1500);
        }
    });

    function clickBox(obj){
        var val = $(obj).val();
        var col = document.getElementsByClassName('dis_colnum')[0];
        var vid = $('#VideoLiveSignSetting_video_live_id').val();
        if($("input[type='checkbox']").is(':checked')==true && val==210){
            $('.dis_account').show();
            col.style.width = '38%';
        }
        else{
            $('.dis_account').hide();
            col.style.width = '88%';
        }
        if($("input[type='checkbox']").is(':checked')==true && val==502 && $('#type_502').length==0){
            if(vid==''){
                we.msg('minus','请选择直播');
                $("input[type='checkbox']").attr('checked',false);
                return false;
            }
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('get_club'); ?>&id='+vid,
                dataType: 'json',
                success: function(data){
                    // console.log(data);
                    var num = $('.acc_len').length;
                    var s_html = 
                        '<tr id="type_502" class="acc_len" style="text-align:center;">'+
                            '<input type="hidden" name="account_list['+num+'][gf_account]" value="'+data.code+'">'+
                            '<input type="hidden" name="account_list['+num+'][gf_name]" value="'+data.title+'">'+
                            '<input type="hidden" name="account_list['+num+'][gf_zsxm]" value="">'+
                            '<input type="hidden" name="account_list['+num+'][id]" value="null">'+
                            '<td>'+data.code+'</td>'+
                            '<td>'+data.title+'</td>'+
                            '<td>直播发布者</td>'+
                            '<td><input type="text" class="input-text" name="account_list['+num+'][show_name]"></td>'+
                            '<td>'+
                                '<input id="<?php echo get_class($model);?>_show_icon_'+num+'" class="input-text fl" type="hidden" name="account_list['+num+'][show_icon]" value="'+data.logo+'">'+
                                '<div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_show_icon_'+num+'"></div>'+
                                '<span id="box_<?php echo get_class($model);?>_show_icon_'+num+'"></span>'+
                            '</td>'+
                            '<td><a href="javascript:;" class="btn" onclick="onDelete(this);">删除</a></td>'+
                        '</tr>';
                    $('#account_list').append(s_html);
                    we.uploadpic('<?php echo get_class($model);?>_show_icon_'+num,'<?php echo $picprefix; ?>');
                },
                error: function(request){
                    console.log('获取错误');
                }
            });
        }
        else if($("input[type='checkbox']").is(':checked')==false && val==502){
            $('#type_502').remove();
        }
    }
</script>