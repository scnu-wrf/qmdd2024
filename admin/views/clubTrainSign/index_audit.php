<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》报名培训 》报名审核 <?= !empty($_REQUEST['state'])?'》待审核':'';?></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if(empty($_REQUEST['state'])){?>
            <div class="box-header" >
                <span class="exam" onclick="on_exam();"><p>待审核：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
            </div><!--box-header end-->
        <?php } ?>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <?php if(empty($_REQUEST['state'])){?>
                    <label style="margin-right:10px;">
                        <span>审核日期：</span>
                        <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                        <span>-</span>
                        <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                    </label>
                <?php } ?>
                <label style="margin-right:20px;">
                    <span>培训标题：</span>
                    <?php echo downList($train_list,'id','train_title','title','onchange="changeSignData(this);"'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>培训内容：</span>
                    <?php echo downList($train_data,'id','train_content','content'); ?>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号或标题">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php if(!empty($_REQUEST['state'])){?>
            <div class="box-header" >
                <span style="margin-right:10px;">
                    <input id="send_notice" class="input-check" type="checkbox" checked="checked" value="649">
                    <label for="send_notice">发送通知</label>
                </span>
                <a class="btn btn-blue" href="javascript:;" onclick="checkSubmit('tongguo')">审核通过</a>
                <a class="btn btn-blue" href="javascript:;" onclick="checkSubmit('butongguo')">审核不通过</a>
            </div><!--box-header end-->
        <?php } ?>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check" ><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('train_code');?></th>
                        <th>培训类别</th>
                        <th><?php echo $model->getAttributeLabel('train_title');?></th>
                        <th><?php echo $model->getAttributeLabel('train_data_id');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_account');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_name');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_sex');?></th>
                        <th><?php echo $model->getAttributeLabel('sige_phone');?></th>
                        <th>现有职称</th>
                        <th><?php echo $model->getAttributeLabel('train_identity_rank');?></th>
                        <?php if(empty($_REQUEST['state'])){?>
                            <th>审核<?php echo $model->getAttributeLabel('state');?></th>
                            <th>是否通知缴费</th>
                            <th><?php echo $model->getAttributeLabel('audit_time');?></th>
                            <th><?php echo $model->getAttributeLabel('adminname');?></th>
                        <?php }else{ ?>
                            <th>申请日期</th>
                        <?php } ?>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->train_code; ?></td>
                            <td><?php if(!is_null($v->train_data))echo $v->train_data->type_name; ?></td>
                            <td><?php echo $v->train_title; ?></td>
                            <td><?php echo $v->train_data_content; ?></td>
                            <td><?php echo $v->sign_account; ?></td>
                            <td><?php echo $v->sign_name; ?></td>
                            <td><?php echo $v->sign_sex_name; ?></td>
                            <td><?php echo $v->sige_phone; ?></td>
                            <td><?php echo $v->train_identity_type_name; ?></td>
                            <td><?php echo $v->train_identity_rank_name; ?></td>
                            <?php if(empty($_REQUEST['state'])){?>
                                <td><?php echo $v->state_name; ?></td>
                                <td>
                                    <?php 
                                        if(!is_null($v->gData))echo is_null($v->gData->sending_notice_time)?'否':'是'; 
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $left = substr($v->audit_time,0,10);
                                        $right = substr($v->audit_time,11);
                                        echo $left.'<br>'.$right; 
                                    ?>
                                </td>
                                <td><?php echo $v->adminname; ?></td>
                            <?php }else{ ?>
                                <td>
                                    <?php 
                                        $left = substr($v->uDate,0,10);
                                        $right = substr($v->uDate,11);
                                        echo $left.'<br>'.$right; 
                                    ?>
                                </td>
                            <?php } ?>
                            <td>
                                <?php echo show_command(empty($_REQUEST['state'])?'详情':'审核',$this->createUrl('update', array('id'=>$v->id,'index'=>2))); ?>
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
            $('#state').val(371);
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

    function changeSignData(obj) {
        var show_id = $(obj).val();
        var content='<option value="">请选择</option>';
        $("select[name='content']").html(content);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getListData'); ?>',
            data: {id: show_id},
            dataType: 'json',
            success: function(data) {
                $.each(data,function(k,info){
                    content+='<option value="'+info.id+'" remnant="'+info.remnant+'" >'+info.train_content+'</option>'
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

    function checkSubmit(state){
        var str = '';
        $(".check-item input:checked").each(function(){
            str += $(this).val() + ',';
        })
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请选中要审核的数据');
            return false;
        }
        var an = function(){
            var if_notice=$('#send_notice:checked').val()==649?649:648;
            we.loading('show');
            $.ajax({
                type:'post',
                url:'<?php echo $this->createUrl("check"); ?>',
                data: {id: str,submitType:state,if_notice:if_notice},
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
            content: '是否审核？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    }
</script>