<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i></h1>
        <span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <div class="box-content">
        <div class="box-table">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <?php echo $form->hiddenField($model,'id'); ?>
            <table class="detail">
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model,'code'); ?></td>
                    <td>
                        <?php
                            echo $model->code;
                            echo $form->hiddenField($model,'code');
                            echo $form->error($model,'code',$htmlOption = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'recharge_amount'); ?></td>
                    <td>
                        <?php
                            echo $model->recharge_amount;
                            echo $form->hiddenField($model,'recharge_amount');
                            echo $form->error($model,'recharge_amount',$htmlOption = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'exchange_num'); ?></td>
                    <td>
                        <?php
                            echo $model->exchange_num;
                            echo $form->hiddenField($model,'exchange_num');
                            echo $form->error($model,'exchange_num',$htmlOption = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'state'); ?></td>
                    <td><?php echo $model->state_name; ?></td>
                </tr>
                <?php if($model->state==373 || $model->state==371) {?>
                    <tr>
                        <td><?php echo $form->labelEx($model,'reasons_failure'); ?></td>
                        <td><?php echo ($model->state==371) ? $form->textarea($model,'reasons_failure',array('class'=>'input-text','style'=>'width: 15%;')) : $model->reasons_failure; ?></td>
                    </tr>
                <?php }?>
                <tr>
                    <td>可执行操作</td>
                    <td>
                        <?php if($model->state==371) echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过')); ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!--box end-->