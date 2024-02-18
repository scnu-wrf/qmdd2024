<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr class="table-title">
                    <td colspan="4">服务信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'service_type_name'); ?></td>
                    <td><?php echo $model->service_type_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'service_name'); ?></td>
                    <td><?php echo $model->service_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'project_name'); ?></td>
                    <td><?php echo $model->project_name; ?></td>
                    <td><?php echo '服务时间'; ?></td>
                    <td><?php echo $model->servic_time_star.'-'.$model->servic_time_end; ?></td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="7">签到信息</td>
                </tr>
                <tr>
                    <td>服务流水号</td>
                    <td>免冠相片</td>
                    <td>姓名</td>
                    <td>帐号/队号</td>
                    <td>签到情况</td>
                    <td>签到时间</td>
                    <td>操作</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <input class="btn" type="button" onclick="signin(1);" value="签到">
                        <!-- <input class="btn" type="button" onclick="go_evalua();" value="去评价"> -->
                        <a class="btn" type="button" href="<?php echo $this->createUrl(''); ?>" value="0">去评价</a>
                    </td>
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td colspan="3"><button class="btn" type="button" onclick="we.back();">返回</button></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    // function signin(a){
    //     console.log(a);
    //     $.dialog(){
    //         id:'sign',
    //         lock:'true',
    //         opacity:'0.3',
    //         title:'签到',
    //         width:'200px',
    //         height:'100px',
    //         close: function(){};
    //     }
    // }

    var content=
        '<table>'+
            '<tr>'+
                '<td><input id="code" class="input-text" placeholder="请输入验证码"></td>'+
            '</tr>'+
        '</table>';
        
    var signin=function(id){
        $.dialog({
            id:'qiandao',
            lock:true,
            opacity:0.3,
            height:'15%',
            width:'20%',
            title:'签到',
            content:content,
            button:[
                {
                    name:'验证',
                    callback:function(){
                        var code = $('#code').val();
                        if(code==''){
                            we.msg('minus','请输入验证码');
                            return false;
                        }
                        we.loading('show');
                        $.ajax({
                            type: 'post',
                            url: '<?php echo $this->createUrl('signin');?>&id='+id,
                            data: {code:code},
                            dataType: 'json',
                            success: function(data) {
                                if(data.status==1){
                                    we.loading('hide');
                                    $.dialog.list['qiandao'].close();
                                    we.success(data.msg, data.redirect);
                                }else{
                                    we.loading('hide');
                                    we.msg('minus', data.msg);
                                }
                            }
                        });
                        return false;
                    },
                    focus:true
                },
                // {
                //     name:'取消',
                //     callback:function(){
                //         return true;
                //     }
                // }
            ]
        });
    };
</script>