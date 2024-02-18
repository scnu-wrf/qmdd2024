<?php 
if(@$_REQUEST['exam']==1 || @$_REQUEST['good_sent']){
    //$txt='';
	$txt2='》待审核';
	
} else{
    //$txt='邀';
	//$txt2='》详情';
}
?>
<style>.box-table .list tr th,.box-table .list tr td{ text-align:left; }</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》退换货管理》退款/退换货审核<?php echo @$txt2;?></h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    </div>
    <div class="box-content">
        <div class="box-header" 
           <?php if(@$_REQUEST['exam']==1 || @$_REQUEST['good_sent']){?>
            style="display:none;"     
           <?php }else{?>
          
           <?php }?>    
        >
            
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            <!--<button id="exc_btn" class="btn btn-blue" type="button" onclick="javascript:excel();">导出</button>-->
            
 
                <span class="exam" onclick="on_exam();"><p>待审核：(<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span>)</p></span>
         
                    
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <?php if(@$_REQUEST['exam']==1){?>
                <input type="hidden" id="exam" name="exam" value="1">
                <?php }else{?>
                <input type="hidden" id="exam" name="exam" value="">
                <?php }?>
                
                
                <!-- <label style="margin-right:20px;width:22.5%;">
                    <span>审核状态：</span>
                    <?php //echo downList($ret_state,'f_id','F_NAME','ret_state'); ?>
                </label> -->
                
               <?php if(@$_REQUEST['exam']==1){ ?>
                  <label style="margin-right:20px;width:280px;">
                    <span>申请时间：</span>
                    <input style="width:75px;" class="input-text" type="text" id="time_start" name="time_start" value="<?php echo Yii::app()->request->getParam('time_start');?>" >
                    <span>-</span>
                    <input style="width:75px;" class="input-text" type="text" id="time_end" name="time_end" value="<?php echo Yii::app()->request->getParam('time_end'); ?>">
                </label>
               <?php }else{ ?>
                               <label style="margin-right:20px;width:280px;">
                    <span>申请时间：</span>
                    <input style="width:75px;" class="input-text" type="text" id="time_start" name="time_start" value="<?php echo Yii::app()->request->getParam('time_start');?>" placeholder="<?php echo date('Y-m-d');?>">
                    <span>-</span>
                    <input style="width:75px;" class="input-text" type="text" id="time_end" name="time_end" value="<?php echo Yii::app()->request->getParam('time_end'); ?>" placeholder="<?php echo date('Y-m-d');?>">
                </label>
               <?php } ?>
                

                
                
                  <label style="margin-right:20px;width:150px;">
                    <span>售后类型：</span>
                    <select name="change_type" id="change_type">
                        <option value="">请选择</option>
                        <?php if(@$_REQUEST['change_type']==1137){?>
                        <option value="1137" selected="selected">退货</option>
                        <?php }else{?>
                        <option value="1137">退货</option>
                        <?php }?>
                        
                        
                        <?php if(@$_REQUEST['change_type']==1138){?>
                        <option value="1138" selected="selected">换货</option>
                        <?php }else{?>
                        <option value="1138">换货</option>
                        <?php }?>
                        
                        
                        <?php if(@$_REQUEST['change_type']==941){?>
                        <option value="941" selected="selected">退款</option>
                        <?php }else{?>
                        <option value="941">退款</option>
                        <?php }?>
                    </select>
                </label>
                
              <?php if(@$_REQUEST['exam']==1 || @$_REQUEST['good_sent']){?>
                <label style="margin-right:20px;width:150px;">
                    <span>商品状态：</span>
                    <select name="good_sent" id="good_sent">
                        <option value="">请选择</option>
                        
                        
                        <?php if(@$_REQUEST['good_sent']==473){?>
                        <option value="473" selected="selected">已发货</option>
                        <?php }else{?>
                        <option value="473">已发货</option>
                        <?php }?>
                        
                        
                         <?php if(@$_REQUEST['good_sent']==472){?>
                        <option value="472" selected="selected">未发货</option>
                        <?php }else{?>
                        <option value="472">未发货</option>
                        <?php }?>
                    </select>
                </label>
              <?php }else{?>
                <label style="margin-right:20px;width:150px;">
                    <span>售后状态：</span>
                    <?php echo downList($after_sale_state,'f_id','F_NAME','after_sale_state','id="after_sale_state"'); ?>
                </label>
              <?php }?>

                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:220px;margin-left: 24px;" class="input-text" type="text" id="order_num" name="order_num" value="<?php echo Yii::app()->request->getParam('order_num');?>" placeholder="售后单号/商品名称">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list" >
                <thead>
                    <tr >
                        <th style="text-align:center;">序号</th>
                        <th ><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('return_order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('product_title');?></th>
                        <th><?php echo $model->getAttributeLabel('logistics_state');?></th>
                        <th><?php echo $model->getAttributeLabel('change_type');?></th>
                        <th><?php echo $model->getAttributeLabel('buy_count');?></th>   
                        <!--<th><?php //echo $model->getAttributeLabel('order_account');?></th>
                        <th><?php //echo $model->getAttributeLabel('logistics_state');?></th>-->
                        <th>退款金额(元)(不含运费)</th>
                        <th><?php echo $model->getAttributeLabel('revi_state');?></th>  
						<?php if(@$_REQUEST['exam']==0){?>   
                        <th>售后状态</th> 
                        <?php }?>                
                        <th><?php echo $model->getAttributeLabel('order_date');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php echo $v->return_order_num; ?></td>
                            <td><?php if(!empty($v->order_data_id))echo $v->orderdata->product_title; ?></td>
                            <td>
                        <?php 
                        $txt1='';
                        if(!empty($v->orderdata_return)) $txt1=($v->orderdata_return->logistics_id==0) ? '未发货' : '已发货';  
                        echo $txt1;
                        ?>
                            </td>
                            <td>
                        <?php $changetype=(!empty($v->change_base)) ? $v->change_base->F_NAME : '';	
                        $txt2='';
                        if(!empty($v->orderdata_return)) $txt2=($v->orderdata_return->logistics_id==0) ? '退款' : $changetype;  
                        echo $txt2;
                        ?>				
							</td>
                            <td><?php if(!empty($v->order_data_id))echo $v->orderdata->ret_count; ?></td>
                            <td>
                            <?php if($v->change_type==1137) 
                            echo sprintf("%.2f",$v->orderdata->buy_price*$v->orderdata->ret_count);?>
                            </td>
                            <td><?php 				
						    echo $v->orderdata->ret_state_name;
							?></td>
                        <?php if(@$_REQUEST['exam']==0){?>
                        <?php 
                            $txt3='';
                            if(!empty($v->orderdata_return)) $tx3t=($v->orderdata_return->logistics_id==0) ? '待退款' : '待退货';  
                            echo $txt3;?>
                             <td>
                              <?php echo $txt3; ?>
                            </td>
                        <?php } ?>
                            <td><?php echo substr($v->order_date,0,10).'<br>'; echo substr($v->order_date,11); ?></td>
                            <td><a class="btn" href="<?php echo $this->createUrl('update_exam', array('id'=>$v->id,'ret_state'=>$v->orderdata->ret_state,'from_page'=>'index_after_sale'));?>" title="编辑"><?php echo ($v->orderdata->ret_state==371 || $v->orderdata->ret_state==0) ? '审核' : '查看'; ?></a></td>
                        </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

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

    function on_exam(){
        $('#exam').val(1);
        $('#after_sale_state').html('<option>请选择</option>');
        $('.input-text').val('');
        document.getElementById('submit_button').click();
    }
</script>