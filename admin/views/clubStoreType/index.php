
<div class="box">
    <div class="box-title c">
        <h1><span>当前界面：培训/活动 》培训设置 》培训类型设置</span></h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    </div> <!--box-title end-->
    <div class="box-content"> 
        <div class="box-header">
            <?php echo show_command('添加','javascript:;','添加','onclick="add_tr(\'\',\'create\');"');?> 
            <?php echo show_command('批删除','','删除'); ?>
        </div> <!--box-header end--> 
        <div class="box-table">
            <table class="list" style="text-align:left;">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th >序号</th>
                        <th ><?php echo $model->getAttributeLabel('code');?></th>
                        <th ><?php echo $model->getAttributeLabel('type');?></th>
                        <th ><?php echo $model->getAttributeLabel('classify');?></th>
                        <th ><?php echo $model->getAttributeLabel('display');?></th>
                        <th style="width:200px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1;foreach($arclist as $v){?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td ><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->code;?></td>
                        <td><?php echo $v->type;?></td>
                        <td><?php echo $v->classify;?></td>
                        <td><?php if(!is_null($v->is_display))echo $v->is_display->F_NAME;?></td>
                        <td>  
                            <?php if(empty($v->fater_id)){?>
                                <a class="btn" href="javascript:;" onclick="add_tr(<?php echo $v->id;?>,'create');">添加下级</a>
                            <?php }?>
                            <?php 
                                $arr=['id'=>$v->id,'f_id'=>$v->f_id,'code'=>$v->code];
                                if(empty($v->fater_id)){
                                    $arr['type']=$v->type;
                                    $arr['display']=$v->display;
                                }else{
                                    $arr['classify']=$v->classify;
                                }
                                echo show_command('修改','javascript:;','','onclick="add_tr(\''.$v->fater_id.'\',\'update\',\''.base64_encode(json_encode($arr)).'\');"'); 
                            ?>
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
    var datas=<?php echo json_encode(toArray($train_type,'f_id,F_NAME'));?>
</script>
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';

function add_tr(fater_id='',change,data=''){
    if(data!=''){
        data=$.parseJSON(new Base64().decode(data));
    }
    var add_html = 
        '<div style="width:500px;">'+
            '<form id="add_form" name="add_form">'+
                '<table class="box-detail-table" style="table-layout:auto;">'+
                    '<input id="change" name="change" value="'+change+'" type="hidden" >'+
                    '<input id="fater_id" name="fater_id" value="'+fater_id+'" type="hidden" >'+
                    '<input id="data_id" name="data_id" value="'+(data==''?'':data.id)+'" type="hidden" >'+
                    '<tr>'+
                        '<td width="100px;">编号</td>'+
                        '<td><input class="input-text" id="code" name="code" type="text" value="'+(data==''?'':data.code)+'" ></td>'+
                    '</tr>';
                    if(fater_id==''){
                        add_html += '<tr>'+
                            '<td width="100px;">类型</td>'+
                            '<td>'+
                                '<select id="f_id" name="f_id">'+
                                    '<option value="">请选择</option>';
                                    $.each(datas,function(k,info){
                                        add_html+='<option value="'+info.f_id+'"';
                                        if(data.f_id==info.f_id){
                                            add_html+='selected = "selected"';
                                        }
                                        add_html+='>'+info.F_NAME+'</option>'
                                    })
                                add_html+='</select>'+
                            // add_html += '<input class="input-text" id="type" name="type" type="text" value="'+(data==''?'':data.type)+'" >';
                            '</td>'+
                        '</tr>';
                        add_html += '<tr>'+
                            '<td width="100px;">是否展示前端</td>'+
                            '<td>'+
                            '<span class="check">'+
                            '<input class="input-check" id="display1" name="display" type="radio" value="649" '+(data.display==649?'checked="checked"':'')+'/>'+
                            '<label for="display1">是</label>&nbsp;&nbsp;'+
                            '<input class="input-check" id="display2" name="display" type="radio" value="648" '+(data.display==648?'checked="checked"':'')+'/>'+
                            '<label for="display2">否</label>&nbsp;&nbsp;'+
                            '</span>'+
                            '</td>'+
                        '</tr>';
                    }else{
                        add_html += '<tr>'+
                            '<td width="100px;">类别</td>'+
                            '<td><input class="input-text" id="classify" name="classify" type="text" value="'+(data==''?'':data.classify)+'" ></td>'+
                        '</tr>';
                    }
                    add_html += '</table>'+
            '</form>'+
        '</div>';
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            // height: '60%',
            // width:'80%',
            title:'当前界面：培训/活动 》培训设置 》培训类型设置 》添加',
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