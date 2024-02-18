
<?php //var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>当前界面：会员 》龙虎会员管理 》未注册龙虎列表</span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search" style="padding-bottom: 15px;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="gf_id" value="<?php echo Yii::app()->request->getParam('gf_id');?>">
                <label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project_id'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>积分来源：</span>
                    <?php echo downList($get_type,'f_id','F_NAME','get_type'); ?>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:150px;" class="input-text" type="text" placeholder="请输入账号/姓名查询" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit" >查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('GF_ACCOUNT') ?></th>
                        <th><?php echo $model->getAttributeLabel('ZSXM') ?></th>
                        <th><?php echo $model->getAttributeLabel('project_id') ?></th>
                        <th><?php echo $model->getAttributeLabel('get_type') ?></th>
                        <th><?php echo $model->getAttributeLabel('get_score_game_reson') ?></th>
                        <th>本次积分</th>
                        <th>龙虎积分（总）</th>
                        <th>积分日期</th>
                </tr>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td><span class="num num-1"><?php echo $index; ?></td>
                        <td><?php echo $v->gfUser->GF_ACCOUNT; ?></td>
                        <td><?php echo $v->gfUser->ZSXM; ?></td>
                        <td><?php if(!is_null($v->projectList))echo $v->projectList->project_name; ?></td>
                        <td><?php if(!is_null($v->getType))echo $v->getType->F_NAME; ?></td>
                        <td><?php echo $v->get_score_game_reson; ?></td>
                        <td><?php echo $v->credit; ?></td>
                        <td>
                            <?php 
                                $credit_count=0;
                                $history=TopScoreHistory::model()->findAll('state=2 and gf_id='.$v->gf_id.' and project_id='.$v->project_id);
                                foreach($history as $h){
                                    $credit_count=$credit_count+$h->credit;
                                }
                                echo $credit_count; 
                            ?>
                        </td>
                        <td><?php echo $v->uDate; ?></td>
                    </tr>
                <?php $index++; } ?>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->