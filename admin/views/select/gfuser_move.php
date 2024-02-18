<div class="box">
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="passed" value="<?php echo Yii::app()->request->getParam('passed');?>">
                <input type="hidden" name="len" value="<?php echo $_REQUEST['len'];?>">
                <label style="margin-right:10px;">
                    <!--<span>关键字：</span>-->
                    <input id="gfuser" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入GF账号">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="width:3%;">序号<span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();"></a></span></th>
                        <th>GF账号</th>
                        <th>姓名</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($arclist as $v){?>
                        <tr data-id="<?php echo $v->GF_ID; ?>" 
                            data-code="<?php echo $v->GF_ACCOUNT; ?>" 
                            data-title="<?php echo $v->GF_NAME; ?>" 
                            data-passed="<?php echo $v->passed; ?>" 
                            data-zsxm="<?php echo $v->ZSXM; ?>" 
                            data-sex="<?php echo $v->real_sex; ?>" 
                            data-card="<?php echo $v->id_card; ?>" 
                            data-birthday="<?php echo $v->real_birthday; ?>" 
                            data-native="<?php echo $v->native; ?>" 
                            data-nation="<?php echo $v->nation; ?>">
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo $v->GF_ID; ?>"></td>
                            <td width="30%"><?php echo $v->GF_ACCOUNT; ?></td>
                            <td width="70%"><?php echo $v->ZSXM; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var num = 0;
    var relen = <?php echo $_REQUEST['len']; ?>;
    $(function(){
        var parentt = $.dialog.parent;				// 父页面window对象
        api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button(
            {
                name:'确定',
                callback:function(){
                    if(num+relen>2){
                        we.msg('minus','不能超过2人');
                        return false;
                    }
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

    $('.list .input-check').on('click',function(){
        var len = 0;
        $('.list .input-check').each(function(){
            if($(this).is(':checked')){
                len = len+1;
            }
        })
        num = len;
    })

    function add_chose(){
        var boxnum = $('table.list ').find('.selected');
        $.dialog.data('id', -1);
        $.dialog.data('service_name', boxnum );
        $.dialog.close();
    };
</script>
