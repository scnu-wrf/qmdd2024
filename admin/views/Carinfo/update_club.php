

<div class="box">
    <div class="box-title c">
        <h1>当前界面：首页》费用中心》待支付订单》支付</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();">
                <i class="fa fa-reply"></i>返回
            </a>
        </span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr>
                	<td style="background:#efefef;width:10%;">订单状态：</td>  
                	<td colspan="3">待支付</td>  
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">订单概要</td>  
                </tr>
                <tr>
                    <td style="width:10%;"><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td style="width:40%;">
                        <?php echo $model->order_num; ?>
                    </td>
                    <td style="width:10%;"><?php echo $form->labelEx($model, 'order_type'); ?></td>
                    <td style="width:40%;">
                        <?php echo $model->ordertype->F_NAME; ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:10%;"><?php echo $form->labelEx($model, 'order_Date'); ?></td>
                    <td style="width:40%;">
                        <?php echo $model->order_Date; ?>
                    </td>
                    <td style="width:10%;">支付时间</td>
                    <td style="width:40%;">
                    </td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">订单详情</td>  
                </tr>
                <tr>
                    <td style="width:25%;"><?php echo $form->labelEx($model, 'product_title'); ?></td>
                    <td style="width:25%;"><?php echo $form->labelEx($model, 'json_attr'); ?></td>
                    <td style="width:25%;"><?php echo $form->labelEx($model, 'buy_count'); ?></td>
                    <td style="width:25%;"><?php echo $form->labelEx($model, 'money'); ?></td>
                </tr>
                <tr>
                    <td style="width:25%;"><?php echo $model->shopping_car->product_title; ?></td>
                    <td style="width:25%;"><?php echo $model->shopping_car->json_attr; ?></td>
                    <td style="width:25%;"><?php echo $model->shopping_car->buy_count; ?></td>
                    <td style="width:25%;"><?php echo $model->money; ?></td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">支付方式</td>  
                </tr>
                <tr>
                    <td>
                        <?php
                            $num=0;
                            $text='';
                            $text.='<span id="Carinfo_pay_type">';
                            foreach ($pay_set as $v) {
                                $type = explode(',',$v->order_type);
                                foreach ($type as $t) {
                                    if($v->order_type==""||$model->order_type==$t){
                                        $text.='<span class="check">';
                                        $text.='<input class="input-check" id="pay_type_'.$num.'" value="'.($v->id==2?12:($v->id==5?10:1)).'" type="radio" name="pay_type">';
                                        $text.='<label for="pay_type_'.$num.'">'.$v->pay_dispay_name.'</label>';
                                        $text.='</span>';
                                    }
                                }
                                $num++;
                            }
                            $text.='</span>';
                            echo $text;
                        ?>
                    </td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;background-color:transparent;">
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'order_money'); ?></td>
                    <td style="width:15%;"><?php echo $model->order_money; ?></td>
                </tr>
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'total_money'); ?></td>
                    <td style="width:15%;"><?php echo $model->total_money; ?></td>
                </tr>
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:15%;"></td>
                    <td style="width:15%;">
                        <input class="btn btn-blue" type="button" value="确认支付" id="go_pay">
                    </td>
                </tr>
            </table>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<!-- gw.gfinter.net -->
<!-- oss.gfinter.net -->
<?php 
    $action='https://gw.gf41.cn/?device_type=7&c=pay&a=io_pay';
    if($_SERVER['SERVER_NAME']=='wwwsportcn()'){
        $action='https://gw.gf41.cn/?device_type=7&c=pay&a=io_pay';
    }else if($_SERVER['SERVER_NAME']==wwwsportnet()){
        $action='https://gw.gf41.net/?device_type=7&c=pay&a=io_pay';
    }else if($_SERVER['SERVER_NAME']==wwwsportnet()){
        $action='https://gw.gfinter.net/?device_type=7&c=pay&a=io_pay';
    }else if($_SERVER['SERVER_NAME']=='oss.gfinter.net'){
        $action='https://oss.gfinter.net/gw/?device_type=7&c=pay&a=io_pay';
    }
?>
<form id="PayForm" action="<?php echo $action;?>" method="post" target="_blank" style="display:none">
	<input name="ordernum" type="hidden" id="ordernum" value="<?=$model->order_num?>"/>
	<input name="paytype" type="hidden" id="paytype" value=""/>
	<input name="fee" type="hidden" id="fee" value="<?=$model->total_money;?>"/>
	<input name="bean" type="hidden" id="bean" value="0" />
	<input name="key" type="hidden" id="key" value="<?=md5($model->order_num.'apply_for_pay'.$model->order_gfid) ?>"/>
	<input name="action" type="hidden" value="apply_for_pay"/>
</form>

<?php 
    $action2='https://www.gf41.cn/GF/alipay_trade_page_pay2s';
    if($_SERVER['SERVER_NAME']=='wwwsportcn()'){
        $action2='https://www.gf41.cn/GF/alipay_trade_page_pay2s';
    }else if($_SERVER['SERVER_NAME']==wwwsportnet()){
        $action2='https://www.gf41.net/GF/alipay_trade_page_pay2s';
    }else if($_SERVER['SERVER_NAME']==wwwsportnet()){
        $action2='https://www.gfinter.net/GF/alipay_trade_page_pay2s';
    }else if($_SERVER['SERVER_NAME']=='oss.gfinter.net'){
        $action2='https://www.gfinter.net/GF2/alipay_trade_page_pay2s';
    }
?>
<form id="aliPayForm" action="<?php echo $action2;?>" method="post" target="_blank" style="display:none">
	<input name="WIDout_trade_no" type="hidden" id="WIDout_trade_no" value="<?=$model->order_num?>"/>
	<input name="WIDsubject" type="hidden" id="WIDsubject" value="<?="GF平台-订单编号".$model->order_num?>"/>
	<input name="WIDtotal_amount" type="hidden" id="WIDtotal_amount" value="<?=$model->total_money?>"/>
	<input name="WIDbody" type="hidden" id="WIDbody" value=""/>
</form>

<?php
/*
* 实现AES加密
* $str : 要加密的字符串
* $keys : 加密密钥
* $iv : 加密向量
* $cipher_alg : 加密方式
*/
function ecaes($str,$keys="QMDD2qrcode&Base",$iv="cw1kzditcxJjb2ri",$cipher_alg=MCRYPT_RIJNDAEL_128){
    $encrypted_string = bin2hex(mcrypt_encrypt($cipher_alg, $keys, $str, MCRYPT_MODE_CBC,$iv));
//    return $encrypted_string;
    return $str;
}

    $aec='ordernum='.$model->order_num.'&paytype=12&bean=0&gfId='.$model->order_gfid.'&fee='.$model->total_money;
    
    $url="https://www.gf41.cn/GF/wx-ht-pays?Code=".strtoupper(ecaes($aec));
    if($_SERVER['SERVER_NAME']=='wwwsportcn()'){
        $url="https://www.gf41.cn/GF/wx-ht-pays?Code=".strtoupper(ecaes($aec));
    }else if($_SERVER['SERVER_NAME']==wwwsportnet()){
        $url="https://www.gf41.net/GF/wx-ht-pays?Code=".strtoupper(ecaes($aec));
    }else if($_SERVER['SERVER_NAME']==wwwsportnet()){
        $url="https://www.gfinter.net/GF/wx-ht-pays?Code=".strtoupper(ecaes($aec));
    }else if($_SERVER['SERVER_NAME']=='oss.gfinter.net'){
        $url="https://www.gfinter.net/GF2/wx-ht-pays?Code=".strtoupper(ecaes($aec));
    }
    // echo $url;
?>
<script>
    $(function(){
        $("#Carinfo_pay_type input[name='pay_type']").removeAttr("checked");
    })
    var payType='';
    $("#Carinfo_pay_type input[name='pay_type']").on("change",function(){
        payType=$(this).val();
        $("#paytype").val(payType);
    })

    $("#go_pay").on("click",function(){
        if(payType!=''){
            sessionStorage.setItem("orderNum",$("#ordernum").val());
            sessionStorage.setItem("orderType",357);
            if($("#paytype").attr("value")=="10"){//支付宝
                if(/(nokia|iphone|android|ipad|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220)/i.test(navigator.userAgent)){//移动端
                    $("#PayForm").submit();
                }else{
                    $("#aliPayForm").submit();
                }
            }else if($("#paytype").attr("value")=="1"){//银联
                $("#PayForm").submit();
            }else if($("#paytype").attr("value")=="12"){//微信
                WXPay();
            }
        }else{
            we.msg('minus', '温馨提示","请选择支付方式！');
        }
    })
    function WXPay(){
        var url = '<?php echo $url;?>';
        // window.location.href=url;
        window.open(url,'_top');
    }
</script>