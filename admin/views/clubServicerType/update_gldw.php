<?php
    $model->member_second_id = empty($model->member_second_id) ? 0 : $model->member_second_id;
?>
<div class="box">
    <div class="box-title c">
        <h1>
          <span>
          当前界面：首页 》管理机构 》管理类型设置 》<?=empty($model->f_id)?'添加':'编辑';?>
          </span>
        </h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table width="100%" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'member_type_id'); ?></td>
                        <td width="32%" colspan="3">
                            <?php echo $form->dropDownList($model, 'member_type_id', Chtml::listData($sign_type, 'id', 'f_ctname'), array('prompt' => '请选择', 'onchange' => 'changeType(this);'));?>
                            <select name="ClubServicerType[member_second_id]" id="clind_type">
                                <option value="">请选择</option>
                            </select>
                            <?php echo $form->error($model, 'member_type_id', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'member_second_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="12%"><?php echo $form->labelEx($model, 'if_project'); ?></td>
                        <td style="font-size:14px;">
                            <?php echo $form->radioButtonList($model, 'if_project', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'if_project'); ?>
                        </td>
                        <td width="14%"><?php echo $form->labelEx($model, 'entry_way'); ?></td>
                        <td style="font-size:14px;">
                            <?php 
                                $model->entry_way=explode(',',$model->entry_way); 
                                echo $form->checkBoxList($model, 'entry_way', Chtml::listData(BaseCode::model()->getApproveState(), 'f_id', 'F_NAME'),$htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));
                            ?>
                            <?php echo $form->error($model, 'entry_way'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="14%">
                          <?php echo $form->labelEx($model, 'renew_time'); ?>
                        </td>
                        <td width="32%">
                          <?php echo $form->textField($model, 'renew_time', array('class' => 'input-text','οnkeyup'=>"value=value.replace(/[^\d]/g,'')")); ?>
                          <?php echo $form->error($model, 'renew_time', $htmlOptions = array()); ?>
                        </td>
                        <td width="12%">
                          <?php echo $form->labelEx($model, 'renew_notice_time'); ?>
                        </td>
                        <td width="42%">
                          <?php echo $form->textField($model, 'renew_notice_time', array('class' => 'input-text')); ?><?php echo $form->error($model, 'renew_notice_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="12%"><?php echo $form->labelEx($model, 'is_show'); ?></td>
                        <td colspan="3">
                            <?php echo $form->radioButtonList($model, 'is_show', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'is_show'); ?>
                        </td>
                    </tr>
                </table>
                <table style="table-layout:auto; margin-top:10px; ">
                    <tr>
                        <td width="14%">可执行操作</td>
                        <td colspan="3">
                            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div> <!--box-detail-tab-item end-->
        </div> <!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div> <!--box-detail end-->
</div> <!--box end-->
<script>

  //单位类型二级联动下拉菜单
  changeType($('#ClubServicerType_member_type_id'));

  function changeType(obj) {
    var show_id = $(obj).val();
    var p_html = '<option value="">请选择</option>';
    $.ajax({
      type: 'post',
      url: '<?php echo $this->createUrl('getType'); ?>',
      data: {id: show_id},
      dataType: 'json',
      success: function(data) {
        console.log(data)
        for (var i = 0; i < data.length; i++) {
          p_html += '<option  value="' + data[i]['id'] + '"';
          if (data[i]['id'] == "<?php echo $model->member_second_id; ?>") {
            p_html += 'selected';
          }
          p_html += '>' + data[i]['f_ctname'] + '</option>';
        }
        $("#clind_type").html(p_html);
      }
    });
  }

  //选择资质要求
  var $certificate_box=$('#certificate_box');
  $('#certificate_select_btn').on('click', function(){
    $.dialog.data('id', 0);
    $.dialog.open('<?php echo $this->createUrl("select/servicerCertificate");?>',{
    id:'zizhi',
    lock:true,opacity:0.3,
    width:'500px',
    height:'60%',
    title:'选择具体内容',		
    close: function () {
        if($.dialog.data('id')>0){
          if($('#classify_item_'+$.dialog.data('id')).length==0){
            $certificate_box.append('<span class="label-box" id="classify_item_'+$.dialog.data('id')+'" data-id="'+$.dialog.data('id')+'">'+$.dialog.data('f_name')+'<i onclick="fnDeleteClassify(this);"></i></span>');
            fnUpdateClassify();
          }
        }
      }
    });
  });

  var fnDeleteClassify=function(op){
    $(op).parent().remove();
    fnUpdateClassify();
  };
  // 删除分类
  var $ClubServicerType_certificate_type=$('#ClubServicerType_certificate_type');
  var fnUpdateClassify=function(){
      var arr=[];
      var id;
      $certificate_box.find('span').each(function(){
          id=$(this).attr('data-id');
          arr.push(id);
      });
      $ClubServicerType_certificate_type.val(we.implode(',', arr));
  };
</script>