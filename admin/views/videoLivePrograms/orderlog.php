
<div class="box">
    <div class="box-content">
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th style='text-align:center;'>序号</th>
                        <th><?php echo $model->getAttributeLabel('gfid');?></th>
                        <th>直播名称</th>
                        <th>节目单号</th>
                        <th>节目单名称</th>
                        <th>直播开始时间</th>
                        <th>直播开始倒计时</th>
                        <th><?php echo $model->getAttributeLabel('remind_state');?></th>
                    </tr>
                    <?php $index = 1;
					 if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                    	<td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php if(!empty($v->user)) echo $v->user->GF_ACCOUNT.'/'.$v->user->ZSXM;; ?></td>
                        <td><?php if(!empty($v->programs)) if(!empty($v->programs->video_live)) echo $v->programs->video_live->title; ?></td>
                        <td><?php if(!empty($v->programs)) echo $v->programs->program_code; ?></td>
                        <td><?php if(!empty($v->programs)) echo $v->programs->title; ?></td>
                        <td><?php if(!empty($v->programs)) echo $v->programs->program_time; ?></td>
                        <td><?php if(!empty($v->programs) && !empty($v->programs->program_time)){
                        $time1 = strtotime(date("Y-m-d H:i:s"));
                        $time2 = strtotime($v->programs->program_time);
                        $all=$time2-$time1;
                        $days=floor($all/86400);
                        $all1=$all-($days*86400);
                        $hours=floor($all1/3600);
                        $all2=$all1-($hours*3600);
                        $minus=floor($all2/60);
                        $sec=$all2%60;
                         echo ($time2>$time1) ? $days.'天'.$hours.'时'.$minus.'分'.$sec.'秒' : '正在直播';} ?></td>
                        <td><?php if(!empty($v->base_code)) echo $v->base_code->F_NAME; ?></td>
                    </tr>
                   <?php $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
