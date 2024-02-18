<?php
    check_request('game_id');
    check_request('data_id');
?>
<style>
    .span_class{display:inline-block;font-weight:700;width:120px;border: solid 1px #ccc;padding: 5px;}
    .span_class span{color:red;}
</style>
<script>
    var arr_index = <?php echo json_encode($arr); ?>;
</script>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名榜 》 赛事管理 》 赛事签到</h1>
        <span class="back">
            <a class="btn" href="<?php echo $this->createUrl('signin_game_index'); ?>"><i class="fa fa-reply"></i>返回上一层</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>比赛开始时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="servic_time_star" name="servic_time_star" value="<?php echo Yii::app()->request->getParam('servic_time_star'); ?>" placeholder="">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="servic_time_end" name="servic_time_end" value="<?php echo Yii::app()->request->getParam('servic_time_end'); ?>" placeholder="">
                </label>
                <label style="margin-right:10px;">
                    <span>赛事名称：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>项目：</span>
                    <select name="data_id" id="data_id">
                        <option value="">请选择</option>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入服务流水号">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <br>
                <div style="width: 100%;">
                    <div style="display:inline-block;">
                        <a id="j-sele" class="btn btn-blue" href="javascript:;" style="vertical-align: middle;margin-right:10px;width: 110px;text-align: center;" value="1">全选</a>
                        <a id="j-send" class="btn btn-blue" href="javascript:;" onclick="getSendCode();" style="vertical-align: middle;margin-right:10px;width: 110px;text-align: center;">一键发送验证码</a>
                        <a id="j-check" class="btn btn-blue" href="javascript:;" onclick="save_Sourcer('.check check-item input:checked',1);" style="vertical-align: middle;margin-right:10px;width: 110px;text-align: center;">一键签到</a>
                    </div>
                    <!-- save_Sourcer('.check check-item input:checked',1) -->
                    <?php
                        $daid = GameListData::model()->find('id='.$_REQUEST['data_id']);
                        // $gid1 = (empty($_REQUEST['game_id'])) ? '' : ' and sign_game_id='.$_REQUEST['game_id'];
                        // $gid2 = (empty($_REQUEST['game_id'])) ? '' : ' and game_id='.$_REQUEST['game_id'];
                        $gid3 = (empty($_REQUEST['game_id'])) ? '' : ' and service_id='.$_REQUEST['game_id'];
                        // $gup1 = (!empty($daid) && $daid->game_player_team==665) ? '' : ' group by service_data_id';
                        $edata = (!empty($daid)) ? ' and service_data_id='.$_REQUEST['data_id'] : '';  // .$gup1
                        // $team1 = (empty($daid)) ? '' : ' and sign_game_data_id='.$_REQUEST['data_id'];
                        // $ac0 = 'state=372 and is_pay=464  and order_num is not null';
                        // $snum1 = GameSignList::model()->count($ac0.$gid1.$team1.' and exists(select * from game_list where '.get_where_club_project('game_club_id').' and id=t.sign_game_id)');
                        // $snum2 = GameTeamTable::model()->count($ac0.$gid2.$team1.' and exists(select * from game_list where '.get_where_club_project('game_club_id').' and id=t.game_id)');
                        $exists = ' and exists(select * from game_list where '.get_where_club_project('game_club_id').' and id=t.service_id)';
                        $ac1 = 'order_type=351 and is_pay=464 and state=372';
                        $model1 = $model::model()->count($ac1.' and (sign_come is not null or sign_come<>"0000-00-00 00:00:00")'.$gid3.$edata.$exists);
                        $model2 = $model::model()->count($ac1.' and servic_time_star>=now() and (sign_come is null or sign_come="0000-00-00 00:00:00")'.$gid3.$edata.$exists);
                    ?>
                    <div class="game-div-num" style="display: inline-block;vertical-align: middle;float: right;margin-right: 10px;">
                        <span class="span_class">赛事报名数：
                            <span>
                                <?php //echo (empty($daid) || (!empty($_REQUEST['game_id']) && empty($daid))) ? $snum1+$snum2 : ($daid->game_player_team==665) ? $snum1 : $snum2; ?>
                                <?php
                                    // if(empty($daid) || (!empty($_REQUEST['game_id']) && empty($daid))){
                                    //     echo $snum1+$snum2;
                                    // }
                                    // else{
                                    //     if($daid->game_player_team==665){
                                    //         echo $snum1;
                                    //     }
                                    //     else{
                                    //         echo $snum2;
                                    //     }
                                    // }
                                    // echo 'state=372 and is_pay=464'.$gid3.$edata.$exists;
                                    echo GfServiceData::model()->count('state=372 and is_pay=464'.$gid3.$edata.$exists);
                                ?>
                            </span>
                        </span>
                        <span class="span_class">已签到：<span><?php echo $model1; ?></span></span>
                        <span class="span_class">待签到：<span><?php echo $model2; ?></span></span>
                    </div>
                </div>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
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
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo $v->id; ?>"></td>
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
                                    // if(strtotime($v->servic_time_star)<time()){
                                        echo '未签到';
                                    // }
                                }else{
                                    echo substr($v->sign_come,0,10).'<br>'.substr($v->sign_come,11);
                                }
                            ?>
                        </td>
                        <td style="text-align: center;"><?php echo $v->sign_code; ?></td>
                        <td style='text-align: center;'>
                            <?php
                                $name = (strtotime($v->servic_time_star)<time()) ? '补签' : '签到';
                                $code = ($v->send_sign_code==648) ? '发送验证码' : '重发验证码';
                                echo '<a class="btn" onClick="sendVerificationCode('.$v->id.');" href="javascript:;" title="服务签到" style="font-size:10px;">'.$code.'</a>&nbsp;';
                                echo ($v->sign_come==null||$v->sign_come=='0000-00-00 00:00:00') ?
                                '<a class="btn" onClick="save_Sourcer('.$v->id.', 1);" href="javascript:;" title="服务签到">'.$name.'</a>' : '<span>已签到</span>';
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
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
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
                    if(data!=''){
                        for(var i=0;i<data.length;i++){
                            s_html += '<option value="'+data[i]['id']+'" '+((data[i]['id']==pr) ? 'selected>' : '>')+data[i]['game_data_name']+'</option>';
                        }
                    }
                    $('#data_id').html(s_html);
                }
            });
        }
        else{
            $('#data_id').html(s_html);
        }
    }

    // 加载可签到成员
    var mArr = sessionStorage.getItem("memIdArray");
    if(mArr!=''){
        mArr = $.parseJSON(mArr);
    }
    if(mArr==null||mArr==''||mArr=='[]'){
        mArr=[];
    }else{
        $.each(mArr,function(k,info){
            $('.check-item .input-check').each(function(){
                if(info==$(this).val()){
                    $(this).prop("checked",true);
                }
            });
        })
    }
    $(function(){
        var value = sessionStorage.getItem("value");
        if(value==null)
            value=1;
        if(value==1){
            $("#j-sele").attr("value",1).text('全选');
        }else{
            $("#j-sele").attr("value",0).text('取消全选');
            $("#j-checkall").prop("checked",true);
        }
    })
    sessionStorage.removeItem("memIdArray");
    sessionStorage.removeItem("value");

    // 总页全选
    $("#j-sele").on('click', function(){
        $temp1 = $('.list .input-check');
        $temp2 = $('.box-table .list tbody tr');
        $this = $(this);
        mArr=[];
        if($this.attr("value")=='1'){
            value=0;
            $this.attr("value",value).text('取消全选');
            $temp1.each(function(){
                if(this.disabled!=true){
                    this.checked = true;
                }
            });
            $temp2.addClass('selected');
            $.each(arr_index,function(k,info){
                mArr.push(info.id);
            })
        }else{
            value=1;
            $this.attr("value",value).text('全选');
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
            mArr=[];
        }
        console.log(mArr);
    });

    // 每页全选
    $('#j-checkall').on('click', function(){
        $temp1 = $('.check-item .input-check');
        $temp2 = $('.box-table .list tbody tr');
        $this = $(this);
        if($this.is(':checked')){
            $temp1.each(function(){
                mArr.push($(this).val());
                if(this.disabled!=true){
                    this.checked = true;
                }
            });
            $temp2.addClass('selected');
            mArr=uniqueArray(mArr);
        }else{
            $temp1.each(function(){
                this.checked = false;
                removeByValue(mArr,$(this).val());
            });
            $temp2.removeClass('selected');
        }
    });
    // 单选
    $('.check-item .input-check').on('click', function() {
        $this = $(this);
        if ($this.is(':checked')) {
            $this.parent().parent().addClass('selected');
            mArr.push($this.val());
        } else {
            $this.parent().parent().removeClass('selected');
            removeByValue(mArr,$this.val());
        }
    });

    //移除数组中的固定元素
    function removeByValue(arr, val) {
        for(var i=0; i<arr.length; i++) {
            if(arr[i] == val) {
                arr.splice(i, 1);
                break;
            }
        }
    }
    //删除数组重复元素
    function uniqueArray(arr){
        var tmp = new Array();
        for(var i in arr){
            if(tmp.indexOf(arr[i])==-1){
                tmp.push(arr[i]);
            }
        }
        return tmp;
    }
    $("#yw0 li").on("click",function(){
        mArr= JSON.stringify(mArr);
        sessionStorage.setItem("memIdArray", mArr);
        sessionStorage.setItem("value", value);
    })

    // 获取所有选中多选框的值
    function getSendCode(){
        if(mArr.length<1){
            we.msg('minus','请选择要发送验证码的成员');
            return false;
        }
        var str= mArr.join(',');
        sendVerificationCode(str);
        mArr=[];
        value=1;
    };

    // 发送验证码
    function sendVerificationCode(id){
        we.loading('show');
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('getSignCode');?>&id='+id,
            // data: {id: id},
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }
                else{
                    we.msg('minus',data.msg);
                }
            }
        });
        return false;
    }

    // 签到服务
    function save_Sourcer(id,val){
        if(val==1){
            if(mArr.length<1){
                we.msg('minus','请选择要签到的成员');
                return false;
            }
            id=mArr.join(',');
        }
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
        mArr=[];
        value=1;
        return false;
    }

    // 签到服务
    // function save_Sourcer(id,val){
    //     if(id==''){
    //         we.msg('minus','请选择要签到的数据');
    //         return false;
    //     }
    //     $.ajax({
    //         type: 'post',
    //         url: '<?php echo $this->createUrl('save_Sourcer');?>&id='+id+'&is_invalid='+val,
    //         dataType: 'json',
    //         success: function(data) {
    //             if(data.status==1){
    //                 //we.success(data.msg, data.redirect);
    //                 we.msg('check','已签到');
    //             }
    //             else{
    //                 we.msg('minus', data.msg);
    //             }
    //         },
    //         error: function(request){
    //             console.log(request);
    //         }
    //     });
    //     return false;
    // }
</script>