<?php
    $t_type=ClubStoreType::model()->find('id='.$train_list->train_type1_id);
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》培训报名 》报名培训 》添加报名</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <?php echo $form->hiddenField($model, 'train_id', array('value'=>$train_list->id));?>
                <?php echo $form->hiddenField($model, 'train_data_id', array('value'=>$train_list_data->id));?>
                <?php echo $form->error($model, 'train_id', $htmlOptions = array()); ?>
            	<table id="t1" style="table-layout:auto;background:none;">
                    <tr>
                        <td style="width:10%;"><?php echo $form->labelEx($model, 'train_title'); ?>：</td>
                        <td style="width:40%;" class="red"><?php echo $train_list->train_title;?></td>
                        <td style="width:10%;">项目：</td>
                        <td style="width:40%;"><?php echo $train_list_data->project_name;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'train_data_id'); ?>：</td>
                        <td class="red"><?php echo $train_list_data->train_content;?></td>
                        <td>可报名人数：</td>
                        <td><?php echo $train_list_data->apply_number;?></td>
                    </tr>
                    <tr>
                        <td>活动费用(元)：</td>
                        <td><?php echo $train_list_data->train_money;?></td>
                        <td>报名审核方式：</td>
                        <td><?php if(!is_null($train_list_data->check_way))echo $train_list_data->check_way->F_NAME; ?></td>
                    </tr>
                    <tr>
                        <td>报名年龄(最小)：</td>
                        <td colspan="3">
                            <?php echo $train_list_data->min_age;?>&nbsp;
                            <?php echo ClubStoreTrain::model()->getAge(strtotime($train_list_data->min_age)).'周岁';?>
                        </td>
                    </tr>
                    <tr>
                        <td>报名年龄(最大)：</td>
                        <td colspan="3">
                            <?php echo $train_list_data->max_age;?>&nbsp;
                            <?php echo ClubStoreTrain::model()->getAge(strtotime($train_list_data->max_age)).'周岁';?>
                        </td>
                    </tr>
                </table>
                <table class="mt15" id="train_sign_data" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="<?= $t_type->f_id==1505?'4':'8';?>">报名信息</td>
                        <input class="input-text" name="add_tag[0][data_id]" type="hidden" value="-1">
                        <td>
                            <input type="button" class="btn" onclick="add_tag(-1);" value="添加"></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:150px;">GF账号</td>
                        <td>姓名</td>
                        <?php if($t_type->f_id==1505){?>
                            <td>性别</td>
                        <?php }?>
                        <td style="width:150px;">联系电话</td>
                        <?php if($t_type->f_id==1504){?>
                        <td>工作单位</td>
                        <td>一寸照片</td>
                        <td>职称等级</td>
                        <td style="width:150px;">证书编号</td>
                        <td>职称证书</td>
                        <?php }?>
                        <td>操作</td>
                    </tr>
                    <!-- <tr data_index="0">
                        <input name="add_tag[0][sign_gfid]" type="hidden">
                        <td style="width:100px;"><input name="add_tag[0][sign_account]" class="input-text" onchange="accountOnchang(this)"></td>
                        <td><input name="add_tag[0][sign_name]" class="input-text" type="hidden" readonly><span clss="name"></span></td>
                        <?php //if($t_type->f_id==1505){?>
                        <td>
                            <input type="hidden" name="add_tag[0][sign_sex]" class="input-text" >
                            <span clss="sex"></span>
                        </td>
                        <?php //}?>
                        <td><input name="add_tag[0][sige_phone]" class="input-text" ></td>
                        <?php //if($t_type->f_id==1504){?>
                            <td><textarea name="add_tag[0][work_unit]"  class="input-text work_unit"></textarea></td>
                            <td>
                                <?php $basepath=BasePath::model()->getPath(288);$picprefix1='';if($basepath!=null){$picprefix1=$basepath->F_CODENAME;}?>
                                <input id="add_tag_Photo_0" class="Photo" name="add_tag[0][Photo]" type="hidden">
                                <div id="box_add_tag_Photo_0" style="margin-left:0.5rem;">
                                <script>we.uploadpic("add_tag_Photo_0", "<?php //echo $picprefix1;?>");</script></div>
                            </td>
                            <td>
                                <select id="train_identity_type0" name="add_tag[0][train_identity_type]" onchange="get_rank(this)" >
                                    <option value="">请选择</option>
                                    <?php 
                                        // $text='';
                                        // if(isset($store_rank))foreach($store_rank as $j){
                                        //     $text.='<option value="'.$j['id'].'" >'.$j['type_name'].'</option>';
                                        // }
                                        // echo $text;
                                    ?>
                                </select>
                                <select id="train_identity_rank0" name="add_tag[0][train_identity_rank]" >
                                    <option value="">请选择</option>
                                </select>
                            </td>
                            <td><input name="add_tag[0][train_identity_code]" class="input-text" ></td>
                            <td>
                                <?php $basepath=BasePath::model()->getPath(291);$picprefix2='';if($basepath!=null){ $picprefix2=$basepath->F_CODENAME;}?>
                                <input id="add_tag_train_identity_image_0" class="train_identity_image" name="add_tag[0][train_identity_image]" type="hidden">
                                <div id="box_add_tag_train_identity_image_0" style="margin-left:0.5rem;">
                                <script>we.uploadpic("add_tag_train_identity_image_0", "<?php //echo $picprefix2;?>");</script></div>
                            </td>
                        <?php //}?>
                        <td>
                        </td>
                    </tr> -->
                </table>
            </div><!--box-detail-tab-item end-->
            <table class="mt15">
                <tr>
                    <td width="10%;">可执行操作</td>
                    <td colspan="3">
                        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <?php echo show_shenhe_box(array('tongguo'=>'审核通过'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>var number=<?php echo json_encode($train_list_data->apply_number);?>;</script>
<script>var min_age=<?php echo json_encode($train_list_data->min_age);?>;</script>
<script>var max_age=<?php echo json_encode($train_list_data->max_age);?>;</script>
<script>var count=<?php echo $count;?>;</script>
<script>var base_type= <?php echo json_encode($t_type->f_id)?>;</script>
<script>var store_rank= <?php echo json_encode($store_rank)?>;</script>
<script>
    var gfId='';
    var signAccount='';
    var signName='';
    var signSex='';
    var sigePhone='';
    var workUnit='';
    var photo='';
    var trainIdentityType='';
    trainIdentityRank='';
    var trainIdentityCode='';
    var trainIdentityImage='';
    function get_rank(obj){
        var show_id = $(obj).val();
        var data_index=$(obj).parents('tr').attr('data_index');
        var content='<option value="">请选择</option>';
        $("#train_identity_rank").html(content);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getRank'); ?>&id='+show_id,
            dataType: 'json',
            success: function(data) {
                $.each(data,function(k,info){
                    content+='<option value="'+info.id+'" '+(info.id==trainIdentityRank?'selected':'')+'>'+info.rank_name+'</option>'
                })
                $("#train_identity_rank").html(content);
            }
        });
    }
    
    function add_tag(index){
        var num=parseInt($("#train_sign_data tr").last().attr('data_index'))+1;
        num=isNaN(num)?0:num;
        if(index==-1&&num>=(number-count)){
            we.msg('minus', '只可报名'+(number-count)+'人');
            return false;
        }

        gfId=index==-1?'':$("#sign_gfid_"+index+"").val();
        signAccount=index==-1?'':$("#sign_account_"+index+"").val();
        signName=index==-1?'':$("#sign_name_"+index+"").val();
        signSex=index==-1?'':$("#sign_sex_"+index+"").val();
        sigePhone=index==-1?'':$("#sige_phone_"+index+"").val();
        workUnit=index==-1?'':$("#work_unit_"+index+"").val();
        photo=index==-1?'':$("#Photo_"+index+"").val();
        trainIdentityType=index==-1?'':$("#train_identity_type_"+index+"").val();
        trainIdentityRank=index==-1?'':$("#train_identity_rank_"+index+"").val();
        trainIdentityCode=index==-1?'':$("#train_identity_code_"+index+"").val();
        trainIdentityImage=index==-1?'':$("#train_identity_image_"+index+"").val();

        var add_html = 
        '<div class="box-detail" id="add_format" style="width:800px;">'+
            '<form id="add_form" name="add_form">'+
                '<table id="table_tag" style="table-layout:auto;">'+
                    '<tr class="table-title">'+
                        '<td colspan="4">添加会员</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td style="width:10%;">GF账号</td>'+
                        '<td style="width:40%;">'+
                            '<input id="sign_gfid" type="hidden" value="'+gfId+'">'+
                            '<input id="sign_account" class="input-text" onchange="accountOnchang(this)" value="'+signAccount+'" autocomplete="off">'+
                        '</td>'+
                        '<td style="width:10%;">姓名</td>'+
                        '<td style="width:40%;">'+
                            '<input id="sign_name" type="hidden" value="'+signName+'" autocomplete="off">'+
                            '<span clss="name">'+signName+'</span>'+
                        '</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>联系电话</td>'+
                        '<td '+(base_type!=1505?"colspan='3'":"")+'>'+
                            '<input id="sige_phone" class="input-text" value="'+sigePhone+'" autocomplete="off">'+
                        '</td>';
                        if(base_type==1505){
                            add_html+='<td style="width:100px;">姓别</td>'+
                            '<td>'+
                                '<input id="sign_sex" type="hidden" value="'+signSex+'">'+
                                '<span clss="sex">'+(signSex==205?'男':'女')+'</span>'+
                            '</td>';
                        }
                    add_html+='</tr>';
                    if(base_type==1504){
                        add_html+='<tr>'+
                            '<td>工作单位</td>'+
                            '<td colspan="3">'+
                                '<textarea id="work_unit" class="input-text work_unit" autocomplete="off">'+workUnit+'</textarea>'+
                            '</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td>一寸照片</td>'+
                            '<td colspan="3">'+
                                '<input id="photo" type="hidden" value="'+photo+'">'+
                                '<div class="upload_img fl" id="upload_pic_photo">'+(index==-1?'':$("#upload_pic_photo"+index+"").html())+'</div>'+
                                '<div id="box_photo" style="margin-left:0.5rem;">'+
                                    '<script>we.uploadpic("photo", "<?php echo $picprefix1;?>");<\/script>'+
                                '</div>'+
                            '</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td>职称等级</td>'+
                            '<td colspan="3">'+
                                '<select id="train_identity_type" onchange="get_rank(this)" >'+
                                    '<option value="">请选择</option>';
                                    $.each(store_rank,function(k,info){
                                        add_html += '<option value="'+info.id+'" '+(info.id==trainIdentityType?'selected':'')+'>'+info.type_name+'</option>';
                                    })
                                add_html += '</select>'+
                                '<select id="train_identity_rank">'+
                                    '<option value="">请选择</option>';
                                add_html += '</select>'+
                            '</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td>证书编号</td>'+
                            '<td colspan="3"><input id="train_identity_code" class="input-text" value="'+trainIdentityCode+'"></td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td>职称证书</td>'+
                            '<td colspan="3">'+
                                '<input id="train_identity_image" type="hidden" value="'+trainIdentityImage+'">'+
                                '<div class="upload_img fl" id="upload_pic_train_identity_image">'+
                                (index==-1?'':$("#upload_pic_train_identity_image"+index+"").html())+
                                '</div>'+
                                '<script>we.uploadpic("train_identity_image", "<?php echo $picprefix2;?>","","",function(e1,e2){fnscrollPic(e1.savename,e1.allpath);});<\/script>'+
                                '<div id="box_train_identity_image" style="margin-left:0.5rem;">'+
                                '</div>'+
                            '</td>'+
                        '</tr>';
                    }
                add_html+='</table>'+
            '</form>'+
        '</div>';
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            // height: '60%',
            // width: '100%',
            title:'添加会员',
            content:add_html,
            button:[
                {
                    name:'保存',
                    callback:function(){
                        if($("#sign_account").val()==''){
                            we.msg('minus','请输入GF账号');
                            return false;
                        }
                        if($("#sige_phone").val()==''){
                            we.msg('minus','请输入联系电话');
                            return false;
                        }
                        if(base_type==1504){
                            if($("#work_unit").val()==''){
                                we.msg('minus','请填写工作单位');
                                return false;
                            }
                            if($("#photo").val()==''){
                                we.msg('minus','请上传一寸照片');
                                return false;
                            }
                            if($("#train_identity_type").val()==''||$("#train_identity_rank").val()==''){
                                we.msg('minus','请选择职称等级');
                                return false;
                            }
                            if($("#train_identity_code").val()==''){
                                we.msg('minus','请输入证书编号');
                                return false;
                            }
                            if($("#train_identity_image").val()==''){
                                we.msg('minus','请上传职称证书');
                                return false;
                            }
                        }
                        if(index<0){
                            return fn_add_tr(num);
                        }else{
                            return fn_change_tr(index);
                        }
                    },
                    focus:true
                },
                {
                    name:'取消',
                    callback:function(){
                        return true;
                    }
                }
            ]
        });
        $("#train_identity_type").change();
        $('.aui_main').css('height','auto');
    }
    
    function fn_add_tr(num){
        gfId=$("#sign_gfid").val();
        signAccount=$("#sign_account").val();
        signName=$("#sign_name").val();
        signSex=$("#sign_sex").val();
        sigePhone=$("#sige_phone").val();
        workUnit=$("#work_unit").val();
        photo=$("#photo").val();
        trainIdentityType=$("#train_identity_type").val();
        trainIdentityRank=$("#train_identity_rank").val();
        trainIdentityCode=$("#train_identity_code").val();
        trainIdentityImage=$("#train_identity_image").val();
        var html =
        '<tr data_index="'+num+'">'+
            '<input id="sign_gfid_'+num+'" name="add_tag['+num+'][sign_gfid]" type="hidden" value="'+gfId+'">'+
            '<td><input id="sign_account_'+num+'" name="add_tag['+num+'][sign_account]" type="hidden" value="'+signAccount+'"><span>'+signAccount+'</span></td>'+
            '<td><input id="sign_name_'+num+'" name="add_tag['+num+'][sign_name]" type="hidden" value="'+signName+'"><span>'+signName+'</span></td>';
            if(base_type==1505){
                html+='<td><input id="sign_sex_'+num+'" name="add_tag['+num+'][sign_sex]" type="hidden" value="'+signSex+'"><span>'+signSex+'</span></td>';
            }
            html+='<td><input id="sige_phone_'+num+'" name="add_tag['+num+'][sige_phone]" type="hidden" value="'+sigePhone+'"><span>'+sigePhone+'</span></td>';
            if(base_type==1504){
                html+='<td><input id="work_unit_'+num+'" name="add_tag['+num+'][work_unit]" type="hidden" value="'+workUnit+'"><span>'+workUnit+'</span></td>'+
                '<td>'+
                    '<input id="Photo_'+num+'" name="add_tag['+num+'][Photo]" type="hidden" value="'+photo+'">'+
                    '<div class="upload_img fl" id="upload_pic_photo'+num+'">'+$("#upload_pic_photo").html()+'</div>'+
                '</td>'+
                '<td>'+
                    '<input id="train_identity_type_'+num+'" name="add_tag['+num+'][train_identity_type]" type="hidden" value="'+trainIdentityType+'">'+
                    '<input id="train_identity_rank_'+num+'" name="add_tag['+num+'][train_identity_rank]" type="hidden" value="'+trainIdentityRank+'">'+
                    '<span>'+$("#train_identity_type").find("option:selected").text()+$("#train_identity_rank").find("option:selected").text()+'</span>'+
                '</td>'+
                '<td>'+
                    '<input id="train_identity_code_'+num+'" name="add_tag['+num+'][train_identity_code]" type="hidden" value="'+trainIdentityCode+'">'+
                    '<span>'+trainIdentityCode+'</span>'+
                '</td>'+
                '<td>'+
                    '<input id="train_identity_image_'+num+'" name="add_tag['+num+'][train_identity_image]" type="hidden" value="'+trainIdentityImage+'">'+
                    '<div class="upload_img fl" id="upload_pic_train_identity_image'+num+'">'+$("#upload_pic_train_identity_image").html()+'</div>'+
                '</td>';
            }
            html+='<td>'+
                '<input onclick="add_tag('+num+');" class="btn" type="button" value="编辑">&nbsp;'+
                '<a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a>'+
            '</td>'+
        '</tr>';
        $('#train_sign_data').append(html);
    }

    function fn_change_tr(index){
        gfId=$("#sign_gfid").val();
        signAccount=$("#sign_account").val();
        signName=$("#sign_name").val();
        signSex=$("#sign_sex").val();
        sigePhone=$("#sige_phone").val();
        workUnit=$("#work_unit").val();
        photo=$("#photo").val();
        trainIdentityType=$("#train_identity_type").val();
        trainIdentityRank=$("#train_identity_rank").val();
        trainIdentityCode=$("#train_identity_code").val();
        trainIdentityImage=$("#train_identity_image").val();

        $("#sign_gfid_"+index+"").val(gfId);
        $("#sign_account_"+index+"").val(signAccount);
        $("#sign_account_"+index+"").next().html(signAccount);
        $("#sign_name_"+index+"").val(signName);
        $("#sign_name_"+index+"").next().html(signName);
        $("#sign_sex_"+index+"").val(signSex);
        $("#sign_sex_"+index+"").next().html(signSex);
        $("#sige_phone_"+index+"").val(sigePhone);
        $("#sige_phone_"+index+"").next().html(sigePhone);
        $("#work_unit_"+index+"").val(workUnit);
        $("#work_unit_"+index+"").next().html(workUnit);
        $("#Photo_"+index+"").val(photo);
        $("#Photo_"+index+"").next().html($("#upload_pic_photo").html());
        $("#train_identity_type_"+index+"").val(trainIdentityType);
        $("#train_identity_rank_"+index+"").val(trainIdentityRank);
        $("#train_identity_rank_"+index+"").next().html($("#train_identity_type").find("option:selected").text()+$("#train_identity_rank").find("option:selected").text());
        $("#train_identity_code_"+index+"").val(trainIdentityCode);
        $("#train_identity_code_"+index+"").next().html(trainIdentityCode);
        $("#train_identity_image_"+index+"").val(trainIdentityImage);
        $("#train_identity_image_"+index+"").next().html($("#upload_pic_train_identity_image").html());
    }

    var remove_arr=[];
    function delete_data(obj){
        $(obj).parent().parent().remove();
    }
    
    // 添加或删除时，更新图片
    var fnUpdatescrollPic=function(){
        var arr1=[];
        $('#upload_pic_train_identity_image').find('a').each(function(){
            arr1.push($(this).attr('data-savepath'));
        });
        $('#train_identity_image').val(we.implode(',',arr1));
        $('#upload_box_train_identity_image').show();
        if(arr1.length>=5) {
            $('#upload_box_train_identity_image').hide();
        }
    };
    // 上传完成时图片处理
    var fnscrollPic=function(savename,allpath){
        $('#upload_pic_train_identity_image').append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
        fnUpdatescrollPic();
    };
    
    // 验证账号
    function accountOnchang(obj){
        var changval=$(obj).val();
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('validate');?>&gf_account='+changval+'&train_id='+<?= $_REQUEST['train_id'];?>+'&train_data_id='+<?= $_REQUEST['train_data_id'];?>,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                var gfid='',ZSXM='',real_sex='',real_sex_name='',PHONE='';
                if(data.status==1){
                    if(data.real_birthday<=min_age&&data.real_birthday>=max_age){
                        gfid=data.GF_ID;
                        ZSXM=data.ZSXM;
                        real_sex=data.real_sex;
                        real_sex_name=data.real_sex_name;
                        PHONE=data.PHONE;
                    }else{
                    $(obj).val('');
                        we.msg('minus', '您输入的GF账号，不符合年龄要求');
                        return false;
                    }
                }else{
                    $(obj).val('');
                    we.msg('minus', data.msg);
                }
                $("#sign_gfid").val(gfid);
                $("#sign_name").val(ZSXM);
                $("#sign_name").next().html(ZSXM);
                $("#sige_phone").val(PHONE);
                $("#sign_sex").val(real_sex);
                $("#sign_sex").next().html(real_sex_name);
            }
        });
    }
</script>