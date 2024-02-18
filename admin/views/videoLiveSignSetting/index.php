<?php
    $video_live_id = $_REQUEST['video_live_id'];
    $video_list = VideoLive::model()->find('id='.$video_live_id);
    $return_state = $_REQUEST['return_state'];
    $return_url = 'reward/upList';
    if($return_state==2){
        $return_url = 'reward/downList';
    }
?>
<div class="box">
    <div class="box-title c">
        <h1><!--当前界面：直播 》直播打赏 》打赏直播列表 》-->打赏对象设置 - <?php echo $video_list->title; ?></h1>
        <span style="float:right" margin-right="15px">
            <a class="btn" href="<?php echo $this->createUrl($return_url); ?>">返回上一层</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end--> 
    <div class="box-content">
        <?php if($return_state<2) {?>
    	<div class="box-header">
            <a class="btn" href="javascript:;" onclick="update('0','添加');"><i class="fa fa-plus"></i>添加</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <?php }?>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <!-- <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th> -->
                        <th style="text-align:center;">序号</th>
                        <!-- <th style="text-align:center;"><?php //echo $model->getAttributeLabel('video_live_code');?></th> -->
                        <!-- <th style="text-align:center;"><?php //echo $model->getAttributeLabel('video_live_title');?></th> -->
                        <!-- <th style="text-align:center;"><?php //echo $model->getAttributeLabel('video_live_programs_code');?></th> -->
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('video_live_programs_title');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('live_man');?></th>
                        <th style="text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <!-- <td class="check check-item"><input class="input-check" type="checkbox" value="<?php //echo CHtml::encode($v->id); ?>"></td> -->
                        <td style='text-align: center;'><span class="num num-1"><?php echo $index; ?></span></td>
                        <!-- <td><?php //echo $v->video_live_code; ?></td> -->
                        <!-- <td><?php //echo $v->video_live_title; ?></td> -->
                        <!-- <td><?php //echo $v->video_live_programs_code; ?></td> -->
                        <td><?php echo $v->video_live_programs_title; ?></td>
                        <td>
                            <?php
                                $VideoLiveSign = VideoLiveSign::model()->findAll('video_live_sign_setting_id='.$v->id);
                                $siz = '';
                                if(!empty($VideoLiveSign))foreach($VideoLiveSign as $vl){
                                    $siz .= $vl->gf_name.',';
                                }
                                // $siz = json_encode($siz);
                                // substr($siz, 0, -1);
                                $siz = rtrim($siz, ",");
                                echo $siz;
                            ?>
                        </td>
                        <td>
                            <a href="javascript:;" class="btn" onclick="update('<?php echo $v->id; ?>','<?php echo $v->video_live_programs_title; ?>');" title="编辑"><i class="fa fa-edit"></i></a>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
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

    function update(id,title){
        var action;
        if(id==0){
            action = '<?php echo $this->createUrl("create",array('video_live_id'=>$video_live_id)); ?>';
        }
        else{
            action = '<?php echo $this->createUrl("update"); ?>&id='+id;
        }
        $.dialog.data('id', 0);
        $.dialog.open(action,{
            id:'tianjia',
            lock:true,
            opacity:0.3,
            title:title+' -详情',
            width:'90%',
            height:'90%',
            close: function () {
                // console.log('77');
            }
        });
    }
</script>