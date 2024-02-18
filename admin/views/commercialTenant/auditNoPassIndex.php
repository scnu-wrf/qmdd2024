
<?php //var_dump($_REQUEST);?>
<script type="text/javascript">
    function show(id,content){
        var modal = document.getElementById("outter");
        document.getElementById("hidId").value=id;
        if(content != undefined && content!="" )
         document.getElementById('lockReason').value=content;
        modal.style.display='block';
    }
    function hid(){
        document.getElementById('outter').style.display='none';
        document.getElementById("hidId").value='';
        document.getElementById('lockReason').value='';
    }
    function sub(){
            var formData = $('#myForm').serialize();
            var reason=document.getElementById('lockReason').value;
            if(reason.includes("'") || reason.includes('"')){
                alert('请勿输入英文的引号！');
                return;
            }
            // 发送 AJAX 请求
            $.ajax({
                type: 'POST',  // 可根据需要使用 POST 或 GET
                url: '/sports/admin/qmdd2018/index.php?r=commercialTenant/lockCT',  // 替换为实际的处理脚本地址
                data: formData,
                success: function(response) {
                    // 处理成功的响应
                      window.location.href = '/sports/admin/qmdd2018/index.php?r=commercialTenant/auditNoPassIndex';
                },
                error: function(error) {
                    // 处理错误的响应
                    console.error(error);
                }
            });
    }
</script>
<style type="text/css">
    #submitLockBtn{
        background: black;
        color: white;
        padding: 5px;
        margin: auto;
        display: block;
        border-radius: 10px;
        width: 60%;
        margin-top: 10px;
        font-size: 20px;
    }
    #lockBody{
        display: flex;
        width: 100%;
        justify-content: center;
    }
    textarea{
        width: 95%;
        resize: none;
        padding: 10px;
        font-size: 18px; 
        direction: ltr;
        text-align: left;
        height: 200px;
        margin: auto;
        margin-top: 10px;
    }
    #lockTitle{
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        padding:5px;
    }
    #outter{
        display: none;
        position: fixed;
        z-index: 9999;
        background-color: rgba(0,0,0,0.3);
        width: 100%;
        height: 100%;
    }
    #inner{
        width: 50%;
        background-color: white;
        margin: auto;
        margin-top: 20px;
        border-radius: 10px;
        padding:0px 0px 10px 0px;
    }
</style>
        <div id="outter" onclick="hid()">
            <div id="inner"  onclick="event.cancelBubble = true">
                <div id="lockTitle">输入注销原因</div>
                <hr>
                <form id="myForm">
                <div id="lockBody">
                    <textarea placeholder="输入注销原因（可选）" id="lockReason" name="lockReason"></textarea>
                    <input type="text" value="" hidden id="hidId" name="hidId">
                </div>
                </form>
                <button id="submitLockBtn"  onclick="sub()">保存原因并注销</button>
            </div>
        </div>


<div class="box">
    <div class="box-title c">
        <h1><?php if(empty($_REQUEST['edit_state'])){echo '当前界面：商户管理 》商户入驻 》未过审商户';}else{echo '当前界面：社区单位》单位认证管理 》单位认证申请';};?></h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search" >
<form action="/sports/admin/qmdd2018/index.php?r=commercialTenant/auditNoPassIndex" ><p>
<input type="hidden" name="r" value="commercialTenant/auditNoPassIndex" >
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
                        onclick="location.href='/sports/admin/qmdd2018/index.php?r=commercialTenant/auditEnterprise&id=<?php echo $arc->id;?>&mode=0&from=2'" style="background-color:#368ee0;color:white;">审核</button>
                          <button class="btn" onclick="show(<?php echo $arc->id ?>,'<?php echo $arc->ct_lock_reason?>')">注销</button>
                          <a class="btn" href="javascript:;" onclick="we.dele(<?php echo $arc->id?>, deleteUrl);" title="删除">删除</a>  
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