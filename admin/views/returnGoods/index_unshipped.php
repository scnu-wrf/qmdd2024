<style>.box-table .list tr th,.box-table .list tr td{ text-align: center; }</style>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-home"></i>当前界面：订单>售后管理><a class="nav-a">未发货退货确认列表</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->    
    <div class="box-content">
        <!--div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <button id="exc_btn" class="btn btn-blue" type="button" onclick="javascript:excel();">导出</button> 
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <!-- <label style="margin-right:20px;">
                    <span>申请时间：</span>
                    <input style="width:75px;" class="input-text" type="text" id="time_start" name="time_start" value="<?php //echo Yii::app()->request->getParam('time_start'); ?>">
                    <span>-</span>
                    <input style="width:75px;" class="input-text" type="text" id="time_end" name="time_end" value="<?php //echo Yii::app()->request->getParam('time_end'); ?>">
                </label>
                <label style="margin-right:20px;width:270px;">
                    <span>申请人账号：</span>
                    <input style="width:100px;" class="input-text" type="text" name="order_account" value="<?php //echo Yii::app()->request->getParam('order_account'); ?>" placeholder="请输入申请人账号">
                </label> -->
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:220px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入退换货单号">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('order_account');?></th>
                        <th><?php echo $model->getAttributeLabel('product_title');?></th>
                        <th><?php echo $model->getAttributeLabel('json_attr');?></th>
                        <th><?php echo $model->getAttributeLabel('buy_count');?></th>
                        <th><?php echo $model->getAttributeLabel('order_date');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php if(!empty($v->order_num) && !empty($v->orderinfo))echo $v->orderinfo->order_gfaccount; ?></td>
                            <td><?php echo $v->orderdata->product_title; ?></td>
                            <td><?php echo $v->orderdata->json_attr; ?></td>
                            <td><?php echo $v->ret_count; ?></td>
                            <td><?php echo $v->order_date; ?></td>
                            <td><a class="btn" href="javascript:;" onclick="unshow(<?php echo $v->id;?>);" title="编辑">确认</a></td>
                        </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var $time_start=$('#time_start');
    var $time_end=$('#time_end');
    var end_input=$dp.$('time_end');
    $time_start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',onpicked:function(){end_input.click();}});
    });
    $time_end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',minDate:"#F{$dp.$D(\'time_start\')}"});
    });

    function excel(){
        $("#is_excel").val(1);
        $("#submit_button").click();
        $("#is_excel").val('');
    }

    function unshow(id){
        var a=confirm("确定？");
        if(a==false){
            return false;
        }
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('addForm');?>&id='+id,
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