<div class="box">
    <div class="box-title c">
    <h1>当前界面：商城》商品发布》商品发布审核》<a class="nav-a">修改</a></h1>
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
                            <?php echo $form->hiddenField($model, 'long_pay_time'); ?>
                            <?php echo $form->hiddenField($model, 'is_post'); ?>
                            <?php echo $form->hiddenField($model, 'sign_long_cycle'); ?>
                            <?php echo $form->hiddenField($model, 'if_apply_return'); ?>
                            <?php echo $form->hiddenField($model, 'return_cycle'); ?>
                            <?php echo $form->hiddenField($model, 'if_invoice'); ?>
                            <?php echo $form->hiddenField($model, 'invoice_cycle'); ?>
                            <span id="classify_box"><?php if(isset($ptype)) foreach($ptype as $v){
                                $types = MallProductsTypeSname::model()->find('tn_code="'.$v.'"');
                                if(!empty($types)){ ?>
                                <span class="label-box" id="classify_item_<?php echo $types->tn_code;?>" data-id="<?php echo $types->tn_code;?>"><?php echo $types->sn_name;?></span><?php } }?></span>
                            <input id="classify_add_btn" class="btn" type="button" value="选择分类">
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
                                <span class="label-box" id="project_item_<?php echo $v->project_id?>" data-id="<?php echo $v->project_id?>">
                                <?php echo $v->project_list->project_name;?>
                                <i onclick="fnDeleteProject(this);"></i>
                                </span>
                            <?php }}?>
                        </span>
                        <input id="project_add_btn" class="btn" type="button" value="添加">
                        <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
                <table>
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
            <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>操作信息</td>
                </tr>
            </table>
            <table id="operate">
                <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td width='85%'>
                        <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td>
                        <?php echo show_shenhe_box(array('baocun'=>'修改'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            </div>
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
//输入商品编码获取分类      
function codeOnchange(obj){
  var changval=$(obj).val();
  var t_html=''; 
  //console.log(changval); 
  if (changval.length>=8) {
      $.ajax({
        type: 'post',
        url: '<?php echo $this->createUrl('validate');?>&code='+changval,
        data: {code:changval},
        dataType: 'json',
        success: function(data) {
            if(data!=null){
                t_html=t_html+'<span class="label-box" id="classify_item_'+data.code1+'" data-id="'+data.code1+'">'+data.tname1+'</span>'+
                '<span class="label-box" id="classify_item_'+data.code2+'" data-id="'+data.code2+'">'+data.tname2+'</span>'+
                '<span class="label-box" id="classify_item_'+data.code3+'" data-id="'+data.code3+'">'+data.tname3+'</span>'+
                '<span class="label-box" id="classify_item_'+data.code4+'" data-id="'+data.code4+'">'+data.tname4+'</span>';
                $('#MallProducts_long_pay_time').val(data.long_pay_time);
                $('#MallProducts_is_post').val(data.is_post);
                $('#MallProducts_sign_long_cycle').val(data.sign_long_cycle);
                $('#MallProducts_if_apply_return').val(data.if_apply_return);
                $('#MallProducts_return_cycle').val(data.return_cycle);
                $('#MallProducts_if_invoice').val(data.if_invoice);
                $('#MallProducts_invoice_cycle').val(data.invoice_cycle);
                $('#classify_box').html(t_html);
                fnUpdateClassify();
            }else{
                we.msg('minus', '编码有误，没有获取到分类');
            }
        }
    });

  }
}

//商品分类编码改变获取商品分类    
function type_codeOnchange(obj){
  var changval=$(obj).val();
  var t_html=''; 
  //console.log(changval); 
  if (changval.length==8) {
      $.ajax({
        type: 'post',
        url: '<?php echo $this->createUrl('validate');?>&code='+changval,
        data: {code:changval},
        dataType: 'json',
        success: function(data) {
            if(data!=null){
                t_html=t_html+'<span class="label-box" id="classify_item_'+data.code1+'" data-id="'+data.code1+'">'+data.tname1+'</span>'+
                '<span class="label-box" id="classify_item_'+data.code2+'" data-id="'+data.code2+'">'+data.tname2+'</span>'+
                '<span class="label-box" id="classify_item_'+data.code3+'" data-id="'+data.code3+'">'+data.tname3+'</span>'+
                '<span class="label-box" id="classify_item_'+data.code4+'" data-id="'+data.code4+'">'+data.tname4+'</span>';
                $('#classify_box').html(t_html);
                fnUpdateClassify();
                $('#MallProducts_type').change();
            }else{
                we.msg('minus', '没有获取到分类');
            }
        }
    });

  }
}

// 选择分类
var $classify_add_btn=$('#classify_add_btn');
$classify_add_btn.on('click', function(){
    var type_fater=$('#MallProducts_type_fater').val();
    if (type_fater=='') {
            we.msg('minus','请先选择商品类型');
            return false;
        }
    $.dialog.data('classify_id', 0);
    $.dialog.open('<?php echo $this->createUrl("select/product_type");?>&order_type='+type_fater,{
        id:'fenlei',
        lock:true,
        opacity:0.3,
        title:'选择具体内容',
        width:'80%',
        height:'90%',
        close: function () {
            if($.dialog.data('classify_id')>0){
                $('#MallProducts_classify_code').val($.dialog.data('classify_code')).trigger('blur');
                $('#MallProducts_classify_code').change(); 
            }
        }
    });
});

// 删除分类
var $classify_box=$('#classify_box');
var $MallProducts_type=$('#MallProducts_type');
var fnUpdateClassify=function(){
    var arr=[];
    var id;
    $classify_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $MallProducts_type.val(we.implode(',', arr));
};

var fnDeleteClassify=function(op){
    $(op).parent().remove();
    fnUpdateClassify();
};
    

// 删除已添加项目
var fnDeleteProject=function(op){
    $(op).parent().remove();
    fnUpdateProject();
};
// 项目添加或删除时，更新
var fnUpdateProject=function(){
    var arr=[];
    $('#project_box span').each(function(){
        arr.push($(this).attr('data-id'));
    });
    $('#MallProducts_project_list').val(we.implode(',',arr));
};
fnUpdateProject();
// 添加项目
    var $project_box=$('#project_box');
    $('#project_add_btn').on('click', function(){
        //var club_id=$('#MallProducts_supplier_id').val();&club_id='+club_id
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project");?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('project_id')==-1){
                    var boxnum=$.dialog.data('project_title');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#project_item_'+boxnum[j].dataset.id).length==0){
                            var s1='<span class="label-box" id="project_item_'+boxnum[j].dataset.id;
                            s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                            $project_box.append(s1+'<i onclick="fnDeleteProject(this);"></i></span>');
                            fnUpdateProject(); 
                        }
                    }
                }
            }
        });
    });

</script> 






