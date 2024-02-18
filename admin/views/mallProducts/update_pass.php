<?php
$txt='';
if(!isset($_REQUEST['flag'])){
        $_REQUEST['flag']='list';
}
$flag=$_REQUEST['flag'];
if($flag=='search'){
    $txt='商品发布查询》';
} elseif ($flag=='pass') {
    $txt='商品发布审核》';
} elseif ($flag=='list') {
    $txt='商品发布列表》';
} elseif ($flag=='index') {
    $txt='商品发布申请》';
}
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商品发布》商品发布审核》<a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
                <li>详情描述</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="table-title">
                    <tr>
                        <td>商品信息</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                        <td width="35%">
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php } ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'product_model'); ?></td>
                        <td width="35%">
                            <?php echo $form->radioButtonList($model, 'product_model', array(1095=>'销售品', 1096=>'赠品'), $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'product_model', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'type_fater'); ?></td>
                        <td> 
                       <?php echo $form->dropDownList($model, 'type_fater', Chtml::listData(BaseCode::model()->getProductType(), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>'true')); ?> 
                    <?php echo $form->error($model, 'type_fater', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'belong_brand'); ?></td>
                        <td><?php echo $form->hiddenField($model, 'belong_brand', array('class' => 'input-text')); ?>
                            <span id="brand_box"><?php if(!empty($model->mall_brand_street)){?><span class="label-box"><?php echo $model->mall_brand_street->brand_title;?></span><?php }?></span>
                             <?php echo $form->error($model, 'belong_brand', $htmlOptions = array()); ?>
                        </td>  
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'supplier_code'); ?></td>
                        <td><?php echo $model->supplier_code; ?></td>
                        <td><?php echo $form->labelEx($model, 'unit'); ?></td>
                        <td><?php echo $model->unit; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'name'); ?></td>
                        <td><?php echo $model->name; ?></td>
                        <td><?php echo $form->labelEx($model, 'made_in'); ?></td>
                        <td><?php echo $model->made_in; ?></td> 
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'json_attr'); ?></td>
                        <td><?php echo $model->json_attr; ?></td>
                        <td><?php echo $form->labelEx($model, 'price'); ?></td>
                        <td><?php echo $model->price; ?></td>                    
                    </tr>
                    <tr>
                      
                         <td><?php echo $form->labelEx($model, 'keywords'); ?></td>
                        <td colspan="3"><?php echo $model->keywords; ?>
                        <p>注：用逗号隔开</p>
                            <?php echo $form->error($model, 'keywords', $htmlOptions = array()); ?>
                        </td>                    
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'product_ICO'); ?></td>
                        <td colspan="3">
                    <?php $basepath=BasePath::model()->getPath(204);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <?php if($model->product_ICO!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_product_ICO"><a href="<?php echo $basepath->F_WWWPATH.$model->product_ICO;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->product_ICO;?>" style="max-width:100px; max-height:100px;"></a></div><?php }?>
                    <span>注：规格530px*530px</span>
                            <?php echo $form->error($model, 'product_ICO', $htmlOptions = array()); ?>
                        </td>
                      </tr>
                      <tr>
                        <td><?php echo $form->labelEx($model, 'product_scroll'); ?></td>
                        <td colspan="3">
                      <?php $base_path=BasePath::model()->getPath(204);$pic_prefix='';if($base_path!=null){ $pic_prefix=$base_path->F_CODENAME; }?>
                            <?php echo $form->hiddenField($model, 'product_scroll', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_MallProducts_product_scroll">
                                <?php 
                                foreach($product_scroll as $v) if($v) {?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $base_path->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $base_path->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"></a>
                                <?php }?>
                            </div>
                        <span>注：规格1080px*809px 1-5张</span>
                            <?php echo $form->error($model, 'product_scroll', $htmlOptions = array()); ?>
                        </td>
                    </tr>                  
                </table>
                <table class="mt15 table-title">
                    <tr>
                        <td>营销信息</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'product_code'); ?><span class="required">*</span></td>
                        <td width="35%"><?php  echo $model->product_code; ?>
                            <?php echo $form->error($model, 'product_code', $htmlOptions = array()); ?>
                        </td>
                         <td width="15%"><?php echo $form->labelEx($model, 'type'); ?></td>
                         <td width="35%">
                            <?php echo $form->hiddenField($model, 'type', array('class' => 'input-text'));echo $form->hiddenField($model, 'classify_code', array('class' => 'input-text','onchange' =>'type_codeOnchange(this)')); ?>
                            <span id="classify_box"><?php if(isset($ptype)) foreach($ptype as $v){
                                $types = MallProductsTypeSname::model()->find('tn_code="'.$v.'"');
                                if(!empty($types)){ ?>
                                <span class="label-box" id="classify_item_<?php echo $types->tn_code;?>" data-id="<?php echo $types->tn_code;?>"><?php echo $types->sn_name;?></span><?php } }?></span>
                            <?php echo $form->error($model, 'type', $htmlOptions = array()); ?>
                         </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                        <td colspan="3">
                        <?php 
                        $model->id=empty($model->id) ?0 : $model->id;
                        $project_list = MallProductsProject::model()->findAll('mall_products_id='.$model->id);
                        echo $form->hiddenField($model, 'project_list', array('class' => 'input-text',)); ?>
                        <span id="project_box">
                            <?php 
                            if(!empty($project_list)){
                            foreach($project_list as $v){?>
                                <span class="label-box" id="project_item_<?php echo $v->project_id?>" data-id="<?php echo $v->project_id?>"><?php echo $v->project_list->project_name;?></span>
                            <?php }}?>
                        </span>
                        <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
                <table class="mt15">
                	<tr class="table-title">
                    	<td>详情描述<span class="required">*</span></td>
                    </tr>
                    <tr>
                        <td>
                        <?php echo $form->hiddenField($model, 'description_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_description_temp', '<?php echo get_class($model);?>[description_temp]');</script>
                            <?php echo $form->error($model, 'description_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>                  
                </table>  
            </div><!--box-detail-tab-item end-->
            <table class="showinfo">
                <tr>
                    <th style="width:20%;">操作时间</th>
                    <th style="width:20%;">操作人</th>
                    <th style="width:20%;">审核状态</th>
                    <th>操作备注</th>
                </tr>
                <tr>
                    <td><?php echo $model->update; ?></td>
                    <td><?php echo $model->admin_nick; ?></td>
                    <td><?php echo $model->display_name; ?></td>
                    <td><?php echo $model->reasons_failure; ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <!--div class="mt15" style="text-align:center;">
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div-->
<?php $this->endWidget(); ?>

  </div><!--box-detail end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');

$(function(){
    $('#operate .btn-blue:eq(0)').on('click',function(){
        if($("#MallProducts_project_list").val()==''){
            we.msg('minus','请添加项目');
            return false;
        }
    });
    setTimeout(function(){ UE.getEditor('editor_MallProducts_description_temp').setDisabled('fullscreen'); }, 500);
});	


</script> 






