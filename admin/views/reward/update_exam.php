<style>
    .td_type_y{
        border-bottom: solid 2px #523b3b;
    }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播 》互动打赏 》<a class="nav-a">待审核详情</a></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
        </span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list());?>
        <div class="box-detail-bd">
        <div style="display:block;" class="box-detail-tab-item">
                <div class="mt15">
                    <table class="mt15" style="table-layout:auto;">
                        <tr>
                            <td style="width:10%;">选择直播：<span class="required">*</span></td>
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
                                <input type="button" class="btn" onclick="clickPic();" value="选择" style="margin-left:20px;color: #fff;border-color: #368EE0;background-color: #368EE0;">
                            </td> -->
                        </tr>
                    </table>
                    <table class="mt15 table_type">
                        <tr class="table-title">
                            <td style="width: 10%;">互动打赏类型</td>
                            <?php
                                $gift = GiftType::model()->findAll('is_use=649');
                                if(!empty($gift))foreach($gift as $g){
                            ?>
                                <td onclick="clickGift('gift_<?php echo $g->id; ?>');" 
                                    code="gift_<?php echo $g->id; ?>" 
                                    class="gift_type" style="text-align:center;cursor: pointer;width: 8%;">
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
                            <td>操作</td>
                        </tr>
                    </table>
                    <?php $index = 1; if(!empty($gift))foreach($gift as $gf){ ?>
                        <table id="reward_<?php echo $index; ?>" class="reward gift_<?php echo $gf->id; ?>">
                            <?php
                                $num=1; 
                                if(!empty($Reward))foreach($Reward as $v){
                                    if($gf->id==$v->gift_type){
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
                                    <td><?php echo $num; ?></td>
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
                                    <td><input type="text" class="input-text centent" name="reward_<?php echo $index; ?>[<?php echo $num;?>][reward_price]" value="<?php echo $v->reward_price; ?>"></td>
                                    <td><input type="text" class="input-text centent" name="reward_<?php echo $index; ?>[<?php echo $num;?>][sort_num]" value="<?php echo $v->sort_num; ?>"></td>
                                    <td><a class="btn" href="javascript:;" onclick="$(this).parent().parent().remove();">删除</a></td>
                                </tr>
                            <?php $num++; }} ?>
                        </table>
                    <?php $index++; }?>
                </div>
                <table class="mt15" style="table-layout:auto;">
                    <tr>
                        <td style="width:10%;"><?php echo $form->labelEx($model,'is_reward_reasons_failure'); ?></td>
                        <td>
                            <?php echo ($model->is_reward_state!=371) ? $model->reasons_failure : $form->textArea($model, 'reasons_failure', array('class' => 'input-text' )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>审核操作</td>
                        <td>
                            <?php
                                if($model->is_reward_state==721){
                                    echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));
                                }
                                else if($model->is_reward_state==371){
                                    echo show_shenhe_box(array('tongguo'=>'审核通过','tuihui'=>'退回修改','butongguo'=>'审核不通过'));
                                }
                            ?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
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
        reward_tr.each(function(){
            if($(this).hasClass(g_type)){
                $(this).show();
            }
            else{
                $(this).hide();
            }
        });
    })

    function clickGift(code){
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
</script>