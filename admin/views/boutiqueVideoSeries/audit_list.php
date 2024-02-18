<div class="box">
    <div class="box-title c"><h1>当前界面：视频》视频分集管理》<a class="nav-a">发布审核</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('boutiqueVideoSeries/submit_list');?>">待审核(<span class="red"><b><?php echo $num; ?></b></span>)</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>审核时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="视频名称/视频分集编号">
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
                        <th style="text-align:center;width: 120px;"><?php echo $model->getAttributeLabel('publish_classify');?></th>
                        <th>发布分集数</th>
                        <th>分集号</th>
                        <th style="text-align:center;">状态</th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('state_time');?></th>
                        <th style="text-align:center;">审核员</th>
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
                        <td><?php echo $v->series_publish_num; ?></td>
                        <td><?php echo $v->series_publish_title; ?></td>
						<td><?php echo $v->state_name; ?></td>
						<td><?php echo date("Y-m-d H:i",strtotime($v->state_time)); ?></td>
                        <td><?php echo $v->admin_nick; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('audit_detail', array('id'=>$v->id));?>" title="详情">详情</a>
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