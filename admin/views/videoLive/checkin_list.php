<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》发布/审核/备案》直播备案登记》<a class="nav-a">待备案</a></h1>
        <span class="back"><a class="btn" href="<?php echo $this->createUrl('videoLive/index_checked');?>""><i class="fa fa-reply"></i>返回</a> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search" style="border:none;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入直播编号 / 标题" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center;width: 50px;">序号</th>
                        <th style="width: 120px;"><?php echo $model->getAttributeLabel('code');?></th>
                        <th style="width: 200px;"><?php echo $model->getAttributeLabel('title');?></th>
                        <th><?php echo $model->getAttributeLabel('live_type');?></th>
                        <th>直播日期</th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th><?php echo $model->getAttributeLabel('state');?></th>
                        <th style="width:70px;">申请时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
				<?php  $index = 1;
				foreach($arclist as $v){ ?>                 
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->title; ?></td>
                        <td><?php if(!empty($v->livetype)) echo $v->livetype->sn_name; ?></td>
                        <td><?php echo $v->live_start_check.'<br>'.$v->live_end_check; ?></td>
                        <td><?php if(!empty($v->club_list)) echo $v->club_list->club_name; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo $v->state_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_checkin', array('id'=>$v->id));?>" title="详情">备案</a>
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
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>