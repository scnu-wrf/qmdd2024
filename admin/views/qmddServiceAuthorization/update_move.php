<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约 》服务签到 》签到管理 》动动约签到授权 》<?php echo empty($model->id) ? '添加' : '详情'; ?></h1>
        <span class="back">
            <a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
        </span>
    </div>
    <div class="box-detail">
        <div class="box-detail-bd">
            <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
                <table class="" style="table-layout:auto;">
                    <tr>
                        <td style="width:15%;"><?php echo $form->labelEx($model,'service_type'); ?></td>
                        <td>
                            <?php
                                $service_type = QmddServerType::model()->findAll('if_del=510');
                                echo $form->dropDownList($model,'service_type',CHtml::listData($service_type,'id','t_name'),array('prompt'=>'请选择','onchange'=>'changeQuery(this);'));
                                echo $form->error($model,'service_type',$htmlOption=array());
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%;"><?php echo $form->labelEx($model,'authorized_person_id'); ?></td>
                        <td>
                            <?php
                                echo $form->hiddenField($model, 'club_id', array('class' => 'input-text', 'value'=>empty($model->id) ? get_session('club_id') : $model->club_id));
                                echo $form->hiddenField($model,'authorized_person_id');
                                echo $form->error($model,'authorized_person_id',$htmlOption=array());
                            ?>
                            <span id="person_account">
                                <?php
                                    if(!empty($model->authorized_person_id)) {
                                        $account_list = GfUser1::model()->findAll('GF_ID in('.$model->authorized_person_id.')');
                                        if(!empty($account_list))foreach($account_list as $al){
                                            // echo '<span class="label-box">'.$al->GF_ACCOUNT.'/'.$al->ZSXM.'</span>';
                                            echo '<span class="label-box" id="item_'.$al->GF_ID.'" data-id="'.$al->GF_ID.'">'.$al->GF_ACCOUNT.'<i onclick="fnDeleteProjectnot(this);"></i></span>';
                                        }
                                    }
                                ?>
                            </span>
                            <input type="button" id="select_account" class="btn" onclick="clickSelectAccount();" value="选择账号">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'service_name'); ?></td>
                        <td>
                            <span id="person_name">
                                <?php
                                    if(!empty($model->authorized_person_id)) {
                                        $account_list = GfUser1::model()->findAll('GF_ID in('.$model->authorized_person_id.')');
                                        if(!empty($account_list))foreach($account_list as $al){
                                            echo '<span class="label-box item_'.$al->GF_ID.'" data-id="'.$al->GF_ID.'">'.$al->ZSXM.'</span>';
                                        }
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>可执行操作</td>
                        <td>
                            <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!--box end-->
<script>
    $(function(){
        fuSearchLabelBoxLength();
    })

    // 选择服务者
    var num = 0;
    function clickSelectAccount(){
        var club_id = $('#QmddServiceAuthorization_club_id').val();
        var relen = fuSearchLabelBoxLength();
        if(relen==2){
            we.msg('minus','请先删除');
            return false;
        }
        $.dialog.data('person_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser_move");?>&club_id='+club_id+'&len='+relen,{
            id:'fuwuzhe',
            lock:true,
            opacity:0.3,
            width:'80%',
            height:'80%',
            title:'选择具体内容',
            close: function () {
                if($.dialog.data('id')==-1){
                    var boxnum=$.dialog.data('service_name');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#item_'+boxnum[j].dataset.id).length==0){
                            $('#person_account').append('<span class="label-box" id="item_'+boxnum[j].dataset.id+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.code+'<i onclick="fnDeleteProjectnot(this);"></i></span>');
                            $('#person_name').append('<span class="label-box item_'+boxnum[j].dataset.id+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.zsxm+'</span>');
                            num++;
                            fnUpdateProjectnot();
                        }
                    }
                    fuSearchLabelBoxLength();
                }
            }
        });
    }

    var fnUpdateProjectnot=function(){
        var arr=[];
        var id;
        $('#person_account').find('span').each(function(){
            id=$(this).attr('data-id');
            arr.push(id);
        });
        $('#QmddServiceAuthorization_authorized_person_id').val(we.implode(',', arr));
    };

    var fnDeleteProjectnot=function(op){
        $(op).parent().remove();
        fnUpdateProjectnot();
        fnDeleteName(op);
        fuSearchLabelBoxLength();
    };

    // 删除账号同时删除名字
    function fnDeleteName(op){
        var pid = $(op).parent().attr('data-id');
        $('.item_'+pid).remove();
    }

    // 判断有几人
    function fuSearchLabelBoxLength(){
        var len = $('#person_account .label-box').length;
        if(len<2){
            $('#select_account').show();
        }
        else{
            $('#select_account').hide();
        }
        return len;
    }

    function changeQuery(ob){
        var val = $(ob).val();
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('getChangeQuery',array('club_id'=>get_session('club_id'))); ?>&service_type='+val,
            dataType: 'json',
            success: function(data){
                if(data==1){
                    we.msg('minus','已存在的类型，请重新选择');
                    $(ob).val('');
                }
            },
            error: function(request){
                console.log(request);
            }
        })
    }
</script>