<?php
  check_request('p_id',1);
  check_request('game_id',0);
  check_request('data_id',0);
  echo '<style>.box-search{margin-top: 0;padding-top: 0;border-top: 0;}</style>';
?>
<div class="box">
    <div class="box-content">
        <div class="box-title c">
            <h1><i class="fa fa-table"></i>赛程列表</h1>
            <span style="float:right;">
                <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
                <?php if($_REQUEST['p_id']==0) {?>
                    <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/index');?>');"><i class="fa fa-reply"></i>返回赛事列表</a></span>
                <?php }?>
            </span>
        </div><!--box-title end-->
        <div class="box-content">
            <div class="box-search">
                <form action="<?php echo Yii::app()->request->url;?>" method="get">
                    <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                    <label style="margin-right:10px;">
                        <span>赛事：</span>
                        <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                    </label>
                    <label style="margin-right:10px;">
                        <span>项目：</span>
                        <select name="data_id" id="data_id">
                            <option value="">请选择</option>
                        </select>
                    </label>
                    <button class="btn btn-blue" type="submit">查询</button>
                </form>
            </div><!--box-search end-->
            <div class="box-table">
                <table class="list">
                    <thead>
                        <tr>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th style='text-align: center;' class="list-id">序号</th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_name');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_data_id');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('arrange_tcode');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('type');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_player_id');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('rounds');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('matches');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('describe');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_site');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('star_time');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_over');?></th>
                            <th style='text-align: center;'>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td style='text-align: center;' class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td style='text-align: center;'><?php echo $v->game_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_data_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->arrange_tcode; ?></td>
                            <td style='text-align: center;'><?php if(!empty($v->game_player_id))echo $v->base_game_player_id->F_NAME; ?></td>
                            <td style='text-align: center;'><?php echo ($v->game_player_id==666 || $v->game_player_id==982) ? $v->team_name : $v->sign_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->rounds; ?></td>
                            <td style='text-align: center;'><?php echo $v->matches; ?></td>
                            <td style='text-align: center;'><?php echo $v->describe; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_site; ?></td>
                            <td style='text-align: center;'><?php echo $v->star_time=='0000-00-00 00:00:00' ? '' : $v->star_time; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_over_name; ?></td>
                            <td style='text-align: center;'>
                                <a class="btn" href="<?php echo $this->createUrl('gameListArrangeScore/update',array('id'=>$v->id,'game_id'=>$v->game_list->id,'data_id'=>$v->game_list_data->id,'data_title'=>$v->game_list_data->game_name,'p_id'=>$_REQUEST['p_id']));?>" title="赛事成绩">成绩管理</a>
                                <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'p_id'=>$_REQUEST['p_id']));?>" title="编辑"><i class="fa fa-edit"></i></a>
                                <!-- <a class="btn" href="javascript:;" onclick="we.dele('<?php //echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a> -->
                            </td>
                        </tr>
                        <?php $index++; } ?>
                    </tbody>
                </table>
            </div><!--box-table end-->
            <div class="box-page c"><?php $this->page($pages); ?></div>
        </div><!--box-content || gamesign-lt end-->
    </div>
</div><!--box end-->
<script>
    // var deleteUrl = '<?php //echo $this->createUrl('delete', array('id'=>'ID'));?>';

    changeGameid($('#game_id'));
    function changeGameid(obj){
        var obj = $(obj).val();
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['data_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    var s_html = '<option value>请选择</option>';
                    for(var i=0;i<data.length;i++){
                        s_html += '<option value="'+data[i]['id']+'" '+((data[i]['id']==pr) ? 'selected>' : '>')+data[i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                }
            });
        }
    }
</script>