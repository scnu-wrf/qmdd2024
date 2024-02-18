<?php 
   check_request('game_type');
   check_post('data_id');
   check_post('data_type');
?>
<style>
    .box-search div{ display:inline-block; }
    #keywords{ margin-left: 12px; }
</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php echo ($_REQUEST['game_type']==810) ? '活动' : '赛事'; ?>列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create',array('type'=>$_REQUEST['game_type'])),'发布'); ?>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            <span>
                <a class="btn" href="<?php echo $this->createUrl('gameListArrange/index1',array('p_id'=>'0')); ?>">赛程管理</a>
                <a class="btn" href="<?php echo $this->createUrl('gameSignList/index',array('p_id'=>'0')); ?>">成员管理</a>
                <a class="btn" href="<?php echo $this->createUrl('gameListArrangeScore/index',array('p_id'=>'0')); ?>">赛事成绩</a>
            </span>
            <span style="float:right;">
                <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;&nbsp;
                <a class="btn" href="javascript:;" type="button" onclick="javascript:excel();"><i class="fa fa-file-excel-o"></i>导出</a>
            </span>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="game_type" value="<?php echo Yii::app()->request->getParam('game_type');?>">
                <?php if(get_session('club_id')==1) {?>
                    <div id="select0" style="width: 450px;">
                        <label>
                            <span>发布单位：</span>
                            <?php echo downList($game_club_id,'id','club_name','game_club_id'); ?>
                        </label>
                    </div>
                <?php }?>
                <div id="select1" style="width: auto;<?php if(get_session('club_id')!=1)echo 'margin-right: 18px;'; ?>">
                    <label>
                        <span>地区搜索：</span>
                        <select name="province"></select><select name="city" style="margin:auto 5px auto 5px;"></select><select name="area"></select>
                        <script>new PCAS("province","city","area","<?php echo Yii::app()->request->getParam('province');?>","<?php echo Yii::app()->request->getParam('city');?>","<?php echo Yii::app()->request->getParam('area');?>");</script>
                    </label>
                </div>
                <?php if(get_session('club_id')==1)echo '<br>';?>
                <div id="select23" style="width: 450px;">
                    <div id="select2">
                        <label>
                            <span><?php echo ($_REQUEST['game_type']==810) ? '活动' : '赛事'; ?>等级：</span>
                            <?php echo downList($game_area,'f_id','F_NAME','game_area'); ?>
                        </label>
                    </div>
                    <div id="select3" style="margin-left:10px;">
                        <label>
                            <span><?php echo ($_REQUEST['game_type']==810) ? '活动' : '赛事'; ?>类型：</span>
                            <?php echo downList($game_type,'f_id','F_NAME','game_type'); ?>
                        </label>
                    </div>
                </div>
                <div id="select45" style="width: 450px;<?php if(get_session('club_id')!=1)echo 'margin-right: 12px;'; ?>">
                    <div id="select4">
                        <label>
                            <span><?php echo ($_REQUEST['game_type']==810) ? '活动' : '赛事'; ?>状态：</span>
                            <?php echo downList($game_state,'f_id','F_NAME','game_state'); ?>
                        </label>
                    </div>
                    <div id="select5" style="margin-left: 10px;">
                        <label>
                            <span>审核状态：</span>
                            <?php echo downList($state,'f_id','F_NAME','state'); ?>
                        </label>
                    </div>
                </div>
                <div id="select6">
                    <label>
                        <span>关键字：</span>
                        <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编码或标题">
                    </label>
                    <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                </div>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <ul class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;width:24px;'>序号</th>
                        <th style='text-align: center;width:9%;'><?php echo $model->getAttributeLabel('game_code');?></th>
                        <th style='text-align: center;width:7%;'><?php echo $model->getAttributeLabel('game_small_pic');?></th>
                        <th style='text-align: center;width:15%'><?php echo $model->getAttributeLabel('game_title');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_club_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_area');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_level');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_state');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state');?></th>
                        <th style='text-align: center;width:8%'><?php echo $model->getAttributeLabel('publish_time');?></th>
                        <th style='text-align: center;width:15%'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(118);?>
                    <?php $index = 1; foreach($arclist as $v){ $p_id = ($v->state==371 || $v->game_state==149) ? 0 : 1; ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td style='text-align: center;'><?php echo $v->game_code; ?></td>
                            <td style='text-align: center;'>
                                <a href="<?php echo $basepath->F_WWWPATH.$v->game_small_pic; ?>" target="_blank">
                                    <div style="width:50px; height:50px;overflow:hidden;">
                                        <img src="<?php echo $basepath->F_WWWPATH.$v->game_small_pic; ?>" width="50">
                                    </div>
                                </a>
                            </td>
                            <td style='text-align: center;'><?php echo $v->game_title; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_club_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->area_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->level_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_statec; ?></td>
                            <td style='text-align: center;'><?php echo $v->state_name; ?></td>
                            <td style='text-align: center;'>
                                <?php
                                    $left = substr($v->publish_time,0,10);
                                    $right = substr($v->publish_time,11);
                                    echo $left.'<br>';
                                    echo $right;
                                ?>
                            </td>
                            <td style='display: none;'><?php echo $v->game_type; ?></td>
                            <td style='text-align: center;'> <!-- display:inline-flex;-->
                                <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->game_type))); ?>
                                <?php echo show_command('删除','\''.$v->id.'\''); ?>
                                <span class="down" style="position:relative;">
                                    <a class="a" href="javascript:;">更多</a>
                                    <ul class="drop-down-content game_list_index_a" style="left:-26px;">
                                        <li><a href="<?php echo $this->createUrl('gameNews/index', array('game_id'=>$v->id,'game_name'=>$v->game_title,'p_id'=>$p_id)); ?>">赛事动态</a></li>
                                        <li><a href="<?php echo $this->createUrl('gameSignList/index', array('game_id'=>$v->id,'game_name'=>$v->game_title,'p_id'=>$p_id)); ?>">成员管理</a></li>
                                        <li><a href="<?php echo $this->createUrl('gameListArrange/index', array('game_id'=>$v->id,'data_title'=>$v->game_title,'p_id'=>$p_id)); ?>">赛程管理</a></li>
                                        <li><a href="<?php echo $this->createUrl('gameSignList/index_rank', array('game_id'=>$v->id,'game_name'=>$v->game_title)); ?>">名次公告</a></li>
                                        <li><a href="<?php echo $this->createUrl('gameSignList/showsale', array('game_id'=>$v->id,'game_name'=>$v->game_title)); ?>">赛事收费查询</a></li>
                                    </ul>
                                </span>
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
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    function excel(){
        $num = $("#is_excel");
        $num.val(1);
        $("#submit_button").click();
        $num.val('');
    }

    $(function(){
        // 判断浏览器
        if(navigator.userAgent.indexOf('Firefox') >= 0){
            $('.drop-down-content li').css('width','100px');
            $('.drop-down-content').css('left','-37px');
            $('#select0').css('margin-right','92px');
        }
 
        $('.drop-down-content').hide();
        $(".a").on("click", function(e){
            if($(".drop-down-content").is(":hidden")){
                $(this).next("ul.drop-down-content").slideToggle(100).siblings("ul.drop-down-content").slideUp("slow");
                $('.down').find(".drop-down-content").hide();
                $(this).next(".drop-down-content").show();
            }
            else{
                $(this).next(".drop-down-content").hide();
            }
            $(document).on("click", function(){
                $(".drop-down-content").hide();
            });
            e.stopPropagation();
        });

    });
</script>