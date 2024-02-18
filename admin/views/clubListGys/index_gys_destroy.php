<div class="box">
    <div class="box-title c">
        <h1> <span>当前界面：供应商》供应商管理》供应商注销</span> </h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span> </div>
    <!--box-title end-->
    <div class="box-content">

<div class="box-header" style="<?= !empty($_REQUEST['date'])?'display:none':''?>">
            <?php 
                //if(empty($_REQUEST['date'])){
                    if($_REQUEST['edit_state']==2){
						
						   echo show_command('添加','','添加');
                            
                    }else{
                     echo show_command('添加',$this->createUrl('create'),'添加');
                    }
                //}
                if(empty($_REQUEST['date'])){
                    echo '&nbsp;<span class="exam" onclick="on_exam();"><p>今日申请数：(<span style="color:red;font-weight: bold;">'.$count_gys_destroy.'</span>)</p></span>';
                }
            ?>
        </div>
      

        <div class="box-table">
            <table class="list" style="text-align:left;">
                <thead>
                <tr>
                    <th width="20" class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th width="49" >序号</th>
                    <th width="137"><?php echo $model->getAttributeLabel('club_code');?></th>
                    <th width="140"><?php echo $model->getAttributeLabel('company');?></th>
                    <th width="129">单位性质</th>
                    <th width="104">单位所在地</th>
                    <th width="81"><?php echo $model->getAttributeLabel('apply_name');?></th>
                    <th width="103"><?php echo $model->getAttributeLabel('contact_phone');?></th>
                    <th width="154">状态</th>
                    <th width="172"><?php echo $model->getAttributeLabel('apply_time');?></th>
                    <th width="146">操作</th>
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
                        <td ><?php echo $v->club_code;?></td>
                        <td ><?php echo $v->company;?></td>
                        <td ><?php if(!empty($v->baseCode_company_type_id->F_NAME)) echo $v->baseCode_company_type_id->F_NAME;?></td>
                        <td ><?php echo $v->club_area_province;?>/<?php if($v->club_area_city == '市辖区' || $v->club_area_city == '市辖县'   || $v->club_area_city == '省直辖县级行政区划'){ ?>
    <?php }else{ ?>
    <?php echo $v->club_area_city;?>/
    <?php } ?>/<?php echo $v->club_area_district;?></td>
                        <td ><?php echo $v->apply_name;?></td>
                        <td ><?php echo $v->contact_phone;?></td>
                        <td ><?php if(!empty($v->baseCode_state->F_NAME)) echo $v->baseCode_state->F_NAME;?></td>
                        <td ><?php echo $v->apply_time;?></td>

                        <td ><a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'action'=>'index_apply'));?>" title="编辑">编辑</a>
                            <?php if($v->state == 721){ ?>
                                <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                            <?php }else{ ?>
                            <?php } ?>


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

     //时分秒：
    $(function(){
        var $start_time=$('#start_date');
        var $end_time=$('#end_date');
        $start_time.on('click', function(){
            var end_input=$dp.$('end_date')
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
        });
    });



    function on_exam(){
        $('#to_day').val(1);
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        document.getElementById('click_submit').click();
    }
	
	
		 <?php if($_REQUEST['edit_state']==2){?>
        $(".box-header>.btn:eq(0)").on("click",function(){
            $.dialog.data('club_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/clubEditlist", array('club_type'=>380,'edit_state'=>2));?>',{
                id:'danwei',
                lock:true,
                opacity:0.3,
                title:'选择要注销的供应商',
                width:'500px',
                height:'60%',
                close: function () {
                    if($.dialog.data('club_id')>0){
                        window.location.href="<?php echo $this->createUrl('update_data'); ?>&id="+$.dialog.data('club_id');
                    }
                }
            });
            return false;
        })
    <?php }?>
</script>
