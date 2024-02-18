<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动》活动报名》缴费通知 <?= !empty($_REQUEST['is_notice'])?'》待通知':'';?></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if(empty($_REQUEST['is_notice'])){?>
            <div class="box-header">
                <span class="exam" onclick="on_exam();"><p>待通知：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
                <span><a class="btn btn-blue" href="javascript:;"  onclick="checkval('.check-item input:checked');" style="margin-left:10px;">撤销通知</a></span>
            </div><!--box-header end-->
        <?php }?>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="is_notice" id="is_notice" value="<?php echo Yii::app()->request->getParam('is_notice');?>">
                <?php if(empty($_REQUEST['is_notice'])){?>
                    <label style="margin-right:10px;">
                        <span>通知时间：</span>
                        <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                        <span>-</span>
                        <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                    </label>
                <?php } ?>
                <label style="margin-right:20px;">
                    <span>活动标题：</span>
                    <?php echo downList($activity_list,'id','activity_title','title','onchange="changeSignData(this);"'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>活动内容：</span>
                    <select name="content"><option value=''>请选择</option></select>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入流水号/账号/姓名">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php if(!empty($_REQUEST['is_notice'])&&$_REQUEST['is_notice']==1){?>
    	<div class="box-table" >
            <table class="list">
                <tr>
                    <th style="width:20%;">收费方式</th>
                    <th>可执行操作</th>
                </tr>
                <tr>
                    <td>
                        <label style="margin-right:20px;">
                            <input id="sky1" name="sky" class="sky input-check" type="radio" value="1" /*checked="checked"*/><label for="sky1">实缴报名费</label>
                            <input id="sky2" name="sky" class="sky input-check" type="radio" value="0"><label for="sky2">免单</label>
                        </label>
                    </td>
                    <td>
                        <a href="javascript:;" class="btn btn-blue" onclick="sendNotice('.check-item input:checked');">确认通知</a>
                    </td>
                </tr>
            </table>
        </div><!--box-header end-->
        <?php }?>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check" ><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th class="list-id">序号</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th>活动标题</th>
                        <th>活动内容</th>
                        <th><?php echo $model->getAttributeLabel('gf_account');?></th>
                        <th>报名人</th>
                        <th>费用(元)</th>
                        <?php if(empty($_REQUEST['is_notice'])){?>
                            <th><?php echo $model->getAttributeLabel('sending_notice_time');?></th>
                            <th><?php echo $model->getAttributeLabel('notice_content');?></th>
                            <th>操作员</th>
                        <?php }else{ ?>
                            <th>报名时间</th>
                        <?php } ?>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item">
                                <?php if(((($v->is_pay==463||($v->is_pay==464&&$v->buy_price-$v->free_money==0))&&$v->free_make==1)||$v->free_make==0)&&$v->pay_confirm==0){?>
                                    <input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>">
                                <?php }?>
                            </td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php echo $v->service_name; ?></td>
                            <td><?php echo $v->service_data_name; ?></td>
                            <td><?php echo $v->gf_account; ?></td>
                            <td><?php if(!is_null($v->activity_sign))echo $v->activity_sign->sign_name; ?></td>
                            <td><?php echo $v->buy_price; ?></td>
                            <?php if(empty($_REQUEST['is_notice'])){?>
                                <td><?php echo $v->sending_notice_time; ?></td>
                                <td><?php echo $v->notice_content; ?></td>
                                <td><?php echo $v->admin_name; ?></td>
                            <?php }else{ ?>
                                <td><?php echo $v->add_time; ?></td>
                            <?php } ?>
                            <td>
                                <?php
                                    if(((($v->is_pay==463||($v->is_pay==464&&$v->buy_price-$v->free_money==0))&&$v->free_make==1)||$v->free_make==0)&&$v->pay_confirm==0&&(!is_null($v->sending_notice_time) && $v->sending_notice_time!="0000-00-00 00:00:00")){
                                        echo '<a class="btn btn-blue" href="javascript:;" onclick="clickUnnotice('.$v->id.')">撤销通知</a>';
                                    }elseif(is_null($v->sending_notice_time) || $v->sending_notice_time=="0000-00-00 00:00:00"){
                                        echo '<a href="javascript:;" class="btn" onclick="clickNotice('.$v->id.');">通知</a>';
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    function on_exam(){
        var exam = $('.exam p span').text();
        if(exam>0){ 
            $('#is_notice').val(1);
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('submit_button').click();
        }
    }

    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

    $(function(){
        if($("select[name='title']").val()!=''){
            $("select[name='title']").trigger("change");
        }
    })

    function changeSignData(obj) {
        var show_id = $(obj).val();
        var query_content = <?php echo !empty($_REQUEST['content'])?$_REQUEST['content']:0;?>;
        var content='<option value="">请选择</option>';
        $("select[name='content']").html(content);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getListData'); ?>',
            data: {id: show_id},
            dataType: 'json',
            success: function(data) {
                $.each(data,function(k,info){
                    content+='<option value="'+info.id+'" remnant="'+info.remnant+'" ';
                    if(query_content==info.id){
                        content+='selected = "selected"';
                    }
                    content+='>'+info.activity_content+'</option>'
                })
                $("select[name='content']").html(content);
            }
        });
    }

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

    function checkval(op){
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        else{
            we.msg('minus','请选择要撤销的人员');
            return false;
        }
        clickUnnotice(str);
    };

    function clickUnnotice(id){
        var an = function(){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('unnotice');?>&id='+id,
                dataType: 'json',
                success: function(data) {
                    we.success(data.msg, data.redirect);
                },
                error: function(request){
                    we.msg('minus','操作错误');
                }
            });
        }
        $.fallr('show', {
            buttons: {
                button1: {text: '确定', danger: true, onclick: an},
                button2: {text: '取消'}
            },
            content: '确定撤销通知吗？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    }
    
    function sendNotice(op){
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        else{
            we.msg('minus','请选择要通知的人员');
            return false;
        }
        clickNotice(str);
    };

    function clickNotice(id){
        if(!$(".sky:checked").val()){
            we.msg('minus','请选择缴费方式');
            return false;
        }
        var an1 = function(){
            var radio = $(".sky:checked").val();
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('notice');?>&id='+id+'&radio='+radio,
                dataType: 'json',
                success: function(data) {
                    if(data.status==1){
                        we.success(data.msg, data.redirect);
                    }
                    else{
                        we.msg('minus','操作失败');
                    }
                },
                error: function(request){
                    we.msg('minus','操作错误');
                }
            });
        }
        $.fallr('show', {
            buttons: {
                button1: {text: '确定', danger: true, onclick: an1},
                button2: {text: '取消'}
            },
            content: '确定通知吗？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    }
</script>