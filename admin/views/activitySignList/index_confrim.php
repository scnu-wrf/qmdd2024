<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动》活动报名》缴费确认 <?= !empty($_REQUEST['pay_confirm'])?'》待确认':'';?></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php if(empty($_REQUEST['pay_confirm'])){?>
                    <span class="exam" onclick="on_exam();"><p>待确认：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
            <?php }else{?>
                <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked');">确认</a>
            <?php }?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="pay_confirm" id="pay_confirm" value="<?php echo Yii::app()->request->getParam('pay_confirm');?>">
                <?php if(empty($_REQUEST['pay_confirm'])){?>
                    <label style="margin-right:10px;">
                        <span>确认时间：</span>
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
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check" ><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th class="list-id">序号</th>
                        <th><?php echo $model->getAttributeLabel('info_order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th>活动标题</th>
                        <th>活动内容</th>
                        <th><?php echo $model->getAttributeLabel('gf_account');?></th>
                        <th>报名人</th>
                        <th>费用(元)</th>
                        <th><?php echo $model->getAttributeLabel('free_make');?></th>
                        <th><?php echo $model->getAttributeLabel('buy_price2');?></th>
                        <th>支付方式</th>
                        <?php if(empty($_REQUEST['pay_confirm'])){?>
                            <th><?php echo $model->getAttributeLabel('pay_admin_name');?></th>
                            <th>操作时间</th>
                        <?php }else{ ?>
                            <th>支付时间</th>
                            <th>操作</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->info_order_num; ?></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php echo $v->service_name; ?></td>
                            <td><?php echo $v->service_data_name; ?></td>
                            <td><?php echo $v->gf_account; ?></td>
                            <td><?php if(!is_null($v->activity_sign))echo $v->activity_sign->sign_name; ?></td>
                            <td><?php echo $v->buy_price; ?></td>
                            <td><?php echo $v->free_make==0?'免费':'收费'; ?></td>
                            <td><?php echo $v->buy_price-$v->free_money; ?></td>
                            <td><?php if(!is_null($v->mall_order_num))echo $v->mall_order_num->pay_supplier_type_name; ?></td>
                            <?php if(empty($_REQUEST['pay_confirm'])){?>
                                <td><?php echo $v->pay_admin_name; ?></td>
                                <td><?php echo $v->pay_confirm_time; ?></td>
                            <?php }else{ ?>
                                <td><?php if(!is_null($v->mall_order_num))echo $v->mall_order_num->pay_time; ?></td>
                                <td>
                                    <a class="btn btn-blue" href="javascript:;" onclick="confirmed(<?=$v->id;?>)">确认</a>
                                </td>
                            <?php } ?>
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
            $('#pay_confirm').val(1);
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

    // 获取所有选中多选框的值
    checkval = function(op,num){
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        else{
            we.msg('minus','请先选中要确认的数据');
            return false;
        }
        confirmed(str);

    };

    // 确认操作
    function confirmed(id){
        var an = function(){
            console.log(id)
            we.loading('show');
            $.ajax({
                type:'post',
                url:'<?php echo $this->createUrl('confirmed'); ?>&id='+id,
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
        $.fallr('show', {
            buttons: {
                button1: {text: '确定', danger: true, onclick: an},
                button2: {text: '取消'}
            },
            content: '是否确认？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    }

</script>