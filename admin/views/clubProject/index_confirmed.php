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
            <li class="current"><a href="<?php //echo $this->createUrl('clubProject/index_confirmed'); ?>">服务机构入驻实收费用列表</a></li>
            <li><a href="<?php //echo $this->createUrl('qualificationsPerson/index_confirmed'); ?>">服务者入驻实收费用列表</a></li>
            <li><a href="#">龙虎会员注册实收费用列表</a></li>
            <li style="border-right:none;"><a href="<?php //echo $this->createUrl('clubProject/index_strat_confirmed'); ?>">战略伙伴会员注册实收费用列表</a></li>
        </ul>
    </div>box-detail-tab end -->
    <div class="box-title c">
        <h4><span><a href="../../admin/index.php?act=main" class="lode_po" onclick="parent.location.reload();"><i class="fa fa-home"></i>当前界面：</a>会员费用管理->会员服务实收费用管理-><a class="nav-a" href="#">服务机构入驻实收费用列表</a></span></h4>
        <!-- <span style="float:right;"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span> -->
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked');">确认</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
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
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('p_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('club_type');?></th>
                        <th>应收金额</th>
                        <th><?php echo $model->getAttributeLabel('cost_account');?></th>
                        <th>收费项目名称</th>
                        <th>确认状态</th>
                        <th>通知时间</th>
                        <th>操作</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" <?php if($v->free_state_Id==1201){echo $checked;}else{echo 'disabled="disabled"';} ?> value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->p_code; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php if(!empty($v->club_type))echo $v->base_club_type->F_NAME; ?></td>
                            <td><?php if(!empty($v->partnership_type))echo $v->base_partnership_type->F_NAME; ?></td>
                            <td><?php echo $v->cost_admission; ?></td>
                            <td><?php echo $v->cost_account; ?></td>
                            <td><?php echo $v->free_state_name; ?></td>
                            <td><?php echo $v->uDate; ?></td>
                            <td>
                                <a class="btn btn-blue" href="javascript:;" onclick="confirmed(<?php echo $v->id; ?>)">确认</a>
                                <?php
                                    //if(empty($v->mall_order_num)){echo '<a class="btn btn-blue" href="javascript:;" onclick="confirmed('.$v->id.')">确认</a>&nbsp;';}
                                ?>
                            </td>
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

    // 获取所有选中多选框的值
    checkval = function(op,num){
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请先选中要确认的数据');
            return false;
        }
        confirmed(str);
    };

    // 确认操作
    function confirmed(id){
        we.loading('show');
        $.ajax({
            type:'post',
            url:'<?php echo $this->createUrl('confirmed'); ?>&id='+id,
            // data:{id:id},
            dataType:'json',
            success: function(data){
                we.loading('hide');
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>
