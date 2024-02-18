<?php
    check_request('game_id',0);
    check_request('title','');
    check_request('p_id',0);
?>
<div class="box">
    <div class="box-title c">
        <span>
            <a href="../../admin/index.php?act=main" class="lode_po" onclick="parent.location.reload();"><i class="fa fa-home"></i>当前界面：</a>赛事/活动/培训->
            <a href="#" class="lode_po">赛事管理</a>->
            <a href="<?php echo $this->createUrl('gameList/update_history',array('id'=>$_REQUEST['game_id'],'p_id'=>$_REQUEST['p_id']));?>" class="lode_po">历史赛事列表</a>->
            <a href="#" class="lode_po">赛事成员</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab">
            <ul class="c">
                <li><a href="<?php echo $this->createUrl('gameList/update_history',array('id'=>$_REQUEST['game_id'],'p_id'=>$_REQUEST['p_id']));?>">基本信息</a></li>
                <li><a href="<?php echo $this->createUrl('gameRefereesList/index_history',array('game_id'=>$_REQUEST['game_id'],'p_id'=>$_REQUEST['p_id'])); ?>">赛事裁判</a></li>
                <li class="current"><a href="#">赛事成员</a></li>
                <li><a href="<?php echo $this->createUrl('gameListArrange/index_history',array('game_id'=>$_REQUEST['game_id'],'p_id'=>$_REQUEST['p_id'])); ?>">赛事赛程</a></li>
                <li><a href="<?php  ?>">赛事成绩</a></li>
            </ul>
        </div>
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="game_id" value="<?php echo Yii::app()->request->getParam('game_id');?>">
                <label style="margin-right:20px;">
                    <span>竞赛项目：</span>
                    <?php echo downList($data_list,'id','game_data_name','data_id') ?>
                </label>
                <label style="margin-right:20px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号或姓名">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_account');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_sex');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_game_contect');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('team_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_money');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){?>
                        <tr>
                            <td style='text-align: center;'><span class="num num-1"><?php echo $index; ?></span></td>
                            <td style="text-align: center;"><?php echo $v->sign_account; ?></td>
                            <td style="text-align: center;"><?php echo $v->sign_name; ?></td>
                            <td style="text-align: center;"><?php if(!empty($v->sign_sex)) echo $v->usersex->F_NAME; ?></td>
                            <td style="text-align: center;"><?php echo $v->sign_game_contect; ?></td>
                            <td style="text-align: center;"><?php echo $v->team_name; ?></td>
                            <td style="text-align: center;"><?php echo $v->game_money; ?></td>
                            <td style="text-align: center;"><?php echo $v->state_name; ?></td>
                            <td style='text-align: center;'>
                                <a href="<?php echo $this->createUrl('update', array('id'=>$v->id,'p_id'=>0)); ?>" class="btn" title="详情"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->