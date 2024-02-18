
   <div class="box">
    <div class="box-title c">
        <h1>当前界面：财务》订单管理》待支付列表》<a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr  class="table-title">
                    <td colspan="4">
                    订单信息
                    </td>  
                </tr>
                <tr>
                    <td>订单号</td>
                    <td><?php echo $arclist[0]->order_code; ?></td>
                    <td>订单说明</td>
                    <td><?php echo $arclist[0]->order_title; ?></td>
                </tr>
                <tr>
                    <td>商品类型</td>
                    <td><?php echo $arclist[0]->type; ?></td>
                    <td>订单类型</td>
                    <td><?php echo $arclist[0]->order_type; ?></td>
                </tr>
            </table>
            <br/>
            <table>
                <tr  class="table-title">
                    <td colspan="6">
                    购买者信息
                    </td>  
                </tr>
                <tr>
                    <td>购买者账号</td>
                    <td><?php echo $arclist[0]->add_code; ?></td>
                    <td>购买者姓名</td>
                    <td><?php echo $arclist[0]->add_name; ?></td>
                    <td>购买者电话</td>
                    <td><?php echo $arclist[0]->add_phone; ?></td>
                </tr>
            </table>
            <br/>
            <table>
                <tr  class="table-title">
                    <td colspan="8">
                    订单详情
                    </td>  
                </tr>
                <tr>
                    <!-- <td>序号</td> -->
                    <td>商品编号</td>
                    <td>商品运动项目</td>
                    <td>商品场地名称</td>
                    <td>日期</td>
                    <td>时间段</td>
                    <td>教练id</td>
                    <td>教练姓名</td>
                    <td>价格</td>
                </tr>
                <?php //$index=1;
                foreach($arclist as $v){?>
                <tr>
                    <!-- <td><?php //echo $index; ?></td> -->
                    <td><?php echo $v->product_id; ?></td>
                    <td><?php echo $v->product_project; ?></td>
                    <td><?php echo $v->product_place; ?></td>
                    <td><?php echo $v->product_date; ?></td>
                    <td><?php echo $v->product_time; ?></td>
                    <td><?php echo $v->product_coach_id; ?></td>
                    <td><?php echo $v->product_name; ?></td>
                    <td><?php echo $v->price; ?></td>
                 </tr>
                <?php //$index++;} ?>
            <?php } ?>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
