<div class="box">
    <div class="box-title c">
		<h1>当前界面：视频》视频管理》<a class="nav-a">视频列表</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
	</div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<label style="margin-right:10px;">
                    <span>发布时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label style="margin-right:20px;">
                    <span><?php echo $model->getAttributeLabel('publish_classify');?>：</span>
                    <select name="video_classify">
                        <option value="">请选择</option>
                        <?php foreach($video_classify as $k=>$v){?>
                        <option value="<?php echo $k;?>"<?php if(Yii::app()->request->getParam('video_classify')==$k){?> selected<?php }?>><?php echo $v;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="视频编号/名称">
                </label>
				<input class="input-text" type="hidden" name="search_date" value="1">
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center;width: 30px;">序号</th>
                        <th style="text-align:center;width: 120px;"><?php echo $model->getAttributeLabel('video_code');?></th>
                        <th style="text-align:center;width: 200px;"><?php echo $model->getAttributeLabel('video_title');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('publish_classify');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('project_list');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('open_club_member');?></th>
                        <th style="text-align:center;">观看费用</th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('is_uplist');?></th>
                        <th style="text-align:center;">上/下线时间</th>
                        <th style="text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
				<?php $index = 1;
				 foreach($arclist as $k=>$v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$k+1 ?></span></td>
                        <td><?php echo $v->video_code; ?></td>
                        <td><?php echo $v->video_title; ?></td>
                        <td><?php echo $v->publish_classify_name; ?></td>
                        <td><?php if($v->project_is==649){
                            $project=BoutiqueVideoProject::model()->findAll('boutique_video_id=' . $v->id);
                            $tx='';
                            if(count($project)>=2){
                                $tx=$project[0]['project_name'].' '.$project[1]['project_name'].'...';
                            } elseif (count($project)==1) {
                                $tx=$project[0]['project_name'];
                            }
                        }else{
							$tx='不限项目';
						}
                        echo $tx;
						?></td>
                        <td><?php if($v->open_club_member!=null){ echo $v->open_club_member_name->F_NAME; } ?></td>
                        <td><?php echo (($v->member_price) .(($v->open_club_member==210)?('/'.($v->gf_price)):'')); ?></td>
                        <td><?php echo $v->is_uplist==1?'上线':'下线'; ?></td>
                        <td><?php echo $v->video_start .'<br>'. $v->video_end; ?></td>
                        <td>
							<a class="btn" href="<?php echo $this->createUrl('video_detail', array('id'=>$v->id));?>" title="详情">详情</a>
							
							<?php if($v->is_uplist==1){ ?>
                            <a class="btn" href="javascript:;" onclick="we.down('<?php echo $v->id;?>', downUrl);" title="下线">下线</a>
							<?php } else{ ?>
							<a class="btn" href="javascript:;" onclick="we.online('<?php echo $v->id;?>', onlineUrl);" title="上线">上线</a>
							<?php }?>
							<a class="btn" href="<?php echo $this->createUrl('BoutiqueVideoSeries/video_series_list', array('video_id'=>$v->id));?>" title="视频分集">视频分集</a>
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
<script>
    var $star_time=$('#start_date');
    var $end_time=$('#end_date');
    $star_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>
<script>
var downUrl = '<?php echo $this->createUrl('down', array('id'=>'ID'));?>';
var onlineUrl = '<?php echo $this->createUrl('online', array('id'=>'ID'));?>';
var istopUrl = '<?php echo $this->createUrl('istop', array('id'=>'ID'));?>';
var notopUrl = '<?php echo $this->createUrl('notop', array('id'=>'ID'));?>';
</script>