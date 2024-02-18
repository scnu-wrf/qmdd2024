<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="game_list_data_id" value="<?php echo $_REQUEST['game_list_data_id'];?>">
                <input type="hidden" name="arr" value="<?php echo $arr;?>">
                <input type="hidden" name="tcode" value="<?php echo $tcode;?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="game" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table" style="width: 100%;display: inline-block;">
            <table class="list" style="width: 49%;float:left;margin-right:2%;">
                <thead>
                    <tr>
                        <th>GF账号</th>
                        <th>姓名/队名</th>
                        <th>对应签号</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-id="0" data-title="轮空">
                        <td class="click_td" style="color:red;" colspan="3">轮空</td>
                    </tr>
                    <!-- <table class="list" style="width: 49%;float: left;margin-right:2%;"> -->
                        <?php
                            foreach($arclist as $key => $v){
                                $len = count($arclist);
                                $key = $key+1;
                                $num2 = 0;
                                $width = 'width:33.33%;';
                                $float = is_float($len / 2);
                                $num2 = intval($len / 2);
                                if($float) $num2 = $num2+1;
                        ?>
                            <tr data-id="<?php echo $v->id; ?>" data-title="<?php echo $v->sign_name; ?>" data-gfid="<?php echo $v->sign_gfid; ?>" data-account="<?php echo $v->sign_account; ?>" data-pic="<?php echo $v->sign_head_pic; ?>">
                                <td class="click_td" style="<?php echo $width; ?>"><?php echo $v->sign_account; ?></td>
                                <td class="click_td" style="<?php echo $width; ?>"><?php echo $v->sign_name; ?></td>
                                <td style="<?php echo $width; ?>" class="text">
                                    <input type="text" class="input-text out_blur" value="<?php
                                        $arr1 = explode(',',$arr);
                                        if(!empty($arr1))foreach($arr1 as $val){
                                            if(!empty($val)){
                                                $a = explode(':',$val);
                                                if($v->id==$a[1]){
                                                    echo $a[0];
                                                }
                                            }
                                        }
                                    ?>">
                                </td>
                            </tr>
                        <?php
                                if($key==$num2){
                                    echo '</tbody></table><table class="list" style="width: 49%;"><tr data-id="0" data-title="轮空"><thead>
                                            <tr>
                                                <th>GF账号</th>
                                                <th>姓名/队名</th>
                                                <th>对应签号</th>
                                            </tr>
                                        </thead><tbody><td class="click_td" style="color:red;" colspan="3">轮空</td></tr>';
                                }
                            }
                        ?>
                    <!-- </table> -->
                </tbody>
            </table>
        </div><!--box-table end-->
        <!-- <div class="box-page c"><?php //$this->page($pages); ?></div> -->
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        api = $.dialog.open.api;    //          art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button( { name: '取消' } );
        $('.box-table tbody tr .click_td').on('click', function(){
            var thisa = $(this).parent();
            if($.trim(thisa.children(".text:last-child").text())==''){
                var id = thisa.attr('data-id');
                var title = thisa.attr('data-title');
                var code = thisa.attr('data-code');
                var sign_gfid = thisa.attr('data-gfid');
                var sign_account = thisa.attr('data-account');
                var sign_pic = thisa.attr('data-pic');
                $.dialog.data('sign_id', id);
                $.dialog.data('sign_title', title);
                $.dialog.data('sign_code', code);
                $.dialog.data('sign_gfid', sign_gfid);
                $.dialog.data('sign_account', sign_account);
                $.dialog.data('sign_head_pic', sign_pic);
                $.dialog.close();
            }
        });
    });

    $('body').on('blur','.out_blur',function(){
        var thisa = $(this).parent().parent();
        var id = thisa.attr('data-id');
        var gfid = thisa.attr('data-gfid');
        var gfname = thisa.attr('data-title');
        var gfaccount = thisa.attr('data-account');
        var this_val = $(this).val();
        // console.log(id,gfid,gfaccount);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('gameListArrange/saveSign',array('data_id'=>$_REQUEST['game_list_data_id'],'arrange_tcode'=>$tcode)); ?>',
            data: {id:id,gfid:gfid,gfaccount:gfaccount,gfname:gfname,this_val:this_val},
            dataType: 'json',
            success: function(data){
                if(data.status==0){
                    we.msg('minus',data.msg);
                }
            },
            error: function(request){
                console.log(request);
            }
        })
    })
</script>