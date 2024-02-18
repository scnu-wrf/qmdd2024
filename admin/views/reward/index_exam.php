<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播 》互动打赏 》<a class="nav-a">待审核</a></h1>
        <span style="float:right;"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <!-- <label style="margin-right:10px;">
                    <span>查询提交时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="time_start" name="time_start" placeholder="请选择时间" value="<?php //echo Yii::app()->request->getParam('time_start');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="time_end" name="time_end" placeholder="请选择时间" value="<?php //echo Yii::app()->request->getParam('time_end');?>">
                </label> -->
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:150px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入直播编号/直播名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <a style="display:none;vertical-align: middle;" id="j-delete" class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked');">审核通过</a>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('code');?></th>
                        <th><?php echo $model->getAttributeLabel('title');?></th>
                        <th>直播时间</th>
                        <th>开通打赏类型</th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th><?php echo $model->getAttributeLabel('is_reward_add_time'); ?></th>
                        <th><?php echo $model->getAttributeLabel('is_reward_state'); ?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                  	<?php $index=1; foreach($arclist as $v){ $reward = Reward::model()->findAll('video_live_id='.$v->id);?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->title; ?></td>
                        <td></td>
                        <td>
                            <?php
                                $video_live_id = Reward::model()->findAll('video_live_id='.$v->id.' and if_del=648 and if_down=648');
                                $list1 = array();
                                if(!empty($video_live_id))foreach($video_live_id as $vl){
                                    if(!empty($vl->gift_type)){
                                        $gift = GiftType::model()->find('id='.$vl->gift_type);
                                        if(!empty($gift)){
                                            array_push($list1,$gift->name);
                                        }
                                    }
                                }
                                asort($list1);
                                $list1 = array_unique($list1);
                                foreach($list1 as $b){
                                    echo $b.'&nbsp;';
                                }
                            ?>
                        </td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->is_reward_add_time; ?></td>
                        <td><?php echo $v->base_is_reward_state->F_NAME; ?></td>
                        <td>
                            <?php echo show_command('审核',$this->createUrl('update_exam',array('id'=>$v->id)),'审核'); ?>
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
    $(function(){
        var $time_start=$('#time_start');
        var $time_end=$('#time_end');
        $time_start.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        $time_end.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });

    var rewardUp=function(op,state){
        var id=$(op).attr("id");
        on_click(id,state,'<?php echo $this->createUrl('updateState'); ?>');
    };

    checkval = function(op){
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请选择要审核的数据');
            return false;
        }
        on_click(str,372,'<?php echo $this->createUrl('updateState'); ?>');
    };

    function on_click(id,state,url){
        we.loading('show');
        $.ajax({
            type:'post',
            url:url+'&id='+id+'&state='+state,
            dataType:'json',
            success: function(data){
                we.loading('hide');
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            },
            errer: function(request){
                we.msg('minus','处理错误');
            }
        });
        return false;
    }
</script>
