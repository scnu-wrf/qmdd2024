<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>应用更新</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list());
      ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">

                <table class="mt15">
                    <tr class="table-title">
                        <td colspan="2" >更新信息</td>
                    </tr>

                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'app_id'); ?></td>
                        <td width="85%"> <?php echo $_REQUEST['pid'];?>
                            <input type="hidden" name="app_id" value="<?php echo Yii::app()->request->getParam('pid');?>">
                       </td>
                    </tr>

                    <tr>    
                        <td width="15%"><?php echo $form->labelEx($model, 'app_name'); ?></td>
                        <td width="85%"> <?php echo $_REQUEST['appname'];?>
                             <input type="hidden" name="app_name" value="<?php echo Yii::app()->request->getParam('appname');?>">
                        </td>
                    </tr>
					<tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'version_code'); ?></td>
                        <td width="85%">
							<?php echo $form->textField($model, 'version_code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'version_code', $htmlOptions = array()); ?>
                       </td>
                    </tr>              
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'version'); ?></td>
                        <td width="85%">
                            <?php echo $form->textField($model, 'version', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'version', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'name'); ?></td>

                     <td width="85%">
                        <div class="material-upload">
                             <?php echo $form->hiddenField($model, 'name', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(186);$picprefix='';
                            if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <span class="msg">格式支持APK、IPA</span>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input id="btn_inputUrl" type="button" class="btn" value="链接上传" />

                            <script>we.uploadapp('<?php echo get_class($model);?>_name','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                                
                                <!-- 上传文档结束 -->

                        </div> <!-- material-upload end -->
						 <div style="margin-top: 10px;">
							 
							<?php echo $form->textField($model, 'url', array('class' => 'input-text','readonly'=>'true')); ?>
                            <?php echo $form->error($model, 'url', $htmlOptions = array()); ?>
						 </div>
                        </td>
                    </tr>
                    

                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'ptype'); ?></td>
                        <td width="85%">
                            <?php echo $form->checkBoxList($model, 'ptype', 
                              array(732=>'安卓',730=>'苹果',731=>'IPAD'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                             <?php echo $form->error($model, 'ptype'); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'version_content'); ?></td>
                        <td width="85%">
                            <?php echo $form->textArea($model, 'version_content', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'version_content', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="15%">发布时间</td>
                        <td width="85%">
                            <?php echo $form->radioButtonList($model, 'if_state_dispay', array(649 => '审核通过后立即发布', 648 => '定时间发布'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;",'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'if_state_dispay'); ?>
                           &nbsp;请选择发布时间：
                           <?php echo $form->textField($model, 'dispay_time', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                            <?php echo $form->error($model, 'dispay_time', $htmlOptions = array()); ?>

                        </td>
                    </tr>

                </table>


            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->

<!-- 审核信息开始 -->

        <div class="mt15">
            <table class="table-title"><tr> <td>审核信息</td></tr></table>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td width="85%">
                       <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' )); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td>
                        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                        <button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button>
                        <button onclick="submitType='tongguo'" class="btn btn-blue" type="submit">审核通过</button>
                        <button onclick="submitType='butongguo'" class="btn btn-blue" type="submit">审核不通过</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div> 
         
         <table class="showinfo">
            <tr>
                <th style="width:20%;">操作时间</th>
                <th style="width:20%;">操作人</th>
                <th style="width:20%;">状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php echo $model->s_time; ?></td>
                <td><?php echo $model->s_qmddname; ?></td>
                <td><?php echo $model->state_name; ?></td>
                <td><?php echo $model->reasons_failure; ?></td>
            </tr>
        </table>

<!-- 审核信息结束 -->

<?php $this->endWidget();?>

  </div><!--box-detail end-->
</div><!--box end-->

<script>

    //选择发布时间
    $('#AndroidPhone_dispay_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });


    //手动添加安装包地址
    $(function () {  
        $("#btn_inputUrl").bind("click", function () {  
            var nUrl=prompt("请输入安装包地址",$("#AndroidPhone_url").val());
            if (nUrl){
                $("#AndroidPhone_url").val(nUrl).trigger('blur');
                $("#AndroidPhone_name").val(nUrl.substring(nUrl.lastIndexOf('/')+1)).trigger('blur');
                } 
            })  
        }); 

</script>