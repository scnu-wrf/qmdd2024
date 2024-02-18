<?php
    $sel_2 = 0;
    $sel_3 = 0;
    $sel_1 = ClubMembershipFeeScaleInfo::model()->find('club_id='.get_session('club_id').' and use_default=1 and levetypeid=502');
    if(!empty($sel_1)){
        $sel_2 = $sel_1->use_default;
        $sel_3 = $sel_1->id;
    }
?>
<style>
    .box-table .list tr th,.box-table .list tr td{
        text-align: center;
    }
    .box-detail-tab li{
        width:24.9173%;
        border-right:solid 1px #d9d9d9;
        line-height: 30px;
        font-size:0.5rem;
    }
    .box-detail-tab{
        margin:10px auto 0;
    }
    .box-title h4{
        display: inline-block;
        width: auto;
        color: #444;
        font-size:12px;
        line-height: 30px;
    }
    .lode_po{
        color:#333;
    }
    .lode_po:hover{
        color:red;
    }
</style>
<div class="box">
    <!-- <div class="box-detail-tab">
        <ul class="c">
            <li class="current"><a href="<?php //echo $this->createUrl('clubProject/index_server_pay'); ?>">服务机构入驻应收费用列表</a></li>
            <li><a href="<?php //echo $this->createUrl('qualificationsPerson/index_pay'); ?>">服务者入驻应收费用列表</a></li>
            <li><a href="#">龙虎会员注册应收费用列表</a></li>
            <li style="border-right:none;"><a href="<?php //echo $this->createUrl('clubProject/index_strat_pay'); ?>">战略伙伴会员应收费用列表</a></li>
        </ul>
    </div>box-detail-tab end -->
    <div class="box-title c">
        <h4>
            <span>
                <a href="../../admin/index.php?act=main" class="lode_po" onclick="parent.location.reload();"><i class="fa fa-home"></i>当前界面：</a>会员费用管理->会员服务应收费用管理->
                <a class="lode_po" href="#">服务机构入驻应收费用列表</a>
            </span>
        </h4>
        <span style="float:right;"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="/*box-search*/">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project,'id','project_name','project'); ?>
                </label>
                <label style="display: inline-block;width: 200px;padding-top: 5px;">
                    <span>缴费状态：</span>
                    <?php echo downList($paymen_state,'f_id','F_NAME','paymen_state','style="margin-left: 12px;width: 92px;"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>入驻时间：</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="请输入开始时间" id="time_start" name="time_start" value="<?php echo $time_start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="请输入结束时间" id="time_end" name="time_end" value="<?php echo $time_end; ?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号/单位名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-header" style="position: relative;margin-top: 15px;border-top: solid 1px #d9d9d9;padding-top: 15px;">
            <label title="选择全部服务机构" style="margin-right:10px;">
                <span class="check">
                    <input class="input-check" id="check_all" value="1" type="checkbox" style="vertical-align:sub;">
                    <label for="check_all">全选</label>
                </span>
            </label>
            <label style="margin-right:10px;">
                <span>选择方案：</span>
                <select name="fee_list" onchange="selectFeeList(this,'.check-item input:checked');">
                    <option value="">请选择</option>
                    <?php foreach($fee_list as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if($v->use_default==1){?> selected<?php }?>><?php echo $v->name;?></option>
                    <?php }?>
                </select>
            </label>
            <input id="info_id" type="hidden">
            <span>
                <a href="javascript:;" class="btn" type="buttom" id="loke_fee" onclick="loke_fee();">方案详细</a>
                <div id="div_fee_list" class="dis_fee white_content" style="margin-top:10px;display:none;"></div>
            </span>
            <span style="float:right;">
                <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked','0');">免费/有偿</a>
                <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked','1');" style="margin-right:60px;width: 58px;text-align: center;">免单</a>
            </span>
        </div><!--box-header end-->
        <div class="box-table">
            <thead>
                <table class="list">
                    <?php $checked = 'checked="checked"'; ?>
                    <tr>
                        <th class="check" title="全选当前页面"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <!-- <th><?php //echo $model->getAttributeLabel('order_num');?></th> -->
                        <th><?php echo $model->getAttributeLabel('p_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('club_type');?></th>
                        <th><?php echo $model->getAttributeLabel('partnership_type');?></th>
                        <th>应收金额</th>
                        <th>收费项目名称</th>
                        <th>缴费状态</th>
                        <th><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th>操作</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" <?php if($v->free_state_Id==1200 || $v->free_state_Id==0){echo $checked;}else{echo 'disabled="disabled"';} ?> value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <!-- <td><?php //echo $v->order_num; ?></td> -->
                            <td><?php echo $v->p_code; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php if(!empty($v->club_type))echo $v->base_club_type->F_NAME; ?></td>
                            <td><?php if(!empty($v->partnership_type))echo $v->base_partnership_type->F_NAME; ?></td>
                            <td><?php echo $v->cost_admission; ?></td>
                            <td>入驻费</td>
                            <td><?php echo $v->free_state_name; ?></td>
                            <td><?php echo $v->add_time; ?></td>
                            <td>
                                <?php
                                    // if(empty($v->mall_order_num)){echo '<a class="btn btn-blue" href="javascript:;" onclick="on_click('.$v->id.',\''.$this->createUrl("send").'\')">通知缴费</a>&nbsp;';}
                                    // elseif(!empty($v->mall_order_num)){echo '<a class="btn btn-blue" href="javascript:;" onclick="on_click('.$v->id.',\''.$this->createUrl("unsend").'\')">取消通知</a>&nbsp;';}
                                    if(!empty($v->mall_order_num)){echo '<a class="btn btn-blue" href="javascript:;" onclick="on_click('.$v->id.',\''.$this->createUrl("unsend").'\')">取消通知</a>&nbsp;';}
                               ?>
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
        if(sel_2==1){
            div_html(sel_3);
        }
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
        console.log('183');
        if($(this).is(':checked')){
            $temp1.each(function() {
                this.checked = false;
            });
        }
    });
    $('.check-item .input-check').on('click',function(){
        console.log('191');
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
        if(num==0){ on_click(str,'<?php echo $this->createUrl("whole"); ?>'); }
        else { on_click(str,'<?php echo $this->createUrl("free"); ?>'); }
    };

    // count=whole 为免费/有偿
    // count=free 为免单
    // count=send 单个通知
    // count=unsend 取消通知
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

    function loke_fee(){
        if($('#div_fee_list').html()==''){
            we.msg('minus','请先选择方案');
            return false;
        }
        $('#div_fee_list').toggle(100);
        if($('#loke_fee').text()=='方案详细'){
            $('#loke_fee').text('关闭详细');
        }
        else{
            $('#loke_fee').text('方案详细');
        }
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
        if($('#check_all').is(':checked')){
            check_all = $('#check_all').val();
        }
        if(check_all==0 && str.length<1){
            we.msg('minus','请选择要设置的数据');
            return false;
        }
        div_html(obj);
        $("#info_id").val(obj);
        scaleInfo(str,'<?php echo $this->createUrl("scaleInfo"); ?>',obj,check_all,time_start,time_end);
    }

    function div_html(obj){
        var p_html ='';
        var s_num = 0;
        if(obj>0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('scales');?>&info_id='+obj,
                dataType: 'json',
                success: function(data) {
                    for(j=0;j<data.length;j++){
                        s_num++;
                        p_html += '<span style="display:inline-block;width:180px;">'+data[j]['levelname']+'<b>(￥：'+data[j]['scale_amount']+')</b></span>';
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
</script>
