<?php $model->member_second_id = empty($model->member_second_id) ? 0 : $model->member_second_id; ?>
<div class="box">
  <div class="box-title c">
    <h1>
      <span>
        当前界面：服务者 》服务者设置 》服务者等级设置 》<?= empty($model->id) ? '添加' : '编辑'; ?>
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
            <td>
              <?php echo $form->labelEx($model, 'member_type_id'); ?>
            </td>
            <td colspan="3">
              <?php echo $form->dropDownList($model, 'member_type_id', Chtml::listData($sign_type, 'id', 'f_ctname'), array('prompt' => '请选择', 'onchange' => 'changeType(this);')); ?>
              <select name="ServicerLevel[member_second_id]" id="clind_type">
                <option value="">请选择</option>
              </select>
              <?php echo $form->error($model, 'member_type_id', $htmlOptions = array()); ?>
              <?php echo $form->error($model, 'member_second_id', $htmlOptions = array()); ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $form->labelEx($model, 'entry_way'); ?>
            </td>
            <td>
              <?php echo $form->dropDownList($model, 'entry_way', Chtml::listData(BaseCode::model()->getPaytype(452), 'f_id', 'F_NAME'), array('prompt' => '请选择', 'onchange' => 'changeType(this);')); ?>
              <?php echo $form->error($model, 'entry_way', $htmlOptions = array()); ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $form->labelEx($model, 'renew_time'); ?>
            </td>
            <td>
              <?php echo $form->textField($model, 'renew_time', array('class' => 'input-text')); ?>
              <?php echo $form->error($model, 'renew_time', $htmlOptions = array()); ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $form->labelEx($model, 'card_name'); ?>
            </td>
            <td>
              <?php echo $form->textField($model, 'card_name', array('class' => 'input-text')); ?>
              <?php echo $form->error($model, 'card_name', $htmlOptions = array()); ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $form->labelEx($model, 'card_score'); ?>
            </td>
            <td>
              <?php echo $form->textField($model, 'card_score', array('class' => 'input-text')); ?>
              <?php echo $form->error($model, 'card_score', $htmlOptions = array()); ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $form->labelEx($model, 'card_end_score'); ?>
            </td>
            <td>
              <?php echo $form->textField($model, 'card_end_score', array('class' => 'input-text')); ?>
              <?php echo $form->error($model, 'card_end_score', $htmlOptions = array()); ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $form->labelEx($model, 'card_xh'); ?>
            </td>
            <td>
              <?php echo $form->textField($model, 'card_xh', array('class' => 'input-text')); ?>
              <?php echo $form->error($model, 'card_xh', $htmlOptions = array()); ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $form->labelEx($model, 'card_level'); ?>
            </td>
            <td>
              <?php echo $form->textField($model, 'card_level', array('class' => 'input-text')); ?>
              <?php echo $form->error($model, 'card_level', $htmlOptions = array()); ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $form->labelEx($model, 'certificate_type'); ?></td>
            <td colspan="3" width="86%">
              <?php echo $form->hiddenField($model, 'certificate_type', array('class' => 'input-text')); ?>
              <span id="certificate_box">
                <?php if (!empty($model->certificate_type)) { ?>
                <?php
                  $c_ty = '';
                  $certificate = ServicerCertificate::model()->findAll('id in(' . $model->certificate_type . ')');
                  foreach ($certificate as $b) {
                    $c_ty .= '<span class="label-box" id="classify_item_' . $b->id . '" data-id="' . $b->id . '">' . $b->f_name . '<i onclick="fnDeleteClassify(this);"></i></span>';
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
            <td><?php echo $form->labelEx($model, 'card_level_logo'); ?></td>
            <td id="dpic_card_level_logo">
                <?php
                    echo $form->hiddenField($model, 'card_level_logo', array('class' => 'input-text fl'));
                    $basepath=BasePath::model()->getPath(302);$picprefix='';
                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                    if($model->card_level_logo!=''){
                ?>
                <div class="upload_img fl" id="upload_pic_ServicerLevel_card_level_logo">
                    <a href="<?php echo $basepath->F_WWWPATH.$model->card_level_logo;?>" target="_blank">
                        <img src="<?php echo $basepath->F_WWWPATH.$model->card_level_logo;?>" width="100">
                    </a>
                </div>
                <?php }?>
                <script>we.uploadpic('<?php echo get_class($model);?>_card_level_logo','<?php echo $picprefix;?>');</script>
                <?php echo $form->error($model, 'card_level_logo', $htmlOptions = array()); ?>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">
              <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
              <button class="btn" type="button" onclick="we.back();">取消</button>
            </td>
          </tr>
        </table>
      </div>
      <!--box-detail-tab-item end-->
    </div>
    <!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
  </div>
  <!--box-detail end-->
</div>
<!--box end-->
<script>
  //单位类型二级联动下拉菜单
  changeType($('#ServicerLevel_member_type_id'));

  var datas = [];

  function changeType(obj) {
    var show_id = $(obj).val();
    var p_html = '<option value="">请选择</option>';
    $.ajax({
      type: 'post',
      url: '<?php echo $this->createUrl('getType'); ?>',
      data: {
        id: show_id
      },
      dataType: 'json',
      success: function(data) {
        console.log(data)
        datas = data;
        for (var i = 0; i < data.length; i++) {
          p_html += '<option  value="' + data[i]['id'] + '"';
          if (data[i]['id'] == "<?php echo $model->member_second_id; ?>") {
            p_html += 'selected';
            $("#ServicerLevel_entry_way").val(data[i]['entry_way']);
            $("#account_box span").html(data[i]['entry_way_name']);
          }
          p_html += '>' + data[i]['f_ctname'] + '</option>';
        }
        $("#clind_type").html(p_html);
      }
    });
  }
  $("#clind_type").on("change", function() {
    var th = $(this);
    $.each(datas, function(k, info) {
      if (info.id == th.val()) {
        $("#ServicerLevel_entry_way").val(info.entry_way);
        $("#account_box span").html(info.entry_way_name);
      }
    })
  })

  //选择资质要求
  var $certificate_box = $('#certificate_box');
  $('#certificate_select_btn').on('click', function() {
    $.dialog.data('id', 0);
    $.dialog.open('<?php echo $this->createUrl("select/servicerCertificate"); ?>', {
      id: 'zizhi',
      lock: true,
      opacity: 0.3,
      width: '500px',
      height: '60%',
      title: '选择具体内容',
      close: function() {
        if ($.dialog.data('id') > 0) {
          if ($('#classify_item_' + $.dialog.data('id')).length == 0) {
            $certificate_box.append('<span class="label-box" id="classify_item_' + $.dialog.data('id') + '" data-id="' + $.dialog.data('id') + '">' + $.dialog.data('f_name') + '<i onclick="fnDeleteClassify(this);"></i></span>');
            fnUpdateClassify();
          }
        }
      }
    });
  });

  var fnDeleteClassify = function(op) {
    $(op).parent().remove();
    fnUpdateClassify();
  };
  // 删除分类
  var $ServicerLevel_certificate_type = $('#ServicerLevel_certificate_type');
  var fnUpdateClassify = function() {
    var arr = [];
    var id;
    $certificate_box.find('span').each(function() {
      id = $(this).attr('data-id');
      arr.push(id);
    });
    $ServicerLevel_certificate_type.val(we.implode(',', arr));
  };
</script>