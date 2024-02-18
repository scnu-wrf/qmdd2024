<?php 
    $f_types=BaseCode::model()->getCode(832);
    $f_items=BaseCode::model()->getCode(835);
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑应用</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
       <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table style="table-layout:auto;">
            <tr class="table-title">
                <td colspan="2">应用信息</td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'app_name'); ?></td>
                <td width="85%">
                    <?php echo $form->textField($model, 'app_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'app_name', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'app_type'); ?></td>
                <td>
                    <?php
                        echo $form->dropDownList($model, 'app_type', Chtml::listData(BaseCode::model()->getCode(832), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); 
                        echo $form->error($model, 'app_type', $htmlOptions = array());
                    ?>
                </td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'app_item'); ?></td>
                <td width="85%">
                    <?php echo $form->dropDownList($model, 'app_item', Chtml::listData(BaseCode::model()->getCode(835), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?> 
                    <?php echo $form->error($model, 'app_item', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'app_icon'); ?></td>
                <td>
                    <?php echo $form->hiddenField($model, 'app_icon', array('class' => 'input-text fl')); ?>
                    <span id="picture_box" class="fl">
                        <?php $basepath=BasePath::model()->getPath(185);$picprefix='';?>
                        <canvas id="myCanvas" style="border:1px solid #d3d3d3;width:100px;height:100px;">
                        Your browser does not support the HTML5 canvas tag.
                        </canvas> 
                    </span>
                    <div class="upload fl">
                        <input style="margin-left:5px;" id="picture_select_btn" class="btn" type="button" value="选择图片" >
                    </div>
                    <?php echo $form->error($model, 'app_icon', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td>坐标</td>
                <td>
                    <div style="display:inline;">
                        <?php
                           echo 'X: '.$form->textField($model, 'app_icon_x', array('class' => 'input-text','style'=>'display:inline-block;width:20px;','readonly'=>'true')); 
                           echo 'Y: '.$form->textField($model, 'app_icon_y', array('class' => 'input-text','style'=>'display:inline-block;width:20px;','readonly'=>'true')); 
                           echo 'Width: '.$form->textField($model, 'app_icon_w', array('class' => 'input-text','style'=>'display:inline-block;width:20px;','readonly'=>'true')); 
                           echo 'Height: '.$form->textField($model, 'app_icon_h', array('class' => 'input-text','style'=>'display:inline-block;width:20px;','readonly'=>'true')); 
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'app_introduce'); ?></td>
                <td>
                    <?php echo $form->textArea($model, 'app_introduce', array('class' => 'input-text' ,'value'=>$model->app_introduce)); ?>
                    <?php echo $form->error($model, 'app_introduce', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    we.tab('.box-detail-tab li');
    window.onload = function (){
        draw('<?php echo $basepath->F_WWWPATH.$model->app_icon;?>');
    }
    // 选择图片
    var $picture_box=$('#picture_box');
    var $GfApp_app_icon=$('#GfApp_app_icon');
    $('#picture_select_btn').on('click', function(){
        $.dialog.data('app_icon', 0);
        $.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type'=>252,'fd'=>185));?>',{
            id:'picture',
            lock:true,
            opacity:0.3,
            title:'请选择素材',
            width:'100%',
            height:'90%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $('#GfApp_app_icon').val($.dialog.data('app_icon')).trigger('blur');
                    $('#GfApp_app_icon_x').val($.dialog.data('dataX')).trigger('blur');
                    $('#GfApp_app_icon_y').val($.dialog.data('dataY')).trigger('blur');
                    $('#GfApp_app_icon_w').val($.dialog.data('dataWidth')).trigger('blur');
                    $('#GfApp_app_icon_h').val($.dialog.data('dataHeight')).trigger('blur');
                    draw('<?php echo $basepath->F_WWWPATH;?>'+$.dialog.data('app_icon'));
               }
            }
        });
    });

    function draw(picX) {
        var showX=$('#GfApp_app_icon_x').val();
        var showY=$('#GfApp_app_icon_y').val();
        var showW=$('#GfApp_app_icon_w').val();
        var showH=$('#GfApp_app_icon_h').val();
        heightX=100; //basepath表里fid=206的数据只有高度，没有宽度
        raitoX=showW/showH;
        widthC=heightX*raitoX;            
        var c=document.getElementById("myCanvas");
        c.setAttribute("width",widthC);
        c.setAttribute("height",heightX);
        var ctx=c.getContext("2d");
        var img = new Image();
        img.src = picX;
        img.onload = function () {
            ctx.drawImage(img,showX,showY,showW,showH,0,0,widthC,heightX);
        }
    }
</script>