<?php 
    $title='';
    if(!empty($_REQUEST['is_sign'])){
        if($_REQUEST['is_sign']==1){
            $title=' 》待签到';
        }elseif($_REQUEST['is_sign']==2){
            $title=' 》未签到';
        }
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》活动签到 》签到列表<?= $title;?></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if(empty($_REQUEST['is_sign'])){ ?>
            <div class="box-header">
                <span id="exam1" class="exam" onclick="on_exam(1);"><p>待签到：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
                <span id="exam2" class="exam" onclick="on_exam(2);"><p>未签到：<span style="color:red;font-weight: bold;"><?php echo $count2; ?></span></p></span>
            </div>
        <?php } ?>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input id="is_sign" type="hidden" name="is_sign" value="<?php echo Yii::app()->request->getParam('is_sign');?>">
                <label style="margin-right:10px;">
                    <span><?= empty($_REQUEST['is_sign'])?'签到':'开始';?>时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="star" name="star" value="<?php echo $star; ?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end; ?>">
                </label>
                <label style="margin-right:20px;">
                    <span>活动标题：</span>
                    <?php echo downList($activity_list,'id','activity_title','title','onchange="changeSignData(this);"'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>活动内容：</span>
                    <select name="content"><option value=''>请选择</option></select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入服务流水号">
                </label>
                <button id="search_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php if(!empty($_REQUEST['is_sign'])){ ?>
            <div class="box-search">
                <?php if($_REQUEST['is_sign']==1){ ?>
                    <a class="btn btn-blue" href="javascript:;" onclick="getSendCode('.check-item input:checked');" >一键发送验证码</a>
                    <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked');">一键签到</a>
                    
                    <span style="float:right;font-weight:700;margin-right:10px;">
                        <span class="btn">活动报名数：<b class="red"><?php echo $num; ?></b></span><span class="btn">待签到：<b class="red"><?php echo $count1; ?></b></span>
                    </span>
                    
                <?php }elseif($_REQUEST['is_sign']==2){ ?>
                    <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked');">一键补签</a>
                <?php } ?>
            </div><!--box-search end-->
        <?php } ?>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check" ><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('info_order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th>活动名称</th>
                        <th>活动内容</th>
                        <th>活动开始时间</th>
                        <th>报名人</th>
                        <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_come');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_code');?></th>
                        <?php if(empty($_REQUEST['is_sign'])){ ?>
                            <th>状态</th>
                        <?php }else{ ?>
                            <th>操作</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $index ?></td>
                        <td><?php echo $v->info_order_num; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->service_name; ?></td>
                        <td><?php echo $v->service_data_name; ?></td>
                        <td><?php echo $v->servic_time_star; ?></td>
                        <td><?php if(!is_null($v->activity_sign))echo $v->activity_sign->sign_name.'('.$v->gf_account.')'; ?></td>
                        <td><?php if(!is_null($v->activity_sign))echo $v->activity_sign->sige_phone; ?></td>
                        <td>
                            <?php 
                                $left = substr($v->sign_come,0,10);
                                $right = substr($v->sign_come,11);
                                echo $left.'<br>'.$right;
                            ?>
                        </td>
                        <td><?php echo $v->sign_code; ?></td>
                        <td style="text-align:center;">
                            <?php
                                if(empty($_REQUEST['is_sign'])&&$v->sign_come!=null&&$v->sign_come!='0000-00-00 00:00:00'){
                                    echo (strtotime($v->servic_time_star)>=time()) ? '已签到' : '人工补签';
                                }else{
                                    if(strtotime($v->servic_time_star)>=time()){
                                        if($v->send_sign_code==648){
                                            echo '<a class="btn btn-blue" onClick="sendVerificationCode('.$v->id.');" href="javascript:;" title="服务签到">发送验证码</a>&nbsp;';
                                        }else{
                                            echo '<a class="btn btn-blue" onClick="sendVerificationCode('.$v->id.');" href="javascript:;" title="服务签到">重发验证码</a>&nbsp;';
                                        }
                                    }
                                    $name = (strtotime($v->servic_time_star)<time()) ? '补签' : '签到';
                                    echo '<a class="btn btn-blue" onClick="save_Sourcer('.$v->id.');" href="javascript:;" title="服务签到">'.$name.'</a>';
                                }
                            ?>
                        </td>
                    </tr>
                <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    function on_exam(val){
        var exam = $('#exam'+val+' p span').text();
        if(exam>0){ 
            $('#is_sign').val(val);
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('search_submit').click();
        }
    }

    $(function(){
        var $star=$('#star');
        var $end=$('#end');
        $star.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $end.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });

        if($("select[name='title']").val()!=''){
            $("select[name='title']").trigger("change");
        }
    });

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
    
    // 获取所有选中多选框的值
    function getSendCode(op){
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        else{
            we.msg('minus','请先选中要签到的数据');
            return false;
        }
        sendVerificationCode(str);
    };

    // 发送验证码
    function sendVerificationCode(id){
        we.loading('show');
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('getSignCode');?>&id='+id,
            // data: {id: id},
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }
                else{
                    we.msg('minus',data.msg);
                }
            }
        });
        return false;
    }
    
    // 获取所有选中多选框的值
    checkval = function(op){
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        else{
            we.msg('minus','请先选中要签到的数据');
            return false;
        }
        save_Sourcer(str);
    };
    
    // 签到服务
    function save_Sourcer(id){
        var an = function(){
            $.ajax({
                type: 'get',
                url: '<?php echo $this->createUrl('save_Sourcer');?>&id='+id,
                // data: {id: id},
                dataType: 'json',
                success: function(data) {
                    if(data.status==1){
                        we.success(data.msg, data.redirect);
                    }else{
                        we.msg('minus', data.msg);
                    }
                }
            });
            return false;
        }
        $.fallr('show', {
            buttons: {
                button1: {text: '确定', danger: true, onclick: an},
                button2: {text: '取消'}
            },
            content: '是否签到？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    }
</script>