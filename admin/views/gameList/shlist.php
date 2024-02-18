<?php 
   check_request('game_type',0);
   check_post('data_id',0);
   check_post('data_type',0);
?>
<style>
    .box-search div{ display:inline-block; }
    #keywords{ margin-left: 12px; }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事 》赛事发布 》<a class="nav-a">发布审核</a></h1>
        <span style="float:right;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
		<div class="box-detail-tab">
			<ul class="c">
				<li><a href="<?php echo $this->createUrl('submitlist'); ?>">待审核 <?php echo $stay_state; ?></a></li>
				<li class="current"><a href="<?php echo $this->createUrl('shlist'); ?>">审核记录</a></li>
			</ul>
		</div><!--box-detail-tab end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="game_type" value="<?php echo Yii::app()->request->getParam('game_type');?>">
                <label style="margin-right:10px;">
                    <span>审核日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="star_time" name="star_time" value="<?php echo $star_time;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo $end_time;?>">
                </label>
                <label style="margin-right:20px;">
                    <span>状态：</span>
                    <select name="state">
                        <option value="">请选择</option>
						<?php foreach($state_l as $k=>$v){?>
                        <option value="<?php echo $k;?>"<?php if(Yii::app()->request->getParam('state')==$k){?> selected<?php }?>><?php echo $v;?></option>
                        <?php }?>
                    </select>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编码或标题">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <ul class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;width:24px;'>序号</th>
                        <th style='text-align: center;width:9%;'><?php echo $model->getAttributeLabel('game_code');?></th>
                        <th style='text-align: center;width:15%'><?php echo $model->getAttributeLabel('game_title');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_level');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_area');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_time1');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_club_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state_time');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td style='text-align: center;'><?php echo $v->game_code; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_title; ?></td>
                            <td style='text-align: center;'><?php echo $v->level_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->area_name; ?></td>
                            <td style='text-align: center;'><?php echo date("Y-m-d H:i",strtotime($v->game_time)).'<br>'.date("Y-m-d H:i",strtotime($v->game_time_end)); ?></td>
                            <td style='text-align: center;'><?php echo $v->game_club_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->state_name; ?></td>
                            <td style='text-align: center;'><?php echo date("Y-m-d H:i",strtotime($v->state_time)); ?></td>
                            <td style='text-align: center;'>
                                <a class="btn" href="<?php echo $this->createUrl('submitupdate', array('id'=>$v->id,'type'=>$v->game_type,'p_id'=>0));?>" title="详情">详情</a>
                            </td>
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
        var $star_time=$('#star_time');
        var $end_time=$('#end_time');
        $star_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });

    // 关联直播设置
    var fnVideoLive=function(id){
        $.dialog.open('<?php echo $this->createUrl("liveinstall");?>&id='+id,{
            id:'shezhi',
            lock:true,
            opacity:0.3,
            title:'直播关联设置',
            width:'80%',
            height:'60%',
            close: function () {}
        });
    };
</script>