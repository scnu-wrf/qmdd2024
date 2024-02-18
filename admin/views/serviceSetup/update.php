<?php
    if (isset( $_REQUEST['lang_type'] ) ) {
       $model->lang_type=$_REQUEST['lang_type'];//角色类型
    } 
    if ($model->lang_type>0) $model->club_id=get_session('club_id');
      $da=array("club_id"=>get_session("club_id"),"project_id"=>"0","code_type"=>"GL");
      $tname= (($model->lang_type==0) ?'单位' : '个人');
      if(empty($model->id)){
        $model->admin_gfaccount=" ";
      }
   ?>
<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i><?php echo $tname; ?>管理员详细</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
        <div style="display:block;" class="box-detail-tab-item">
        <table class="mt15">
           <?php echo $form->hiddenField($model, 'id', array('class' => 'input-text',)); ?>
          
           <tr><td width="10%"><?php echo $form->labelEx($model, 'admin_gfaccount'); ?></td>
              <td width="90%">
               <?php echo $form->textField($model, 'admin_gfaccount', array('class' => 'input-text','readonly'=>'ture','style'=>'width:200px;')); 
                ?>
                  <input id="club_select_btn" class="btn" type="button" value="选择">
                  <?php 
                  echo $form->error($model, 'admin_gfaccount', $htmlOptions = array()); ?>
              </td>
          </tr>
          <tr>
          <td ><?php echo $form->labelEx($model, 'user_name'); ?></td>
          <td ><?php echo $form->textField($model, 'admin_gfnick', array('class' => 'input-text','readonly'=>'ture','style'=>'width:200px;')); ?>
              <?php echo $form->error($model, 'admin_gfnick', $htmlOptions = array()); ?></td>
          </tr>
          <tr>
           <td><?php echo $form->labelEx($model, 'password'); ?></td>
             <td id='funpsd'>
              <?php echo 123456;?><span class="msg">注：默认登录密码为123456，添加成功后请尽快前往更新登录密码</span>
            </td>
          </tr>
          <tr>
           <td><?php echo $form->labelEx($model, 'pay_pass'); ?></td>
             <td id='funpsd'>
              <?php echo 123456;?><span class="msg">注：默认支付密码为123456，添加成功后请尽快前往更新支付密码</span>
            </td>
          </tr>
          <tr> 
            <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
            <td>
                <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text',)); ?>
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
          <tr>
           <td><?php echo $form->labelEx($model, 'admin_level'); ?></td>
           <td >
<?php if($model->lang_type=="110" )  { ?>
                 <?php 
                   $da2=$model->admin_level;
                   $model->admin_level=$da2[0];
                   echo $form->radioButtonList($model, 'admin_level',
                  Chtml::listData(Role::model()->getLevel($model->lang_type,get_session('club_id')), 'f_id', 'f_rname'), 
                  $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
<?php } else { ?>
              <?php echo $form->checkBoxList($model, 'admin_level', 
                  Chtml::listData(Role::model()->getLevel($model->lang_type,get_session('club_id')), 'f_id', 'f_rname'),
                  $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
        <?php } ?>
              <?php echo $form->error($model, 'admin_level'); ?>
            </td>
          </tr>
        </table>
        </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
 <?php echo $form->textField($model, 'admin_gfid', array('class' => 'input-text','hidden'=>'ture')); ?>
 <?php echo $form->textField($model, 'club_id', array('class' => 'input-text','hidden'=>'ture')); ?>
 <?php echo $form->textField($model, 'lang_type', array('class' => 'input-text','hidden'=>'ture')); ?>
 <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
  <button class="btn" type="button" onclick="we.back();">取消</button>
 </div>

<?php $this->endWidget();?>

</div>
</div>
<script>
$('#club_select_btn').on('click', function(){
if ($('#Clubadmin_lang_type').val()==0){  read_club(); } else{ read_person();} });
    
 function read_club(){
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/club", array('partnership_type'=>16));?>',{
            id:'danwei',lock:true,opacity:0.3,width:'500px',height:'60%',
            title:'选择具体内容',
            close: function () {
                if($.dialog.data('club_id')>0){
                  $('#Clubadmin_club_id').val($.dialog.data('club_id'));
                  $('#Clubadmin_admin_gfaccount').val($.dialog.data('club_code'));
                  $('#Clubadmin_admin_gfnick').val($.dialog.data('club_title'));
                }
            }
        });
    }

 function read_person(){
        $.dialog.data('admin_gfid', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser",$da);?>',{
            id:'fuwuzhe',lock:true,opacity:0.3,width:'500px',height:'60%',
            title:'选择具体内容',
            close: function () {
            if($.dialog.data('GF_ID')>0){
                  $('#Clubadmin_admin_gfid').val($.dialog.data('GF_ID'));
                  $('#Clubadmin_admin_gfaccount').val($.dialog.data('GF_ACCOUNT'));
                  $('#Clubadmin_admin_gfnick').val($.dialog.data('GF_NAME'));
            }
        }
    });    
  } 

	
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
    $('#Clubadmin_project_list').val(we.implode(',',arr));
};
fnUpdateProject();

$(function(){
	
    // 添加项目
	var $project_box=$('#project_box');
    $('#project_add_btn').on('click', function(){
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project", array("club_id"=>get_session("club_id")));?>',{
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
	

});
 </script>
