<div class="box">

    <div class="box-title c">
        <h1>当前界面：社区单位》社区管理》审核未通过列表》<a class="nav-a">编辑</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->

    <div class="box-detail">

    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>

    <div class="box-detail-bd">
            <table>

                <tr class="table-title">
                    <td colspan="4" style="font-size: 15px;font-weight: bold;">社区基本信息</td>
                </tr>

                <tr>
                <td>社区编号</td>
                <td style="text-align: center;"><?php echo $model->club_code;?></td>
                <?php setbkcolor(0);//控制字段名是否添加底色，0不添加，1添加?>
                <?php echo readData($form,$model,'club_name');?>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'club_address:1:3');?>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'contact_phone');?>
                    <?php echo readData($form,$model,'email');?>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'club_logo_pic:1:3:pic');?>
                </tr>

                </table> 

        <div class="box-detail-submit">
            <button onclick="submitType='again'" class="btn btn-blue" type="submit">重新提交</button>
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

    </div><!--box-detail-bd end-->

    <?php $this->endWidget(); ?>

    </div><!--box-detail end-->

</div><!--box end-->