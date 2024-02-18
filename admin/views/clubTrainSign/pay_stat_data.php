<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》培训统计 》报名费用明细</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li style="padding:0 10px;"><a href="<?php echo $this->createUrl('clubStoreTrain/index_pay_stat');?>">报名费用统计</a></li>
                <li class="current" style="padding:0 10px;">报名费用明细</li>
            </ul>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="index" value="<?php echo Yii::app()->request->getParam('index');?>">
                <input type="hidden" name="club_id" value="<?php echo Yii::app()->request->getParam('club_id');?>">
                <label style="margin-right:10px;">
                    <span>起始时间：</span>
                    <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label style="margin-right:20px;">
                    <span>培训标题：</span>
                    <?php echo downList($train_list,'id','train_title','title','onchange="changeSignData(this);"'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>培训内容：</span>
                    <?php echo downList($train_data,'id','train_content','content'); ?>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号/账号/发布单位">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('info_order_num');?></th>
                        <th>培训类别</th>
                        <th>培训标题</th>
                        <th>培训内容</th>
                        <th>报名人</th>
                        <th>费用（元）</th>
                        <th><?php echo $model->getAttributeLabel('free_make');?></th>
                        <th><?php echo $model->getAttributeLabel('buy_price2');?></th>
                        <th>支付方式</th>
                        <th>支付时间</th>
                        <th>发布单位</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $index = 1; foreach($arclist as $v){ 
                    ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php echo $v->info_order_num; ?></td>
                            <td><?php if(!is_null($v->train_list_data))echo $v->train_list_data->type_name; ?></td>
                            <td><?php echo $v->service_name; ?></td>
                            <td><?php echo $v->service_data_name; ?></td>
                            <td><?php if(!is_null($v->train_sign))echo $v->train_sign->sign_name.'('.$v->gf_account.')'; ?></td>
                            <td><?php echo $v->buy_price; ?></td>
                            <td><?php echo $v->free_make==0?'免费':'收费'; ?></td>
                            <td><?php echo $v->buy_price-$v->free_money; ?></td>
                            <td><?php if(!is_null($v->mall_order_num))echo $v->mall_order_num->pay_supplier_type_name; ?></td>
                            <td><?php if(!is_null($v->mall_order_num))echo $v->mall_order_num->pay_time; ?></td>
                            <td><?php echo $v->supplier_name; ?></td>
                            <td>
                                <?php 
                                    if(!empty($v->info_order_num))$info=MallSalesOrderInfo::model()->find('order_num="'.$v->info_order_num.'"');
                                    if(!empty($info)){
                                        echo '<a class="btn" href="'.$this->createUrl('mallSalesOrderInfo/update_serve_type', array('id'=>$info->id)).'"  title="详情"><i class="fa fa-edit"></i></a>'; 
                                    }
                                ?>
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

    var $start_date=$('#start_date');
    var $end_date=$('#end_date');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_date.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    
    function changeSignData(obj) {
        var show_id = $(obj).val();
        var content='<option value="">请选择</option>';
        $("select[name='content']").html(content);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getListData'); ?>',
            data: {id: show_id},
            dataType: 'json',
            success: function(data) {
                $.each(data,function(k,info){
                    content+='<option value="'+info.id+'" remnant="'+info.remnant+'" >'+info.train_content+'</option>'
                })
                $("select[name='content']").html(content);
            }
        });
    }
</script>