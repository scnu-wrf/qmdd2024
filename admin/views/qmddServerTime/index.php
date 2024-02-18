
<style>
    .aui_content{overflow:auto;padding: 5px 5px!important;}
    #table_tag tbody tr td{border:solid 1px #d9d9d9;padding:5px}
</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务时间</h1></div>
    <div class="box-content">
        <div class="box-header">
            <!-- <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a> -->
            <a class="btn" href="javascript:;" onclick="add_tr();">添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <label style="margin-right:10px">
                    <span>关键字：</span>
                    <input type="text" style="width:200px;" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入功能名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th style="text-align: center;">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('timename');?></th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <td class="check check-item"><input type="checkbox" class="input-check" value="<?php echo CHtml::encode($v->id);?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center"><?php echo $v->timename; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
<script>
    // var screen = document.documentElement.clientWidth;
    // var sc = screen-30;
    var add_html = 
        '<div id="add_format" style="width:800px;">'+
            '<form id="add_form" name="add_form">'+
                '<table id="table_tag" style="width:100%;border: solid 1px #d9d9d9;">'+
                    '<thead>'+
                        '<tr class="table-title">'+
                            '<td colspan="10" style="padding: 5px;">添加&nbsp;&nbsp;<input type="button" class="btn btn-blue" onclick="add_tag();" value="添加"></td>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+
                        '<tr style="text-align:center;">'+
                            '<td style="width: 90px;">开始时间</td>'+
                            '<td style="width: 100px;">结束时间</td>'+
                            '<td style="width: 60px;">操作</td>'+
                        '</tr>'+
                        '<tr style="text-align:center;" class="add_len">'+
                            '<td><input style="width:135px;" class="input-text" type="text" id="start_time" name="table_tag[1][start_time]" onclick="time(this);"></td>'+
                            '<td><input style="width:135px;" class="input-text" type="text" id="end_time" name="table_tag[1][end_time]" onclick="time(this);"></td>'+
                            '<td class="del_tag"><a class="btn dis_a" href="javascript:;" onclick="tag_dele(this);">删除</a></td>'+
                        '</tr>'+
                    '</tbody>'+
                '</table>'+
            '</form>'+
        '</div>';

    // var a = '<a class="btn dis_a" href="javascript:;" onclick="tag_dele(this);">删除</a>';
    function tag_dele(op){
        $(op).parent().parent().remove();
        // var el = document.getElementsByClassName('del_tag');
        // el[el.length-1].innerHTML = a;
    }

    function time(){
        WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'HH:mm'});
    }
    function add_tr(){
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            height: '60%',
            // width:'80%',
            title:'添加时间',
            content:add_html,
            button:[
                {
                    name:'保存',
                    callback:function(){
                        return fn_add_tr();
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
    var o_num = 2;
    function add_tag(){
        // var add_num = $('.add_len').length;
        var table_tag = $('#table_tag');
        // var o_num = add_num+1;
        // $('.dis_a').remove();
        var tab_html = 
        '<tr style="text-align:center;" class="add_len">'+
            '<td><input style="width:135px;" class="input-text" type="text" id="start_time" name="table_tag['+o_num+'][start_time]" onclick="time(this);" ></td>'+
            '<td><input style="width:135px;" class="input-text" type="text" id="end_time" name="table_tag['+o_num+'][end_time]" onclick="time(this);"></td>'+
            '<td class="del_tag"><a class="btn dis_a" href="javascript:;" onclick="tag_dele(this);">删除</a></td>'+
        '</tr>';
        table_tag.append(tab_html);
        o_num++;
    }
    function fn_add_tr(){
        var form=$('#add_form').serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('addForm',array());?>',
            data: form,
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.loading('hide');
                    $.dialog.list['tianjia'].close();
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>