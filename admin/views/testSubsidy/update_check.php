<div class="box">

    <div class="box-title c">
        <h1>当前界面：动动约》补贴券管理》补贴券审核》<a class="nav-a">审核</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->

    <div class="box-detail">

    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>

    <div class="box-detail-bd">
            <table>

                <tr class="table-title">
                    <td colspan="4" style="font-size: 15px;font-weight: bold;">补贴券基本信息</td>
                </tr>

                <tr>
                <?php setbkcolor(0);//控制字段名是否添加底色，0不添加，1添加?>
                <?php echo readData($form,$model,'comCode:label');?>
                <?php echo readData($form,$model,'comName:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'staCode:label');?>
                <?php echo readData($form,$model,'staName:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'venCode:label');?>
                <?php echo readData($form,$model,'venName:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'code:label');?>
                <?php echo readData($form,$model,'name:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'price:label:1:3');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'listTime:label');?>
                <?php echo readData($form,$model,'delistTime:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'reviewCom:1:3');?>
                </tr>

            </table>

        <div class="box-detail-submit">
            <button onclick="submitType='pass'" class="btn btn-blue" type="submit">审核通过</button>
            <button onclick="submitType='notpass'" class="btn btn-blue" type="submit">审核不通过</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

    </div><!--box-detail-bd end-->

    <?php $this->endWidget(); ?>

    </div><!--box-detail end-->

</div><!--box end-->