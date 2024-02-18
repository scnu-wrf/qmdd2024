<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播打赏》发布审核</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a href="<?php echo $this->createUrl('index_exam'); ?>" class="btn btn-blue" onclick="add_recive();" *="">待审核(<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span>)</a>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>审核时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="time_start" name="time_start" placeholder="请选择时间" value="<?php echo $time_start;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="time_end" name="time_end" placeholder="请选择时间" value="<?php echo $time_end;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:150px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入直播编号/直播名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="width:3%;text-align:center;">序号</th>
                        <th style="width:10%;"><?php echo $model->getAttributeLabel('code');?></th>
                        <th><?php echo $model->getAttributeLabel('title');?></th>
                        <th>直播时间</th>
                        <th>开通打赏类型</th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th><?php echo $model->getAttributeLabel('is_reward_state'); ?></th>
                        <th><?php echo $model->getAttributeLabel('is_reward_time'); ?></th>
                        <th><?php echo $model->getAttributeLabel('is_reward_admin_id'); ?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                  	<?php $index=1; foreach($arclist as $v){ $reward = Reward::model()->findAll('video_live_id='.$v->id);?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->title; ?></td>
                        <td></td>
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
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->base_is_reward_state->F_NAME; ?></td>
                        <td><?php echo substr($v->is_reward_time,0,10).'<br>'.substr($v->is_reward_time,11); ?></td>
                        <td><?php echo $v->is_reward_admin_name; ?></td>
                        <td>
                            <?php
                                echo show_command('详情',$this->createUrl('update_exam',array('id'=>$v->id)),'详情');
                                if($v->is_reward_state==373){
                                    echo '&nbsp;';
                                    echo show_command('删除','\''.$v->id.'\'');
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
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
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
</script>
