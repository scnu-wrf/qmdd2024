<style>.box-table .list tr th,.box-table .list tr td{ text-align: left; }</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城>退换货管理><a class="nav-a">审核未通过列表</a></h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    </div>
    <div class="box-content">
        <!--<div class="box-header" 
           <?php //if(@$_REQUEST['exam']==1){?>
            style="display:none;"
           <?php //}else{?>
          
           <?php //}?>    
        >
            
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
         <button id="exc_btn" class="btn btn-blue" type="button" onclick="javascript:excel();">导出</button>
            
 
                <span class="exam" onclick="on_exam();"><p>待审核：(<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span>)</p></span>
         
                    
        </div>-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" id="exam" name="exam" value="">
                <!-- <label style="margin-right:20px;width:22.5%;">
                    <span>审核状态：</span>
                    <?php //echo downList($ret_state,'f_id','F_NAME','ret_state'); ?>
                </label> -->
<!--                <label style="margin-right:20px;width:270px;">
                    <span>售后状态：</span>
                    <?php //echo downList($after_sale_state,'f_id','F_NAME','after_sale_state','id="after_sale_state"'); ?>
                </label>
                <label style="margin-right:20px;width:270px;">
                    <span>申请人账号：</span>
                    <input style="width:100px;" class="input-text" type="text" name="order_account" value="<?php //echo Yii::app()->request->getParam('order_account'); ?>" placeholder="请输入申请人账号">
                </label>-->
             
                <label style="margin-right:20px;width:270px;">
                    <span>操作时间：</span>
                    <input style="width:75px;" class="input-text" type="text" id="time_start" name="time_start" value="<?php echo Yii::app()->request->getParam('time_start'); ?>" placeholder="<?php echo date('Y-m-d');?>">
                    <span>-</span>
                    <input style="width:75px;" class="input-text" type="text" id="time_end" name="time_end" value="<?php echo Yii::app()->request->getParam('time_end'); ?>" placeholder="<?php echo date('Y-m-d');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:220px;margin-left: 24px;" class="input-text" type="text" id="order_num" name="order_num" value="<?php echo Yii::app()->request->getParam('order_num');?>" placeholder="售后单号/商品名称">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('return_order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('product_title');?></th>
                        <th><?php echo $model->getAttributeLabel('logistics_state');?></th>
                        <th><?php echo $model->getAttributeLabel('change_type');?></th>
                           
                        <!--<th><?php //echo $model->getAttributeLabel('order_account');?></th>
                        <th><?php //echo $model->getAttributeLabel('logistics_state');?></th>-->
                
                        <th><?php echo $model->getAttributeLabel('revi_state');?></th>    
                        <th>售后状态</th>                   
                        <th>操作时间</th>
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
        							if($v->orderdata_return->logistics_id==0){
										echo '未发货';
									}else{
										echo '已发货';
									}
                            ?>
                            </td>
                            <td><?php 
							
							/*if($v->good_sent==0  || $v->good_sent==472){
								echo '退款';
							}else{
								echo (!empty($v->change_type)) ? $v->change_base->F_NAME : '';
							}*/
		if($v->orderdata_return->logistics_id == 0){
			echo '退款';
		}else{
			echo (!empty($v->change_type)) ? $v->change_base->F_NAME : '';
		}
							
							
							
							 ?></td>
                            
                            
                             <!--<td><?php //if(!empty($v->order_num) && !empty($v->orderinfo))echo $v->orderinfo->order_gfaccount; ?></td>
                           <td>
                                <?php
                                    /*if(empty($v->good_sent)){
                                        echo (empty($v->orderdata_return->logistics_id)) ? '未发货' : '已发货';
                                    }else{
                                        echo $v->base_good_sent->F_NAME;
                                    }*/
                                ?>
                                </td>-->
                      
                            <td>
                            
							<?php 
							echo $v->orderdata->ret_state_name;		
							?>
                            </td>
                            <td>不予退换</td>
                            <td><?php echo substr($v->uDate,0,10).'<br>'; echo substr($v->uDate,11); ?></td>
                            <td><a class="btn" href="<?php echo $this->createUrl('update_exam', array('id'=>$v->id,'ret_state'=>$v->orderdata->ret_state,'from_page'=>'index_examine_nopass'));?>" title="编辑"><?php echo ($v->orderdata_return->ret_state==371 || $v->orderdata->ret_state==0) ? '审核' : '查看'; ?></a></td>
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