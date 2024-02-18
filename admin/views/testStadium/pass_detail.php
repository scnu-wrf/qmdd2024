<div class="box">

    <div class="box-title c">
        <h1>当前界面：社区单位》场馆管理》场馆列表》<a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->

    <div class="box-detail">

    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>

    <div class="box-detail-bd">
            <table>

                <tr class="table-title">
                    <td colspan="4" style="font-size: 15px;font-weight: bold;">场馆基本信息</td>
                </tr>

                <tr>
                <?php setbkcolor(0);//控制字段名是否添加底色，0不添加，1添加?>
                <?php echo readData($form,$model,'code:label');?>
                <?php echo readData($form,$model,'name:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'address:label:1:3');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'city:label');?>
                <?php echo readData($form,$model,'district:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'lng:label');?>
                <?php echo readData($form,$model,'lat:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'project:label:1:3');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'base:label:1:3');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'introduce:label:1:3');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'phone:label');?>
                <?php echo readData($form,$model,'comName:label');?>
                </tr>

                <tr>
                <td><?php echo $form->labelEx($model, 'pic'); ?></td>
                <td colspan="3">
                <?php if(!empty($model->pic)){?>
                <a href="<?php echo $model->pic?>" target="_blank">
                    <img src="<?php echo $model->pic?>" width="200" height="100">
                </a>
                <?php } else{?>
                    暂未上传图片
                <?php }?>
                </td>
                </tr>

                </table>

    </div><!--box-detail-bd end-->

    <?php $this->endWidget(); ?>

    </div><!--box-detail end-->

</div><!--box end-->