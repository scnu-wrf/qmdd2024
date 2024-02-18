
<?php //var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
        <h1><?php if(empty($_REQUEST['edit_state'])){echo '当前界面：商户管理 》商户入驻 》商户审核';}else{echo '当前界面：社区单位》单位认证管理 》单位认证申请';};?></h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search" >
<form action="/sports/admin/qmdd2018/index.php?r=commercialTenant/auditIndex" ><p>
<input type="hidden" name="r" value="commercialTenant/auditIndex" >
<label style="margin-right:10px;">
<span>关键词：</span>
<input style="width:200px;height=25px;" class="input-text" name="keywords" value="" placeholder="请输入关键词">
 </label>
<button class="btn btn-blue" type="submit">查询</button><input type="hidden" name="submitType" id="submitType" value="3">
</p></form>
        </div><!--box-search end-->


        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                            <th class="check">
                                <input id="j-checkall" class="input-check" type="checkbox">
                            </th>
                            <th>类型</th>
                            <th>商户名称</th>
                            <th>商户地址</th>
                            <th>联系人名称</th>
                            <th>联系人手机号</th>
                            <th>状态</th>
                            <th>更新时间</th>
                            <th>操作</th>
                    </tr>

                    <?php foreach ($arclist as $arc) {?>
                    <tr>
                        <td class="check"><input id="j-checkall" class="input-check" type="checkbox"></td>
                        <td><?php echo $arc->ct_type?></td>
                        <td><?php echo $arc->ct_name?></td>
                        <td><?php echo $arc->ct_province.$arc->ct_city.$arc->ct_district.$arc->ct_street.$arc->ct_address?></td>
                        <td><?php echo $arc->ct_connector_name?></td>
                        <td><?php echo $arc->ct_connector_phone?></td>
                        <td><?php echo $arc->ct_condition?></td>
                        <td><?php echo $arc->ct_update_time?></td>
                        <td>
                        <button class="btn" type="button" 
                        onclick="location.href='/sports/admin/qmdd2018/index.php?r=commercialTenant/auditEnterprise&id=<?php echo $arc->id;?>&mode=0&from=0'" style="background-color:#368ee0;color:white;">审核</button>
                        </td>
                    </tr>
                    <?php } ?>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'edit_state','del'=>null,'yes'=>'取消成功','no'=>'取消失败'));?>';
</script>
<script>
    $(function(){
        var $start_time=$('#start_date');
        var $end_time=$('#end_date');
        $start_time.on('click', function(){
            var end_input=$dp.$('end_date')
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
        });
    });

    function on_exam(){
        $('#date').val(1);
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        document.getElementById('click_submit').click();
    }

</script>