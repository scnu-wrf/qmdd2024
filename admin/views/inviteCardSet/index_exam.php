<div class="box">
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <label style="margin-right:20px;">
                    <span>审核状态：</span>
                    <?php echo downList($state,'f_id','F_NAME','state'); ?>
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th><?php echo $model->getAttributeLabel('reward_code');?></th>
                        <th><?php echo $model->getAttributeLabel('reward_name');?></th>
                        <th><?php echo $model->getAttributeLabel('reward_pic');?></th>
                        <th><?php echo $model->getAttributeLabel('reward_gif');?></th>
                        <th><?php echo $model->getAttributeLabel('state');?></th>
                        <th>操作</th>  
                    </tr>
                </thead>
                <tbody>
                  	<?php foreach($arclist as $v){?>
                    <tr> 	
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php  echo $v->reward_code; ?></td>
                        <td><?php  echo $v->reward_name; ?></td>
                        <td>
                            <div class="upload_img fl" id="upload_pic_RewardName_reward_pic">
                                <?php if(!empty($v->reward_pic)) {?>
                                    <a href="<?php echo $v->reward_pic;?>" target="_blank"><img src="<?php echo $v->reward_pic;?>" width="50"></a>
                                <?php }?>
                            </div>
                        </td> 
                        <td>
                            <div class="upload_img fl" id="upload_pic_RewardName_reward_gif">
                                <?php if(!empty($v->reward_gif)) {?>
                                    <a href="<?php echo $v->reward_gif;?>" target="_blank"><img src="<?php echo $v->reward_gif;?>" width="50"></a>
                                <?php }?>
                            </div>
                        </td>
                        <td><?php echo $v->base_state->F_NAME; ?></td>
                        <td>
                            <?php if($v->state!=372) {?>
                                <a class="btn" href="javascript:;" onclick="clickState('<?php echo $v->id; ?>');">审核通过</a>
                            <?php }?>
                        </td>
                    </tr>
					<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    function clickState(id){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('use_state'); ?>&id='+id,
            dataType: 'json',
            success: function(data){
                we.success(data.msg,data.redirect);
            },
            error: function(require){
                we.msg('minus','审核失败');
            }
        })
    }
</script>
