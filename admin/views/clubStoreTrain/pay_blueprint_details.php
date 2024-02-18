<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》培训收费方案 》详情</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">收费方案信息</td>
                    </tr>
                    <tr>
                        <td style="width:10%">收费方案编号</td>
                        <td style="width:40%"><?php echo $model->event_code; ?></td>
                        <td style="width:10%">收费培训标题</td>
                        <td style="width:40%"><?php echo $model->event_title; ?></td>
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
                    <tr class="table-title">
                        <td>序号</td>
                        <td>培训内容</td>
                        <td>总名额数</td>
                        <td>报名费（元）</td>
                    </tr>
                    <?php
                        $set_details = MallPriceSetDetails::model()->findAll('set_id='.$model->id);
                        $num=1;if(!empty($set_details))foreach($set_details as $sd){
                    ?>
                        <tr>
                            <td><?php echo $num; ?></td>
                            <td><?php echo $sd->service_data_name; ?></td>
                            <td><?php echo $sd->Inventory_quantity; ?></td>
                            <td><?php echo $sd->sale_price; ?></td>
                        </tr>
                    <?php $num++;}?>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->