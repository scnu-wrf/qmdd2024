
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php echo $model->product_title; ?></h1><span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div>
        <div class="box-detail">
            <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-bd">
                <div style="display:block;" class="box-detail-tab-item">
                <table border="0" cellspacing="1" cellpadding="0" class="product_publish_content">
                    <tr>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'order_num'); ?>：</td>
                        <td>
                            <?php echo $model->order_num; ?>
                        </td>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'product_ico'); ?>：</td>
                        <td id="dpic_dispay_icon">
                        <?php echo $form->hiddenField($model, 'product_ico', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(176);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->product_ico!=''){?>
                            <div class="upload_img fl" id="product_ico">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->product_ico;?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$model->product_ico;?>" width="100"></a>
                            </div>
                            <?php }?>
                            <!-- <script>we.uploadpic('<?php //echo get_class($model);?>product_ico','<?php //echo $picprefix;?>');</script> -->
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'product_title'); ?>：</td>
                        <td>
                            <?php echo $model->product_title; ?>
                        </td>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'supplier_name'); ?>：</td>
                        <td>
                            <?php echo $model->supplier_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'buy_amount'); ?>：</td>
                        <td>
                            <?php echo $model->buy_amount; ?>
                        </td>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'json_attr'); ?>：</td>
                        <td>
                            <?php echo $model->json_attr; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'project_name'); ?>：</td>
                        <td>
                            <?php echo $model->project_name; ?>
                        </td>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'set_name'); ?>：</td>
                        <td>
                            <?php echo $model->set_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'buy_count'); ?>：</td>
                        <td>
                            <?php echo $model->buy_count; ?>
                        </td>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'buy_price'); ?>：</td>
                        <td>
                            <?php echo $model->buy_price; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'purpose'); ?>：</td>
                        <td>
                            <?php 
                                if($model->purpose==1)
                                    echo '普通销售';
                                else if($model->purpose==3)
                                    echo '限时抢购';
                                else if($model->purpose==4)
                                    echo '会员促销(购买自用)';
                                else if($model->purpose==5)
                                    echo '代销下单(二次上架)';
                                else if($model->purpose==7)
                                    echo '单位导购';
                            ?>
                        </td>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'gf_name'); ?>：</td>
                        <td>
                            <?php echo $model->gf_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'buy_beans'); ?>：</td>
                        <td>
                            <?php echo $model->buy_beans; ?>
                        </td>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'bean_discount'); ?>：</td>
                        <td>
                            <?php echo $model->bean_discount; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'coupon_discount'); ?>：</td>
                        <td>
                            <?php echo $model->coupon_discount; ?>
                        </td>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'post'); ?>：</td>
                        <td>
                            <?php echo $model->post; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'uDate'); ?>：</td>
                        <td>
                            <?php echo $model->uDate; ?>
                        </td>
                        <td class="detail-hd"></td>
                        <td>
                            
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>可执行操作：</td>
                        <td colspan="3">
                            <!-- <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button> -->
                            <!--<?php //echo show_shenhe_box(array('baocun'=>'保存')); ?>-->
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
                </div><!--box-detail-tab-item end-->
            </div><!--box-detail-bd end-->
            <?php $this->endWidget(); ?>
        </div>
</div><!--box end-->