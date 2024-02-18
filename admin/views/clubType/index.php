
<div class="box">
  <div class="box-title c">
    <h1>
    <span><i class="fa fa-table"></i>当前界面：系统 》系统设置 》会员类型设置</span>
    </h1>
      <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
  </div>
  <!--box-title end-->
  <div class="box-content"> 
    <div class="box-header"> <a class="btn" onclick="addMemberType()"><i class="fa fa-plus"></i>添加</a> <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> </div>
    <!--box-header end--> 
    <div class="box-table">
      <table class="list" style="text-align:left;">
        <thead>
          <tr>
            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
            <th >序号</th>
            <th >会员编码</th>
            <th >会员类型（一级）</th>
            <th >会员类型（二级）</th>
            <th >会员性质</th>
            <th >操作</th>
          </tr>
        </thead>
        <tbody>
          <?php
                $index = 1;
                //print_r($arclist);
                foreach($arclist as $v){

                    ?>
            <tr>
                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                <td ><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                <!--<td ><?php //echo $v->GF_ID; ?></td>-->
                <td><?php echo $v->f_ctcode;?></td>
                <td ><?php if(mb_strlen($v->f_ctcode) > 3){}else{ echo '<strong>'.$v->f_ctname.'</strong>';}?></td>
                <td ><?php if(mb_strlen($v->f_ctcode) > 3){echo $v->f_ctname;}else{}?></td>
                <td ><?php if($v->member_attribute == 403 && mb_strlen($v->member_attribute) == 3){echo '个人';}elseif($v->member_attribute == 404 && mb_strlen($v->member_attribute) == 3){echo '单位';}else{echo '单位/个人';}?></td>
                <td ><a class="btn" onclick="editMemberType('<?php echo $v->id;?>','<?php echo $v->f_ctcode;?>','<?php echo $v->f_ctname;?>','<?php echo $v->member_attribute;?>')" title="编辑"><i class="fa fa-edit"></i></a>
                </td>
          </tr>
          <?php $index++; } ?>
        </tbody>
      </table>
    </div>
    <!--box-table end-->
    
    <div class="box-page c">
      <?php $this->page($pages);?>
    </div>
  </div>
  <!--box-content end--> 
</div>
<!--box end--> 
<script>
//onKeyUp="show_msg();" oninput="accountOnchang(this)"  onpropertychange="accountOnchang(this)"
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
var addClubHtml='<div style="width:500px;">'+
'<table class="box-detail-table showinfo">'+
    '<tr>'+
        '<td>会员编码</td>'+
        '<td><input id="dialog_f_ctcode" onKeyUp="show_msg();" type="text" value="" ><input id="member_gfid" type="hidden" value=""></td>'+
    '</tr>'+
	    '<tr>'+
        '<td>会员类型</td>'+
        '<td><input id="dialog_f_ctname" onKeyUp="show_msg();" type="text" value="" ><input id="member_gfid" type="hidden" value=""></td>'+
    '</tr>'+
	
	 
	    '<tr>'+
        '<td>会员性质</td>'+
        '<td><input type="checkbox" id="dialog_member_attribute" name="test" value="404">单位 &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="dialog_member_attribute" name="test" value="403">个人</td>'+
    '</tr>'+


'</table>'+
'</div>';


//帐号验证
function show_msg(){
	
     var s1=$('#dialog_gf_account').val();
     var s2='<?php echo $this->createUrl("userlist/getUser");?>';
     if (s1.length>5){
      $.ajax({
        type: 'get',
        url: s2,
        data: {gfaccount: s1},
        dataType:'json',
        success: function(data) {
          if (data.GF_ACCOUNT==s1 && data.passed == 2){
            $('#member_gfid').val(data.GF_ID);
          }else{
            we.msg('minus', '该帐号不存在或未实名登记');
          }
       },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
        }
    });
	
}
 }
// 添加会员类型
var addMemberType=function(){
    $.dialog({
        id:'addlianmeng',
        lock:true,
        opacity:0.3,
        title:'添加会员类型',
        content:addClubHtml,
        button:[
            {
                name:'保存',
                callback:function(){
                    return fnSendInvite();
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
};


// 保存添加会员类型
var fnSendInvite=function(){

    var msg=$('#dialog_msg').val();
    var f_ctcode = $('#dialog_f_ctcode').val();
	var f_ctname = $('#dialog_f_ctname').val();
	//var member_attribute = '';

   console.log(f_ctcode);
   console.log(f_ctname);
   


	if(f_ctcode == ''){
        we.msg('minus', '请填写会员编码');
        return false;
    }
	
	if(f_ctname == ''){
        we.msg('minus', '请填写会员类型');
        return false;
    }
	
    obj = document.getElementsByName("test");
    check_val = [];
    for(k in obj){
        if(obj[k].checked)
            check_val.push(obj[k].value);
    }
	
	 if (check_val == "") { 
        we.msg('minus', '请选择会员性质');
		 return false;
	 }
	    console.log(check_val);
	
    we.loading('show');
    $.ajax({
        type: 'post',
        url: '<?php echo $this->createUrl('sendInvite');?>',
        data: {msg:msg, f_ctcode:f_ctcode, f_ctname:f_ctname, check_val:check_val},
        dataType: 'json',
        success: function(data) {
            if(data.status==1){
                we.loading('hide');
                $.dialog.list['addlianmeng'].close();
                we.success(data.msg, data.redirect);
            }else{
                we.loading('hide');
                we.msg('minus', data.msg);
            }
        }
    });
    return false;
	
};


// 编辑会员类型
var editMemberType=function(id,f_ctcode,f_ctname,member_attribute){
console.log(typeof(member_attribute));
//var str = explode(',',member_attribute);
var str = member_attribute.split(",");
console.log(typeof(str));
console.log(str[0]);
var l = '404';
var r = '403';
var k = '';
var g = '';
var h = '';
if(str[0]=='404'){
	console.log('208'+str[0]);
	k = 'checked="checked"';
	l = '404';
}

if(str[0]=='403'){
	console.log('213'+str[1]);
	g = 'checked="checked"';
	r = '403';
}
if(str[0]=='404' && str[1]=='403'){
	h = 'checked="checked"';
}
    $.dialog({
        id:'addlianmeng',
        lock:true,
        opacity:0.3,
        title:'编辑会员类型',
        content:'<div style="width:500px;">'+
'<table class="box-detail-table showinfo">'+
    '<tr>'+
        '<td>会员编码</td>'+
        '<td><input id="dialog_f_ctcode" onKeyUp="show_msg();" type="text" value="'+f_ctcode+'" ><input id="member_gfid" type="hidden" value=""></td>'+
    '</tr>'+
	    '<tr>'+
        '<td>类型名称</td>'+
        '<td><input id="dialog_f_ctname" onKeyUp="show_msg();" type="text" value="'+f_ctname+'" ><input id="member_gfid" type="hidden" value=""></td>'+
    '</tr>'+
	
	 '<tr>'+
        '<td>会员性质</td>'+
        '<td><input type="checkbox" id="dialog_member_attribute" name="test2" value="'+l+'" '+k+h+'>单位 &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="dialog_member_attribute" name="test2" value="'+r+'" '+g+h+'>个人</td>'+
    '</tr>'+

'</table>'+
'</div>',
        button:[
            {
                name:'保存',
                callback:function(){
				
                    return fnSaveEdit(id,f_ctcode,f_ctname);
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
	

};


// 保存编辑会员类型
var fnSaveEdit=function(id,f_ctcode,f_ctname){
	

    var msg=$('#dialog_msg').val();
    var f_ctcode=$('#dialog_f_ctcode').val();
	var f_ctname=$('#dialog_f_ctname').val();

 

	if(f_ctcode == ''){
        we.msg('minus', '请填写会员编码');
        return false;
    }
	
	if(f_ctname == ''){
        we.msg('minus', '请填写类型名称');
        return false;
    }
	
	
	obj2 = document.getElementsByName("test2");
    check_val_edit = [];
    for(k in obj2){
        if(obj2[k].checked)
            check_val_edit.push(obj2[k].value);
    }
	
	 if (check_val_edit == "") { 
        we.msg('minus', '请选择会员性质');
		 return false;
	 }
	    console.log(check_val_edit);
	
	
    we.loading('show');
    $.ajax({
        type: 'get',
        url: '<?php echo $this->createUrl('saveEdit');?>',
        data: {id:id, f_ctcode:f_ctcode, f_ctname:f_ctname, check_val_edit:check_val_edit},
        dataType: 'json',
        success: function(data) {
            if(data.status==1){
                we.loading('hide');
                $.dialog.list['addlianmeng'].close();
                we.success(data.msg, data.redirect);
            }else{
                we.loading('hide');
                we.msg('minus', data.msg);
            }
        }
    });
    return false;
};



// 删除已选择单位
var fnDeleteClub=function(op){
    $(op).parent().remove();
    fnUpdateClub();
};

// 重置单位
var fnResetClub=function(){
    $('#club_box').html('');
    $('#dialog_club').val('');
};
// 更新单位
var fnUpdateClub=function(){
    var arr=[];
    var id;
    $('#club_box').find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $('#dialog_club').val(we.implode(',', arr));
};
// 选择单位、项目
var fnSelectClub=function(){
    // 选择项目
    var project_id=$('#dialog_project').val();
    if(project_id<=0){
        we.msg('minus', '请先选择项目');
        return false;
    }
    // 选择单位
    var $club_box=$('#club_box');
    $.dialog.data('club_id', 0);
    $.dialog.open('<?php echo $this->createUrl("select/club", array('no_cooperation'=>Yii::app()->session['club_id']));?>&project_id='+project_id,{
        id:'danwei',
        lock:true,
        opacity:0.3,
        title:'选择具体内容',
        width:'500px',
        height:'60%',
        close: function () {
            //console.log($.dialog.data('club_id'));
            if($.dialog.data('club_id')>0 && $('#club_item_'+$.dialog.data('club_id')).length==0){
                $club_box.html('<span id="club_item_'+$.dialog.data('club_id')+'" class="label-box" data-id="'+$.dialog.data('club_id')+'">'+$.dialog.data('club_title')+'</span>');
                fnUpdateClub();
            }
        }
    });
};
</script> 
