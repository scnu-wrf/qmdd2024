
<div class="box">
    <div class="box-content">
		<div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="BoutiqueVideoSeries/customer_service_list">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入视频编号或名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'>视频编号</th>
                        <th style='text-align: center;'>视频名称</th>
                        <th style='text-align: center;'>已发布集数</th>
                    </tr>
                </thead>
                <tbody>
               
					<?php 
					$index = 1;
					foreach($arclist as $v){ 
					?>
                    <tr data-video_id="<?php echo $v->id?>" data-video_title="<?php echo $v->video_title?>" data-publish_classify_name="<?php echo $v->publish_classify_name?>">
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v["video_code"];?></td>
                        <td style='text-align: center;'><?php echo $v["video_title"];?></td>
                        <td style='text-align: center;'><?php echo $v["series_num"];?></td>
                    </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages);?></div>
        
    </div><!--box-content end-->
</div><!--box end-->
<script>
$(function(){
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button( { name: '取消' } );
    $('.box-table tbody tr').on('click', function(){
        $.dialog.data('video_id', $(this).attr('data-video_id'));
        $.dialog.data('video_title', $(this).attr('data-video_title'));
        $.dialog.data('publish_classify_name', $(this).attr('data-publish_classify_name'));
        $.dialog.close();
    });
});
</script>
