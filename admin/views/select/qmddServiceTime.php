<style>
    /* #time_money .input-text{ width: 80%; } */
    /* #time_money .t_time,#time_money .m_nony{ width: 25px; } */
    /* #time_money td:nth-child(odd){ width: 25px; } */
    /* #time_money .i_mony{ width:5%; } */
    /* #time_money .i_time{ width:5%; } */
    /* #time_money td:nth-child(even){ width:35px; } */
    /* #time_money td:nth-child(4n+0){ width: 25px; } */
    /* #time_money .time{ width: 80px; } */
    /* #time_money .doube{ width: 50px; } */
    /* @media screen and (min-width: 800px){ #time_money .doube{ width:5%; } #time_money .time{ width:80%; } #time_money .i_time{ width:8%; } }
    @media screen and (min-width: 1000px){ #time_money .doube{ width:75%; } #time_money .time{ width:83%; } #time_money .i_time{ width:10%; } #time_money .i_mony{ width:7%; } }
    @media screen and (min-width: 1240px){ #time_money .doube{ width:80%; } #time_money .time{ width:90%; } #time_money .i_time{ width:12%; } }
    @media screen and (min-width: 1480px){ #time_money .doube{ width:80%; } #time_money .time{ width:90%; } #time_money .i_time{ width:13%; } } */
    /* @media screen and (min-width: 814px){ #time_money .doube{ width: 23px; } }
    @media screen and (min-width: 890px){ #time_money .time{ width:80%; } #time_money .doube{ width: 75%; } }
    @media screen and (min-width: 1240px){ #time_money td:nth-child(odd){ width: 30px; } } */
    /* @media screen and (min-width: 1480px){ #time_money .i_mony{ width:5%; } } */
</style>
<div class="box">
    <div class="box-content">
        <div class="box-table">
            <!-- <div> -->
                <!-- <table class="list">
                    <thead>
                        <tr class="table-title">
                            <th colspan="16">时间与价格</th>
                        </tr>
                    </thead>
                    <tbody id="time_money">
                        <tr>
                            <?php
                                // $d=06;
                                // for($j=1;$j<18;$j++){
                                //     $d=$d+1;
                                //     $s=$d+1;
                                //     if($s==24){ $s='00'; }
                                //     echo '<td class="t_time">时间</td>';
                                //     echo '<td class="i_time"><input type="text" class="input-text time" id="f_dname'.$j.'" value="'.$d.':00-'.$s.':00"></td>';
                                //     echo '<td class="m_nony">价格</td>';
                                //     echo '<td id="'.$j.'" class="i_mony"><input type="text" class="input-text doube" id="f_price'.$j.'"></td>';
                                //     if($j==4 || $j==8 || $j==12 || $j==16){
                                //         echo '</tr><tr>';
                                //     }
                                //     if($j==17){
                                //         echo '<script>$("#17").after("<td colspan=12></td>");</script>';
                                //     }
                                // }
                            ?>
                        </tr>
                    </tbody>
                </table> -->
            <!-- </div> -->
            <div style="display:inline-block;width:100%;" class="gamesign">
                <div style="float:left;width:40%;overflow-x:hidden; overflow-y:scroll; position:fixed; height:auto; overflow:auto;">
                    <table id="list" class="list mt15" style="margin-top:0;">
                        <thead>
                            <tr>
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox" value="全选"><span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span></th>
                                <th>
                                    <label for="j-checkall">
                                        <?php
                                            $member_card = MemberCard::model()->find('mamber_type='.Yii::app()->request->getParam('membertype'));
                                            if(!empty($member_card->mamber_type_name))echo $member_card->mamber_type_name.'等级';
                                        ?>
                                    </label>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($arclist as $v){?>
                                <tr data-id="<?php echo $v->f_id; ?>" 
                                    data-mambertype="<?php echo $v->mamber_type; ?>" 
                                    data-title="<?php echo $v->card_name; ?>" >
                                    <td class="check check-item"><input id="<?php echo $v->f_id; ?>" class="input-check" type="checkbox" name="check_box" value="<?php echo CHtml::encode($v->f_id); ?>"></td>
                                    <td><label for="<?php echo $v->f_id; ?>"><?php echo $v->card_name; ?></label></td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
                <div style="float:right; width:56%; margin-left:10px;">
                    <table class="list" id="add_time">
                        <thead>
                            <tr class="table-title">
                                <th colspan="4"><b>时间与价格</b><span style="color:#888888;">（最多17条）</span></th>
                            </tr>
                            <tr>
                                <td style="text-align:center;">序号</td>
                                <td style="text-align:center;">时间段</td>
                                <td style="text-align:center;">价格</td>
                                <td style="text-align:center;min-width:108px;">操作</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $num = 1; ?>
                            <tr class="add_len">
                                <td style="text-align:center;"><?php echo $num; ?></td>
                                <td style="width:25%;"><input type="text" class="input-text time" id="f_dname<?php echo $num; ?>" style="width:75%;"></td>
                                <td style="width:23%;"><input type="text" class="input-text doube" id="f_price<?php echo $num; ?>" style="width:75%;"></td>
                                <td class="del_operation" style="text-align:center;">
                                    <a href="javascript:;" class="btn dis_a" onclick="add_tm();">添加</a>
                                    <!-- <a href="javascript:;" class="btn dis_a" onclick="del_time(this);">删除</a> -->
                                </td>
                            </tr>
                            <?php $num=$num+1; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        var parentt = $.dialog.parent;  // 父页面window对象
        api = $.dialog.open.api;	// art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button(
            {
                name:'确定',
                callback:function(){
                    var check_box = document.getElementsByName("check_box");
                    var checkNum = 0;
                    for(var i=0;i<check_box.length;i++){
                        if(check_box[i].checked){
                            checkNum++;
                        }
                    }
                    if(checkNum == 0){
                        we.msg('minus','未选择等级');
                        return false;
                    }
                    else{
                        return add_chose();
                    }
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        );
    });
    
    $(document).on('blur','.doube',function(){
    // $('.doube').blur(function(){
        var c=$(this);
        var reg = /^[0-9]+([.]{1}[0-9]{1,2})?$/;
        if(!reg.test(c.val()) && c.val()!=''){
            var temp_amount=c.val().replace(reg,'');
            we.msg('minus',"\u6574\u6570\uFF0C\u4E14\u6700\u591A\u4E24\u4F4D\u5C0F\u6570\u70B9",1500);
            $(this).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
            $(this).val(temp_amount.replace(/[^\d\.]/g,''));
        }
        else{
            $(this).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
        }
    });

    $(document).on('blur','.time',function(){
    // $('.time').blur(function(){
        var c=$(this);
        var reg = /^(([0-1]?\d)|(2[0-4])):[0-5]?\d\-(([0-1]?\d)|(2[0-4])):[0-5]?\d$/;
        if(!reg.test(c.val()) && c.val()!=''){
            var temp_amount=c.val().replace(reg,'');
            we.msg('minus',"\u683C\u5F0F\u4E3A\uFF1A\u0030\u0038\u003A\u0033\u0030\u002D\u0030\u0039\u003A\u0033\u0030\u0020\u6216\uFF1A\u0038\u003A\u0033\u0030\u002D\u0039\u003A\u0033\u0030","",2000);
            $(this).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
            // $(this).val(temp_amount.replace(/[^\d\:\d\-\d\:\d]/g,''));
            $(this).val('');
        }
        else{
            $(this).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
        }
    });

    var a = '<a href="javascript:;" class="btn dis_a" onclick="add_tm();">添加</a>&nbsp';
    var b = '<a href="javascript:;" class="btn dis_a" onclick="del_time(this);">删除</a>';
    function del_time(op){
        $(op).parent().parent().remove();
        var add_len = $('.add_len').length;
        var c = b;
        var el = document.getElementsByClassName('del_operation');
        if(add_len<1){
            add_tm();
            c = '';
        }
        el[el.length-1].innerHTML = a+c;
    }

    // var num = <?php //echo $num; ?>;
    var add_time = $('#add_time');
    function add_tm(){
        var num = $('.add_len').length+1;
        if(num>=18){
            alert('已最大数量时间段');
            return false;
        }
        $('.dis_a').remove();
        if($('.add_len').length<1){
            num = 1;
        }
        // num = num+1;
        var s_html = 
                '<tr class="add_len">'+
                    '<td style="text-align:center;">'+num+'</td>'+
                    '<td style="width:25%;"><input type="text" class="input-text time" id="f_dname'+num+'" style="width:75%;"></td>'+
                    '<td style="width:23%;"><input type="text" class="input-text doube" id="f_price'+num+'" style="width:75%;"></td>'+
                    '<td class="del_operation" style="text-align:center;">'+a+b+'</td>'+
                '</tr>';
                num++;
        add_time.append(s_html);
    }

    function add_chose(){
        var f_dname={};
        var f_price={};
        var add_len = $('.add_len').length;
        var boxnum = $('table#list').find('.selected');
        $.dialog.data('id', -1);
        $.dialog.data('title', boxnum);
        for(var i=1;i<=add_len;i++){
            f_dname['f_dname'+i] = document.getElementById('f_dname'+i).value;
            f_price['f_price'+i] = document.getElementById('f_price'+i).value;
            $.dialog.data('f_dname'+i,f_dname['f_dname'+i]);
            $.dialog.data('f_price'+i,f_price['f_price'+i]);
            $.dialog.data('add_len',add_len);
        }
        $.dialog.close();
    };
</script>