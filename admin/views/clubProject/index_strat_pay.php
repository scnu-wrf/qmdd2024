<?php
    $sel_2 = 0;
    $sel_3 = 0;
    $sel_1 = ClubMembershipFeeScaleInfo::model()->find('club_id='.get_session('club_id').' and use_default=1 and levetypeid=502');
    if(!empty($sel_1)){
        $sel_2 = $sel_1->use_default;
        $sel_3 = $sel_1->id;
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>
        <?php if(empty($_REQUEST['free_state_Id'])){echo '当前界面：项目》单位项目费用》项目缴费通知';}elseif(!empty($_REQUEST['free_state_Id'])&&$_REQUEST['free_state_Id']==1200){echo '当前界面：项目》单位项目费用》项目缴费通知》待通知';}?>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if(empty($_REQUEST['free_state_Id'])){?>
            <div class="box-header">
                <span class="exam" onclick="on_exam();"><p>待通知：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
                <span>
                <a class="btn" href="javascript:;"  onclick="unsend('.check-item input:checked','<?php echo $this->createUrl('unsend')?>')" style="margin-left:10px;">撤销通知</a>
                </span>
            </div><!--box-header end-->
        <?php }?>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
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
                    <?php echo downList($project,'id','project_name','project'); ?>
                </label>
                <?php if(empty($_REQUEST['free_state_Id'])){?>
                    <label style="display: inline-block;width: 200px;padding-top: 5px;">
                        <span>费用方案：</span>
                        <?php echo downList($fee_list,'id','name','pay_blueprint','style="margin-left: 12px;width: 92px;"'); ?>
                    </label>
                    <label style="display: inline-block;width: 200px;padding-top: 5px;">
                        <span>入驻方式：</span>
                        <?php echo downList($approve_state,'f_id','F_NAME','approve_state','style="margin-left: 12px;width: 92px;"'); ?>
                    </label>
                <?php }?>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号/单位名称/项目">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php if(!empty($_REQUEST['free_state_Id'])&&$_REQUEST['free_state_Id']==1200){?>
            <div class="box-header" style="position: relative;margin-top: 15px;border-top: solid 1px #d9d9d9;padding-top: 15px;">
                <label style="margin-right:10px;">
                    <span>选择方案：</span>
                    <select name="fee_list" onchange="div_html(this);">>
                        <option value="">请选择</option>
                        <?php foreach($fee_list as $v){?>
                            <option value="<?php echo $v->id;?>"><?php echo $v->name;?></option>
                        <?php }?>
                    </select>
                </label>
                <input id="info_id" type="hidden">
                <span>
                    <a href="javascript:;" class="btn" type="buttom" id="loke_fee"  title="方案详情">?</a>
                    <div id="div_fee_list" class="dis_fee white_content" style="margin-top:10px;display:none;"></div>
                </span>
                <span style="margin-left:10px;">
                    <label style="margin-right:20px;">
                        <span>选择缴费方式：</span>
                        <input id="sky1" name="sky" class="sky" type="radio" value="0" /*checked="checked"*/><label for="sky1">按入驻方式缴费</label>
                        <input id="sky2" name="sky" class="sky" type="radio" value="1"><label for="sky2">免单</label>
                        <a class="btn" href="javascript:;" onclick="send('.check-item input:checked')" style="margin:0 10px;">通知缴费</a>
                    </label>
                </span>
            </div><!--box-header end-->
        <?php }?>
        <div class="box-table">
            <thead>
                <table class="list">
                    <?php $checked = 'checked="checked"'; ?>
                    <tr>
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('p_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('club_type');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <?php if(empty($_REQUEST['free_state_Id'])){?>
                        <th><?php echo $model->getAttributeLabel('pay_blueprint');?></th>
                        <th><?php echo $model->getAttributeLabel('cost_admission');?></th>
                        <?php }?>
                        <th><?php echo $model->getAttributeLabel('approve_state');?></th>
                        <th>状态</th>
                        <?php if(empty($_REQUEST['free_state_Id'])){?>
                            <th><?php echo $model->getAttributeLabel('cut_date');?></th>
                            <th><?php echo $model->getAttributeLabel('send_date');?></th>
                            <th><?php echo $model->getAttributeLabel('send_adminid');?></th> 
                        <?php }else{?>
                            <th>审核时间</th>
                        <?php }?>
                        <th>操作</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item">
                            <?php if(($v->pay_way==12&&$v->free_state_Id==1195)||($v->pay_way!=12&&$v->free_state_Id==1201)||$v->free_state_Id==1200){?>
                                <input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>">
                            <?php }?>
                            </td>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->p_code; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->club_type_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <?php if(empty($_REQUEST['free_state_Id'])){?>
                            <td><?php echo $v->pay_blueprint_name; ?></td>
                            <td><?php echo $v->cost_admission; ?></td>
                            <?php }?>
                            <td><?php echo $v->approve_state_name; ?></td>
                            <td><?php echo $v->free_state_name; ?></td>
                            <?php if(empty($_REQUEST['free_state_Id'])){?>
                                <!-- <td><?php echo $v->cut_date; ?></td> -->
                                <td>
                                    <?php 
                                        $today = time(); //当前时间戳 6月7号
                                        if(!empty($v->order_num)){
                                            $or = Carinfo::model()->find('order_num="'.$v->order_num.'"');
                                        }
                                            $end_time = $v->cut_date;//结束时间，一般由数据库查询出来的待缴费结束时间
                                            $second = strtotime($end_time)-$today;//结束时间戳减去当前时间戳
                                            $day = floor($second/3600/24);    //倒计时还有多少天
                                            $hr = floor($second/3600);     
                                            $hr = floor($second/3600%24);     //倒计时还有多少小时（%取余数）
                                            $min = floor($second/60%60);      //倒计时还有多少分钟
                                            $sec = floor($second%60);         //倒计时还有多少秒
                                            $str = $day.'天'.$hr.":".$min.":".$sec;  //组合成字符串
                                            echo $str;
                                    ?>
                                </td>
                                <td><?php echo $v->send_date; ?></td>
                                <td><?php echo (!is_null($v->sendAdmin)?$v->sendAdmin->send_adminname:'').'/'.$v->audit_adminname; ?></td>
                            <?php }else{?>
                                <td><?php echo $v->uDate; ?></td>
                            <?php }?>
                            <td>
                                <?php if(empty($_REQUEST['free_state_Id'])){?>
                                    <?php echo show_command('详情',$this->createUrl('update_unit', array('id'=>$v->id))); ?>
                                <?php }else{?>
                                    <?php
                                        if($v->free_state_Id==1200){echo '<a class="btn btn-blue" href="javascript:;" onclick="send('.$v->id.',\'one\')">通知缴费</a>&nbsp;';}
                                    ?>
                                <?php }?>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </table>
            </thead>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
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

        var sel_2 = <?php echo $sel_2; ?>;
        var sel_3 = <?php echo $sel_3; ?>;
        // if(sel_2==1){
        //     div_html(sel_3);
        // }
    });

    var $temp1 = $('.check-item .input-check');
    var $temp2 = $('.box-table .list tbody tr');
    $('#j-checkall').on('click', function() {
        var $this = $(this);
        if ($this.is(':checked')) {
            $temp1.each(function() {
                if(this.disabled!=true){
                    this.checked = true;
                }
            });
            $temp2.addClass('selected');
        } else {
            $temp1.each(function() {
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });

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

    // 获取所有选中多选框的值
    checkval = function(op,num){
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请先选中要通知的数据');
            return false;
        }
        if(num==0){
            on_click(str,'<?php echo $this->createUrl("whole"); ?>',par);
        }
        else if(num==1){
            on_click(str,'<?php echo $this->createUrl("free"); ?>',par);
        }
    };


    // function sendCode(btn,time){
	// 	var clock = '';
	// 	var nums = time;
	// 	var btn;
	// 	btn.innerHTML = '请稍等...';
	// 	clock = setInterval(doLoop, 1000); //一秒执行一次
	// 	function doLoop(){
	// 		nums--;
	// 		if(nums > 0){
	// 			btn.innerHTML = '大约'+nums+'秒内完成';
	// 		}else{
	// 		clearInterval(clock); //清除js定时器
	// 			btn.disabled = false;
	// 			btn.innerHTML = '操作失败，请重新加载后再试';
	// 			nums = time; //重置时间
	// 		}
	// 	}
    // }

    // function loke_fee(){
    //     if($('#div_fee_list').html()==''){
    //         return false;
    //     }
    //     $('#div_fee_list').toggle(100);
    //     if($('#loke_fee').text()=='方案详细'){
    //         $('#loke_fee').text('关闭详细');
    //     }
    //     else{
    //         $('#loke_fee').text('方案详细');
    //     }
    // }
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
    
    function div_html(obj){
        var p_html ='';
        var s_num = 0;
        if($(obj).val()>0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('scales');?>&info_id='+$(obj).val(),
                dataType: 'json',
                success: function(data) {
                    for(j=0;j<data.length;j++){
                        s_num++;
                        p_html += '<span style="display:inline-block;width:180px;">'+data[j]['member_name']+data[j]['levelname']+'<b>(￥：'+data[j]['scale_amount']+')</b></span>';
                        if(data[j]['levelid']==63){
                            continue;
                        }
                        if(s_num==6){
                            s_num=0;
                            p_html += '<br>';
                        }
                    }
                    $("#div_fee_list").html(p_html);
                }
            });
        }
    }

    
    function send(op,val){
        if(val=='one'){
            var str = op;
        }else{
            var str = '';
            $(op).each(function() {
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
        console.log(str)
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
    function scaleInfo(id,cont,par,check_all,time_start,time_end){
        we.loading('show');
        $.ajax({
            type:'post',
            url:cont+'&id='+id+'&par='+par+'&check_all='+check_all,
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

    function on_click(id,cont){
        we.loading('show');
        // $('#loading').append('<span id="dpsn_load" style="position:absolute;left: 45%;"></span>');
        // sendCode(dpsn_load,5);
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

    
    function unsend(id,cont,val){
        if(val=='one'){
            var str = id;
        }else{
            var str = '';
            $(id).each(function() {
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
</script>