
<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播预约》<a class="nav-a">直播通知列表</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:6px;">
                    <span>通知时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="star" name="star" value="<?php echo $star;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:6px;">
                    <span>直播名称：</span>
                    <input style="width:150px;" class="input-text" type="text" name="live_title" value="<?php echo Yii::app()->request->getParam('live_title');?>">
                </label>
                <label style="margin-right:6px;">
                    <span>节目名称：</span>
                    <input style="width:150px;" class="input-text" type="text" name="programs_title" value="<?php echo Yii::app()->request->getParam('programs_title');?>">
                </label>
                <label style="margin-right:6px;">
                    <span>关键字：</span>
                    <input style="width:150px;" class="input-text" type="text" name="keywords" placeholder="预约人帐号" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th style='text-align: center;'>序号</th>
                        <th>预约人</th>
                        <th><?php echo $model->getAttributeLabel('live_id');?></th>
                        <th><?php echo $model->getAttributeLabel('live_program_title');?></th>
                        <th>直播时间</th>
                        <th><?php echo $model->getAttributeLabel('notify_type');?></th>
                        <th><?php echo $model->getAttributeLabel('m_message');?></th>
                        <th><?php echo $model->getAttributeLabel('s_time');?></th>
                    </tr>
<?php $index = 1;
if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                    	<td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo (!empty($v->gf_r_gfid)) ? $v->r_gfaccount.'/'.$v->gf_r_gfid->ZSXM : '群发'; ?><?php  ?></td>
                        <td><?php if(!empty($v->video_live_id)) echo $v->video_live_id->title; ?></td>
                        <td><?php echo $v->live_program_title; ?></td>
                        <td><?php echo $v->live_program_time; ?><br><?php echo $v->live_program_end_time; ?></td>
                        <td><?php echo $v->notify_type_name; ?></td>
                        <?php $con=json_decode($v->m_message,true); ?>
                        <td><?php if(!empty($con)) echo $con['content']; ?></td>
                        <td><?php echo $v->s_time; ?></td>
                    </tr>
                   <?php $index++; } ?>
                </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var $star_time=$('#start');
    var $end_time=$('#end');
    $star_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });

</script>