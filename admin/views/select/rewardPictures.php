<?php
    check_request('gift_type',0);
?>
<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>选择类型：</span>
                    <?php echo downList($interact_type,'f_id','F_NAME','interact_type','id="interact_type" onchange="changeGift(this);"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>选择礼物：</span>
                    <select name="gift_type" id="gift_type">
                        <option value="">请选择</option>
                    </select>
                </label>
                <!-- <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="club" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php //echo Yii::app()->request->getParam('keywords');?>">
                </label> -->
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th width="20%" class="check"><input id="j-checkall" class="input-check" type="checkbox" value="全选"></th>
                        <!-- <th class="check" colspan="2">点击选择 -->
                            <span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span>
                        <!-- </th> -->
                        <th>礼物名称</th>
                        <th>礼物图标</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($arclist as $v){ ?>
                        <?php
                            $base = BaseCode::model()->find('f_id='.$v->interact_type);
                            $interact_name = $base->F_NAME;
                        ?>
                        <tr id="line_<?php echo $v->id; ?>"
                            data-id="<?php echo $v->id; ?>"
                            data-code="<?php echo $v->reward_code; ?>"
                            data-name="<?php echo $v->reward_name; ?>"
                            data-pic="<?php echo $v->reward_pic; ?>"
                            data-gif="<?php echo $v->reward_gif; ?>"
                            data-interacttype="<?php echo $v->interact_type; ?>"
                            data-interactname="<?php echo $interact_name; ?>"
                            data-gifttype="<?php echo $v->gift_type; ?>"
                            data-rewardprice="<?php echo $v->reward_price; ?>"
                            data-gifttypename="<?php echo $v->gift_type_name; ?>">
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo $v->id; ?>"></td>
                            <td><?php echo $v->reward_name; ?></td>
                            <td>
                                <a href="<?php echo $v->reward_pic;?>" target="_blank">
                                    <img src="<?php echo $v->reward_pic;?>" width="50">
                                </a>
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
    $(function(){
        var parentt = $.dialog.parent;	// 父页面window对象
        api = $.dialog.open.api;	// art.dialog.open扩展方法
        if (!api) return;
        // 操作对话框
        api.button(
            {
                name:'确定',
                callback:function(){
                    return add_chose();
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

    function add_chose(){
        var boxnum = $('table.list ').find('.selected');
        $.dialog.data('id', -1);
        $.dialog.data('reward_name', boxnum );
        $.dialog.close();
    };

    $('.btn-blue').on('click',function(){
        if($('#interact_type').val()==''){
            we.msg('minus','请选择礼物类型');
            return false;
        }
        if($('#gift_type').val()==''){
            we.msg('minus','请选择礼物');
            return false;
        }
    });

    changeGift($('#interact_type'));
    function changeGift(obj){
        var obj = $(obj).val();
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('select/rewardPicturesGift'); ?>&id='+obj,
            dataType: 'json',
            success: function(data){
                // console.log(data);
                var s_html = '<option value=>请选择</option>';
                for(var i=0;i<data.length;i++){
                    s_html += '<option value="'+data[i]['id']+'"';
                    if(data[i]['id']==<?php echo $_REQUEST['gift_type']; ?>){
                        s_html += 'selected';
                    }
                    s_html += '>'+data[i]['name']+'</option>';
                }
                $('#gift_type').html(s_html);
            },
            errer: function(request){
                we.msg('minus','获取错误');
            }
        })
    }
</script>