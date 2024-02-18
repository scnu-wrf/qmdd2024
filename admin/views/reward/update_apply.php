<?php
    check_request('state',0);
?>
<style>
    .td_type_y{ border-bottom: solid 2px #523b3b; }
    .switch{ width:50px; }
    .btn_fath{ position:relative; border-radius:20px; }
    .btn1{ float:left; }
    .btn2{ float:right; }
    .btnSwitch{height:25px;width:25px;border:none;color:#fff;line-height:22px;font-size:14px;text-align:center;z-index:1;}
    .move{width:20px;height:20px;z-index:100;border-radius:20px;cursor:pointer;position:absolute;border:1px solid #828282;background-color:#f1eff0;}
    .on .move{left:29px;}
    .on.btn_fath{background-color:#44b549;height:22px}
    .off.btn_fath{background-color:#828282;height:22px}
    .disable{ pointer-events: none; }

</style>
<div class="box">
    <?php if($_REQUEST['state']==1){ ?>
    <div class="box-title c">
        <h1>当前界面：直播 》互动打赏 》赞赏/礼物发布 》<?php echo empty($model->id) ? '添加' : '详情'; ?></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a>
        </span>
    </div><!--box-title end-->
    <?php }?>
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list());?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <div>
                    <?php if($_REQUEST['state']==1){ ?>
                    <table style="table-layout:auto;">
                        <tr>
                            <td style="width:10%;">开通打赏直播：<span class="required">*</span></td>
                            <td>
                                <?php
                                    if(empty($model->id)) {
                                        echo downList($video_live,'id','title','VideoLive[video_live_id]','id="VideoLive_video_live_id" onchange="changeVideoLive(this)"');
                                    }
                                    else{
                                        echo $model->title;
                                        echo $form->hiddenField($model,'id',array('name'=>'VideoLive[video_live_id]'));
                                    }
                                ?>
                                <div id="hidden_video" class="errorMessage" style="display:none;">直播项目不能为空</div>
                                <?php echo $form->error($model, 'video_live_id', $htmlOptions = array()); ?>
                            </td>
                            <!-- <td style="width:10%;">选择赞赏/礼物</td>
                            <td style="width:40%;">
                                <?php //if($_REQUEST['state']==1){ ?>
                                    <input type="button" class="btn" onclick="clickPic();" value="选择" style="margin-left:20px;color: #fff;border-color: #368EE0;background-color: #368EE0;">
                                <?php //}?>
                            </td> -->
                        </tr>
                    </table>
                    <?php }?>
                    <table class="<?php if($_REQUEST['state']==1) echo 'mt15'; ?> table_type">
                        <tr class="table-title">
                            <td style="width: 10%;">开通打赏类型：</td>
                            <td id="clickGiftAll" class="gift_type" style="text-align:center;cursor: pointer;width:8%;">全部</td>
                            <?php
                                $gift = GiftType::model()->findAll('is_use=649');
                                if(!empty($gift))foreach($gift as $g){
                            ?>
                                <td onclick="clickGift('gift_<?php echo $g->id; ?>');" code="gift_<?php echo $g->id; ?>" class="gift_type" style="text-align:center;cursor: pointer;width: 8%;">
                                    <?php echo $g->name; ?>
                                </td>
                            <?php }?>
                            <td></td>
                        </tr>
                    </table>
                    <table class="mt15">
                        <tr class="table-title" style="text-align:center;">
                            <td>序号</td>
                            <td>礼物类型</td>
                            <td>打赏编码</td>
                            <td>打赏名称</td>
                            <td>打赏图标</td>
                            <td>打赏价格</td>
                            <td>排序号</td>
                            <td>是否使用</td>
                        </tr>
                    </table>
                    <?php $index = 1; if(!empty($gift))foreach($gift as $gf){ ?>
                        <table id="reward_<?php echo $index; ?>" num="<?php echo $index; ?>" class="reward gift_<?php echo $gf->id; ?>">
                            <?php
                                $num = 1; 
                                if(!empty($Reward))foreach($Reward as $v){
                                    if($gf->id==$v->gift_type){
                                        $is_on = $v->if_use==0 ? 'off' : 'on';
                                        $interact_name = '';
                                        if(!empty($v->interact_type)){
                                            $base = BaseCode::model()->find('f_id='.$v->interact_type);
                                            if(!empty($base)){
                                                $interact_name = $base->F_NAME;
                                            }
                                        }
                            ?>
                                <tr id="line_<?php echo $v->reward_id; ?>" class="line" code="gift_<?php echo $gf->id; ?>" style="text-align:center;">
                                    <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][id]" value="<?php echo $v->id;?>">
                                    <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_id]" value="<?php echo $v->reward_id;?>">
                                    <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_code]" value="<?php echo $v->reward_code;?>">
                                    <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_name]" value="<?php echo $v->reward_name;?>">
                                    <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_pic]" value="<?php echo $v->reward_pic;?>">
                                    <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_gif]" value="<?php echo $v->reward_gif;?>">
                                    <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][interact_type]" value="<?php echo $v->interact_type;?>">
                                    <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][gift_type]" value="<?php echo $v->gift_type;?>">
                                    <td class="all_num"></td>
                                    <td class="one_num"><?php echo $num; ?></td>
                                    <td><?php echo $interact_name; ?></td>
                                    <td><?php echo $v->reward_code; ?></td>
                                    <td><?php echo $v->reward_name; ?></td>
                                    <td>
                                        <?php if(!empty($v->reward_pic)) {?>
                                            <a href="<?php echo $v->reward_pic;?>" target="_blank">
                                                <img src="<?php echo $v->reward_pic;?>" style="height: 50px;width: 50px;">
                                            </a>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <input type="text" class="input-text centent" 
                                            name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_price]" 
                                            value="<?php echo $v->reward_price; ?>" 
                                            <?php if($model->is_reward_state!=721) echo 'readonly="readonly"';?>>
                                    </td>
                                    <td>
                                        <input type="text" class="input-text" 
                                            name="reward_<?php echo $index; ?>[<?php echo $num;?>][sort_num]" 
                                            value="<?php echo $v->sort_num; ?>" 
                                            <?php if($model->is_reward_state!=721) echo 'readonly="readonly"';?>>
                                    </td>
                                    <td>
                                        <input type="hidden" id="reward_if_use_<?php echo $v->id; ?>" name="reward_<?php echo $index; ?>[<?php echo $num;?>][if_use]" value="<?php echo $v->if_use; ?>">
                                        <div class="switch">
                                            <div class="btn_fath clearfix <?php echo $is_on; ?>" onclick="toogle(this,'<?php echo $v->id; ?>')">
                                                <div class="move" data-state="<?php echo $is_on; ?>"></div>
                                                <div class="btnSwitch btn1">是</div>
                                                <div class="btnSwitch btn2">否</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php $num++; }}else{?>
                                <?php
                                    $rewardName = RewardName::model()->findAll('gift_type='.$gf->id);
                                    if(!empty($rewardName))foreach($rewardName as $rn){
                                        $pic = str_replace('http://upload.gfinter.net/','',$rn->reward_pic);
                                        $gif = str_replace('http://upload.gfinter.net/','',$rn->reward_gif);
                                ?>
                                    <tr id="line_<?php echo $rn->id; ?>" class="line" code="gift_<?php echo $gf->id; ?>" style="text-align:center;">
                                        <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][id]" value="null">
                                        <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_id]" value="<?php echo $rn->id;?>">
                                        <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_code]" value="<?php echo $rn->reward_code;?>">
                                        <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_name]" value="<?php echo $rn->reward_name;?>">
                                        <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_pic]" value="<?php echo $pic;?>">
                                        <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_gif]" value="<?php echo $gif;?>">
                                        <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][interact_type]" value="<?php echo $rn->interact_type;?>">
                                        <input type="hidden" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][gift_type]" value="<?php echo $rn->gift_type;?>">
                                        <td class="all_num"></td>
                                        <td class="one_num"><?php echo $num; ?></td>
                                        <td><?php echo $rn->interact_type_name; ?></td>
                                        <td><?php echo $rn->reward_code; ?></td>
                                        <td><?php echo $rn->reward_name; ?></td>
                                        <td>
                                            <?php if(!empty($rn->reward_pic)) {?>
                                                <a href="<?php echo $rn->reward_pic;?>" target="_blank">
                                                    <img src="<?php echo $rn->reward_pic;?>" style="height: 50px;width: 50px;">
                                                </a>
                                            <?php }?>
                                        </td>
                                        <td><input type="text" class="input-text centent" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_price]" value="<?php echo $rn->reward_price; ?>"></td>
                                        <td><input type="text" class="input-text" name="reward_<?php echo $index; ?>[<?php echo $num;?>][sort_num]" value=""></td>
                                        <td>
                                            <input type="hidden" id="reward_if_use_<?php echo $rn->id; ?>" name="reward_<?php echo $index; ?>[<?php echo $num;?>][if_use]" value="1">
                                            <div class="switch">
                                                <div class="btn_fath clearfix on" onclick="toogle(this,'<?php echo $rn->id;?>')">
                                                    <div class="move" data-state="on"></div>
                                                    <div class="btnSwitch btn1">是</div>
                                                    <div class="btnSwitch btn2">否</div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            <?php $num++; }}?>
                        </table>
                    <?php $index++; }?>
                </div>
                <div class="box-detail-submit">
                    <?php
                        if($_REQUEST['state']==1){
                            if($model->is_reward_state==721){
                                echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));
                            }
                            else if($model->is_reward_state==371){
                                echo show_shenhe_box(array('quxiao'=>'撤销提交'));
                            }
                            echo '<button class="btn" type="button" onclick="we.back();">取消</button>';
                        }
                    ?>
                </div>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function(){
        $('.table_type tr td:nth-child(2)').addClass('td_type_y');
        var g_type = $('.table_type tr td:nth-child(2)').attr('code');
        var reward_tr = $('.reward');
        var is_state = '<?php echo $_REQUEST['state']; ?>';
        if(is_state==0){
            $('.switch').addClass('disable');
        }
        ready_now();
    })

    function ready_now(){
        $('.one_num').hide();
        var s_num = 0;
        $('.all_num').each(function(){
            s_num++;
            $(this).html(s_num);
        });
    }

    function clickGift(code){
        $('.all_num').hide();
        $('.one_num').show();
        $('.gift_type').each(function(){
            if($(this).attr('code')==code){
                $(this).addClass('td_type_y');
            }
            else{
                $(this).removeClass('td_type_y');
            }
        })
        $('.reward').each(function(){
            if($(this).hasClass(code)){
                $(this).show();
            }
            else{
                $(this).hide();
            }
        });
    }
    
    $('#clickGiftAll').on('click',function(){
        $('.table_type tr td').removeClass('td_type_y');
        $('.one_num').hide();
        $('.all_num').show();
        $(this).addClass('td_type_y');
        $('.reward').show();
    });

    function changeVideoLive(obj){
        var obj = $(obj).val();
        if(obj==''){
            $('#hidden_video').css('display','block');
        }
        else{
            $('#hidden_video').css('display','none');
        }
    }

    $('.btn-blue').on('click',function(){
        if($('#VideoLive_video_live_id').val()==''){
            we.msg('minus','请选择直播','',1500);
            return false;
        }
        var is_ok = true;
        $('.centent').each(function(){
            if($(this).val()==''){
                is_ok = false;
                $(this).css('border-color','red');
            }
        });
        if(!is_ok){
            we.msg('minus','请输入价格');
            return false;
        }
    });

    function clickPic(){
        $.dialog.data('id', '');
        $.dialog.open('<?php echo $this->createUrl("select/rewardPictures");?>',{
            id:'pictures',
            lock:true,
            opacity:0.3,
            title:'选择图片',
            width:'40%',
            height:'70%',
            close: function () {
                if($.dialog.data('id')==-1){
                    var boxnum=$.dialog.data('reward_name');
                    for(var i=0;i<boxnum.length;i++){
                        if($('#line_'+boxnum[i].dataset.id).length==0){
                            var gift_append = $('.gift_'+boxnum[i].dataset.gifttype+' .line');
                            num = gift_append.length+1;
                            var gift = $('.gift_'+boxnum[i].dataset.gifttype);
                            var gift_attr = gift.attr('num');
                            gift.append(
                                '<tr id="line_'+boxnum[i].dataset.id+'" class="line '+boxnum[i].dataset.code+'" style="text-align:center;">'+
                                    '<input type="hidden" class="input-text" name="reward_'+gift_attr+'['+num+'][id]" value="null">'+
                                    '<input type="hidden" class="input-text" name="reward_'+gift_attr+'['+num+'][reward_id]" value="'+boxnum[i].dataset.id+'">'+
                                    '<input type="hidden" class="input-text" name="reward_'+gift_attr+'['+num+'][reward_code]" value="'+boxnum[i].dataset.code+'">'+
                                    '<input type="hidden" class="input-text" name="reward_'+gift_attr+'['+num+'][reward_name]" value="'+boxnum[i].dataset.name+'">'+
                                    '<input type="hidden" class="input-text" name="reward_'+gift_attr+'['+num+'][reward_pic]" value="'+boxnum[i].dataset.pic+'">'+
                                    '<input type="hidden" class="input-text" name="reward_'+gift_attr+'['+num+'][reward_gif]" value="'+boxnum[i].dataset.gif+'">'+
                                    '<input type="hidden" class="input-text" name="reward_'+gift_attr+'['+num+'][interact_type]" value="'+boxnum[i].dataset.interacttype+'">'+
                                    '<input type="hidden" class="input-text" name="reward_'+gift_attr+'['+num+'][gift_type]" value="'+boxnum[i].dataset.gifttype+'">'+
                                    '<td class="all_num"></td>'+
                                    '<td class="one_num">'+num+'</td>'+
                                    '<td>'+boxnum[i].dataset.interactname+'</td>'+
                                    '<td>'+boxnum[i].dataset.code+'</td>'+
                                    '<td>'+boxnum[i].dataset.name+'</td>'+
                                    '<td>'+
                                        '<a href="'+boxnum[i].dataset.pic+'" target="_blank">'+
                                            '<img src="'+boxnum[i].dataset.pic+'" style="height: 50px;width: 50px;">'+
                                        '</a>'+
                                    '</td>'+
                                    '<td><input type="text" class="input-text centent" name="reward_'+gift_attr+'['+num+'][reward_price]" value="'+boxnum[i].dataset.rewardprice+'"></td>'+
                                    '<td><input type="text" class="input-text centent" name="reward_'+gift_attr+'['+num+'][sort_num]" value="0"></td>'+
                                    '<td><a class="btn" href="javascript:;" onclick="$(this).parent().parent().remove();">删除</a></td>'+
                                '</tr>'
                            );
                            ready_now();
                            // num++;
                        }
                    }
                }
            }
        });
    }

    function toogle(th,id) {
        var ele = $(th).children(".move");
        var re = 0;
        if(ele.attr("data-state") == "on"){
            ele.animate({
                left: "0"
            }, 300, function() {
                ele.attr("data-state", "off");
            });
            $(th).removeClass("on").addClass("off");
            re = '0';
        }
        else if(ele.attr("data-state") == "off"){
            ele.animate({
                left: '29px'
            }, 300, function(){
                $(this).attr("data-state", "on");
            });
            $(th).removeClass("off").addClass("on");
            re = '1';
        }
        $('#reward_if_use_'+id).val(re);
    }
</script>