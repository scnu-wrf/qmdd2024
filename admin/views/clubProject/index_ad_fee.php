<style>
    .box-table .list tr th,.box-table .list tr td{
        text-align: center;
    }
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
</style>
<div class="box">
    <!-- <div class="box-detail-tab">
        <ul class="c">
            <li class="current"><a href="<?php //echo $this->createUrl('clubProject/index_ad_fee'); ?>">服务机构入驻费列表</a></li>
            <li style="border-right:none;"><a href="<?php //echo $this->createUrl('qualificationsPerson/index_ad_fee'); ?>">服务者入驻费列表</a></li>
        </ul>
    </div>box-detail-tab end -->
    <div class="box-title c">
        <h4>
            <span>
                <a href="../../admin/index.php?act=main" class="lode_po" onclick="parent.location.reload();"><i class="fa fa-home"></i>当前界面：</a>会员费用管理->会员服务费用管理->
                <a class="lode_po" href="#">服务机构入驻费列表</a>
            </span>
        </h4>
        <span style="float:right;padding-right:15px;">
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="/*box-search*/">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入项目/单位/账号/缴费单号" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <thead>
                <table class="list">
                    <tr>
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th>缴费单号</th>
                        <th>账号</th>
                        <th>名称</th>
                        <th>项目</th>
                        <th>收费会员类型</th>
                        <th>服务费用类别</th>
                        <th>收费项目名称</th>
                        <th>应收金额</th>
                        <th>实收金额</th>
                        <th>通知时间</th>
                        <th>通知操作员</th>
                        <th>确认时间</th>
                        <th>确认操作员</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php echo $v->club_projectid->p_code; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->club_projectid->club_type_name; ?></td>
                            <td><?php echo $v->club_projectid->partnership_name; ?></td>
                            <td><?php if(!empty($v->club_projectid->cost_oper)){ echo '入驻费'; }else if(!empty($v->club_projectid->renew_oper)){ echo '续签费'; } ?></td>
                            <td><?php echo $v->club_projectid->cost_admission; ?></td>
                            <td><?php echo $v->club_projectid->cost_account; ?></td>
                            <td><?php echo $v->club_projectid->uDate; ?></td>
                            <td><?php echo $v->club_projectid->admin_gfname; ?></td>
                            <td><?php echo substr($v->f_userdate,0,10).'<br>'.substr($v->f_userdate,11); ?></td>
                            <td><?php echo $v->f_username; ?></td>
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
</script>