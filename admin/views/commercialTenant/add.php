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
/*    .coverOut{
        width: 100%;
        height:10000px;
        background-color:black;
        opacity: 0.3;
        overflow: hidden;
        position: fixed;
    }
    .coverIn{
        background-color: white;
        opacity: 1;
    }
    #coverImg{
        width: 50%;
        height: 50%;
    }*/
</style>
<!-- <div class="coverOut">
     <div class="coverIn">
        <img src="uploads/image/basketBall.jpg" id="coverImg">
     </div>
</div> -->
<?php $_REQUEST['flat_type']=empty($_REQUEST['flat_type'])?$model->individual_enterprise:$_REQUEST['flat_type']; ?>
<div class="box">
    <div class="box-title c"><h1><?php if(empty($model->id)){echo '当前界面：商户管理》商户入住》商户列表》添加';}else{echo '当前界面：社区单位》意向入驻申请》详情';};?></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->

    <div class="box-detail">
        <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="<?php echo $type==0?'current':'';?>"><a href="<?php echo $this->createUrl('add&mode=0&type=0',array('flat_type'=>403));?>">个人工商户</a></li>
                <li class="<?php echo $type==1?'current':'';?>"><a href="<?php echo $this->createUrl('add&mode=0&type=1',array('flat_type'=>404));?>">企业工商户</a></li>
            </ul>
        </div>
        <style type="text/css">
            .star{
                width: 7px;
                height: auto;
                margin-left: 2px;
            }
        </style>
       <form id="myForm"  method="post" enctype="multipart/form-data">
            <table class="mt15" id="t2">
                <tr class="table-title">
                    <td colspan="4">商户基本信息
                    </td>
                </tr>
                <input type="text" name="ct_type" value="<?php echo $type==0?'个体工商户':'企业工商户'?>" hidden>
                <?php if($type==1){?> 
                <tr >
                    <td width="10%">所属单位类型</td>
                    <td width="40%">                     
                        <input type="text" class="input-text" name="organization_type" data-title="所属单位类型" data-must="1">
                        <div style="color:red"></div>
                    </td>
                    <td width="10%">所属单位名称</td>
                    <td width="40%">
                        <input type="text" class="input-text" name="organization_name" data-title="所属单位名称" data-must="1">
                        <div style="color:red"></div>
                    </td>
                </tr>
                <?php }?>
                <tr >
                    <td width="10%" rowspan="4">上传营业执照照片</td>
                    <td width="40%" rowspan="4">
                       <div style="display:inline-block;">                     
                        <input type="file" id="imageInput1" name="ct_certificates_img" accept="image/*"
                        data-title="营业执照" data-must="1">
                        <div style="color:red"></div>
                       </div>
                        <img id="imageDisplay1" src="" alt="上传的图片将在这里显示" style="width:50%;height: auto;display: none;">
                    </td>

                   <td width="10%">商户名称</td>
                    <td width="40%">
                      <input type="text" class="input-text" name="ct_name" data-title="商户名称" data-must="1">
                      <div style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td width="10%">营业执照编号</td>
                    <td width="40%">
                      <input type="text" class="input-text" name="ct_certificates_number" data-title="营业执照编号" data-must="1">
                      <div style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td width="10%">营业执照有效期开始时间</td>
                    <td  width="40%"> 
                        <input class="input-text click_time" style="height:25px" name="ct_certificates_start" 
                        id="ct_certificates_start" type="text" 
                        value="" data-title="营业执照有效期开始时间"  data-must="1">
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
                        data-title="营业执照到期时间"
                        value="">
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
                        <img id="imageDisplay2" src="" alt="上传的图片将在这里显示" style="width:50%;height: auto;display: none;">
                    </td>                
                    <td width="10%">开户名称</td>
                    <td width="40%">
                        <input type="text" class="input-text" name="ct_bank_name" data-title="开户名称"  data-must="1">
                        <div style="color:red"></div>
                    </td>
                </tr>

                <tr>
                    <td width="10%">开户支行名称</td>
                    <td width="40%">
                      <input type="text" class="input-text" name="ct_bank_branch_name" data-title="开户支行名称"  data-must="1">
                      <div style="color:red"></div>
                    </td>
                </tr>   
                <tr>
                    <td width="10%">银行账号</td>
                    <td width="40%">
                       <input type="text" class="input-text" name="ct_bank_account" data-title="银行账号"  data-must="1">
                       <div style="color:red"></div>
                    </td>
                </tr>   
             <tr>
                    <td rowspan="2">商户地址</td>
                    <td colspan="3" id="city">
                        <?php  $disabled=!empty($model->id)?'disabled="disabled"':'';
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
                                echo $t_region->level;
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
                        <input type="text" class="input-text" name="ct_address">
                    </td>
                </tr>
                <tr class="table-title">
                    <td colspan="4">商户<?php echo $type==0?'经营者':'法人' ?>基本信息</td>
                </tr>
                <tr >
                    <td width="10%" >身份证正面</td>
                    <td width="40%">
                    <div style="display:inline-block;">                         
                        <input type="file" id="imageInput3" name="ct_legal_entity_idCardFront" data-title="身份证正面"  data-must="1">
                        <div style="color:red"></div>
                    </div>
                        <img id="imageDisplay3" src="" alt="上传的图片将在这里显示" style="width:50%;height: auto;display: none;"
                        >
                    </td>
                   <td width="10%">身份证背面</td>
                    <td width="40%">
                    <div style="display:inline-block;">    
                        <input type="file" id="imageInput4" name="ct_legal_entity_idCardBack" data-title="身份证背面"  data-must="1">
                        <div style="color:red"></div>
                   </div>
                        <img id="imageDisplay4" src="" alt="上传的图片将在这里显示" style="width:50%;height: auto;display: none;"
                        >
                    </td>
                </tr>                

                 <tr >
                    <td width="10%">姓名</td>
                    <td width="40%">                     
                      <input type="text" class="input-text" name="ct_legal_entity_name" data-title="姓名"  data-must="1">
                      <div style="color:red"></div>
                    </td>
                    <td width="10%">身份证号</td>
                    <td width="40%">
                      <input type="text" class="input-text" name="ct_legal_entity_idCardNumber" data-title="身份证号"  data-must="1">
                      <div style="color:red"></div>
                    </td>
                </tr>
              <tr >
                    <td width="10%">联系电话</td>
                    <td width="40%">                     
                      <input type="text" class="input-text" name="ct_legal_entity_phone" data-title="法人联系电话"  data-must="1">
                      <div style="color:red"></div>
                    </td>
                    <td width="10%">电子邮箱</td>
                    <td width="40%">
                      <input type="text" class="input-text email-input" name="ct_legal_entity_email" data-title="法人电子邮箱"  data-must="1">
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
                        <input type="file" id="imageInput5" name="ct_connector_idCardFront" data-title="身份证正面"  data-must="1">
                        <div style="color:red"></div>
                    </div>
                        <img id="imageDisplay5" src="" alt="上传的图片将在这里显示" style="width:50%;height: auto;display: none;">

                    </td>
                   <td width="10%">身份证背面</td>
                    <td width="40%">
                    <div style="display:inline-block;">    
                        <input type="file" id="imageInput6" name="ct_connector_idCardBack" data-title="身份证背面"  data-must="1">
                        <div style="color:red"></div>
                    </div>
                        <img id="imageDisplay6" src="" alt="上传的图片将在这里显示" style="width:50%;height: auto;display: none;">
                    </td>
                </tr>                

                 <tr >
                    <td width="10%">姓名</td>
                    <td width="40%">                     
                      <input type="text" class="input-text" name="ct_connector_name" data-title="姓名"  data-must="1">
                      <div style="color:red"></div>
                    </td>
                    <td width="10%">身份证号</td>
                    <td width="40%">
                      <input type="text" class="input-text" name="ct_connector_idCardNumber" data-title="身份证号"  data-must="1">
                      <div style="color:red"></div>
                    </td>
                </tr>
                <tr >
                    <td width="10%">联系电话</td>
                    <td width="40%">                     
                      <input type="text" class="input-text" name="ct_connector_phone" data-title="电话"  data-must="1">
                      <div style="color:red"></div>
                    </td>
                    <td width="10%">电子邮箱</td>
                    <td width="40%">
                      <input type="text" class="input-text email-input" name="ct_connector_email" data-title="电子邮箱"  data-must="1">
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
                        <input type="submit" value="保存" onclick="return check(1)"class="btn" style="background-color:#368ee0;color:white;">
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
                url: '/sports/admin/qmdd2018/index.php?r=commercialTenant/add&mode='+mode,  // 替换为实际的处理脚本地址
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
        if(mode==1)
          submitForm(1,'index');
        else if(mode==2){
            var result = confirm("确定提交审核？");
            // 根据用户的选择执行不同的操作
            if (result) {
              submitForm(2,'auditIndex');
            }
        }
        return true;
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


$('#ClubListSqdw_valid_until,#ClubListSqdw_valid_until_start').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

    // 滚动图片处理
    var $club_list_pic=$('#ClubListSqdw_club_list_pic');
    var $upload_pic_club_list_pic=$('#upload_pic_club_list_pic');
    var $upload_box_club_list_pic=$('#upload_box_Club_list_pic');

    // 添加或删除时，更新图片
    var fnUpdateClub_list_pic=function(){
        var arr=[];
        $upload_pic_club_list_pic.find('a').each(function(){
            arr.push($(this).attr('data-savepath'));
        });
        $club_list_pic.val(we.implode(',',arr));
        $upload_box_club_list_pic.show();
        if(arr.length>=5) {
            $upload_box_club_list_pic.hide();
        }
    };
    // 上传完成时图片处理
    var fnClub_list_pic=function(savename,allpath){
        $upload_pic_club_list_pic.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateClub_list_pic();return false;"></i></a>');
        fnUpdateClub_list_pic();
    };
    // 添加或删除时，更新图片搭配club_list_pic的value值
    // var arr_pic=[];
    // $upload_pic_club_list_pic.find('a').each(function(){
    //     arr_pic.push($(this).attr('data-savepath'));
    // });
    // $club_list_pic.val(we.implode(',',arr_pic));
    // $upload_box_club_list_pic.show();
    // if(arr_pic.length>=5) {
    //     $upload_box_club_list_pic.hide();
    // }

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
