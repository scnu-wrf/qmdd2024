<?php
    $model->member_second_id = empty($model->member_second_id) ? 0 : $model->member_second_id;
?>
<div class="box">
    <div class="box-title c">
        <h1>
          <span>
          当前界面：会员 》龙虎会员管理 》龙虎会员等级设置 》<?=empty($model->id)?'添加':'编辑';?>
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
                        <td width="150px">
                          <?php echo $form->labelEx($model, 'member_type_id'); ?>
                        </td>
                        <td colspan="3">
                          <?php echo $form->dropDownList($model, 'member_type_id', Chtml::listData($sign_type, 'id', 'f_ctname'), array('prompt' => '请选择', 'onchange' => 'changeType(this);'));?>
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
                            <?php //echo $form->dropDownList($model, 'entry_way', Chtml::listData(BaseCode::model()->getApproveState(), 'f_id', 'F_NAME'), array('prompt' => '请选择', 'onchange' => 'changeType(this);'));?>
                            <select name="ServicerLevel[entry_way]" id="ServicerLevel_entry_way">
                                <option value="">请选择</option>
                            </select>
                            <?php echo $form->error($model, 'entry_way', $htmlOptions = array()); ?>
                        </td>
                    </!-->
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
  $(function(){
    changeType($('#ServicerLevel_member_type_id'));
  })
  
  var datas=[];
  function changeType(obj) {
    var show_id = $(obj).val();
    var p_html = '<option value="">请选择</option>';
    $.ajax({
      type: 'post',
      url: '<?php echo $this->createUrl('getType'); ?>',
      data: {id: show_id},
      dataType: 'json',
      success: function(data) {
        datas=data;
        console.log(datas)
        for (var i = 0; i < data.length; i++) {
          p_html += '<option  value="' + data[i]['id'] + '"';
          if (data[i]['id'] == "<?php echo $model->member_second_id; ?>") {
            p_html += 'selected';

            var content = '<option value="">请选择</option>';
            if(data[i]['entry_way']){
                $.each(data[i]['entry_way'].split(','),function(m,n){
                    $.each(data[i]['entry_way_name'].split('/'),function(a,b){
                        if(m==a){
                            content+='<option value="'+n+'" ';
                            if(n == '<?php echo $model->entry_way; ?>'){
                                content+='selected ';
                            }
                            content+='>'+b+'</option>';
                        }
                    })
                })
            }
            $("#ServicerLevel_entry_way").html(content);
          }
          p_html += '>' + data[i]['f_ctname'] + '</option>';
        }
        $("#clind_type").html(p_html);
      }
    });
  }
  $("#clind_type").on("change",function(){
    var th =$(this);
    var content = '<option value="">请选择</option>';
    $.each(datas,function(k,info){
        if(info.id==th.val()){
            if(info.entry_way){
                $.each(info.entry_way.split(','),function(m,n){
                    $.each(info.entry_way_name.split('/'),function(a,b){
                        if(m==a){
                            content+='<option value="'+n+'">'+b+'</option>';
                        }
                    })
                })
            }
        }
    })
    $("#ServicerLevel_entry_way").html(content);
  })

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
  var $ServicerLevel_certificate_type=$('#ServicerLevel_certificate_type');
  var fnUpdateClassify=function(){
      var arr=[];
      var id;
      $certificate_box.find('span').each(function(){
          id=$(this).attr('data-id');
          arr.push(id);
      });
      $ServicerLevel_certificate_type.val(we.implode(',', arr));
  };
</script>