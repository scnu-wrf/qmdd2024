<style>
    .upload_img a{
        width: 100px;
        height: 100px;
        display: inline-flex!important;
        align-items: center;
        justify-content: center;
        border: 1px solid #ccc;
    }
    .upload_img a img{
        width: auto!important;
        height:auto!important;
        max-width:100%;
        max-height:100%;
    }
    table{
        table-layout:auto!important;
    }
    table tr td:nth-child(2n+1){
        /* width:150px; */
    }
    .input-text{
        width: 90%;
        border:1px solid #ccc;
    }
  #modal {
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
  }
  #modal-image {
    display: block;
    width: 50%;
    height: auto;
    margin: auto;
    margin-top: 5%;
  }
</style>
<script>
     response.setHeader("Cache-Control", "no-cache");
    function showModal(image) {
    var modal = document.getElementById("modal");
    var modalImage = document.getElementById("modal-image");
    modal.style.display = "block";
    modalImage.src = image.src;
    console.log(image.src);
   }

   function hideModal() {
    var modal = document.getElementById("modal");
    modal.style.display = "none";
   }
</script> 
<div id="modal" onclick="hideModal()">
      <img src="" id="modal-image">
</div>

<div class="box">
    <div class="box-title c"><h1><?php if(empty($model->id)){echo '当前界面：商户管理》商户入住》商户列表》添加';}else{echo '当前界面：社区单位》意向入驻申请》详情';};?></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->

    <div class="box-detail">
       <form id="myForm"  method="post" enctype="multipart/form-data">
            <table class="mt15" id="t2">

                <tr class="table-title">
                    <td colspan="4">商户基本信息
                    </td>
                </tr>
                <tr>
                    <td >商户类型</td>
                    <td colspan="3"><?php echo $model->ct_type?></td>
                </tr>
                <?php if($model->ct_type=='企业工商户'){ ?>
                <tr >
                    <td width="10%">所属单位类型</td>
                    <td width="40%">                     
                        <input type="text" class="input-text" name="organization_type" data-title="所属单位类型" data-must="1"
                        value="<?php echo $model->organization_type?>" >
                        <div style="color:red"></div>
                    </td>
                    <td width="10%">所属单位名称</td>
                    <td width="40%">
                        <input type="text" class="input-text" name="organization_name" data-title="所属单位名称" data-must="1"
                        value="<?php echo $model->organization_name?>">
                        <div style="color:red"></div>
                    </td>
                </tr>
                <?php  } ?>
                <tr >
                    <td width="10%" rowspan="4">上传营业执照照片</td>
                    <td width="40%" rowspan="4">
                       <div style="display:inline-block;">                     
                        <input type="file" id="imageInput1" name="ct_certificates_img" accept="image/*"
                        data-title="营业执照" data-must="1">
                        <div style="color:red"></div>
                       </div>

                        <img id="imageDisplay1" src="<?php echo $model->ct_certificates_img?>" alt="上传的图片将在这里显示" style="width:50%;height: auto;" onclick="showModal(this)">
                    </td>

                   <td width="10%">商户名称</td>
                    <td width="40%">
                      <input type="text" class="input-text" name="ct_name" data-title="商户名称" data-must="1"
                      value="<?php echo $model->ct_name?>">
                      <div style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td width="10%">营业执照编号</td>
                    <td width="40%">
                      <input type="text" class="input-text" name="ct_certificates_number" data-title="营业执照编号" data-must="1"
                      value="<?php echo $model->ct_certificates_number?>">
                      <div style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td width="10%">营业执照有效期开始时间</td>
                    <td  width="40%"> 
                        <input class="input-text click_time" style="height:25px" name="ct_certificates_start" 
                        id="ct_certificates_start" type="text" 
                        value="<?php echo $model->ct_certificates_start?>" data-title="营业执照有效期开始时间"  data-must="1">
                        <div style="color:red"></div>
                    </td>
                       <script>
                       var $insure_I_end=$('#ct_certificates_start');
                      $insure_I_end.on('click', function(){
                      WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
                        });
                       </script>
                </tr>
                <tr>
                    <td width="10%">营业执照到期时间</td>
                      <td  width="40%"> 
                        <input class="input-text click_time" style="height:25px" name="ct_certificates_end" 
                        id="ct_certificates_end" type="text" placeholder="不填为长期"
                        data-title="营业执照到期时间"  data-must="1"
                        value="<?php echo $model->ct_certificates_end?>">
                        <div color="red"></div>
                    </td>
                       <script>
                       var $insure_I_end=$('#ct_certificates_end');
                      $insure_I_end.on('click', function(){
                      WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
                        });
                       </script>
                </tr>

                <tr>
                    <td width="10%" rowspan="3">银行开户许可证照片</td>
                    <td width="40%" rowspan="3">
                      <div style="display:inline-block;">                         
                        <input type="file" id="imageInput2" name="ct_bank_pic"  data-title="银行开户许可证照片"  data-must="1">
                        <div style="color:red"></div>
                     </div>
                        <img id="imageDisplay2" src="<?php echo $model->ct_bank_pic?>" alt="上传的图片将在这里显示" style="width:50%;height: auto;"    >
                    </td>                
                    <td width="10%">开户名称</td>
                    <td width="40%">
                        <input type="text" class="input-text" name="ct_bank_name" data-title="开户名称"  data-must="1"
                        value="<?php echo $model->ct_bank_name?>">
                        <div style="color:red"></div>
                    </td>
                </tr>

                <tr>
                    <td width="10%">开户支行名称</td>
                    <td width="40%">
                      <input type="text" class="input-text" name="ct_bank_branch_name" data-title="开户支行名称"  data-must="1"
                      value="<?php echo $model->ct_bank_branch_name?>">
                      <div style="color:red"></div>
                    </td>
                </tr>   
                <tr>
                    <td width="10%">银行账号</td>
                    <td width="40%">
                       <input type="text" class="input-text" name="ct_bank_account" data-title="银行账号"  data-must="1"
                       value="<?php echo $model->ct_bank_account?>">
                       <div style="color:red"></div>
                    </td>
                </tr>   
             <tr>
                    <td rowspan="2">商户地址</td>
                    <td colspan="3" id="city">
                        <?php  $disabled='';
                        if(!empty($model->ct_area_code)){$area=explode(',',$model->ct_area_code);foreach($area as $h){?>
                            <?php

                                $t_region=TRegion::model()->find('id='.$h);
                                $text='';
                                if($t_region->level==1){
                                    $t1=$t_region->id;
                                    $tRegion=TRegion::model()->findAll('level=1');
                                    $option='';
                                    foreach($tRegion as $tion){
                                        $selected=$t_region->id==$tion->id?'selected="selected"':'';
                                        $option.='<option value="'.$tion->id.'" '.$selected.'>'.$tion->region_name_c.'</option>';
                                    }
                                    $text.= '<select name="area[1][ct_area_code]" id="ClubList_club_area_code1" onchange="showArea(this)" value="1" '.$disabled.' style="margin-right:10px;"><option value="">请选择</option>'.$option.'</select>';
                                }elseif($t_region->level==2){
                                    $t2=$t_region->id;
                                    $tRegion2=TRegion::model()->findAll('upper_region='.$t1.' and level=2');
                                    $option='';
                                    foreach($tRegion2 as $tion){
                                        $selected=$t_region->id==$tion->id?'selected="selected"':'';
                                        $option.='<option value="'.$tion->id.'" '.$selected.'>'.$tion->region_name_c.'</option>';
                                    }
                                    $text.= '<select name="area[2][ct_area_code]" id="ClubList_club_area_code2" onchange="showArea(this)" value="2" '.$disabled.' style="margin-right:10px;"><option value="">请选择</option>'.$option.'</select>';
                                }elseif($t_region->level==3){
                                    $t3=$t_region->id;
                                    if(empty($t2)){
                                        $tRegion3=TRegion::model()->findAll('upper_region='.$t1.' and level=3');
                                    }else{
                                        $tRegion3=TRegion::model()->findAll('upper_region='.$t2.' and level=3');
                                    }
                                    $option='';
                                    foreach($tRegion3 as $tion){
                                        $selected=$t_region->id==$tion->id?'selected="selected"':'';
                                        $option.='<option value="'.$tion->id.'" '.$selected.'>'.$tion->region_name_c.'</option>';
                                    }
                                    $text.= '<select name="area[3][ct_area_code]" id="ClubList_club_area_code3" onchange="showArea(this)" value="3" '.$disabled.' style="margin-right:10px;"><option value="">请选择</option>'.$option.'</select>';
                                }elseif($t_region->level==4){
                                    $t4=$t_region->id;
                                    if(!empty($t3)){
                                        $tRegion4=TRegion::model()->findAll('upper_region='.$t3.' and level=4');
                                    }else{
                                        $tRegion4=TRegion::model()->findAll('upper_region='.$t2.' and level=4');
                                    }
                                    $option='';
                                    foreach($tRegion4 as $tion){
                                        $selected=$t_region->id==$tion->id?'selected="selected"':'';
                                        $option.='<option value="'.$tion->id.'" '.$selected.'>'.$tion->region_name_c.'</option>';
                                    }
                                    $text.= '<select name="area[4][ct_area_code]" id="ClubList_club_area_code4" onchange="showArea(this)" value="4" '.$disabled.' style="margin-right:10px;"><option value="">请选择</option>'.$option.'</select>';
                                }
                                echo $text;
                            ?>
                        <?php }}else{?>
                            <?php $area=explode(',',$model->ct_area_code);foreach($area as $h){?>
                            <?php 
                                $text='';
                                $tRegion=TRegion::model()->findAll('level=1');
                                $option='';
                                foreach($tRegion as $tion){
                                    $option.='<option value="'.$tion->id.'">'.$tion->region_name_c.'</option>';
                                }
                                $text.= '<select name="area[1][ct_area_code]" id="ClubList_club_area_code1" onchange="showArea(this)" value="1" '.$disabled.' style="margin-right:10px;"><option value="">请选择</option>'.$option.'</select>';
                                echo $text;
                            ?>
                            <?php }?>
                        <?php }?>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <input type="text" class="input-text" name="ct_address" value="<?php echo $model->ct_address?>">
                    </td>
                </tr>
                <tr class="table-title">
                    <td colspan="4">商户<?php echo $model->ct_type=='企业工商户'?'法人':'经营者'?>基本信息</td>
                </tr>
                <tr >
                    <td width="10%" >身份证正面</td>
                    <td width="40%">
                    <div style="display:inline-block;">                         
                        <input type="file" id="imageInput3" name="ct_legal_entity_idCardFront" data-title="身份证正面"  data-must="1">
                        <div style="color:red"></div>
                    </div>
                        <img id="imageDisplay3" src="<?php echo $model->ct_legal_entity_idCardFront?>" alt="上传的图片将在这里显示" style="width:50%;height: auto;" onclick="showModal(this)"
                        >
                    </td>
                   <td width="10%">身份证背面</td>
                    <td width="40%">
                    <div style="display:inline-block;">    
                        <input type="file" id="imageInput4" name="ct_legal_entity_idCardBack" data-title="身份证背面"  data-must="1">
                        <div style="color:red"></div>
                   </div>
                        <img id="imageDisplay4" src="<?php echo $model->ct_legal_entity_idCardBack?>" alt="上传的图片将在这里显示" style="width:50%;height: auto;" onclick="showModal(this)"
                        >
                    </td>
                </tr>                

                 <tr >
                    <td width="10%">名称</td>
                    <td width="40%">                     
                      <input type="text" class="input-text" name="ct_legal_entity_name" data-title="姓名"  data-must="1"
                      value="<?php echo $model->ct_legal_entity_name?>">
                      <div style="color:red"></div>
                    </td>
                    <td width="10%">身份证号</td>
                    <td width="40%">
                      <input type="text" class="input-text" name="ct_legal_entity_idCardNumber" data-title="身份证号"  data-must="1" value="<?php echo $model->ct_legal_entity_idCardNumber?>">
                      <div style="color:red"></div>
                    </td>
                </tr>
              <tr >
                    <td width="10%">联系电话</td>
                    <td width="40%">                     
                      <input type="text" class="input-text" name="ct_legal_entity_phone" data-title="联系电话"  data-must="1"
                      value="<?php echo $model->ct_legal_entity_phone?>">
                      <div style="color:red"></div>
                    </td>
                    <td width="10%">电子邮箱</td>
                    <td width="40%">
                      <input type="text" class="input-text email-input" name="ct_legal_entity_email" data-title="电子邮箱"  data-must="1" value="<?php echo $model->ct_legal_entity_email?>">
                      <div class="email-feedback" style="color: red;"></div>
                    </td>
                </tr> 
                <tr class="table-title">
                    <td colspan="4">商户联系人基本信息</td>
                </tr>  
                <tr >
                    <td width="10%" >身份证正面</td>
                    <td width="40%">
                    <div style="display:inline-block;">             
                        <input type="file" id="imageInput5" name="ct_connector_idCardFront" data-title="联系人身份证正面"  data-must="1">
                        <div style="color:red"></div>
                    </div>
                        <img id="imageDisplay5" src="<?php echo $model->ct_connector_idCardFront?>" alt="上传的图片将在这里显示" style="width:50%;height: auto;" onclick="showModal(this)">

                    </td>
                   <td width="10%">身份证背面</td>
                    <td width="40%">
                    <div style="display:inline-block;">    
                        <input type="file" id="imageInput6" name="ct_connector_idCardBack" data-title="联系人身份证背面"  data-must="1">
                        <div style="color:red"></div>
                    </div>
                        <img id="imageDisplay6" src="<?php echo $model->ct_connector_idCardBack?>" alt="上传的图片将在这里显示" style="width:50%;height: auto;" onclick="showModal(this)">
                    </td>
                </tr>                

                 <tr >
                    <td width="10%">联系人名称</td>
                    <td width="40%">                     
                      <input type="text" class="input-text" name="ct_connector_name" data-title="联系人名称"  data-must="1"
                      value="<?php echo $model->ct_connector_name?>">
                      <div style="color:red"></div>
                    </td>
                    <td width="10%">联系人身份证号</td>
                    <td width="40%">
                      <input type="text" class="input-text" name="ct_connector_idCardNumber" data-title="联系人身份证号"  data-must="1" value="<?php echo $model->ct_connector_idCardNumber?>">
                      <div style="color:red"></div>
                    </td>
                </tr>
                <tr >
                    <td width="10%">联系人联系电话</td>
                    <td width="40%">                     
                      <input type="text" class="input-text" name="ct_connector_phone" data-title="联系人电话"  data-must="1"
                      value="<?php echo $model->ct_connector_phone?>">
                      <div style="color:red"></div>
                    </td>
                    <td width="10%">联系人电子邮箱</td>
                    <td width="40%">
                      <input type="text" class="input-text email-input" name="ct_connector_email" data-title="联系人电子邮箱"  data-must="1"
                      value="<?php echo $model->ct_connector_email?>">
                      <div style="color:red"></div>
                      <div class="email-feedback" style="color: red;"></div>
                    </td>
                </tr>     
               <tr class="table-title">
                    <td colspan="4">操作</td>
                </tr>  
                <tr>
                    <td width='10%'>可执行操作</td>
                    <td colspan="3">
                        <input type="submit" value="保存" onclick="return check(1)" class="btn" style="background-color:#368ee0;color:white;">
                        <input type="submit" value="提交审核" onclick="return check(2)" class="btn" style="background-color:#368ee0;color:white;">
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>                                               
            </table>


    <script>
        function submitForm(mode,url) {
            // 获取表单数据
            var formData = $('#myForm').serialize();
            
            // 发送 AJAX 请求
            $.ajax({
                type: 'POST',  // 可根据需要使用 POST 或 GET
                url: '/sports/admin/qmdd2018/index.php?r=commercialTenant/updateEnterprise&id=<?php echo $model->id?>&mode='+mode,  // 替换为实际的处理脚本地址
                data: formData,
                success: function(response) {
                    // 处理成功的响应
                    window.location.href = '/sports/admin/qmdd2018/index.php?r=commercialTenant/'+url;
                },
                error: function(error) {
                    // 处理错误的响应
                    console.error('提交出错');
                    console.error(error);
                }
            });
        }
    </script>
<script type="text/javascript">
    function check(mode){
        // var s="";
        // var inputElements = document.getElementsByTagName("input");

        // // 遍历所有的 input 元素
        // for (var i = 0; i < inputElements.length; i++) {
        //      var inputElement = inputElements[i];
             
        //      var MustValue = inputElement.getAttribute("data-must");
        //      var type=inputElement.type;
        //      var nextDiv = inputElement.nextElementSibling;
        //     if (MustValue !== null&&type=="text") {
        //       var value=inputElement.value;
        //       if(value==null || value==""){
        //         s+=inputElement.getAttribute("data-title")+"不能为空\n";
        //         nextDiv.textContent = inputElement.getAttribute("data-title")+"不能为空";
        //      }else if(nextDiv.textContent!="邮箱格式不正确"){
        //         nextDiv.textContent = '';
        //      }
        //     }
        //     if (MustValue !== null&&type=="file") {
        //       if(inputElement.files.length==0){
        //         s+=inputElement.getAttribute("data-title")+"不能为空\n";
        //          nextDiv.textContent = inputElement.getAttribute("data-title")+"不能为空";
        //      }else{
        //         nextDiv.textContent = '';
        //      }
        //     }
        // }
        // if(s.length!=0){
        //      alert(s);
        //   return false;
        // }
        // return true;
        if(mode==1)
          submitForm(1,'index');
        else if(mode==2){
            var result = confirm("确定提交审核？");
            // 根据用户的选择执行不同的操作
            if (result) {
                console.log("审核");
                submitForm(2,'auditIndex');
            }else{
               console.log("到这");
               return false;
            }
        }
    }
</script>


       </form>
    </div><!--box-detail end-->
</div><!--box end-->
<script type="text/javascript">
document.querySelectorAll('.email-input').forEach(function(input) {
    input.addEventListener('blur', function() {
        var email = this.value;
        var feedbackElement = this.nextElementSibling; // 假设 feedback 元素紧跟在输入框后面

        if (validateEmail(email)) {
            feedbackElement.textContent = '邮箱格式正确';
            feedbackElement.style.color = 'green';
        } else {
            feedbackElement.textContent = '邮箱格式不正确';
            feedbackElement.style.color = 'red';
        }
    });
});

function validateEmail(email) {
    var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return regex.test(email);
}

</script> 
<script>

  document.getElementById('imageInput1').addEventListener('change', function(event) {
     var file = event.target.files[0];
     var reader = new FileReader();

     reader.onload = function(e) {
         document.getElementById('imageDisplay1').src = e.target.result;
         document.getElementById('imageDisplay1').style.display="inline-block";
     };

     reader.readAsDataURL(file);
  });
//上传图片后显示图片
for(let i=1;i<=6;i++){
  document.getElementById('imageInput'+i).addEventListener('change', function(event) {
    var file = event.target.files[0];
    var reader = new FileReader();
    
    reader.onload = function(e) {
        document.getElementById('imageDisplay'+i).src = e.target.result;
        document.getElementById('imageDisplay'+i).style.display="inline-block";
    };

    reader.readAsDataURL(file);
});
}



var club_id=0;


//城市联动
    function showArea(obj){
        var show_id=$(obj).val();
        console.log(show_id);
        if($(obj).attr("value")==1){
            $("#ClubList_club_area_code2,#ClubList_club_area_code3,#ClubList_club_area_code4").remove();
            $("#ClubListSqdw_club_area_city,#ClubListSqdw_club_area_district,#ClubListSqdw_club_area_township").val('');
            $("#ClubListSqdw_club_area_province").val($(obj).find("option[value='"+show_id+"']").text());
        }else if($(obj).attr("value")==2){
            $("#ClubList_club_area_code3,#ClubList_club_area_code4").remove();
            $("#ClubListSqdw_club_area_district,#ClubListSqdw_club_area_township").val('');
            $("#ClubListSqdw_club_area_city").val($(obj).find("option[value='"+show_id+"']").text());
        }else if($(obj).attr("value")==3){
            $("#ClubList_club_area_code4").remove();
            $("#ClubListSqdw_club_area_township").val('');
            $("#ClubListSqdw_club_area_district").val($(obj).find("option[value='"+show_id+"']").text());
        }else if($(obj).attr("value")==4){
            $("#ClubListSqdw_club_area_township").val($(obj).find("option[value='"+show_id+"']").text());
        }
        var area_arr=[];
        $("#city select").each(function(){
            area_arr.push($(this).val());
        })
        $("#ClubListSqdw_club_area_code").val(area_arr.join(","))
        if(show_id>0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('scales');?>&info_id='+show_id,
                dataType: 'json',
                success: function(data) {
                    var content='';
                    if(data[0].level==2){
                        $("#city").append('<select name="area[2][ct_area_code]" id="ClubList_club_area_code2" onchange="showArea(this)" value="2" style="margin-right:10px;"><option value="">请选择</option></select>');
                        $.each(data,function(k,info){
                            if(info.level==2){
                                content+='<option value="'+info.id+'">'+info.region_name_c+'</option>'
                            }
                        })
                        $("#ClubList_club_area_code2").append(content);
                    }else if(data[0].level==3){
                        $("#city").append('<select name="area[3][ct_area_code]" id="ClubList_club_area_code3" onchange="showArea(this)" value="3" style="margin-right:10px;"><option value="">请选择</option></select>');
                        $.each(data,function(k,info){
                            if(info.level==3){
                                content+='<option value="'+info.id+'">'+info.region_name_c+'</option>'
                            }
                        })
                        $("#ClubList_club_area_code3").append(content);
                    }else if(data[0].level==4){
                        $("#city").append('<select name="area[4][ct_area_code]" id="ClubList_club_area_code4" onchange="showArea(this)" value="4" style="margin-right:10px;"><option value="">请选择</option></select>');
                        $.each(data,function(k,info){
                            if(info.level==4){
                                content+='<option value="'+info.id+'">'+info.region_name_c+'</option>'
                            }
                        })
                        $("#ClubList_club_area_code4").append(content);
                    }
                }
            });
        }
    }
</script>
