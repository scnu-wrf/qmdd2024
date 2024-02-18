<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑服务器位置</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
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
                <td width="15%"><?php echo $form->labelEx($model, 'server_id'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'server_id', array('class' => '')); ?>
                    <?php echo $form->error($model, 'server_id', $htmlOptions = array()); ?>
                </td>
            </tr>
            
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'server_country_name'); ?></td>
                <td>

                    <?php echo $form->dropDownList($model, 'server_country_name', Chtml::listData(tcountry::model()->findAll(), 'chinese_name', 'chinese_name'), array('prompt'=>'请选择')); ?>


                    <?php //array('select'=>'chinese_NAME')
                    //echo $form->dropDownList($model, 'server_country_code', Chtml::listData(tcountry::model()->getCode(8), 'id', 'chinese_NAME'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'server_country_name', $htmlOptions = array()); ?>
                </td>
            </tr>
            
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'server_region_name'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'server_region_name', Chtml::listData(tregion::model()->findAll('level=1'), 'region_name_c', 'region_name_c'), array('prompt'=>'请选择')); ?> 

                    <?php echo $form->error($model, 'server_region_name', $htmlOptions = array()); ?>
                </td>
            </tr>


        </table>
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>

// $('#gfserverarea_server_country_code').on('change', function(){
//        server_country_code=$(this).val();
//        fnAdverUrlIdChange(server_country_code);
//    });
//    fnAdverUrlIdChange(<?php //echo $model->server_country_code;?>, false);
//    
//    
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