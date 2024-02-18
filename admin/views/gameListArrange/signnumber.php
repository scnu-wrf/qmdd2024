<?php 
    check_request('game_id',0);
    check_request('data_id',0);
    $dataid = (!empty($data_id)) ? $data_id : $_REQUEST['data_id'];
    $arr1 = $model->find('game_data_id='.$dataid.' and length(arrange_tcode)=5');
?>
<style>
    .box-table .list tr th,.box-table .list tr td{ text-align: center; }
    .aui_content{ height:auto;overflow:auto;padding:5px 5px!important;}
    /* .aui_main{ height:auto!important; } */
    .nav-ul li{ display:inline-block;width:8%;padding:5px;text-align:center;background-color:#5b8d98;color:white;cursor:pointer;margin-top:5px; }
    .td_bor{ border-bottom: solid 2px #d6841e; }
    .box-detail-tab li { width: 120px; }
</style>
<div class="box" style="margin: 0px 10px 10px 0;">
    <div class="gamesign c">
        <div class="box-title c" style="width: 99%;position: fixed;background-color: #F2F2F2;z-index: 99;">
            <h1>当前界面：赛事 》赛事管理 》签号录入</h1>
            <span style="float:right;">
                <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            </span>
        </div><!--box-title end-->
        <div class="box-search" style="margin-top: 43px;width: 99%;z-index: 99;position: fixed;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>赛事：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php if($_REQUEST['game_id']!=0) { ?>
            <div class="gamesign-rt game_list_arrange" style="background-color:#e0e0e0;top: 105px;">
                <div class="gamesign-group">
                	<span class="gamesign-title">竞赛项目</span>
                    <?php foreach($game_data1 as $v){ ?>
                        <a <?php if($data_id==$v->id){?> class="current"<?php }?> href="<?php echo $this->createUrl('gameListArrange/signnumber', array('game_id'=>$v->game_id,'data_id'=>$v->id));?>"><?php echo $v->game_data_name;?></a>
                    <?php }?>
                </div>
            </div><!--gamesign-rt end-->
        <?php } ?>
        <div class="<?php echo ($_REQUEST['game_id']!=0) ? 'gamesign-lt' : 'box-content'; ?>" style="border:none;padding:0 0;">
            <div class="box-content" style="margin: 105px 0 0 0;">
                <form action="" id="save_number" name="save_number">
                    <div class="box-table">
                        <?php if($_REQUEST['game_id']>0) {?>
                            <div style="margin-bottom:15px;">
                                <ul class="nav-ul">
                                    <?php
                                        $arrange = $model->findAll('game_data_id='.$dataid.' and length(arrange_tcode)=4 order by arrange_tcode');
                                        if(!empty($arrange))foreach($arrange as $ar){
                                            $format_list = $model->find('game_data_id='.$dataid.' and left(arrange_tcode,4)="'.$ar->arrange_tcode.'" and length(arrange_tcode)=5');
                                            $name1 = '';
                                            $name2 = '';
                                            $mode_format = '';
                                            if(!empty($format_list)){
                                                $basecode1 = BaseCode::model()->find('f_id='.$format_list->game_mode);
                                                $basecode2 = BaseCode::model()->find('f_id='.$format_list->game_format);
                                                $name1 = $basecode1->F_NAME;
                                                $name2 = $basecode2->F_NAME;
                                                $mode_format = $format_list->arrange_tname;
                                            }
                                    ?>
                                        <li class="nav-li" 
                                            onclick="clickTname(this,'<?php echo $ar->arrange_tcode; ?>');" 
                                            code="<?php echo $ar->arrange_tcode; ?>" 
                                            mode="<?php echo $name1; ?>" 
                                            format="<?php echo $name2; ?>" 
                                            gname="<?php echo $mode_format; ?>">
                                            <?php echo $ar->arrange_tname; ?>
                                        </li>
                                    <?php }?>
                                </ul>
                            </div>
                        <?php } if(!empty($arr1)){?>
                            <div>
                                <table class="list">
                                    <tr class="table-title">
                                        <td style="text-align:left;width:15%;font-weight: 700;">赛事赛制：</td>
                                        <td style="text-align:left;width:35%;font-weight: 700;" id="ag_format"><?php if(!empty($arr1->game_format))echo $arr1->base_code_game_format->F_NAME; ?></td>
                                        <td style="text-align:left;width:15%;font-weight: 700;">赛事形式：</td>
                                        <td style="text-align:left;width:35%;font-weight: 700;" id="ag_mode"><?php if(!empty($arr1->game_mode))echo $arr1->base_game_mode->F_NAME; ?></td>
                                    </tr>
                                    <tr class="table-title">
                                        <td style="text-align:left;font-weight: 700;">小组名称：</td>
                                        <td style="text-align:left;font-weight: 700;" colspan="3" id="ag_name"><?php echo $arr1->arrange_tname; ?></td>
                                    </tr>
                                </table>
                            </div>
                        <?php }?>
                        <table id="table_number" class="list">
                            <thead>
                                <tr>
                                    <th class="list-id">序号</th>
                                    <th><?php echo $model->getAttributeLabel('arrange_tname');?></th>
                                    <th><?php echo $model->getAttributeLabel('sign_name');?></th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $index = 1; if(!empty($arr_data1))foreach($arr_data1 as $v){
                                ?>
                                    <tr class="<?php echo substr($v->arrange_tcode,0,4); ?> tr">
                                        <td><span class="num num-1 all_num"></span><span class="num num-1 chi_num"><?php echo $index; ?></span></td>
                                        <td><?php echo $v->arrange_tname; ?></td>
                                        <td>
                                            <?php
                                                $tid = ($v->game_player_id==665) ? $v->sign_id : $v->team_id;
                                                $tname = ($v->game_player_id==665) ? $v->sign_name : $v->team_name;
                                            ?>
                                            <input type="hidden" class="input-text sign_id_<?php echo substr($v->arrange_tcode,0,4); ?>" id="sign_id_<?php echo $index; ?>" name="save_number[<?php echo $index; ?>][sign_id]" value="<?php echo $tid; ?>">
                                            <input type="hidden" class="input-text tname" id="tname_<?php echo $index; ?>" value="<?php echo $v->arrange_tname; ?>">
                                            <input 
                                                type="text" class="input-text save_signnumber_name" id="sign_name_<?php echo $index; ?>" name="save_number[<?php echo $index; ?>][sign_name]" 
                                                attrid="<?php echo $v->id; ?>" attrnum="<?php echo $index; ?>" attrplayer="<?php echo $v->game_player_id; ?>" value="<?php echo $tname; ?>">
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn" onclick="onArr(<?php echo $v->game_data_id.','.$v->game_player_id.','.$index.','.$v->id.','.'\''.substr($v->arrange_tcode,0,4).'\''; ?>)">签号录入</a>
                                            <a href="javascript:;" class="btn" onclick="onClear(<?php echo $v->id; ?>,<?php echo $index; ?>,<?php echo $v->game_player_id; ?>);">清除</a>
                                        </td>
                                    </tr>
                                <?php $index++; } ?>
                                <?php $index1 = $index; if(!empty($arr_data2))foreach($arr_data2 as $v1){ ?>
                                    <tr class="<?php echo substr($v1->arrange_tcode,0,4); ?> tr">
                                        <td><span class="num num-1 all_num"></span><span class="num num-1 chi_num"><?php echo $index1; ?></span></td>
                                        <td><?php echo $v1->arrange_tname; ?></td>
                                        <td>
                                            <?php
                                                $tid = ($v1->game_player_id==665) ? $v1->sign_id : $v1->team_id;
                                                $tname = ($v1->game_player_id==665) ? $v1->sign_name : $v1->team_name;
                                            ?>
                                            <input type="hidden" class="input-text sign_id_<?php echo substr($v1->arrange_tcode,0,4); ?>" id="sign_id_<?php echo $index1; ?>" name="save_number[<?php echo $index1; ?>][sign_id]" value="<?php echo $tid; ?>">
                                            <input type="hidden" class="input-text tname" id="tname_<?php echo $index1; ?>" value="<?php echo $v1->arrange_tname; ?>">
                                            <input 
                                                type="text" class="input-text save_signnumber_name" id="sign_name_<?php echo $index1; ?>" name="save_number[<?php echo $index1; ?>][sign_name]" 
                                                attrid="<?php echo $v1->id; ?>" attrnum="<?php echo $index1; ?>" attrplayer="<?php echo $v1->game_player_id; ?>" value="<?php echo $tname; ?>">
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn" onclick="onArr(<?php echo $v1->game_data_id.','.$v1->game_player_id.','.$index1.','.$v1->id.','.'\''.substr($v1->arrange_tcode,0,4).'\''; ?>)">签号录入</a>
                                            <a href="javascript:;" class="btn" onclick="onClear(<?php echo $v1->id; ?>,<?php echo $index1; ?>,<?php echo $v1->game_player_id; ?>);">清除</a>
                                        </td>
                                    </tr>
                                <?php $index1++; }?>
                            </tbody>
                        </table>
                    </div><!--box-table end-->
                </form>
                <div class="box-page c"><?php $this->page($pages); ?></div>
            </div><!--box-content || gamesign-lt end-->
        </div>
    </div>
</div><!--box end-->
<script>
    $(function(){
        // 默认显示方式
        $('.nav-ul li:nth-child(1)').addClass('td_bor');
        var type = $('.nav-ul li:nth-child(1)').attr('code');
        var child = $('.'+type).length;
        var s_num = 0;
        var data_id = sessionStorage.getItem('dataid');
        var session_type = sessionStorage.getItem('code_type');
        // console.log(type,data_id,session_type);
        if(session_type!='' && session_type!=null && session_type!='null' && session_type!=undefined && data_id=='<?php echo $dataid; ?>') type = session_type;
        clickTname(this,type,1);
    });

    // 点击选择阶段
    function clickTname(obj,code,n=0){
        var c = $('.'+code);
        var attr_code = c.attr('code');
        $('.nav-li').removeClass('td_bor');
        $('.nav-li').each(function(){
            if($(this).attr('code')==code){
                $(this).addClass('td_bor');
            }
        });
        // 废弃"all"
        if(code=='all'){
            $('.chi_num').hide();
            $('.tr,.all_num').show();
            $('.all').addClass('td_bor');
        }
        else{
            var num1 = 0;
            $('.tr,.all_num').hide();
            $('.'+code+' .chi_num').each(function(){
                num1++;
                $(this).html(num1);
            });
            if(n==0){
                $('#ag_mode').html($(obj).attr('mode'));
                $('#ag_format').html($(obj).attr('format'));
                $('#ag_name').html($(obj).attr('gname'));
            }
            $('.chi_num').show();
            $('.'+code).show();
        }
        sessionStorage.setItem('code_type',code);
        sessionStorage.setItem('dataid','<?php echo $dataid; ?>');
    }
    
    changeGameid($('#game_id'));
    function changeGameid(obj){
        var obj = $(obj).val();
        if(obj > 0){
            var pr = '<?php echo $dataid; ?>';
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

    function onArr(data_id,player_id,num,id,code){
        if(player_id==665){
            select_sign(data_id,player_id,num,id,'sign_id','sign_title','sign_head_pic',code);
        }
        else{
            select_sign(data_id,player_id,num,id,'id','name','logo',code);
        }
    }

    function select_sign(data_id,player_id,num,id,sid,sname,slogo,code){
        var purl = (player_id==665) ? '<?php echo $this->createUrl('select/gameSignList'); ?>' : '<?php echo $this->createUrl('select/gameTeamTable');?>';
        var arr = new Array();
        $('.sign_id_'+code).each(function(){
            if($(this).val()>0){
                var kn = $(this).siblings('.tname').val()+':'+$(this).val();
                arr.push(kn);
            }
        });
        purl += '&game_list_data_id='+data_id+'&arr='+arr+'&tcode='+code;
        $.dialog.data(sid, 0);
        $.dialog.open(purl,{
            id:"gamelist",
            lock:true,
            opacity:0.3,
            title:"选择具体内容",
            width:"95%",
            height:"95%",
            close: function(){
                if($.dialog.data(sid)!=''){
                    $("#sign_id_"+num).val($.dialog.data(sid));
                    $("#sign_name_"+num).val($.dialog.data(sname));
                    // $("#team_logo"+num).val($.dialog.data(slogo));
                    save_signmember(id,num,player_id);
                }
            }
        });
    }

    // 保存签号
    function save_signmember(id,num,player){
        var sign_id = $("#sign_id_"+num).val();
        var sign_name = $("#sign_name_"+num).val();
        // console.log(id,sign_id,sign_name);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('save_signmember'); ?>&id='+id+'&player='+player,
            data: {sign_id:sign_id,sign_name:sign_name},
            dataType: 'json',
            success: function(data){}
        });
    }

    // 清除选中
    function onClear(id,num,player){
        $('#sign_id_'+num).val('');
        $('#sign_name_'+num).val('');
        save_signmember(id,num,player);
    }

    $('.save_signnumber_name').on('blur',function(){
        var id = $(this).attr('attrid');
        var num = $(this).attr('attrnum');
        var player = $(this).attr('attrplayer');
        save_signmember(id,num,player);
    })
</script>