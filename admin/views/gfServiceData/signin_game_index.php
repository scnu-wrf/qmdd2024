<?php
    check_request('game_id');
    check_request('data_id');
    if(!isset($_REQUEST['back'])) $_REQUEST['back'] = 0;
    if(!isset($_REQUEST['is_sign'])) $_REQUEST['is_sign'] = 0;
    if(!isset($_REQUEST['back'])){
        $_REQUEST['back'] = 0;
    }
    $url = '';
    if($_REQUEST['back']==1){
        $url = 'gameList/index_list';
    }
    else if($_REQUEST['back']==2){
        $url = 'gameList/game_club_search';
    }
    else if($_REQUEST['back']==3){
        $url = 'gameList/game_history_search';
    }
    else if($_REQUEST['back']==4){
        $url = 'gameList/game_club_history_search';
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名榜 》 赛事管理 》 赛事签到</h1>
        <span class="back">
            <?php if($_REQUEST['back']>0) {?>
                <a class="btn" href="<?php echo $this->createUrl($url); ?>">返回上一层</a>
            <?php }?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('signin_game_stat_index'); ?>">
                <span>待签到：<?php echo $count1; ?></span>
            </a>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="back" value="<?php echo $_REQUEST['back']; ?>">
                <label style="margin-right:10px;">
                    <span>比赛开始时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="servic_time_star" name="servic_time_star" value="<?php echo Yii::app()->request->getParam('servic_time_star'); ?>" placeholder="近一个月">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="servic_time_end" name="servic_time_end" value="<?php echo Yii::app()->request->getParam('servic_time_end'); ?>" placeholder="近一个月">
                </label>
                <label style="margin-right:10px;">
                    <span>赛事名称：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>竞赛项目：</span>
                    <select name="data_id" id="data_id">
                        <option value="">请选择</option>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>是否签到：</span>
                    <select name="is_sign" id="is_sign">
                        <option value="">请选择</option>
                        <option value="648" <?php if($_REQUEST['is_sign']==648) echo 'selected'; ?>>是</option>
                        <option value="649" <?php if($_REQUEST['is_sign']==649) echo 'selected'; ?>>否</option>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入服务流水号">
                </label>
                <button id="search_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <!-- <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th> -->
                        <th style="text-align: center;">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('service_game_id');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('service_game_data_id');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('service_game_time');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('contact_phone');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('sign_come');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('sign_code');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <!-- <td class="check check-item"><input class="input-check" type="checkbox" value="<?php //echo CHtml::encode($v->id); ?>" <?php //if($v->sign_come!=null){ echo 'disabled="disabled"'; }?>></td> -->
                        <td style="text-align: center;"><?php echo $index ?></td>
                        <td style="text-align: center;"><?php echo $v->order_num; ?></td>
                        <td style="text-align: center;"><?php echo $v->service_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->service_data_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->servic_time_star; ?></td>
                        <td style="text-align: center;"><?php echo $v->gf_name.'('.$v->gf_account.')'; ?></td>
                        <td style="text-align: center;"><?php echo $v->contact_phone; ?></td>
                        <td style="text-align: center;">
                            <?php
                                if($v->sign_come==null||$v->sign_come=='0000-00-00 00:00:00'){
                                    if(strtotime($v->servic_time_star)<time()){
                                        echo '未签到';
                                    }
                                }else{
                                    $left = substr($v->sign_come,0,10);
                                    $right = substr($v->sign_come,11);
                                    echo $left.'<br>'.$right;
                                }
                            ?>
                        </td>
                        <td style="text-align: center;"><?php echo $v->sign_code; ?></td>
                        <td style='text-align: center;'>
                            <?php
                                $name = (strtotime($v->servic_time_star)<time()) ? '补签' : '签到';
                                echo ($v->sign_come==null||$v->sign_come=='0000-00-00 00:00:00') ?
                                '<a class="btn" onClick="save_Sourcer('.$v->id.',1);" href="javascript:;" title="服务签到">'.$name.'</a>' : '已签到';
                            ?>
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
    $(function(){
        var $servic_time_star=$('#servic_time_star');
        var $servic_time_end=$('#servic_time_end');
        $servic_time_star.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $servic_time_end.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });

    var back = '<?php echo $_REQUEST['back']; ?>';
    changeGameid($('#game_id'));
    function changeGameid(obj){
        var obj = $(obj).val();
        var s_html = '<option value>请选择</option>';
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['data_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    for(var i=0;i<data.length;i++){
                        s_html += '<option value="'+data[i]['id']+'" '+((data[i]['id']==pr) ? 'selected>' : '>')+data[i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                }
            });
        }
        else{
            $('#data_id').html(s_html);
        }
        if(back>0){
            $('#game_id').attr('disabled','disabled');
        }
    }

    // 查询时去除赛事id的不可编辑，否则后台获取不到数据
    $('#search_submit').on('click',function(){
        $('#game_id').removeAttr('disabled');
    })

    // 签到服务
    function save_Sourcer(id,val){
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('save_Sourcer');?>&id='+id+'&is_invalid='+val,
            // data: {id: id},
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        we.msg('check', '已签到');
        window.location.reload();
        return false;
    }
</script>