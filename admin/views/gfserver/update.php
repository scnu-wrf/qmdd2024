<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑服务器列表</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php
        //$form = $this->beginWidget('creactiveForm',  get_form_list());
            $form = $this->beginWidget('CActiveForm', array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    if(!hasError){
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
                }',
            ),
        ));
        ?>

          
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'server_code'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'server_code', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'server_code', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'server_adminid'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'server_adminid', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'server_adminid', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'server_type_name'); ?></td>
                <td>
                  <?php
                    echo $form->dropDownList($model, 'server_type', Chtml::listData(BaseCode::model()->getCode(685), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); 
                    echo $form->error($model, 'server_type_name', $htmlOptions = array()); ?>
                </td>
                
            </tr>
            
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'server_item_name'); ?></td>
                <td>
                <?php
                    echo $form->dropDownList($model, 'server_item', Chtml::listData(BaseCode::model()->getCode(802), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); 
                    echo $form->error($model, 'server_item_name', $htmlOptions = array()); ?>
                </td>
            </tr>
             <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'server_name'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'server_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'server_name', $htmlOptions = array()); ?>
                </td>
            </tr>
             <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'server_ip_address'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'server_ip_address', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'server_ip_address', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'server_area'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'server_area', array('class' => 'input-text')); ?>
                            <?php echo $form->hiddenField($model, 'longitude'); ?>
                            <?php echo $form->hiddenField($model, 'latitude'); ?>
                            <input id="server_area_btn" class="btn" type="button" value="地点">
                            <?php echo $form->error($model, 'server_area', $htmlOptions = array()); ?>
                        </td>
                       
                        

            </tr>
              <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'if_user'); ?></td>
                <td>
                    <?php echo $form->radioButtonList($model, 'if_user', array(649 => '在用', 648 => '下线'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    
                    <?php echo $form->error($model, 'if_user', $htmlOptions = array()); ?>
                </td>
            </tr>
             

             
             <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'add_time'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'add_time', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'add_time', $htmlOptions = array()); ?>
                </td>
            </tr>

        </table>

        
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');
$(function(){
    // 选择直播地址
    var $gfserver_server_area=$('#gfserver_server_area');
    var $gfserver_longitude=$('#gfserver_longitude');
    var $gfserver_latitude=$('#gfserver_latitude');
    $('#server_area_btn').on('click', function(){
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
                    $gfserver_server_area.val($.dialog.data('maparea_address'));
                    $gfserver_longitude.val($.dialog.data('maparea_lng'));
                    $gfserver_latitude.val($.dialog.data('maparea_lat'));
                }
            }
        });
    });
});

    // 选择直播地址
/*    var $VideoLive_live_address=$('#VideoLive_live_address');
    var $VideoLive_longitude=$('#VideoLive_longitude');
    var $VideoLive_latitude=$('#VideoLive_latitude');
    $VideoLive_live_address.on('click', function(){
        $.dialog.data('maparea_address', '');
        $.dialog.open('<?php //echo $this->createUrl("select/mapArea");?>',{
            id:'diqu',
            lock:true,
            opacity:0.3,
            title:'选择服务地区',
            width:'907px',
            height:'504px',
            close: function () {;
                if($.dialog.data('maparea_address')!=''){
                    $VideoLive_live_address.val($.dialog.data('maparea_address'));
                    $VideoLive_longitude.val($.dialog.data('maparea_lng'));
                    $VideoLive_latitude.val($.dialog.data('maparea_lat'));
                }
            }
        });
    });

/*$(function(){
    var $waterdemo_pic=$('#waterdemo_pic');
    var $GfWatermark_watermark_area=$('#GfWatermark_watermark_area');
    var $GfWatermark_watermark_area_item=$('#GfWatermark_watermark_area .input-check');
    var $GfWatermark_dispay_x_area=$('#GfWatermark_dispay_x_area');
    var $GfWatermark_dispay_y_area=$('#GfWatermark_dispay_y_area');
    var cssX='left',cssY='top';
    var fnUpdateWater=function(){
        var id=$GfWatermark_watermark_area.find('input:checked').val();
        if(id==699){
            cssX='left';
            cssY='top';
        }else if(id==700){
            cssX='right';
            cssY='top';
        }else if(id==701){
            cssX='left';
            cssY='bottom';
        }if(id==702){
            cssX='right';
            cssY='bottom';
        }
        $waterdemo_pic.attr('style', cssX+':'+$GfWatermark_dispay_x_area.val()+'%;'+cssY+':'+$GfWatermark_dispay_y_area.val()+'%;');
    };
    fnUpdateWater();
    $GfWatermark_watermark_area_item.on('click', function(){
        fnUpdateWater();
    });
    $GfWatermark_dispay_x_area.on('change', function(){
        $waterdemo_pic.attr('style', cssX+':'+$GfWatermark_dispay_x_area.val()+'%;'+cssY+':'+$GfWatermark_dispay_y_area.val()+'%;');
    });
    $GfWatermark_dispay_y_area.on('change', function(){
        $waterdemo_pic.attr('style', cssX+':'+$GfWatermark_dispay_x_area.val()+'%;'+cssY+':'+$GfWatermark_dispay_y_area.val()+'%;');
    });
    
    // 选择发布单位
    var $club_box=$('#club_box');
    var $GfWatermark_club_id=$('#GfWatermark_club_id');
    $('#club_select_btn').on('click', function(){
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php //echo $this->createUrl("select/club");?>',{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('club_id')>0){
                    club_id=$.dialog.data('club_id');
                    $GfWatermark_club_id.val($.dialog.data('club_id')).trigger('blur');
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });
});*/
</script>