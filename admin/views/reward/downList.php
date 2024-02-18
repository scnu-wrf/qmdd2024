<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播 》直播打赏 》下架/历史打赏直播列表</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>操作时间：</span>
                    <input style="width:120px;" type="text" class="input-text" name="is_reward_oper_time">
                </label>
            </form>
        </div>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <!-- <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th> -->
                        <th>序号</th>
                        <th style="width:10%;"><?php echo $model->getAttributeLabel('code');?></th>
                        <th style="width:15%;"><?php echo $model->getAttributeLabel('title');?></th>
                        <th>直播时间</th>
                        <th>显示时间</th>
                        <th>互动打赏类型</th>
                        <th><?php echo $model->getAttributeLabel('is_reward');?></th>
                        <th><?php echo $model->getAttributeLabel('is_reward_oper_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index=1; foreach($arclist as $v){ $reward = Reward::model()->findAll('video_live_id='.$v->id);?>
                    <tr>
                        <!-- <td class="check check-item"><input class="input-check" type="checkbox" value="<?php //echo CHtml::encode($v->id); ?>"></td> -->
                        <td><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->title; ?></td>
                        <td><?php echo $v->live_start.'<br>'.$v->live_end; ?></td>
                        <td><?php echo $v->live_start.'<br>'.$v->live_end; ?></td>
                        <td>
                            <?php
                                $video_live_id = Reward::model()->findAll('video_live_id='.$v->id.' and if_del=648 and if_down=648 group by gift_type');
                                $list1 = array();
                                if(!empty($video_live_id)){
									foreach($video_live_id as $vl){
										if(!empty($vl->gift_type)){
											$gift = GiftType::model()->find('id='.$vl->gift_type);
											if(!empty($gift)){
												array_push($list1,$gift->name);
											}
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
                        <td><?php echo ($v->is_reward==0) ? '关闭' : '打开'; ?></td>
                        <td><?php echo $v->is_reward_oper_time ?></td>
                        <td>
                            <a href="javascript:;" class="btn" onclick="look('<?php echo $this->createUrl('update_apply',array('id'=>$v->id,'state'=>0)); ?>','<?php echo $v->title;?>');">详情</a>
                            <a href="<?php echo $this->createUrl('videoLiveSignSetting/index',array('video_live_id'=>$v->id,'return_state'=>2)); ?>" class="btn">打赏对象</a>
                            <a href="javascript:;" class="btn" onclick="clickDetails('<?php echo $v->id;?>','<?php echo $v->title;?>');">明细</a>
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
    function look(action,title){
        $.dialog.data('id', '');
        $.dialog.open(action,{
            id:'update_apply',
            lock:true,
            opacity:0.3,
            title:title+'-礼物详情',
            width:'90%',
            height:'90%',
            close: function () {}
        });
    }

    function clickDetails(id,title){
        $.dialog.data('id', '');
        $.dialog.open('<?php echo $this->createUrl('details'); ?>&id='+id,{
            id:'details',
            lock:true,
            opacity:0.3,
            title:title+'-获打赏明细',
            width:'90%',
            height:'90%',
            close: function () {}
        });
    }
</script>