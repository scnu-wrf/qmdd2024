<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <!-- <th><?php //echo $model->getAttributeLabel('gf_account'); ?></th> -->
                        <th><?php echo $model->getAttributeLabel('reward_gf_name'); ?></th>
                        <th><?php echo $model->getAttributeLabel('cover_name'); ?></th>
                        <th><?php echo $model->getAttributeLabel('receiv_num'); ?></th>
                        <th><?php echo $model->getAttributeLabel('gift_tatil'); ?></th>
                        <th><?php echo $model->getAttributeLabel('redenv_num'); ?></th>
                        <th><?php echo $model->getAttributeLabel('redenv_tatil'); ?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="num num-1">1</span></td>
                        <!-- <td><?php //if(!empty($video_id->club_id)) echo $video_id->club_list->club_code; ?></td> -->
                        <td><?php echo $video_id->club_name; ?></td>
                        <td>直播发布者</td>
                        <td>
                            <?php
                                $count = $model->findAll('live_id='.$video_id->id.' and is_pay=464 and live_reward_id<>0 and m_type=32');
                                echo count($count);
                            ?>
                        </td>
                        <td>
                            <?php
                                $sum = 0;
                                if(!empty($count))foreach($count as $c){
                                    $sum = $sum+$c->live_reward_price;
                                }
                                echo $sum;
                            ?>
                        </td>
                        <td>
                            <?php
                                $red = $model->findAll('live_id='.$video_id->id.' and is_pay=464 and live_reward_id<>0 and m_type=40');
                                echo count($red);
                            ?>
                        </td>
                        <td>
                            <?php
                                $red_sum = 0;
                                if(!empty($red))foreach($red as $r){
                                    $red_sum = $red_sum+$r->live_reward_price;
                                }
                                echo $red_sum;
                            ?>
                        </td>
                        <td>
                            <a href="javascript:;" class="btn" onclick="clickDetail1('<?php echo $this->createUrl('details_child',array('id'=>$video_id->id)); ?>','<?php echo $video_id->club_name; ?>');">明细</a>
                        </td>
                    </tr>
                    <?php $index = 2; foreach($arclist as $v){?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
                            <!-- <td><?php //if(!empty($v->live_reward_gfid)) ?></td> -->
                            <td>
                                <?php
                                    $gf_name = '';
                                    if(!empty($v->s_gfid) && !empty($v->gf_s_gfid)){
                                        $gf_name = $v->gf_s_gfid->GF_NAME;
                                        echo $gf_name;
                                    }
                                ?>
                            </td>
                            <td>嘉宾</td>
                            <td>
                                <?php
                                    $v_count = $model->findAll('live_id='.$v->live_id.' and s_gfaccount="'.$v->s_gfaccount.'" and is_pay=464 and live_reward_id<>0 and m_type=32');
                                    echo count($v_count);
                                ?>
                            </td>
                            <td>
                                <?php
                                    $v_sum = 0;
                                    if(!empty($v_count))foreach($v_count as $vc){
                                        $v_sum = $v_sum+$vc->live_reward_price;
                                    }
                                    echo $v_sum;
                                ?>
                            </td>
                            <td>
                                <?php
                                    $v_red = $model->findAll('live_id='.$v->live_id.' and is_pay=464 and live_reward_id<>0 and m_type=40');
                                    echo count($v_red);
                                ?>
                            </td>
                            <td>
                                <?php
                                    $v_red_sum = 0;
                                    if(!empty($v_red))foreach($v_red as $vr){
                                        $v_red_sum = $v_red_sum+$vr->live_reward_price;
                                    }
                                    echo $v_red_sum;
                                ?>
                            </td>
                            <td>
                                <a href="javascript:;" class="btn" onclick="clickDetail1('<?php echo $this->createUrl('details_child',array('id'=>$v->live_id,'account'=>$v->s_gfaccount)); ?>','<?php echo $v->gf_s_gfid->GF_NAME ?>');">明细</a>
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
    function clickDetail1(action,title){
        $.dialog.data('id', '');
        $.dialog.open(action,{
            id:'details1',
            lock:true,
            opacity:0.3,
            title:title+'-礼物明细',
            width:'60%',
            height:'80%',
            close: function () {}
        });
    }
</script>