
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>GF普通账号列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="update('.check-item input:checked',1);">保留</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <!-- <a id="j-check" class="btn" href="javascript:;" onclick="update('.check-item input:checked',1);" style="vertical-align: middle;margin-top: 10px;margin-right:10px;">一键保留</a> -->
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入GF账号">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align: center;">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('non_account');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(170);?>
                <?php $index = 1;
                 foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item">
                            <input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>">
                        </td>
                        <td style="text-align: center"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></td>
                        <td style="text-align: center"><?php echo $v->non_account; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" onclick="update(<?php echo $v->id;?>);" href="javascript:;" title="保留">保留</a>
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

    var ids=[];
    // 每页全选
    $('#j-checkall').on('click', function(){
        $temp1 = $('.check-item .input-check');
        $temp2 = $('.box-table .list tbody tr');
        $this = $(this);
        if($this.is(':checked')){
            $temp1.each(function(){
                ids.push($(this).val());
                this.checked = true;
            });
            $temp2.addClass('selected');
            ids=uniqueArray(ids);
        }else{
            $temp1.each(function(){
                this.checked = false;
                removeByValue(ids,$(this).val());
            });
            $temp2.removeClass('selected');
        }
    });
    // 单选
    $('.check-item .input-check').on('click', function() {
        $this = $(this);
        if ($this.is(':checked')) {
            $this.parent().parent().addClass('selected');
            ids.push($this.val());
        } else {
            $this.parent().parent().removeClass('selected');
            removeByValue(ids,$this.val());
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
    // 保留账号
    function update(id,val){
        if(val==1){
            if(ids.length<1){
                we.msg('minus','请选择要保留的账号');
                return false;
            }
            id=ids.join(',');
        }
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('update');?>&id='+id,
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
        return false;
    }
    
</script>