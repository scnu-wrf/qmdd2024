<?php
    $model->member_second_id = empty($model->member_second_id) ? 0 : $model->member_second_id;
?>
<div class="box">
    <div class="box-title c">
        <h1>
          <span>
            当前界面：系统 》服务者设置 》服务者类型设置 》<?=empty($model->f_id)?'添加':'编辑';?>
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
                        <?php echo $form->hiddenField($model, 'type', array('class' => 'input-text','value' => 501)); ?>
                    </tr>
                    <tr>
                        <td>
                          <?php echo $form->labelEx($model, 'member_type_id'); ?>
                        </td>
                        <td width="32%">
                          <?php echo $form->dropDownList($model, 'member_type_id', Chtml::listData($sign_type, 'id', 'f_ctname'), array('prompt' => '请选择', 'onchange' => 'changeType(this);'));?>
                          <select name="ClubServicerType[member_second_id]" id="clind_type">
                              <option value="">请选择</option>
                          </select>
                          <?php echo $form->error($model, 'member_type_id', $htmlOptions = array()); ?>
                          <?php echo $form->error($model, 'member_second_id', $htmlOptions = array()); ?>
                        </td>
                        <td width="12%">
                          <?php echo $form->labelEx($model, 'code'); ?>
                        </td>
                        <td width="42%">
                          <?php echo $form->textField($model, 'code', array('class' => 'input-text')); ?><?php echo $form->error($model, 'code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="14%"><?php echo $form->labelEx($model, 'entry_way'); ?></td>
                        <td style="font-size:14px;">
                          <?php echo $form->radioButtonList($model, 'entry_way', Chtml::listData(BaseCode::model()->getApproveState(), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                          <?php echo $form->error($model, 'entry_way'); ?>
                        </td>
                        <td width="12%"><?php echo $form->labelEx($model, 'if_project'); ?></td>
                        <td style="font-size:14px;">
                          <?php echo $form->radioButtonList($model, 'if_project', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                          <?php echo $form->error($model, 'if_project'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="14%">
                          <?php echo $form->labelEx($model, 'renew_time'); ?>
                        </td>
                        <td width="32%">
                          <?php echo $form->textField($model, 'renew_time', array('class' => 'input-text')); ?>
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
                        <td width="14%"><?php echo $form->labelEx($model, 'certificate_type'); ?></td>
                        <td colspan="3" width="86%">
                          <?php echo $form->hiddenField($model, 'certificate_type', array('class' => 'input-text')); ?>
                            <span id="certificate_box">
                              <?php if(!empty($model->certificate_type)) { ?>
                                  <?php
                                    $c_ty='';
                                    $certificate=ServicerCertificate::model()->findAll('id in('.$model->certificate_type.')');
                                    foreach($certificate as $b){
                                      $c_ty.='<span class="label-box" id="classify_item_'.$b->id.'" data-id="'.$b->id.'">'.$b->f_name.'<i onclick="fnDeleteClassify(this);"></i></span>';
                                    }
                                    echo $c_ty;
                                  ?>
                              <?php } ?>
                            </span>
                            <input id="certificate_select_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'certificate_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'is_club_qualification'); ?></td>
                        <td colspan="3"><?php echo $form->radioButtonList($model, 'is_club_qualification', array(0 => '否', 1 => '是'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'is_club_qualification'); ?></td>
                    </tr>
                </table>
                <table width="100%" style="table-layout:auto; margin-top:10px; ">
                    <tr class="table-title">
                        <td colspan="4">挂靠战略伙伴设置</td>
                    </tr>
                    <tr>
                        <td width="14%"><?php echo $form->labelEx($model, 'is_rely_on_partner'); ?></td>
                        <td width="86%" colspan="3"><?php echo $form->radioButtonList($model, 'is_rely_on_partner', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'is_rely_on_partner'); ?></td>
                    </tr>
                    <tr>
                        <td width="14%"><?php echo $form->labelEx($model, 'is_rely_on_partner_by_project'); ?></td>
                        <td width="86%" colspan="3"><?php echo $form->radioButtonList($model, 'is_rely_on_partner_by_project', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'is_rely_on_partner_by_project'); ?></td>
                    </tr>
                    <tr>
                        <td width="14%"><?php echo $form->labelEx($model, 'rely_on_partner_number'); ?></td>
                        <td width="86%" colspan="3"><?php echo $form->radioButtonList($model, 'rely_on_partner_number', array(0 => '挂靠1个战略伙伴', 1 => '挂靠多个战略伙伴'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'rely_on_partner_number'); ?></td>
                    </tr>
                </table>
                <table width="100%" style="table-layout:auto; margin-top:10px; ">
                    <tr class="table-title">
                        <td colspan="4">挂靠社区单位设置</td>
                    </tr>
                    <tr>
                        <td width="14%"><?php echo $form->labelEx($model, 'is_rely_on_community'); ?></td>
                        <td width="86%" colspan="3"><?php echo $form->radioButtonList($model, 'is_rely_on_community', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'is_rely_on_community'); ?></td>
                    </tr>
                    <tr>
                        <td width="14%"><?php echo $form->labelEx($model, 'is_rely_on_community_by_project'); ?></td>
                        <td width="86%" colspan="3"><?php echo $form->radioButtonList($model, 'is_rely_on_community_by_project', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'is_rely_on_community_by_project'); ?></td>
                    </tr>
                    <tr>
                        <td width="14%"><?php echo $form->labelEx($model, 'rely_on_community_number'); ?></td>
                        <td width="86%" colspan="3"><?php echo $form->radioButtonList($model, 'rely_on_community_number', array(0 => '挂靠1个社区单位', 1 => '挂靠多个社区单位'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'rely_on_community_number'); ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
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