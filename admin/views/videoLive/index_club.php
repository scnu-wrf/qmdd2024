<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》各单位直播查询》<a class="nav-a">各单位直播列表</a></h1>
        <span class="back"><a class="btn" href="<?php echo $this->createUrl('index_club');?>"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
        <div class="box-search" style="border:none; margin:0">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>类型：</span>
                    <?php echo downList($live_type,'id','sn_name','type'); ?>
                </label>
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
                        <th><?php echo $model->getAttributeLabel('is_single');?></th>
                        <th>直播日期</th>
                        <th>播出时间</th>
                        <th><?php echo $model->getAttributeLabel('project_is');?></th>
                        <th><?php echo $model->getAttributeLabel('open_club_member');?></th>
                        <th>直播观看收费</th>
                        <th>直播显示时间</th>
                        <th>状态</th>
                        <th style="width:80px;"><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php  $index = 1;
 foreach($arclist as $v){ ?>
    <?php $live=VideoLivePrograms::model()->find('(live_id=' . $v->id.') order by program_time ASC');
    $live2=VideoLivePrograms::model()->find('(live_id=' . $v->id.') order by program_end_time DESC'); ?>
                    <tr>
                        <td style='text-align:center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
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
                        <td><?php echo $v->live_start; ?><br><?php echo $v->live_end; ?></td>
                        <td><?php if($v->is_uplist==1){ echo '上线'; } else echo '下线';  ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_live', array('id'=>$v->id));?>" title="详情">详情</a>
                            <a class="btn" href="javascript:;" onclick="fnRTMP(<?php echo $v->id;?>);" title="查看">推流地址</a>
                            <a href="javascript:;" class="btn" onclick="look('<?php echo $this->createUrl('reward/update_apply',array('id'=>$v->id,'state'=>0)); ?>','<?php echo $v->title;?>');">礼物</a>
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
// 查看推流地址
var fnRTMP=function(id){
    $.dialog.open('<?php echo $this->createUrl("after_RTMP");?>&id='+id,{
        id:'tuiliu',
        lock:true,
        opacity:0.3,
        title:'查看推流地址',
        width:'95%',
        height:'95%',
        close: function () {}
    });
};
//查看礼物
function look(action,title){
    $.dialog.data('id', '');
    $.dialog.open(action,{
        id:'update_apply',
        lock:true,
        opacity:0.3,
        title:title+'-礼物详情',
        width:'98%',
        height:'98%',
        close: function () {}
    });
}
</script>