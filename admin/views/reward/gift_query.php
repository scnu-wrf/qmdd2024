<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播 》互动打赏 》<a class="nav-a">单位赞赏/礼物查询</a></h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>选择单位：</span>
                    <?php echo downList($club_list,'id','club_name','club_list'); ?>
                    <!-- <style>
                        .div-search{
                            margin-top: 15px;
                        }
                        .div-1{
                            display:none;
                        }
                        .div-ul{
                            height:150px;
                            overflow-y:scroll;
                        }
                    </style>
                    <div class="div-search">
                        <span>选择单位1：</span>
                        <select name="" id="select-1">
                            <option value="">请选择</option>
                        </select>
                        <div class="div-1">
                            <ul class="div-ul">
                                <input type="text">
                                <?php //foreach($club_list as $cl) {?>
                                    <li value="<?php //echo $cl->id; ?>"><?php //echo $cl->club_name; ?></li>
                                <?php //}?>
                            </ul>
                        </div>
                    </div> -->
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('code');?></th>
                        <th><?php echo $model->getAttributeLabel('title');?></th>
                        <th>互动打赏类型</th>
                        <th>发布单位</th>
                        <th><?php echo $model->getAttributeLabel('is_reward');?></th>
                        <th>操作</th>  
                    </tr>
                </thead>
                <tbody>
                    <?php $index=1; foreach($arclist as $v){ $reward = Reward::model()->findAll('video_live_id='.$v->id);?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php  echo $v->code; ?></td> 
                        <td><?php  echo $v->title; ?></td>
                        <td>
                            <?php
                                $video_live_id = Reward::model()->findAll('video_live_id='.$v->id.' and if_del=648 and if_down=648');
                                $list1 = array();
                                if(!empty($video_live_id))foreach($video_live_id as $vl){
                                    if(!empty($vl->gift_type)){
                                        $gift = GiftType::model()->find('id='.$vl->gift_type);
                                        if($gift){
                                            array_push($list1,$gift->name);
                                        }
                                    }
                                }
                                asort($list1);
                                $list1 = array_unique($list1);
                                foreach($list1 as $b){
                                    echo $b.'&nbsp;';
                                }
                            ?>
                        </td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo ($v->is_reward==0) ? '关闭' : '上架'; ?></td>
                        <td>
                            <a href="javascript:;" class="btn" onclick="look('<?php echo $this->createUrl('update_apply',array('id'=>$v->id,'state'=>0)); ?>','<?php echo $v->title;?>');">查看</a>
                            <a href="javascript:;" class="btn" onclick="clickDetails('<?php echo $v->id;?>','<?php echo $v->title;?>');">明细</a>
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
    function look(action,title){
        $.dialog.data('id', '');
        $.dialog.open(action,{
            id:'update_apply',
            lock:true,
            opacity:0.3,
            title:title+'-礼物详情',
            width:'90%',
            height:'90%',
            close: function () {}
        });
    }

    function clickDetails(id,title){
        $.dialog.data('id', '');
        $.dialog.open('<?php echo $this->createUrl('details'); ?>&id='+id,{
            id:'details',
            lock:true,
            opacity:0.3,
            title:title+'-获打赏明细',
            width:'90%',
            height:'90%',
            close: function () {}
        });
    }
</script>
