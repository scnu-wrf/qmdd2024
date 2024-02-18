<!-- <style>
    .box-detail-tab li{
        width:24.9173%;
        border-right:solid 1px #d9d9d9;
        line-height: 30px;
        font-size:0.5rem;
    }
    .box-detail-tab{
        margin:10px auto 0;
    }
    .box-title h4{
        display: inline-block;
        width: auto;
        color: #444;
        font-size:12px;
        line-height: 30px;
    }
    .lode_po{
        color:#333;
    }
    .lode_po:hover{
        color:red;
    }
</style> -->
<div class="box">
    <!-- <div class="box-detail-tab">
        <ul class="c">
            <li><a href="<?php //echo $this->createUrl('clubProject/index_ad_fee'); ?>">服务机构入驻费列表</a></li>
            <li class="current" style="border-right:none;"><a href="<?php //echo $this->createUrl('qualificationsPerson/index_ad_fee'); ?>">服务者入驻费列表</a></li>
        </ul>
    </div>box-detail-tab end -->
    <div class="box-title c">
        <h1>
            <span>当前界面：服务者》服务者费用》费用明细表</span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo get_session('club_id');?>">
                <label style="margin-right:10px;">
                    <span>确认日期：</span>
                    <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project,'id','project_name','project'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>服务者类型：</span>
                    <?php echo downList($type,'member_second_id','member_second_name','type'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>收费方式：</span>
                    <?php echo downList($pay_way,'f_id','F_NAME','pay_way'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入项目名称 / 单位名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <thead>
                <table class="list">
                    <?php $checked = 'checked="checked"'; ?>
                    <tr>
                        <!-- <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th> -->
                        <th>序号</th>
                        <th>收费会员类型</th>
                        <th>收费项目名称</th>
                        <th>缴费单号</th>
                        <th>账号</th>
                        <th>姓名</th>
                        <th>入驻项目</th>
                        <th>入驻类型</th>
                        <th>收费方式</th>
                        <th>应收费用</th>
                        <th>减免金额</th>
                        <th>实收费用</th>
                        <th>支付方式</th>
                        <th>确认时间</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <!-- <td class="check check-item"><input class="input-check" type="checkbox" value="<?php //echo CHtml::encode($v->id); ?>"></td> -->
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td>服务者</td>
                            <td><?php echo $v->product_name; ?></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php if(!empty($v->gf_user->GF_ACCOUNT))echo $v->gf_user->GF_ACCOUNT; ?></td>
                            <td><?php echo $v->gf_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php if(!empty($v->qualifications_personid->qualification_type))echo $v->qualifications_personid->qualification_type; ?></td>
                            <td><?php if(!empty($v->qualifications_personid->pay_way_name))echo $v->qualifications_personid->pay_way_name; ?></td>
                            <td><?php if(!empty($v->qualifications_personid->cost_admission))echo $v->qualifications_personid->cost_admission; ?></td>
                            <td><?php if(!empty($v->qualifications_personid->free_charge))echo $v->qualifications_personid->free_charge; ?></td>
                            <td><?php if(!empty($v->qualifications_personid->cost_account))echo $v->qualifications_personid->cost_account; ?></td>
                            <td><?php echo $v->scale_type; ?></td>
                            <td><?php echo $v->f_userdate; ?></td>
                        </tr>
                    <?php $index++; } ?>
                </table>
            </thead>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $('#j-checkall').on('click', function(){
        $temp1 = $('.check-item .input-check');
        $temp2 = $('.box-table .list tbody tr');
        $this = $(this);
        if($this.is(':checked')){
            $temp1.each(function(){
                this.checked = true;
            });
            $temp2.addClass('selected');
        }
        else{
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });
    
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>