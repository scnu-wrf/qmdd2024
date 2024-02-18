
 <style>
    #loke_fee{
        border-radius: 50%;
        color: #333;
        border: 1px solid #333;
        width: 20px;
        height: 20px;
        line-height: 20px;
        text-align: center;
        padding: 0;
        background: none;
        margin-left:60px;
    }
</style>
<?php //var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span><?php echo empty($_REQUEST['free_state_Id'])?'当前界面：会员》龙虎会员管理》龙虎缴费通知':'当前界面：会员》龙虎会员管理》龙虎缴费通知》待通知'?></span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if(empty($_REQUEST['free_state_Id'])){?>
        <div class="box-header">
            <span class="exam" onclick="on_exam();"><p>待通知：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
            <span><a class="btn btn-blue" href="javascript:;"  onclick="unsend('.check-item input:checked','<?php echo $this->createUrl('unsend')?>')" style="margin-left:10px;">撤销通知</a></span>
        </div><!--box-header end-->
        <?php }?>
        <div class="box-search" style="padding-bottom: 15px;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo get_session('club_id');?>">
                <input type="hidden" name="free_state_Id" id="free_state_Id" value="<?php echo Yii::app()->request->getParam('free_state_Id');?>">
                <?php if(empty($_REQUEST['free_state_Id'])){?>
                <label style="margin-right:10px;">
                    <span>通知时间：</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_start" name="time_start" value="<?php echo $time_start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_end" name="time_end" value="<?php echo $time_end; ?>">
                </label>
                <?php }?>
                <label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project_id'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>龙虎等级：</span>
                    <?php echo downList($level,'id','card_name','member_level'); ?>
                </label>
                <label style="margin-right:10px;display: inline-block;width: auto;padding-top: 5px;">
                    <span>关键字：</span>
                    <input style="width:150px;" class="input-text" type="text" placeholder="请输入账号/姓名" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit" >查询</button>
            </form>
        </div><!--box-search end-->
        <?php if(!empty($_REQUEST['free_state_Id'])&&$_REQUEST['free_state_Id']==1200){?>
    	<div class="box-table" >
            <table class="list">
                <tr>
                    <th>
                        选择费用方案
                        <a href="javascript:;" class="btn" type="buttom" id="loke_fee" title="方案详情">?</a>
                    </th>
                    <th>收费方式</th>
                    <th>可执行操作</th>
                </tr>
                <tr>
                    <td>
                        <label>
                            <select name="fee_list" onchange="div_html(this);">>
                                <option value="">请选择</option>
                                <?php foreach($fee_list as $v){?>
                                    <option value="<?php echo $v->id;?>"><?php echo $v->name;?></option>
                                <?php }?>
                            </select>
                        </label>
                        <input id="info_id" type="hidden">
                    </td>
                    <td>
                        <label style="margin-right:20px;">
                            <input id="sky1" name="sky" class="sky" type="radio" value="0" /*checked="checked"*/><label for="sky1">按入驻方式缴费</label>
                            <input id="sky2" name="sky" class="sky" type="radio" value="1"><label for="sky2">免单</label>
                        </label>
                    </td>
                    <td>
                        <a class="btn btn-blue" href="javascript:;" onclick="send('.check-item input:checked')" style="margin:0 10px;">通知缴费</a>
                    </td>
                </tr>
            </table>
            <div id="div_fee_list" class="dis_fee white_content" style="position: relative;
top: -8px;display: none;margin: 0 auto;overflow: hidden;"></div>
        </div><!--box-header end-->
        <?php }?>
        <div class="box-table">
            <table class="list">
                <tr>
                    <?php if(empty($_REQUEST['free_state_Id'])){?>
                        <th class="check" ><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('GF_ACCOUNT') ?></th>
                        <th><?php echo $model->getAttributeLabel('ZSXM') ?></th>
                        <th><?php echo $model->getAttributeLabel('project_id') ?></th>
                        <th><?php echo $model->getAttributeLabel('integral') ?></th>
                        <th>当前龙虎等级</th>
                        <th><?php echo $model->getAttributeLabel('member_level') ?></th>
                        <th><?php echo $model->getAttributeLabel('free_state_Id') ?></th>
                        <th><?php echo $model->getAttributeLabel('send_date') ?></th>
                        <th>操作</th>
                    <?php }elseif(!empty($_REQUEST['free_state_Id'])&&$_REQUEST['free_state_Id']==1200){?>
                        <th class="check" ><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('GF_ACCOUNT') ?></th>
                        <th><?php echo $model->getAttributeLabel('ZSXM') ?></th>
                        <th><?php echo $model->getAttributeLabel('project_id') ?></th>
                        <th><?php echo $model->getAttributeLabel('integral') ?></th>
                        <th>当前龙虎等级</th>
                        <th><?php echo $model->getAttributeLabel('member_level') ?></th>
                        <th><?php echo $model->getAttributeLabel('free_state_Id') ?></th>
                        <th><?php echo $model->getAttributeLabel('add_time') ?></th>
                        <th>操作</th>
                    <?php }?>
                </tr>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                    <?php if(empty($_REQUEST['free_state_Id'])){?>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>" <?=$v->free_state_Id!=1195?'disabled="disabled"':''?>></td>
                        <td><span class="num num-1"><?php echo $index; ?></td>
                        <td><?php if(!empty($v->gfUser->GF_ACCOUNT))echo $v->gfUser->GF_ACCOUNT; ?></td>
                        <td><?php if(!empty($v->gfUser->ZSXM))echo $v->gfUser->ZSXM; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->integral; ?></td>
                        <td><?php if(!empty($v->member->project_level_name))echo $v->member->project_level_name; ?></td>
                        <td><?php echo $v->member_level_name; ?></td>
                        <td><?php echo $v->free_state_name; ?></td>
                        <td><?php echo $v->send_date; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id))); ?>
                            <?php
                                 if($v->free_state_Id==1195){echo '<a class="btn btn-blue" href="javascript:;" onclick="unsend('.$v->id.',\''.$this->createUrl("unsend").'\',\'one\')">撤销通知</a>&nbsp;';}
                            ?>
                        </td>
                    <?php }elseif(!empty($_REQUEST['free_state_Id'])&&$_REQUEST['free_state_Id']==1200){?>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>" <?=$v->free_state_Id==1200?'':'disabled="disabled"'?>></td>
                        <td><span class="num num-1"><?php echo $index; ?></td>
                        <td><?php if(!empty($v->gfUser->GF_ACCOUNT))echo $v->gfUser->GF_ACCOUNT; ?></td>
                        <td><?php if(!empty($v->gfUser->ZSXM))echo $v->gfUser->ZSXM; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->integral; ?></td>
                        <td><?php if(!empty($v->member->project_level_name))echo $v->member->project_level_name; ?></td>
                        <td><?php echo $v->member_level_name; ?></td>
                        <td><?php echo $v->free_state_name; ?></td>
                        <td><?php echo $v->add_time; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id))); ?>
                            <?php
                                if($v->free_state_Id==1200){echo '<a class="btn btn-blue" href="javascript:;" onclick="send('.$v->id.',\'one\')">通知缴费</a>&nbsp;';}
                            ?>
                        </td>
                    <?php }?>
                    </tr>
                <?php $index++; } ?>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<?php 
    $s1 = 'id';
    if(empty($_REQUEST['free_state_Id'])){
        $date=date('Y-m-d H:i:s',strtotime('-3 day'));
        $s2 = QualificationsPerson::model()->findAll('check_state=2 and free_state_Id=1195 and send_date>="'.$date.'"');
    }elseif($_REQUEST['free_state_Id']==1200){
        $s2 = QualificationsPerson::model()->findAll('check_state=2 and free_state_Id=1200');
    }
    $arr = toArray($s2,$s1);
?>
<script>
    $(function(){
        var time_start = $('#time_start');
        var time_end = $('#time_end');
        time_start.on('click',function(){
            var end_input=$dp.$('time_end');
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'time_end\')}'});
        });
        time_end.on('click',function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'time_start\')}'});
        });
        
    })
    // 每页全选
    $('#j-checkall').on('click', function(){
        var $temp1 = $('.check-item .input-check');
        var $temp2 = $('.box-table .list tbody tr');
        var $this = $(this);
        if($this.is(':checked')){
            $temp1.each(function(){
                this.checked = true;
            });
            $temp2.addClass('selected');
        }else{
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });
    // 单选
    $('.check-item .input-check').on('click', function() {
        var $this = $(this);
        if ($this.is(':checked')) {
            $this.parent().parent().addClass('selected');
        } else {
            $this.parent().parent().removeClass('selected');
        }
    });
    
    function on_exam(){
        var exam = $('.exam p span').text();
        $('#free_state_Id').val(1200);
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        
        document.getElementById('click_submit').click();
    }

    
    $("#loke_fee").mouseover(function(){
        $("#div_fee_list").animate({opacity: "show"}, "slow");
    });
    $("#loke_fee").mouseout(function(){
        $("#div_fee_list").animate({opacity: "hide"}, "fast");
    })

    function send(op,val){
        if(val=='one'){
            var str = op;
        }else{
            var str = '';
            $(".check-item .input-check:checked").each(function(){
                str += $(this).val() + ',';
            });
        }
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请选中要通知的数据');
            return false;
        }
        if(!$("select[name='fee_list']").val()){
            we.msg('minus','请选择缴费方案');
            return false;
        }
        if(!$(".sky:checked").val()){
            we.msg('minus','请选择缴费方式');
            return false;
        }
        var an = function(){
            selectFeeList($("select[name='fee_list']"),'.check-item input:checked');
            if($(".sky:checked").val()==0){
                on_click(str,'<?php echo $this->createUrl("whole"); ?>');
            }else if($(".sky:checked").val()==1){
                on_click(str,'<?php echo $this->createUrl("free"); ?>');
            }
        }
        $.fallr('show', {
            buttons: {
                button1: {text: '确定', danger: true, onclick: an},
                button2: {text: '取消'}
            },
            content: '确定通知缴费吗？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    }

    // 获取所有选中多选框的值
    checkval = function(op,num){
        var str = '';
        var par = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请选中要通知的数据');
            return false;
        }
        if(num==0){
            on_click(str,'<?php echo $this->createUrl("whole"); ?>',par);
        }
        else if(num==1){
            on_click(str,'<?php echo $this->createUrl("free"); ?>',par);
        }
    };

    function unsend(id,cont,val){
        if(val=='one'){
            var str = id;
        }else{
            var str = '';
            $(".check-item .input-check:checked").each(function(){
                str += $(this).val() + ',';
            });
        }
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请选中要撤销通知的数据');
            return false;
        }
        var an = function(){
            on_click(str,cont);
        }
        $.fallr('show', {
            buttons: {
                button1: {text: '确定', danger: true, onclick: an},
                button2: {text: '取消'}
            },
            content: '确定取消吗？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });

        // var a = confirm('确定取消吗？');
        // if(a==true){
        //     on_click(str,cont);
        // }
    }

    // count=whole 为正常入驻
    // count=free 为免费/有偿入住
    // count=send 单个通知
    // count=unsend 取消通知
    function on_click(id,cont){
        we.loading('show');
        // $('#loading').append('<span id="dpsn_load" style="position:absolute;/*top: 39%;*/left: 48%;color:red;width:50px;"></span>');
        // sendCode(dpsn_load,10);
        $.ajax({
            type:'post',
            url:cont+'&id='+id,
            // data:{id:id},
            dataType:'json',
            success: function(data){
                we.loading('hide');
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }

    function scaleInfo(id,cont,par,check_all,time_start,time_end){
        we.loading('show');
        $.ajax({
            type:'post',
            url:cont+'&id='+id+'&par='+par+'&check_all='+check_all+'&time_start='+time_start+'&time_end='+time_end,
            dataType:'json',
            success: function(data){
                we.loading('hide');
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }

    // 当前页和全选只能二选一
    $('#check_all').on('click',function(){
        if($(this).is(':checked')){
            $temp1.each(function() {
                this.checked = false;
            });
        }
    });
    $('.check-item .input-check').on('click',function(){
        if(this.checked==true){
            $('#check_all').attr('checked',false);
        }
    });

    var div_fee_list = $('#div_fee_list');
    function selectFeeList(obj,op){
        var obj = $(obj).val();
        if(obj==''){
            return false;
        }
        var check_all = 0;
        var str = '';
        var time_start = $('#time_start').val();
        var time_end = $('#time_end').val();
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.lastIndexOf(','));
        }
        // if($('#check_all').is(':checked')){
        //     check_all = $('#check_all').val();
        // }
        // if(check_all==0 && str.length<1){
        //     we.msg('minus','请选择要设置的数据');
        //     return false;
        // }
        // div_html(obj);
        $("#info_id").val(obj);
        scaleInfo(str,'<?php echo $this->createUrl("scaleInfo"); ?>',obj,check_all,time_start,time_end);
    }

    function div_html(obj){
        var obj = $(obj).val();
        var p_html ='';
        var s_num = 0;
        if(obj>0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('scales');?>&info_id='+obj,
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    for(j=0;j<data.length;j++){
                        s_num++;
                        p_html += '<span style="display:inline-block;width:200px;">'+data[j]['levelname']+'<b>(￥：'+data[j]['scale_amount']+')</b></span>';
                        if(data[j]['levelid']==63){
                            continue;
                        }
                        if(s_num==4){
                            s_num=0;
                            p_html += '<br>';
                        }
                    }
                    $("#div_fee_list").html(p_html);
                }
            });
        }
    }
</script>