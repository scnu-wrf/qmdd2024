<?php
    if(!isset($_REQUEST['page'])){
        $_REQUEST['page'] = 1;
    }
    if(!isset($_REQUEST['game_area'])){
        $_REQUEST['game_area'] = '';
    }
    if(!isset($_REQUEST['limit_start'])){
        $_REQUEST['limit_start'] = '';
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》排名 》实时排名榜</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div>
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project'); ?>
                    <!-- <select name="project" id="">
                        <?php //foreach($project_list as $pl) {?>
                            <option value="<?php //echo $pl->id; ?>" <?php //if($pl->id==$_REQUEST['project']) echo 'selected'; ?>><?php //echo $pl->project_name; ?></option>
                        <?php //}?>
                    </select> -->
                </label>
                <label style="margin-right:10px;">
                    <span>级别：</span>
                    <?php echo downList($game_area_list,'f_id','F_NAME','game_area'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>性别：</span>
                    <?php echo downList($sex_list,'f_id','F_NAME','top_gfsex'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>排名名次：</span>
                    <input style="width:100px;" type="text" class="input-text" id="limit_start" name="limit_start" value="<?php echo Yii::app()->request->getParam('limit_start'); ?>" placeholder="输入开始名次">
                    <span>-</span>
                    <input style="width:100px;" type="text" class="input-text" id="limit_end" name="limit_end" value="<?php echo Yii::app()->request->getParam('limit_end'); ?>" placeholder="输入查看的条数">
                </label>
                <label style="margin-right:10px;">
                    <span>单位名称：</span>
                    <input style="width:150px;" type="text" class="input-text" name="club_name" value="<?php echo Yii::app()->request->getParam('club_name'); ?>" placeholder="请输入单位名称">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:150px;" type="text" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入账号 / 姓名">
                </label>
                <button type="submit" id="search_submit" class="btn btn-blue">查询</button>
            </form>
        </div>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th><?php echo $model->getAttributeLabel('real_time_ranks'); ?></th>
                        <th><?php echo $model->getAttributeLabel('top_gfaccount'); ?></th>
                        <th><?php echo $model->getAttributeLabel('top_gfzsxm'); ?></th>
                        <th><?php echo $model->getAttributeLabel('top_gfsex'); ?></th>
                        <th><?php echo $model->getAttributeLabel('top_project_id'); ?></th>
                        <!-- <th><?php //echo $model->getAttributeLabel('credit'); ?></th> -->
                        <!-- <th><?php //echo $model->getAttributeLabel('votes'); ?></th> -->
                        <!-- <th><?php //echo $model->getAttributeLabel('clicks'); ?></th> -->
                        <th><?php echo $model->getAttributeLabel('club_score'); ?></th>
                        <th><?php echo $model->getAttributeLabel('municipal_score'); ?></th>
                        <th><?php echo $model->getAttributeLabel('province_score'); ?></th>
                        <th><?php echo $model->getAttributeLabel('country_score'); ?></th>
                        <th><?php echo $model->getAttributeLabel('world_score'); ?></th>
                        <th><?php echo $model->getAttributeLabel('club_id'); ?></th>
                        <th><?php echo $model->getAttributeLabel('naming_club'); ?></th>
                        <!-- <th>操作</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $page = $_REQUEST['page'];
                        $index = 1;
                        // $num = 0;
                        // $index = ($page>1) ? (($page + 15 - 1) % 15 == 0) ? 2 : 3 : 1;
                        // // $num = $page * 1;
                        $index = ($page>1) ? 1 + $page * 15 - 15 : $index;
                        // echo $index;
                        $index = empty($_REQUEST['limit_start']) ? $index : $_REQUEST['limit_start'];
                        foreach($arclist as $v) {
                    ?>
                        <tr>
                            <td><?php echo $index; ?></td>
                            <td><?php echo $v->top_gfaccount; ?></td>
                            <td><?php echo $v->top_gfzsxm; ?></td>
                            <td><?php if(!empty($v->top_gfsex)) echo $v->base_sex->F_NAME; ?></td>
                            <td><?php echo $v->top_project_name; ?></td>
                            <!-- <td><?php //echo $v->credit; ?></td> -->
                            <!-- <td><?php //echo $v->votes; ?></td> -->
                            <!-- <td><?php //echo $v->clicks; ?></td> -->
                            <td><?php echo (empty($_REQUEST['game_area'])) ? $v->club_score : $v->club_score; ?></td>
                            <td><?php echo empty($v->municipal_score) ? '0.0' : $v->municipal_score; ?></td>
                            <td><?php echo empty($v->province_score) ? '0.00' : $v->province_score; ?></td>
                            <td><?php echo empty($v->country_score) ? '0.000' : $v->country_score; ?></td>
                            <td><?php echo $v->world_score; ?></td>
                            <td><?php if(!empty($v->club_id) && !empty($v->club_lists)) echo $v->club_lists->club_name; ?></td>
                            <td></td>
                            <!-- <td>
                                <?php //echo show_command('详情',$this->createUrl('update_real_time_ranking',array('id'=>$v->id)),'详情') ?>
                            </td> -->
                        </tr>
                    <?php $index++;}?>
                </tbody>
            </table>
        </div>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div>
</div>
<script>
    $('#search_submit').on('click',function(){
        var limit_start = $('#limit_start').val();
        var limit_end = $('#limit_end').val();
        // console.log(limit_start,limit_end);
        if(limit_start>0 && limit_end<1){
            // console.log(1212);
            we.msg('minus','排名截止数字不对');
            return false;
        }
        if(limit_end>0 && limit_start<1){
            we.msg('minus','排名开始数字不对');
            return false;
        }
    })
</script>