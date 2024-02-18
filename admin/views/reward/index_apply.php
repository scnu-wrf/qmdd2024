<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播 》直播打赏 》发布打赏</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create',array('state'=>1)),'添加'); ?>
            <?php echo show_command('批删除'); ?>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('code'); ?></th>
                        <th><?php echo $model->getAttributeLabel('title'); ?></th>
                        <th>直播时间</th>
                        <th>开通打赏类型</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $index = 1;
                        foreach($arclist as $v){
                            $reward = Reward::model()->findAll('video_live_id='.$v->id);
                    ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
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
                            <td><?php echo $v->base_is_reward_state->F_NAME; ?></td>
                            <td>
                                <?php
                                    echo show_command('详情',$this->createUrl('update_apply',array('id'=>$v->id,'state'=>1)),'详情').'&nbsp;';
                                    if($v->is_reward_state==721) echo show_command('删除','\''.$v->id.'\'');
                                    if($v->is_reward_state==371) echo '<a href="javascript:;" class="btn" onclick="clickStatu(\''.$v->id.'\')">撤销提交</a>';
                                ?>
                            </td>
                        </tr>
                    <?php $index++; }?>
                </tbody>
            </table>
        </div>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';

    function clickStatu(id){
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('status'); ?>&id='+id,
            dataType: 'json',
            success: function(data){
                we.loading('hide');
                if(data.status==1){
                    we.success(data.msg,data.redirect);
                }
                else{
                    we.msg('minus',data.msg);
                }
            },
            errer: function(request){
                we.msg('设置错误');
            }
        });
        return false;
    }
</script>