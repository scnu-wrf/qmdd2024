<div class="box">
    <div class="box-content">
        <div class="box-table">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list2()); ?>
            <table class="list">
                <thead>
                    <tr>
                        <th width="50%">积分</th>
                        <th width="50%">兑换体育豆</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
            <?php $gfCredit= GfCredit::model()->find('object=734 and beans_num>consume_beans_num and beans_date_start<"'.date('Y-m-d H:i:s').'" and beans_date_end>"'.date('Y-m-d H:i:s').'"'); ?>
                    <?php
			echo $form->hiddenField($model, 'object', array('class' => 'input-text','value'=>502)) ;
			echo $form->hiddenField($model, 'gf_id', array('class' => 'input-text','value'=>$_REQUEST['pid'])) ;
            echo $form->hiddenField($model, 'add_or_reduce', array('class' => 'input-text','value'=>2)) ;
			echo $form->hiddenField($model, 'item_code', array('class' => 'input-text','value'=>$gfCredit->id)) ;
			echo $form->hiddenField($model, 'state', array('class' => 'input-text','value'=>372)) ; ?>
            <?php $data['num']= ClubList::model()->find('id='.$_REQUEST['pid']);
			$credit = $data['num']['club_credit']; ?>
<script>
var credit_club = <?php echo $credit; ?>
</script>
                        <td>
                            <?php echo $form->hiddenField($model, 'credit'); ?>
                            <span id="credit"><?php echo $model->credit; ?></span>
                            <?php echo $form->error($model, 'credit', $htmlOptions = array()); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'beans_num', array('class' => 'input-text','oninput' =>'creditonBlur(this)','placeholder'=>'请输入体育豆')); ?>
                        </td>                       
                    </tr>
                    <tr>
                        <td>
                            <div style="line-height:30px;">当前可用积分 <span class="red"><?php echo $credit; ?></span>分</div>
                        </td>
                        <td>
                            <div style="line-height:30px;">积分与体育豆兑换比<span class="blue">例 <?php echo !empty($gfCredit)?$gfCredit->credit.':'.$gfCredit->beans:'0:0'?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="box-detail-submit"><button class="btn btn-blue" type="submit">兑换</button><!--button class="btn" type="button" onclick="window.close();">取消</button--></div>
        <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
<?php
 function get_form_list2($submit='=='){
    return array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    if(!hasError||(submitType=="'.$submit.'")){
                        we.overlay("show");
                        $.ajax({
                            type:"post",
                            url:form.attr("action"),
                            data:form.serialize()+"&submitType="+submitType,
                            dataType:"json",
                            success:function(d){
                                $.dialog.data("status", d.status);
                                if(d.status==1){
                                    we.success(d.msg, d.redirect);
                                    $.dialog.close();
                                }else{
                                    we.error(d.msg, d.redirect);
                                }
                            }
                        });
                    }else{
                        var html="";
                        var items = [];
                        for(item in data){
                            items.push(item);
                            html+="<p>"+data[item][0]+"</p>";
                        }
                        we.msg("minus", html);
                        var $item = $("#"+items[0]);
                        $item.focus();
                        $(window).scrollTop($item.offset().top-10);
                    }
                }',
            ),
        );
  }
?>
<script>
creditonBlur('#GfCreditHistory_beans_num');
var club_beans=0;
function creditonBlur(obj){
    club_beans=$(obj).val();
    // club_beans=club_beans==''?0:club_beans;
    var credit_num=Math.floor(club_beans*(<?= $gfCredit->credit;?>/<?= $gfCredit->beans;?>));
    if(credit_num>credit_club){	   
        we.msg('minus', '当前可用积分不足');
        $("#GfCreditHistory_beans_num").focus();
        club_beans=Math.floor($("#GfCreditHistory_credit").val()/(<?= $gfCredit->credit;?>/<?= $gfCredit->beans;?>));
        $("#GfCreditHistory_beans_num").val(club_beans).oninput();
        return false;
    }else{
        $("#GfCreditHistory_credit").val(credit_num);
        $("#credit").html(credit_num);
        $("#GfCreditHistory_beans_num").val(club_beans);
        return true;
    }
}
$(".box-detail-submit button").on("click",function(){
    if(club_beans<=0){
        we.msg('minus', '请输入可兑换体育豆');
        return false;
    }
})

</script>