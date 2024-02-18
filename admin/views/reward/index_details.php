<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播 》互动打赏 》<a class="nav-a">打赏明细查询</a></h1>
        <span style="float:right;margin-right: 15px;"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>选择直播：</span>
                    <?php echo downList($video_live,'id','title','video_live'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>起止时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="time_start" name="time_start" placeholder="开始时间" value="<?php echo $time_start;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="time_end" name="time_end" placeholder="结束时间" value="<?php echo $time_end;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入直播编号/单位名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('live_code'); ?></th>
                        <th><?php echo $model->getAttributeLabel('live_name'); ?></th>
                        <th><?php echo $model->getAttributeLabel('reward_gf_name'); ?></th>
                        <th><?php echo $model->getAttributeLabel('reward_type'); ?></th>
                        <th><?php echo $model->getAttributeLabel('gift_money'); ?></th>
                        <th><?php echo $model->getAttributeLabel('redenv_money'); ?></th>
                        <th><?php echo $model->getAttributeLabel('gf_name1'); ?></th>
                        <th><?php echo $model->getAttributeLabel('video_club_name'); ?></th>
                        <th><?php echo $model->getAttributeLabel('reward_time'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
                            <td><?php if(!empty($v->live_id)) echo $v->video_live_id->code;?></td>
                            <td><?php if(!empty($v->live_id)) echo $v->video_live_id->title;?></td>
                            <td>
                                <?php
                                    $club_name = '';
                                    if(!empty($v->live_id)){
                                        $club_name = $v->video_live_id->club_name;
                                    }
                                    echo (!empty($v->live_reward_gfid) && !empty($v->gf_live_reward_gfid)) ? $v->gf_live_reward_gfid->GF_NAME : $club_name;
                                ?>
                            </td>
                            <td><?php echo ($v->m_type==32) ? '普通礼物' : '红包'; ?></td>
                            <td><?php if($v->m_type==32) echo $v->live_reward_price; ?></td>
                            <td><?php if($v->m_type==40) echo $v->buy_price; ?></td>
                            <td><?php if(!empty($v->s_gfid) && !empty($v->gf_s_gfid)) echo $v->gf_s_gfid->GF_NAME; ?></td>
                            <td><?php if(!empty($v->live_id)) echo $v->video_live_id->club_name; ?></td>
                            <td><?php echo $v->pay_time; ?></td>
                        </tr>
                    <?php $index++; }?>
                </tbody>
            </table>
        </div>
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
</script>