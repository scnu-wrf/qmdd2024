<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》发布/审核/备案》<a class="nav-a">直播发布申请</a></h1>
        <span class="back"><a class="btn" href="<?php echo Yii::app()->request->url;?>"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>类型：</span>
                    <?php echo downList($live_type,'id','sn_name','type'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="请输入直播编号 / 标题" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center;width: 50px;">序号</th>
                        <th style="width: 120px;"><?php echo $model->getAttributeLabel('code');?></th>
                        <th style="width: 200px;"><?php echo $model->getAttributeLabel('title');?></th>
                        <th><?php echo $model->getAttributeLabel('live_type');?></th>
                        <th><?php echo $model->getAttributeLabel('is_single');?></th>
                        <th>直播日期</th>
                        <th>播出时间</th>
                        <th><?php echo $model->getAttributeLabel('project_is');?></th>
                        <th><?php echo $model->getAttributeLabel('open_club_member');?></th>
                        <th>直播观看收费</th>
                        <th>状态</th>
                        <th><?php echo $model->getAttributeLabel('info_date');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php  $index = 1;
 foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->title; ?></td>
                        <td><?php if(!empty($v->livetype)) echo $v->livetype->sn_name; ?></td>
                        <td><?php echo ($v->is_single == 1)?'单场':'连续多场'; ?></td>
                        <td><?php echo $v->live_start_check.'<br>'.$v->live_end_check; ?></td>
                        <td><?php echo $v->airtime_check; ?></td>
                        <td><?php if($v->project_is==649){
                            $project=VideoLiveProject::model()->findAll('video_live_id='.$v->id);
                            $tx='';
                            if(count($project)>=2){
                                $tx=$project[0]['project_name'].' '.$project[1]['project_name'].'...';
                            } elseif (count($project)==1) {
                                $tx=$project[0]['project_name'];
                            }
                        }else{
							$tx='全部项目';
						}
                        echo $tx;
						?></td>
                        <td><?php echo $v->open_club_member_name; ?></td>
                        <td><?php echo ($v->member_price .(($v->open_club_member==210)?('/'.$v->gf_price):'')); ?></td>
                        <td><?php echo ($v->live_state==372) ? $v->state_name : $v->live_state_name; ?></td>
                        <td><?php echo $v->info_date; ?></td>
                        <td>
                        <?php if(($v->live_state==721) || ($v->live_state==372 && $v->state==1365) || ($v->live_state==373)){ ?>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        <?php } ?>
                        <?php if($v->live_state==371){ ?>
                            <a class="btn" href="<?php echo $this->createUrl('update_live', array('id'=>$v->id));?>" title="详情">查看</a>
                            <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancel);" title="撤销审核">撤销审核</a>
                        <?php } ?>
                        <?php if(($v->live_state==372) && ($v->state==1362)){ ?>
                            <a class="btn" href="<?php echo $this->createUrl('update_live', array('id'=>$v->id));?>" title="详情">查看</a>
                        <?php } ?>
                        </td>
                    </tr>
<?php  $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
var cancel = '<?php echo $this->createUrl('cancelSubmit', array('id'=>'ID'));?>';
</script>