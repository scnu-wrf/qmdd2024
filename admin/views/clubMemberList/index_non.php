
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
                <label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project_id'); ?>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:150px;" class="input-text" type="text" placeholder="" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit" >查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('gf_account') ?></th>
                        <th><?php echo $model->getAttributeLabel('zsxm') ?></th>
                        <th><?php echo $model->getAttributeLabel('member_project_id') ?></th>
                        <th><?php echo $model->getAttributeLabel('integral') ?></th>
                        <th>是否注册龙虎</th>
                        <th><?php echo $model->getAttributeLabel('udate') ?></th>
                        <th>操作</th>
                </tr>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td><span class="num num-1"><?php echo $index; ?></td>
                        <td><?php echo $v->gf_account; ?></td>
                        <td><?php echo $v->zsxm; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->integral; ?></td>
                        <td><?php echo '未注册'; ?></td>
                        <td><?php echo $v->udate; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('topScoreHistory/index', array('gf_id'=>$v->member_gfid,'project_id'=>$v->member_project_id));?>" title="积分明细">积分明细</a>
                        </td>
                    </tr>
                <?php $index++; } ?>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->