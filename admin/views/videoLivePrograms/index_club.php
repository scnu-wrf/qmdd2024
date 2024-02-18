<?php $txt='各单位回放列表';
 if($type==11){
    $txt='各单位回放列表';
} elseif($type==22){    
    $txt='各单位历史回放列表';
}
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》各单位直播查询》<a class="nav-a"><?php echo $txt; ?></a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="节目单号 / 节目名称 / 直播名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th style='text-align: center;'>序号</th>
                        <th style="width:15%;"><?php echo $model->getAttributeLabel('live_id');?></th>
                        <th><?php echo $model->getAttributeLabel('program_code');?></th>
                        <th><?php echo $model->getAttributeLabel('title');?></th>
                        <th><?php echo $model->getAttributeLabel('duration');?></th>
                        <th>文件大小</th>
                        <th style="width:70px;">缓存时间</th>
                        <th><?php echo $model->getAttributeLabel('online');?></th>
                        <th>直播显示时间</th>
                        <th>发布单位</th>
                        <th style="width:60px;">操作</th>
                    </tr>
<?php $index = 1;
	if(is_array($arclist)) foreach($arclist as $v){ ?>
<?php 
$size='未知';
$v_time='未知';
$link='未知';
$duration='未知';
$bvideo=BoutiqueVideo::model()->find('live_program_id='.$v->id);
if(!empty($bvideo)){
    $gfmaterial=GfMaterial::model()->find('id='.$bvideo->video_source_id);
    $v_time=$gfmaterial->v_file_time;
	$size=$gfmaterial->v_file_size;
    $link=$gfmaterial->v_file_path.$gfmaterial->v_name;
    $link_720p=$gfmaterial->v_file_path.$gfmaterial->v_name_720p;
    $link_480p=$gfmaterial->v_file_path.$gfmaterial->v_name_480p;
    $link_360p=$gfmaterial->v_file_path.$gfmaterial->v_name_360p;
    $duration=$gfmaterial->v_file_insert_size;
}
?>
                    <tr>
                    	<td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php if(!empty($v->video_live)) echo $v->video_live->title; ?></td>
                        <td><?php echo $v->program_code; ?></td>
                        <td><?php echo $v->title; ?></td>
                        <td><?php echo $duration; ?></td>
                        <td><?php echo $size; ?></td>
                        <td><?php echo $v_time; ?></td>
                        <td><?php echo ($v->online==649) ? '上线' : '下线'; ?></td>
                        <td><?php if(!empty($v->video_live)){
                            echo $v->video_live->live_start.'<br>'.$v->video_live->live_end;

                        }  ?></td>
                        <td><?php if(!empty($v->video_live)) echo $v->video_live->club_name; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('video_player',array('url'=>$link));?>" target="_blank" title="原画">原画</a>
							<?php if(!empty($gfmaterial->v_name_720p)){?><a class="btn" href="<?php echo $this->createUrl('video_player',array('url'=>$link_720p));?>" target="_blank" title="720p">高清</a><?php }?>
							<?php if(!empty($gfmaterial->v_name_480p)){?><a class="btn" href="<?php echo $this->createUrl('video_player',array('url'=>$link_480p));?>" target="_blank" title="480p">标清</a><?php }?>
							<?php if(!empty($gfmaterial->v_name_360p)){?><a class="btn" href="<?php echo $this->createUrl('video_player',array('url'=>$link_360p));?>" target="_blank" title="360p">流畅</a><?php }?>
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var downUrl = '<?php echo $this->createUrl('down', array('id'=>'ID'));?>';
var onlineUrl = '<?php echo $this->createUrl('online', array('id'=>'ID'));?>';


</script>
