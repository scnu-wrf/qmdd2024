<div class="box">

    <div class="box-title c">
        <?php if($sign == 'create'){?>
            <h1>当前界面：动动约》补贴券管理》补贴券登记》<a class="nav-a">添加</a></h1>
        <?php }?>
        <?php if($sign == 'update'){?>
            <h1>当前界面：动动约》补贴券管理》补贴券登记》<a class="nav-a">编辑</a></h1>
        <?php }?>
        <?php if($sign == 'index_pass'){?>
            <h1>当前界面：动动约》补贴券管理》补贴券列表》<a class="nav-a">编辑</a></h1>
        <?php }?>
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
                <td>补贴券编号</td>
            <?php if($sign == 'create'){?>
                <td style="text-align: center;"><?php echo $siteCode;?></td>
            <?php }?>
            <?php if($sign == 'update'||$sign == 'index_pass'){?>
                <td style="text-align: center;"><?php echo $model->code;?></td>
            <?php }?>
                <?php setbkcolor(0);//控制字段名是否添加底色，0不添加，1添加?>
                <?php echo readData($form,$model,'name');?>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'price');?>
                    <?php echo readData($form,$model,'venName:list(testVenue)');?>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'listTime:date');?>
                    <?php echo readData($form,$model,'delistTime:date');?>
                </tr>

                </table> 

        <div class="box-detail-submit">
            <?php if($sign == 'index_pass'){?>
            <button onclick="submitType='baocun2'" class="btn btn-blue" type="submit">保存</button>
            <?php } else {?>
            <button onclick="submitType='baocun1'" class="btn btn-blue" type="submit">保存</button>
            <?php }?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

    </div><!--box-detail-bd end-->

    <?php $this->endWidget(); ?>

    </div><!--box-detail end-->

</div><!--box end-->