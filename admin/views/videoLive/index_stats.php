<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》监管/监控》<a class="nav-a">推流地址管理</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('videoLive/index_installrtmp');?>">待配置(<span class="red"><b><?php echo $num; ?></b></span>)</a>
        </div><!--box-header end-->
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
                        <th style="text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('code');?></th>
                        <th><?php echo $model->getAttributeLabel('title');?></th>
                        <th><?php echo $model->getAttributeLabel('live_type');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('live_start');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('live_end');?></th>
                        <th style="width:300px;"><?php echo $model->getAttributeLabel('live_source_RTMP');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php  $index = 1;
 foreach($arclist as $v){ ?>
    <?php $live_num=VideoLivePrograms::model()->count('live_id=' . $v->id); ?>
                    <tr>
                        <td style='text-align:center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->title; ?></td>
                        <td><?php if(!empty($v->livetype)) echo $v->livetype->sn_name; ?></td>
                        <td><?php echo $v->live_start; ?></td>
                        <td><?php echo $v->live_end; ?></td>
                        <td><?php echo $v->live_source_RTMP; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_live', array('id'=>$v->id));?>" title="详情">详情</a>
                            <a class="btn" href="javascript:;" onclick="fnRTMP(<?php echo $v->id;?>);" title="设置">设置</a>
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
// 设置
var fnRTMP=function(id){
    $.dialog.open('<?php echo $this->createUrl("install_RTMP");?>&id='+id,{
        id:'tuiliu',
        lock:true,
        opacity:0.3,
        title:'设置',
        width:'98%',
        height:'98%',
        close: function () {
            //we.reload();
        }
    });
};


</script>