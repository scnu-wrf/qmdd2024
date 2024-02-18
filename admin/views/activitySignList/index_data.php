<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动》活动管理》活动报名</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>活动标题：</span>
                    <?php echo downList($activity_list,'id','activity_title','title','onchange="changeSignData(this);"'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>活动内容：</span>
                    <select name="content"><option value=''>请选择</option></select>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号或标题">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <a class="btn btn-blue" style="vertical-align: middle;"  href="javascript:;" onclick="cancel()">取消报名</a>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('activity_data_id');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_account');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_name');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_sex');?></th>
                        <th><?php echo $model->getAttributeLabel('sige_phone');?></th>
                        <th>费用（元）</th>
                        <th>报名状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->activity_data_content; ?></td>
                            <td><?php echo $v->sign_account; ?></td>
                            <td><?php echo $v->sign_name; ?></td>
                            <td><?php echo $v->sign_sex_name; ?></td>
                            <td><?php echo $v->sige_phone; ?></td>
                            <td><?php if(!is_null($v->gData))echo $v->gData->buy_price-$v->gData->free_money; ?></td>
                            <td><?php echo $v->state==372?'报名成功':'取消报名'; ?></td>
                            <td>
                                <a class="btn" href="<?= $this->createUrl('update', array('id'=>$v->id));?>" title="详情"><i class="fa fa-edit"></i></a>
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
    

    $(function(){
        if($("select[name='title']").val()!=''){
            $("select[name='title']").trigger("change");
        }
    })
    
    function changeSignData(obj) {
        var show_id = $(obj).val();
        var query_content = <?php echo !empty($_REQUEST['content'])?$_REQUEST['content']:0;?>;
        var content='<option value="">请选择</option>';
        $("select[name='content']").html(content);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getListData'); ?>',
            data: {id: show_id},
            dataType: 'json',
            success: function(data) {
                $.each(data,function(k,info){
                    content+='<option value="'+info.id+'" remnant="'+info.remnant+'" ';
                    if(query_content==info.id){
                        content+='selected = "selected"';
                    }
                    content+='>'+info.activity_content+'</option>'
                })
                $("select[name='content']").html(content);
            }
        });
    }

    // 每页全选
    $('#j-checkall').on('click', function(){
        var $temp1 = $('.check-item .input-check');
        var $temp2 = $('.box-table .list tbody tr');
        var $this = $(this);
        if($this.is(':checked')){
            $temp1.each(function(){
                this.checked = true;
            });
            $temp2.addClass('selected');
        }else{
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });
    
    function cancel(){
        var str = '';
        $(".check-item input:checked").each(function(){
            str += $(this).val() + ',';
        })
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请选中要取消报名的数据');
            return false;
        }
        var an = function(){
            we.loading('show');
            $.ajax({
                type:'post',
                url:'<?php echo $this->createUrl("cancel"); ?>&id='+str+'&new="state"&del=374&yes="取消报名成功"&no="取消报名失败"',
                dataType:'json',
                success: function(data){
                    we.loading('hide');
                    if(data.status==1){
                        we.success(data.msg, data.redirect);
                    }else{
                        we.msg('minus', data.msg);
                    }
                }
            });
            return false;
        }
        
        $.fallr('show', {
            buttons: {
                button1: {text: '确定', danger: true, onclick: an},
                button2: {text: '取消'}
            },
            content: '是否取消报名？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    }
</script>