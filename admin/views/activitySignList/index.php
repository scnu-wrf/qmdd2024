<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动》活动报名》活动报名</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
        <!-- $this->createUrl('create') -->
            <?php echo show_command('添加','javascript:;','添加报名','onclick="add_sign_data()"'); ?>
            <a class="btn btn-blue" href="javascript:;" onclick="checkSubmit('tongguo')">审核通过</a>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
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
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('activity_code');?></th>
                        <th><?php echo $model->getAttributeLabel('activity_title');?></th>
                        <th><?php echo $model->getAttributeLabel('activity_data_id');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_account');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_name');?></th>
                        <th><?php echo $model->getAttributeLabel('sige_phone');?></th>
                        <th><?php echo $model->getAttributeLabel('state');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->activity_code; ?></td>
                            <td><?php echo $v->activity_title; ?></td>
                            <td><?php echo $v->activity_data_content; ?></td>
                            <td><?php echo $v->sign_account; ?></td>
                            <td><?php echo $v->sign_name; ?></td>
                            <td><?php echo $v->sige_phone; ?></td>
                            <td><?php echo $v->state_name; ?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'index'=>1))); ?>
                                <?php echo show_command('删除','\''.$v->id.'\''); ?>
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
    var data=<?php echo json_encode(toArray($activity_list,'id,activity_title'));?>
</script>
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    function add_sign_data(){
        var add_html = 
            '<div id="add_format" style="width:500px;">'+
                '<form id="add_form" name="add_form">'+
                    '<table class="list" id="table_tag" style="width:100%;border: solid 1px #d9d9d9;">'+
                        '<tr>'+
                            '<td colspan="2" style="width:25px;padding: 5px;">活动标题&nbsp;&nbsp;</td>'+
                            '<td>'+
                                '<select onchange="changeSignData(this,1);" id="activity_id">'+
                                '<option value="">请选择</option>';
                                $.each(data,function(k,info){
                                    add_html+='<option value="'+info.id+'">'+info.activity_title+'</option>'
                                })
                                add_html+='</select>'+
                            '</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td colspan="2" style="width:25px;padding: 5px;">活动选择&nbsp;&nbsp;</td>'+
                            '<td>'+
                                '<select id="activity_data">'+
                                    '<option value="">请选择</option>';
                                add_html+='</select>'+
                            '</td>'+
                        '</tr>'+
                    '</table>'+
                '</form>'+
            '</div>';
        if_data=0;
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            // height: '60%',
            // width:'80%',
            title:'选择活动',
            content:add_html,
            button:[
                {
                    name:'前往添加',
                    callback:function(){
                        if($("#activity_id").val()==''){
                            we.msg('minus', '请选择活动标题');
                            return false;
                        }
                        if($("#activity_data").val()==''){
                            we.msg('minus', '请选择活动内容');
                            return false;
                        }
                        window.location.href="<?php echo $this->createUrl('create'); ?>&activity_id="+$("#activity_id").val()+'&activity_data_id='+$("#activity_data").val();
                    },
					
                    focus:true
                },
                {
                    name:'取消',
                    callback:function(){
                        return true;
                    }
                }
            ]
        });
        $('.aui_main').css('height','auto');
    }

    $(function(){
        $("select[name='title']").trigger("change");
    })

    function changeSignData(obj,index) {
        index=index==1?1:0;
        var show_id = $(obj).val();
        var query_content = <?php echo !empty($_REQUEST['content'])?$_REQUEST['content']:0;?>;
        var content='<option value="">请选择</option>';
        if(index==1){
            $("#activity_data").html(content);
        }else{
            $("select[name='content']").html(content);
        }
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getListData'); ?>',
            data: {id: show_id,index:index},
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $.each(data,function(k,info){
                    content+='<option value="'+info.id+'" remnant="'+info.remnant+'" ';
                    if(index==0&&query_content==info.id){
                        content+='selected = "selected"';
                    }
                    content+='>'+info.activity_content+'</option>'
                })
                if(index==1){
                    $("#activity_data").html(content);
                }else{
                    $("select[name='content']").html(content);
                    $("select[name='content']").trigger("change");
                }
            }
        });
    }
    
    function checkSubmit(state){
        var str = '';
        $(".check-item input:checked").each(function(){
            str += $(this).val() + ',';
        })
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请选中要提交审核的数据');
            return false;
        }
        var an = function(){
            we.loading('show');
            $.ajax({
                type:'post',
                url:'<?php echo $this->createUrl("submit"); ?>',
                data: {id: str,submitType:state},
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
            content: '是否提交审核？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    }
</script>