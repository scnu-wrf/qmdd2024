<div class="box">
    <div class="box-title c">
		<h1>当前界面：赛事》赛事管理》<a class="nav-a">赛事下架</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
	</div><!--box-title end-->
    <div class="box-content">
		<div class="box-header">
            <a class="btn" id="down_select_btn" href="javascript:;">下架</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>下架时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>" placeholder="选择日期">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>" placeholder="选择日期">
                </label>
                <label style="margin-right:10px;">
					<span>赛事类型：</span>
					<?php echo downList($game_level,'f_id','F_NAME','game_level',''); ?>
				</label>
				<label style="margin-right:20px;">
                    <span>状态：</span>
                    <select name="down_type">
                        <option value="">请选择</option>
                        <option value="1" <?php if(Yii::app()->request->getParam('down_type')==1){?> selected<?php }?>>单位下架</option>
						<option value="2" <?php if(Yii::app()->request->getParam('down_type')==2){?> selected<?php }?>>过期下架</option>
						<option value="3" <?php if(Yii::app()->request->getParam('down_type')==3){?> selected<?php }?>>平台下架</option>
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
						<th width="30px">序号</th>
                        <th width="120px"><?php echo $model->getAttributeLabel('game_club_id');?></th>
                        <th width="105px"><?php echo $model->getAttributeLabel('game_code');?></th>
                        <th width="120px"><?php echo $model->getAttributeLabel('game_title');?></th>
                        <th><?php echo $model->getAttributeLabel('game_level');?></th>
                        <th width="70px"><?php echo $model->getAttributeLabel('game_time1');?></th>
                        <th><?php echo $model->getAttributeLabel('state1');?></th>
                        <th><?php echo $model->getAttributeLabel('down_type');?></th>
                        <th><?php echo $model->getAttributeLabel('down_reason');?></th>
                        <th width="105px"><?php echo $model->getAttributeLabel('down_time');?></th>
                        <th width="110px">操作</th>
                    </tr>
                </thead>
                <tbody>
				<?php $index = 1;
				 foreach($arclist as $k=>$v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$k+1 ?></span></td>
                        <td><?php echo $v->game_club_name; ?></td>
                        <td><?php echo $v->game_code; ?></td>
                        <td><?php echo $v->game_title; ?></td>
                        <td><?php echo $v->level_name; ?></td>
                        <td><?php echo date("Y-m-d",strtotime($v->game_time)).'<br>'.date("Y-m-d",strtotime($v->game_time_end)); ?></td>
                        <td>已下架</td>
                        <td><?php echo $v->down_type_name; ?></td>
                        <td><?php echo $v->down_reason; ?></td>
                        <td><?php echo date("Y-m-d H:i",strtotime($v->down_time)); ?></td>
                        <td>
							<a class="btn" href="<?php echo $this->createUrl('down_detail', array('id'=>$v->id));?>" title="详情">详情</a>
							<a class="btn" href="<?php echo $this->createUrl('GameSignList/game_list_sign', array('game_id'=>$v->id,'back'=>3)); ?>" title="报名">报名</a>
							<a class="btn" href="<?php echo $this->createUrl('gameListArrange/indexvs', array('game_id'=>$v->id,'back'=>3)); ?>" title="赛程/成绩">赛程/成绩</a>
							<a class="btn" href="<?php echo $this->createUrl('gfServiceData/game_list_sign', array('service_id'=>$v->id,'back'=>3)); ?>" title="签到">签到</a>
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
$(function(){
    var $down_select_btn=$('#down_select_btn');
    $down_select_btn.on('click', function(){
        $.dialog.data('game_id', 0);
        $.dialog.open('<?php echo $this->createUrl("down_select");?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择视频',
            width:'65%',
            height:'65%',
            close: function () {
                if($.dialog.data('game_id')==-1){
                    var boxnum=$.dialog.data('game_list');
					var down_type=$.dialog.data('down_type');
					var down_reason=$.dialog.data('down_reason');
					var game_ids=[];
					$.each(boxnum,function(k,v){
						game_ids.push(v.dataset.id);
					});
					downtype(game_ids.join(), downtypeUrl, down_type, down_reason)
                }
            }
        });
    });
});
</script>
<script>
var downtypeUrl = '<?php echo $this->createUrl('downtype', array('id'=>'ID','down_type'=>'DownType','down_reason'=>'DownReason'));?>';
function downtype(id, url, down_type, down_reason){
	we.overlay('show');
	if (id == '' || id == undefined) {
        we.msg('error', '请选择要下架的赛事', function() {
            we.loading('hide');
        });
        return false;
    }
	var fnCancel = function() {
		url = url.replace(/ID/, id);
		url = url.replace(/DownType/, down_type);
		url = url.replace(/DownReason/, down_reason);
        $.ajax({
			type: 'get',
			url: url,
			dataType: 'json',
			success: function(data) {
				if (data.status == 1) {
					we.msg('check', data.msg, function() {
						we.loading('hide');
						we.reload();
					});
				} else {
					we.msg('error', data.msg, function() {
						we.loading('hide');
					});
				}
			}
		});
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '下架', danger: true, onclick: fnCancel},
            button2: {text: '取消'}
        },
        content: '确定下架？',
        icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
	
}


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