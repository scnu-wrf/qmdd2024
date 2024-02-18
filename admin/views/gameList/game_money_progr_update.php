<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》赛事报名 》赛事收费方案 》详情</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="4">赛事方案信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'event_code'); ?></td>
                        <td><?php echo $model->event_code; ?></td>
                        <td><?php echo $form->labelEx($model,'event_code'); ?></td>
                        <td><?php echo $model->event_title; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'star_time1'); ?></td>
                        <td><?php echo $model->star_time; ?></td>
                        <td><?php echo $form->labelEx($model,'end_time1'); ?></td>
                        <td><?php echo $model->end_time; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'product_code'); ?></td>
                        <td><?php echo (!empty($mall_fee)) ? $mall_fee->product_code : ''; ?></td>
                        <td><?php echo $form->labelEx($model,'product_name'); ?></td>
                        <td><?php echo (!empty($mall_fee)) ? $mall_fee->product_name : ''; ?></td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr>
                        <td style="font-weight:bold;">竞赛项目收费信息</td>
                        <td style="font-weight:bold;">总名额数</td>
                        <td style="font-weight:bold;">报名费（元）</td>
                    </tr>
                    <?php
                        $set_details = MallPriceSetDetails::model()->findAll('set_id='.$model->id);
                        if(!empty($set_details))foreach($set_details as $sd){
                    ?>
                        <tr>
                            <td>
                                <p>赛&nbsp;&nbsp;事&nbsp;&nbsp;名&nbsp;&nbsp;称&nbsp;：<span><?php echo $sd->service_name; ?></span></p>
                                <p>绑定商品编号：<span><?php echo $sd->product_code; ?></span></p>
                                <p>收费项目名称：<span><?php echo (!empty($mall_fee)) ? $mall_fee->name : ''; ?></span></p>
                                <p>竞赛项目名称：<span><?php echo $sd->service_data_name; ?></span></p>
                            </td>
                            <td><?php echo $sd->Inventory_quantity; ?></td>
                            <td><?php echo $sd->sale_price; ?></td>
                        </tr>
                    <?php }?>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->