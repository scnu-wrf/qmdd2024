<style>
    #search_div{
        display:none;
        position:absolute;
    }
    #search_ul li{
        width:300px;
        background-color:#fcfcfc;
    }
    #search_ul li:hover{
        color:lightskyblue;
        background-color:#f0f0f0;
        border-color:#4d90fe;
    }
</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>详细报告</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="mt15">
                <tr class="table-title">
                    <td colspan="4" >基本信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'code'); ?>：</td>
                    <td><?php echo $model->code; ?></td>
                    <td><?php echo $form->labelEx($model, 'club_id'); ?>：</td>
                    <td>
                        <span id="club_box">
                            <?php if($model->club_list!=null){?>
                                <span class="label-box">
                                    <?php echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?>
                                </span><?php } else {?>
                                <span class="label-box">
                                    <?php echo get_session('club_name');?>
                                    <?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?>
                                </span>
                            <?php } ?>
                        </span>
                        <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'gf_account'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'gf_account', array('class'=>'input-text','oninput' =>'accountOnchang(this)','onpropertychange' =>'accountOnchang(this)')); ?>
                        <?php echo $form->error($model, 'gf_account', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'gf_name'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'gf_name', array('class' => 'input-text')); ?>
                        <?php echo $form->hiddenField($model, 'gf_id', array('class' => 'input-text')); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'health_date'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'health_date', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'health_date', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'health_state'); ?>：</td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'health_state', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'health_state'); ?>
                    </td>
                </tr>
            </table>
            <table id="htm5">
                <table class="mt15">
                    <tr class="table-title">
                        <td>体检信息</td>
                    </tr>
                </table>
                <?php
                    $basepath=BasePath::model()->getPath(202);$picprefix='';
                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                    $gf_model=GfHealthyModel::model()->findAll();
                    $model->id=empty($model->id) ? 0 : $model->id;
                    $gf_values=GfHealthyValues::model()->findAll('h_id='.$model->id);
                ?>
                <?php echo $form->hiddenField($model, 'gf_healthy_model'); ?>
                <table id="gf_healthy_model">
                    <?php if(!empty($gf_values))foreach($gf_values as $v) {?>
                        <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v->id;?>][model_id]" value="<?php echo $v->model_id;?>">
                        <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v->id;?>][attr_name]" value="<?php echo $v->attr_name;?>">
                        <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v->id;?>][attr_unit]" value="<?php echo $v->attr_unit;?>">
                        <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v->id;?>][attr_input_type]" value="<?php echo $v->attr_input_type;?>">
                        <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>">
                        <?php if($v->attr_input_type==683) { $pic_values = explode(',', $v->attr_values); ?>
                            <tr>
                                <td width="15%"><?php echo $v->attr_name; ?></td>
                                <td>
                                    <div class="upload_img fl" id="upload_pic_GfHealthyList_attr_values_<?php echo $v->id;?>">
                                        <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v->id;?>][attr_values]" id="GfHealthyList_attr_values_<?php echo $v->id;?>" value="<?php echo $v->attr_values;?>">
                                        <?php if($v->attr_values!=''){ foreach ($pic_values as $p) {?>
                                            <a class="picbox" data-savepath="<?php echo $p;?>" href="<?php echo $basepath->F_WWWPATH.$p;?>" target="_blank">
                                                <img src="<?php echo $basepath->F_WWWPATH.$p;?>" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic_<?php echo $v->id;?>();return false;"></i>
                                            </a>
                                        <?php }}?>
                                    </div>
                                    <script>we.uploadpic('<?php echo get_class($model);?>_attr_values_<?php echo $v->id;?>','<?php echo $picprefix;?>','','',function(e1,e2){fnscrollPic_<?php echo $v->id;?>(e1.savename,e1.allpath);},5);</script>
                                    <script>
                                        var fnUpdatescrollPic_<?php echo $v->id;?>=function(){
                                            var arr1=[];
                                            $('#upload_pic_GfHealthyList_attr_values_<?php echo $v->id;?>').find('a').each(function(){
                                                arr1.push($(this).attr('data-savepath'));
                                            });
                                            $('#GfHealthyList_attr_values_<?php echo $v->id;?>').val(we.implode(',',arr1));
                                            $('#upload_box_GfHealthyList_attr_values_<?php echo $v->id;?>').show();
                                            if(arr1.length>=5) {
                                                $('#upload_box_GfHealthyList_attr_values_<?php echo $v->id;?>').hide();
                                            }
                                        };
                                        var fnscrollPic_<?php echo $v->id;?>=function(savename,allpath){
                                            $('#upload_pic_GfHealthyList_attr_values_<?php echo $v->id;?>').append('<a class="picbox" data-savepath="'+
                                            savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic_<?php echo $v->id;?>();return false;"></i></a>');
                                            fnUpdatescrollPic_<?php echo $v->id;?>();
                                        };
                                    </script>
                                    <?php //echo $form->error($model, 'attr_values', $htmlOptions = array()); ?>
                                    <span class="msg">注：1-5张</span>
                                </td>
                            </tr>
                        <?php }else if($v->attr_input_type==681){?>
                            <tr>
                                <td width="15%"><?php echo $v->attr_name; ?></td>
                                <td>
                                    <textarea class="input-text" type="text" style="width:300px;" name="gf_healthy_model[<?php echo $v->id;?>][attr_values]"><?php echo $v->attr_values;?></textarea>
                                    <sub><?php echo $v->attr_unit; ?></sub>
                                </td>
                            </tr>
                        <?php }else if($v->attr_input_type==678){ $down_values = explode(',', $v->attr_values);?>
                            <tr>
                                <td width="15%"><?php echo $v->attr_name; ?></td>
                                <td>
                                    <!--<?php echo $form->radioButtonList($v, 'attr_values', Chtml::listData(GfHealthyModel::model()->find(), 'id', 'attr_values'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>','name'=>'gf_healthy_model['.$v->id.'][attr_values]')); ?>-->
                                    <select name="gf_healthy_model[<?php echo $v->id;?>][attr_values]">
                                        <option value>请选择</option>
                                        <?php if($down_values!='') foreach($down_values as $g){ ?>
                                            <option value="<?php echo $g->id; ?>"><?php echo $g->attr_values; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        <?php }else if($v->attr_input_type==720){ $sear_values = explode(',', $v->attr_values);?>
                            <tr>
                                <td width="15%"><?php echo $v->attr_name; ?></td>
                                <td>
                                    <input id="search_values" class="input-text" type="text" style="width:300px;" name="gf_healthy_model[<?php echo $v->id;?>][attr_values]" oninput="oninputattrname(this);" onpropertychange="oninputattrname(this);" value="<?php echo $v->attr_values;?>">
                                    <sub><?php echo $v->attr_unit; ?></sub>
                                    <div id="search_div">
                                        <ul id="search_ul">
                                            <?php if($v->attr_values!='') foreach($sear_values as $k) {?>
                                                <li class="input-text" onclick="search_click(this);"><?php echo $k; ?></li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php }else{?>
                            <tr>
                                <td width="15%"><?php if(!empty($v)) echo $v->attr_name; ?></td>
                                <td>
                                    <input class="input-text" type="text" style="width:300px;" name="gf_healthy_model[<?php echo $v->id;?>][attr_values]" value="<?php echo $v->attr_values;?>">
                                    <sub><?php echo $v->attr_unit; ?></sub>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }else{?>
                        <?php if(!empty($gf_model)) foreach($gf_model as $v2) {?>
                            <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v2->id;?>][model_id]" value="<?php echo $v2->id;?>">
                            <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v2->id;?>][attr_name]" value="<?php echo $v2->attr_name?>">
                            <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v2->id;?>][attr_unit]" value="<?php echo $v2->attr_unit?>">
                            <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v2->id;?>][attr_input_type]" value="<?php echo $v2->attr_input_type?>">
                            <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v2->id;?>][id]" value="null">
                            <?php if($v2->attr_input_type==683){ ?>
                                <tr>
                                    <td width="15%"><?php echo $v2->attr_name; ?></td>
                                    <td>
                                        <div class="upload_img fl" id="upload_pic_GfHealthyList_attr_values_<?php echo $v2->id;?>">
                                            <input class="input-text" type="hidden" name="gf_healthy_model[<?php echo $v2->id;?>][attr_values]" id="GfHealthyList_attr_values_<?php echo $v2->id;?>">
                                        </div>
                                        <script>we.uploadpic('<?php echo get_class($model);?>_attr_values_<?php echo $v2->id;?>','<?php echo $picprefix;?>','','',function(e1,e2){fnscrollPic_<?php echo $v2->id;?>(e1.savename,e1.allpath);},5);</script>
                                        <script>
                                            var fnUpdatescrollPic_<?php echo $v2->id;?>=function(){
                                                var arr1=[];
                                                $('#upload_pic_GfHealthyList_attr_values_<?php echo $v2->id;?>').find('a').each(function(){
                                                    arr1.push($(this).attr('data-savepath'));
                                                });
                                                $('#GfHealthyList_attr_values_<?php echo $v2->id;?>').val(we.implode(',',arr1));
                                                $('#upload_box_GfHealthyList_attr_values_<?php echo $v2->id;?>').show();
                                                if(arr1.length>=5) {
                                                    $('#upload_box_GfHealthyList_attr_values_<?php echo $v2->id;?>').hide();
                                                }
                                            };
                                            var fnscrollPic_<?php echo $v2->id;?>=function(savename,allpath){
                                                $('#upload_pic_GfHealthyList_attr_values_<?php echo $v2->id;?>').append('<a class="picbox" data-savepath="'+
                                                savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic_<?php echo $v2->id;?>();return false;"></i></a>');
                                                fnUpdatescrollPic_<?php echo $v2->id;?>();
                                            };
                                        </script>
                                        <?php //echo $form->error($model, 'attr_values', $htmlOptions = array()); ?>
                                        <span class="msg">注：1-5张</span>
                                    </td>
                                </tr>
                            <?php }else if($v2->attr_input_type==681){?>
                                <tr>
                                    <td width="15%"><?php echo $v2->attr_name; ?></td>
                                    <td>
                                        <textarea class="input-text" type="text" style="width:300px;" name="gf_healthy_model[<?php echo $v2->id;?>][attr_values]"></textarea>
                                        <sub><?php echo $v2->attr_unit; ?></sub>
                                    </td>
                                </tr>
                            <?php }else if($v2->attr_input_type==678){ $down_values = explode(',', $v2->attr_values);?>
                                <tr>
                                    <td width="15%"><?php echo $v2->attr_name; ?></td>
                                    <td>
                                        <!--<?php echo $form->radioButtonList($v2, 'attr_values', Chtml::listData(GfHealthyModel::model()->find(), 'id', 'attr_values'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>','name'=>'gf_healthy_model['.$v2->id.'][attr_values]')); ?>-->
                                        <select name="gf_healthy_model[<?php echo $v2->id;?>][attr_values]">
                                            <option value>请选择</option>
                                            <?php if($down_values!='') foreach($down_values as $g){ ?>
                                                <option value="<?php echo $g; ?>"><?php echo $g; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php }else if($v2->attr_input_type==720){ $sear_values = explode(',', $v2->attr_values);?>
                                <tr>
                                    <td width="15%"><?php echo $v2->attr_name; ?></td>
                                    <td>
                                        <input id="search_values" class="input-text" type="text" style="width:300px;" name="gf_healthy_model[<?php echo $v2->id;?>][attr_values]" oninput="oninputattrname(this);" onpropertychange="oninputattrname(this);">
                                        <sub><?php echo $v2->attr_unit; ?></sub>
                                        <div id="search_div">
                                            <ul id="search_ul">
                                                <?php if($v2->attr_values!='') foreach($sear_values as $k) {?>
                                                    <li class="input-text" onclick="search_click(this);"><?php echo $k; ?></li>
                                                <?php }?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php }else{?>
                                <tr>
                                    <td width="15%"><?php echo $v2->attr_name; ?></td>
                                    <td>
                                        <input class="input-text" type="text" style="width:300px;" name="gf_healthy_model[<?php echo $v2->id;?>][attr_values]">
                                        <sub><?php echo $v2->attr_unit; ?></sub>
                                    </td>
                                </tr>
                            <?php }?>
                        <?php }?>
                    <?php }?>
                </table>
            </table>
            <table class="mt15">
                <tr>
                    <td width="15%">可执行操作：</td>
                    <td>
                        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </table><!--box-detail-bd end-->
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    function accountOnchang(obj){
        var changval=$(obj).val();
        if (changval.length>=6) {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validate');?>&gf_account='+changval,
                data: {gf_account:changval},
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if(data.status==1){
                        $('#GfHealthyList_gf_name').val(data.real_name);
                        $('#GfHealthyList_gf_id').val(data.gfid);
                    }
                    else{
                        $(obj).val('');
                        we.msg('minus', data.msg);
                    }
                }
            });
        }
    }

    function oninputattrname(obj){
        var search_val=$(obj).val();
        var show_val=$('#search_values').val();
        if(search_val.length>=0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('prompt');?>',
                data: {show_val:show_val},
                dataTypr: 'json',
                success: function(data){
                    console.log(data);
                    if(data.status==1){
                        if(search_val!=''){
                            $('#search_div').show();
                        }
                        else{
                            $('#search_div').hide();
                        }
                    }
                    else{
                        $(obj).val('');
                        we.msg('minus', data.msg);
                    }
                }
            })
        }
    }

    function search_click(obj){
        var li=$(obj).text();
        console.log(obj);
        $('#search_values').val(li);
        $('#search_div').hide();
    }
    $(document).on("click",function(e){
        if($(e.target).closest("#search_div").length==0){
            $("#search_div").hide();
        }
    });
</script>
<script>
    $(function(){
        $('#GfHealthyList_health_date').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });
</script>
