<div class="box">

    <div class="box-title c">
        <h1>当前界面：社区单位》场馆管理》审核未通过列表》<a class="nav-a">编辑</a></h1>
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
                <td>场馆编号</td>
                <td style="text-align: center;"><?php echo $model->code;?></td>
                <?php setbkcolor(0);//控制字段名是否添加底色，0不添加，1添加?>
                <?php echo readData($form,$model,'name');?>
                </tr>

                <tr>
                    <td><?php echo $form->labelEx($model, 'address'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textField($model, 'address', array('class'=>'input-text','id'=>'address')); ?>
                        <?php echo $form->error($model, 'address', $htmlOptions = array()); ?>
                    </td>
                </tr>

                <tr>
                    <td><?php echo $form->labelEx($model, 'city'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'city', array('class'=>'input-text','id'=>'city')); ?>
                        <?php echo $form->error($model, 'city', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'district'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'district', array('class'=>'input-text','id'=>'district')); ?>
                        <?php echo $form->error($model, 'district', $htmlOptions = array()); ?>
                    </td>
                </tr>

                <tr>
                    <td><?php echo $form->labelEx($model, 'lng'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'lng', array('class'=>'input-text','id'=>'lng')); ?>
                        <?php echo $form->error($model, 'lng', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'lat'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'lat', array('class'=>'input-text','id'=>'lat')); ?>
                        <?php echo $form->error($model, 'lat', $htmlOptions = array()); ?>
                    </td>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'project:check(ProjectList):1:3');?>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'base:check(testBase):1:3');?>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'phone:1:3');?>
                </tr>

                <tr>
                    <td><?php echo $form->labelEx($model, 'introduce'); ?></td>
                    <td colspan="3">
                    <?php echo $form->textArea($model,'introduce', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'introduce', $htmlOptions = array()); ?>
                    </td>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'comName:list(ClubListSqdw)');?>
                    <?php echo readData($form,$model,'pic:pic');?>
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
<script>
    $("#address,#city,#district,#lng,#lat").on('click', function(){   
        $.dialog.open('<?php echo $this->createUrl("select/MapArea",array('address'=>$model->address,'city'=>$model->city,'district'=>$model->district,'lng'=>$model->lng,'lat'=>$model->lat));?>',{
            lock:true,//在某些操作完成前禁用其他界面元素
            opacity:0.3,//透明度
            title:'添加导航定位',//对话框标题
            width:'900px',
            height:'500px',
            close: function () {
                var sign = $.dialog.data('sign');
                if(sign == 'queren'){
                document.getElementById('address').value = $.dialog.data('address');
                var str = $.dialog.data('lnglat');
                var arr = str.split(",");
                document.getElementById('lng').value = arr[0];
                document.getElementById('lat').value = arr[1];
                var str2 = $.dialog.data('citydis');
                var arr2 = str2.split(",");
                document.getElementById('city').value = arr2[0];
                document.getElementById('district').value = arr2[1];
                }
                if (sign == 'quxiao') {
                    document.getElementById('address').value = '<?php echo $model->address?>';
                    document.getElementById('city').value = '<?php echo $model->city?>';
                    document.getElementById('district').value = '<?php echo $model->district?>';
                    document.getElementById('lng').value = '<?php echo $model->lng?>';
                    document.getElementById('lat').value = '<?php echo $model->lat?>';
                }
            }
        });
    });
</script>