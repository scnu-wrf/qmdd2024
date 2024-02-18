<style>
    .aui_content{height:400px;overflow:auto;padding: 5px 5px!important;}
    #t_body tr td{ border:solid 1px #d9d9d9;padding: 5px; text-align: center; }
    #table_tag thead tr:nth-child(2){ border:solid 1px #d9d9d9;padding: 5px; text-align: center; }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》收/发货管理》<a class="nav-a">退/换货收货处理</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
        <span class="back"><button id="exc_btn" class="btn btn-blue" type="button" onclick="javascript:excel();">导出</button></span>
    </div><!--box-title end-->     
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('returnGoods/index_forreturn');?>">待退货(<b class="red"><?php echo $for_num;?></b>)</a>
            <a class="btn" href="<?php echo $this->createUrl('returnGoods/receiv_list');?>">已退回(<b class="red"><?php echo $receiv_num; ?></b>)</a>
            <!--a href="javascript:;" class="btn" onclick="add_recive();">收货处理</a-->
            <a class="btn" id="orderdata_btn" href="javascript:;">收货处理</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>操作时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end; ?>">
                </label>
                <label style="margin-right:10px;">
                        <span>售后类型：</span>
                        <?php echo downList($change_type,'f_id','F_NAME','change_type'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:220px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="退换货单号/订单编号/退货物流单号">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center; width:25px;">序号</th>
                        <th style="width:10%;"><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th style="width:10%;"><?php echo $model->getAttributeLabel('return_order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('change_type');?></th>
                        <th>退换商品</th>
                        <th><?php echo $model->getAttributeLabel('ret_count');?></th>
                        <th><?php echo $model->getAttributeLabel('after_sale_state');?></th>
                        <th>物流信息</th>
                        <th><?php echo $model->getAttributeLabel('consignee_id');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('take_date');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->return_order_num; ?></td>
                        <td><?php echo (!empty($v->change_base)) ? $v->change_base->F_NAME : ''; ?></td>
                        <td><?php echo $v->orderdata->product_title; ?>，<?php echo $v->orderdata->json_attr; ?></td>
                        <td><?php echo $v->ret_count; ?></td>
                        <td><?php echo $v->after_sale_state_name; ?></td>
                        <td><?php echo $v->ret_logistics_name; ?>/<?php echo $v->ret_logistics; ?></td>
                        <td><?php echo $v->consignee_name; ?></td>
                        <td><?php echo $v->take_date; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_exam', array('id'=>$v->id,'ret_state'=>372));?>" title="详情">查看</a>
                            <?php if(substr($v->take_date,0,10)==date('Y-m-d')) {?>
                            <a class="btn" href="javascript:;" onclick="unshow(<?php echo $v->id;?>);" title="编辑">取消收货</a>
                            <?php }?>
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
// 查看收货列表
$('#orderdata_btn').on('click', function(){
    $.dialog.open('<?php echo $this->createUrl("receiv_data");?>',{
        id:'shouhuo',
        lock:true,
        opacity:0.3,
        title:'收货处理',
        width:'98%',
        height:'98%',
        close: function () {
            we.reload();
        }
    });
});
    var screen = document.documentElement.clientWidth;

    var $time_start=$('#start');
    var $time_end=$('#end');
    var end_input=$dp.$('end');
    $time_start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',onpicked:function(){end_input.click();}});
    });
    $time_end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',minDate:"#F{$dp.$D(\'start\')}"});
    });

    function excel(){
        $("#is_excel").val(1);
        $("#submit_button").click();
        $("#is_excel").val('');
    }

    // 网页内按下回车触发
    document.onkeydown=function(event){
        if(event.keyCode==13){
            query_child();
            return false;                               
        }
    }

    var screen = document.documentElement.clientWidth;
    var sc = screen-100;
    var html = 
        '<div id="add_format" style="width:'+sc+'px; height:90%;">'+
            '<form id="add_form" name="add_form">'+
                '<table id="table_tag" style="width:100%;border: solid 1px #d9d9d9;">'+
                    '<thead>'+
                        '<tr class="table-title" style="height: 40px;">'+
                            '<td colspan="12" style="padding: 10px;">订单信息：'+
                                '<input id="query_num" type="text" class="input-text" style="width:300px;margin-left:20px;vertical-align: bottom;" placeholder="请输入订单号 / 退货-换货单号 / 退货物流单号">'+
                                '<a href="javascript:;" class="btn btn-blue" onclick="query_child();" style="margin-left:5px;">查询</a>'+
                            '</td>'+
                            // '<input type="hidden" id="scale_state" name="scale_state" value="">'+
                        '</tr>'+
                        '<tr>'+
                            '<td class="check" style="border-right:solid 1px #ddd;">选择</td>'+  /* <input id="j-checkall" class="input-check" type="checkbox">*/
                            '<td style="border-right:solid 1px #ddd;">退货/换货单号</td>'+
                            '<td style="border-right:solid 1px #ddd;">物流单号</td>'+
                            '<td style="border-right:solid 1px #ddd;">商品编号</td>'+
                            '<td style="border-right:solid 1px #ddd;">商品名称</td>'+
                            '<td style="border-right:solid 1px #ddd;">型号/规格</td>'+
                            '<td style="border-right:solid 1px #ddd;">售后方式</td>'+
                            '<td style="border-right:solid 1px #ddd;">退换货数量</td>'+
                            '<td style="border-right:solid 1px #ddd;">申请人</td>'+
                            '<td style="border-right:solid 1px #ddd;">联系电话</td>'+
                            '<td style="border-right:solid 1px #ddd;">订单编号</td>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody id="t_body"></tbody>'+
                '</table>'+
            '</form>'+
        '</div>';

    function query_child(){
        var query_num = $('#query_num').val();
        if(query_num==''){
            we.msg('minus','请输入要查询的编码');
            return false;
        }
        var a = '<a class="picbox" href="" target="_blank"><img src="" style="width:100px;height:100px;"></a>';
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('query');?>&query_num='+query_num,
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.length);
                if(data!=''){
                    for(var i=0;i<data.length;i++){
                        if($('#change_'+data[i][0]['id']).length==0){
                            var o = '';
                            if(data[i][0]['change_type']=='1137'){
                                o = '退货';
                            }
                            else if(data[i][0]['change_type']=='1138'){
                                o = '换货';
                            }
                            var r_html = 
                                '<tr id="change_'+data[i][0]['id']+'">'+
                                    '<td class="check check-item"><input class="input-check" type="checkbox" name="check_box" value="'+data[i][0]['id']+'"></td>'+
                                    '<td>'+data[i][0]['order_num']+'</td>'+
                                    '<td>'+data[i][0]['ret_logistics']+'</td>'+
                                    '<td>'+data[i][2]['product_code']+'</td>'+
                                    '<td>'+data[i][2]['product_title']+'</td>'+
                                    '<td>'+data[i][2]['json_attr']+'</td>'+
                                    '<td>'+o+'</td>'+
                                    '<td>'+data[i][2]['ret_count']+'</td>'+
                                    '<td>'+data[i][0]['gf_name']+'</td>'+
                                    '<td>'+data[i][1]['rec_phone']+'</td>'+
                                    '<td>'+data[i][0]['return_order_num']+'</td>'+
                                '</tr>';
                            $('#t_body').append(r_html);
                        }
                    }
                }
                else{
                    we.msg('minus','单号错误或已收货，请检查后再查询');
                }
            }
        });
    }

    function add_recive(){
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
             //height: '95%',
             //width:'99%',
            title:'退换货收货处理',
            content:html,
            button:[
                {
                    name:'确认收货',
                    callback:function(){
                        var check_box = document.getElementsByName("check_box");
                        var checkNum = 0;
                        for(var i=0;i<check_box.length;i++){
                            if(check_box[i].checked){
                                checkNum++;
                            }
                        }
                        if(checkNum == 0){
                            we.msg('minus','未选择收货件');
                            return false;
                        }
                        var id = we.checkval('.check-item input:checked');
                        //console.log(id);
                        var form=$('#add_form').serialize();
                        we.loading('show');
                        $.ajax({
                            type: 'post',
                            url: '<?php echo $this->createUrl('addForm');?>&id='+id,
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
    }

    $(window).resize(function(){
        $('.aui_content').css('width',$(window).width()-100);
        $('.aui_content').css('height',$(window).height()-250);
    });

    function unshow(id){
        var a=confirm("确定取消吗？");
        if(a==false){
            return false;
        }
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('unshow');?>&id='+id,
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.loading('hide');
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