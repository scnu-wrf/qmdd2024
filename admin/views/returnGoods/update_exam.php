<?php 
    //echo @$_REQUEST['from_page'];
	
	$ct = $model->change_type;
	
	
	if(@$_REQUEST['ret_state']==371 || $_REQUEST['ret_state']==0){
		//$txt='';
		$txt2='退款/退换货审核》待审核》审核';
		
	} elseif(@$_REQUEST['ret_state']==373){
		//$txt='';
		$txt2='审核未通过列表》查看';
		
	}else{
		//$txt='邀';
		$txt2='退款/退换货审核》查看';
	}
?>
<style>#goods_num .return_produce td{text-align:center;}</style>
<div class="box">
    <div class="box-title c"><h1>当前界面：商城》退换货管理》<?php echo @$txt2;?></h1>
    <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        
 
           
     <?php $gf_user1_1 = GfUser1::model()->find('GF_ID='.$model->order_gfid); ?>      
            
    <table style="table-layout:auto; border-collapse: collapse; line-height:8px; clear:both;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr >
        <td colspan="4" style=" font-size:14px; font-weight:bold;">订单信息</td>
      </tr>
      <tr>
        <td width="8%" style=""><?php echo $form->labelEx($model,'gf_name');?>：</td>
        <td width="42%"><?php if(!empty($gf_user1_1))echo $gf_user1_1->GF_ACCOUNT; ?> (<?php echo $model->gf_name; ?>)</td>
        <td width="8%"><?php echo $form->labelEx($model,'logistics_state');?>：</td>
        <td width="42%">
		<?php 
		$txt='未获取到信息';
		if(!empty($model->orderdata_return)) $txt=($model->orderdata_return->logistics_id==0) ? '未发货' : '已发货';	
        echo $txt;
		?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form->labelEx($model,'return_order_num'); ?>：</td>
        <td><?php echo $model->return_order_num; ?></td>
        <td><?php echo $form->labelEx($model,'rec_name'); ?>：</td>
        <td><?php if(!empty($model->orderinfo->rec_name))echo $model->orderinfo->rec_name; ?></td>
      </tr>
      <tr>
        <td>商品编号:</td>
        <td><?php echo $model->orderdata->product_code;?></td>
        <td><?php echo $form->labelEx($model,'rec_phone'); ?>：</td>
        <td><?php if(!empty($model->orderinfo->rec_phone))echo $model->orderinfo->rec_phone; ?></td>
      </tr>
      <tr>
        <td>商品货号:</td>
        <td><?php echo $model->buy_orderdata->supplier_code; ?></td>
        <td>收货地址:</td>
        <td><?php if(!empty($model->orderinfo->rec_address))echo $model->orderinfo->rec_address; ?></td>
      </tr>
    </table>

            
            <!--<table style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="6">订单信息</td>
                </tr>
                <tr>
                    <td style="width:12%;"><?php //echo $form->labelEx($model,'return_order_num'); ?></td>
                    <td style="width:21.33%;"><?php //echo $model->return_order_num; ?></td>
                    <td style="width:12%;"><?php //echo $form->labelEx($model,'rec_name'); ?></td>
                    <td style="width:21.33%;"><?php //if(!empty($model->orderinfo->rec_name))echo $model->orderinfo->rec_name; ?></td>
                    <td style="width:12%;"><?php //echo $form->labelEx($model,'rec_phone'); ?></td>
                    <td style="width:21.33%;"><?php //if(!empty($model->orderinfo->rec_phone))echo $model->orderinfo->rec_phone; ?></td>
                </tr>
            </table>-->
            
    <table style="table-layout:auto; margin-bottom:10px;"  width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="table-title">
        <td width="23%">商品名称</td>
        <td width="10%">规格/型号</td>
        <td width="5%">数量</td>
        <td width="10%">商品单价(元)</td>
        <td width="10%">运费(件/元)</td>
        <td width="10%">商品小计(元)</td>
        <td width="14%">运费小计(元)</td>  
        <td width="13%">商品总额(元)&nbsp;(含运费)</td>
   
      </tr>
      <tr>
        <td><?php echo $model->buy_orderdata->product_title; ?></td>
        <td><?php echo $model->buy_orderdata->json_attr; ?></td>
        <td><?php echo $model->buy_orderdata->buy_count; ?></td>
        <td><?php echo $model->buy_orderdata->buy_price; ?></td>
        <td><?php echo $model->buy_orderdata->post; ?></td>
        <td><?php echo sprintf("%.2f",$model->buy_orderdata->buy_price*$model->buy_orderdata->buy_count); ?></td>    
        <td><?php echo sprintf("%.2f",$model->buy_orderdata->post*$model->buy_orderdata->buy_count);?></td>
        <td>
		<?php
		 //echo $model->orderdata->buy_price*$model->orderdata->ret_count+$model->orderdata->post*$model->orderdata->ret_count;
		 echo sprintf("%.2f",$model->buy_orderdata->buy_price*$model->buy_orderdata->buy_count+$model->buy_orderdata->post*$model->buy_orderdata->buy_count);
		?> 
        </td>
      </tr>
    </table>
     
            
            <!--<div class="mt15">
            <?php //if(!empty($model->buy_orderdata) && $ct==1138){ ?>
                <table>
                    <tr class="table-title">
                        <td colspan="8">购买商品信息</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">商品货号</td>
                        <td style="text-align:center;">商品编号</td>
                        <td style="text-align:center;">商品名称</td>
                        <td style="text-align:center;">型号/规格</td>
                        <td style="text-align:center;">销售价</td>
                        <td style="text-align:center;">体育豆</td>
                        <td style="text-align:center;">运费（单件）</td>
                        <td style="text-align:center;">数量</td>
                    </tr>
                    <tr class="return_produce">
                        <td><?php //echo $model->buy_orderdata->supplier_code; ?></td>
                        <td><?php //echo $model->buy_orderdata->product_code; ?></td>
                        <td><?php //echo $model->buy_orderdata->product_title; ?></td>
                        <td><?php //echo $model->buy_orderdata->json_attr; ?></td>
                        <td><?php //echo $model->buy_orderdata->buy_price; ?></td>
                        <td><?php //echo $model->buy_orderdata->buy_beans; ?></td>
                        <td><?php //echo $model->buy_orderdata->post; ?></td>
                        <td><?php //echo $model->buy_orderdata->buy_count; ?></td>
                    </tr>
                </table>
            <?php //} ?>
                <table>
                    <tr class="table-title">
                        <td colspan="8"><?php //echo (!empty($model->change_type)) ? $model->change_base->F_NAME : ''; ?>商品信息</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">商品货号</td>
                        <td style="text-align:center;">商品编号</td>
                        <td style="text-align:center;">商品名称</td>
                        <td style="text-align:center;">型号/规格</td>
                        <td style="text-align:center;">销售价</td>
                        <td style="text-align:center;">体育豆</td>
                        <td style="text-align:center;">运费（单件）</td>
                        <td style="text-align:center;">申请<?php //echo (!empty($model->change_type)) ? $model->change_base->F_NAME : ''; ?>数量</td>
                    </tr>
                    <?php //if(!empty($model->orderdata) && $ct==1137){ ?>
                    <tr class="return_produce">
                        <td><?php //echo $model->orderdata->supplier_code; ?></td>
                        <td><?php //echo $model->orderdata->product_code; ?></td>
                        <td><?php //echo $model->orderdata->product_title; ?></td>
                        <td><?php //echo $model->orderdata->json_attr; ?></td>
                        <td><?php //echo $model->orderdata->buy_price; ?></td>
                        <td><?php //echo $model->orderdata->buy_beans; ?></td>
                        <td><?php //echo $model->orderdata->post; ?></td>
                        <td><?php //echo $model->orderdata->buy_count; ?></td>
                    </tr>
                    <tr>
                        <td>退款金额<br>（销售价x退货数+运费)</td>
                        <td colspan="3"><?php //echo $model->orderdata->buy_price*$model->orderdata->ret_count+$model->orderdata->post*$model->orderdata->ret_count; ?></td>
                        <td><?php //echo $form->labelEx($model,'ret_money'); ?></td>
                        <td colspan="3"><?php //if($model->orderdata->ret_state==372){ echo $model->ret_money; }else{ echo $form->textField($model, 'ret_money', array('class' => 'input-text'));} ?>
                        <?php //echo $form->error($model, 'ret_money', $htmlOptions = array()); ?></td>
                    </tr>
                <?php //} elseif (!empty($model->orderdata) && $ct==1138 && !empty($model->product)) { ?>
                    <tr class="return_produce">
                        <td><?php //echo $model->product->supplier_code; ?></td>
                        <td><?php //echo $model->product->product_code; ?></td>
                        <td><?php //echo $model->ret_product_title; ?></td>
                        <td><?php //echo $model->ret_json_attr; ?></td>
                        <td><?php //echo $model->orderdata->buy_price; ?></td>
                        <td><?php //echo $model->orderdata->buy_beans; ?></td>
                        <td><?php //echo $model->orderdata->post; ?></td>
                        <td><?php //echo $model->orderdata->buy_count; ?></td>
                    </tr>
                <?php //} ?>
                    <?php
                        $state = 0;
                        if (!empty($model->orderdata)){
                            $state=$model->orderdata->ret_state;
                        }
                    ?>
            </div>-->




<table style="table-layout:auto;  border-collapse: collapse;line-height:8px;" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr >
    <td colspan="4" style="font-size:14px; font-weight:bold;">售后信息</td>

  </tr>
<tr>
        <td width="8%">售后类型：</td>
        <td width="42%">
        <input name="ReturnGoods[after_sale_type]" type="text" value="<?php echo $model->orderdata_return->logistics_id;?>" hidden=""  />
		<?php 
		
		if($model->orderdata_return->logistics_id == 0){
			echo '退款';
		}else{
			echo (!empty($model->change_type)) ? $model->change_base->F_NAME : '';
		}
		
		 ?></td>

        <td width="8%">申请时间：</td>
        <td width="42%"><?php echo $model->order_date; ?></td>
      </tr>
</table>






    <table style="table-layout:auto; margin-bottom:10px;"  width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr class="table-title">
        <td width="23%">售后单号</td>
        <td width="15%">商品名称</td>
        <td width="10%">退换数量</td>
        
        <?php if($model->orderdata_return->logistics_id == 0 || $model->change_base->F_NAME =='退货'){ ?>
        <?php }else{?>
        <td width="11%">换货规格</td>
        <?php } ?>
        
        
        
        <td width="14%">申请原因</td>
        <td width="14%">退换说明</td>
        <?php if($model->change_base->F_NAME =='换货'){ ?>
			
		<?php }else{ ?>
			  <td width="13%">退款金额(元)(不含运费)</td>
		<?php } ?>
      
        
      </tr>
      <tr>
        <td><?php echo $model->order_num; ?></td>
        <td><?php echo $model->buy_orderdata->product_title; ?></td>
        <td><?php echo $model->orderdata->ret_count; ?></td>
        
        <?php if($model->orderdata_return->logistics_id == 0 || $model->change_base->F_NAME =='退货'){ ?>
        <?php }else{?>
        <td><?php //echo $model->buy_orderdata->json_attr; ?><?php echo $model->ret_json_attr; ?></td>
        <?php } ?>
        
        
        <td><?php echo $model->return_reason; ?></td>
        <td><?php echo $model->reason; ?></td>
        

		
		<?php if($model->change_base->F_NAME =='换货'){ ?>
			
		<?php }else{ ?>
		 <td><?php echo sprintf("%.2f",$model->orderdata->buy_price*$model->orderdata->ret_count);?></td>
		<?php } ?>
		 

	
         
      </tr>
      <tr>
        <td >售后图片</td>
        <td colspan="6">
        
      <?php $base_path=BasePath::model()->getPath(204);$pic_prefix='';if($base_path!=null){ $pic_prefix=$base_path->F_CODENAME; }?>
      
      <?php $return_goods1 = ReturnGoods::model()->find('id='.$model->id); 
			$img_array = explode(',', $return_goods1->img);?>
     
        <?php foreach ($img_array as $v) { ?>
                              
			<?php if(empty($v)){ ?>
            <?php }else{ ?>
            <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $base_path->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $base_path->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px; ">&nbsp;
            <?php }  ?>     
            
        <?php } ?>                       
         </td>
      </tr>
    </table>

    <table style="table-layout:auto; margin-bottom:10px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="table-title">
        <td colspan="2">售后处理<?php echo $model->change_type;?></td>
      </tr>
      <tr>
        <td width="10%">商品状态</td>
        <td width="90%">       
		<?php if($model->orderdata_return->logistics_id == 0){ ?> 
		<input name="logistics_state" type="radio" value="473" />已发货
        <input name="logistics_state" type="radio" value="472" checked="checked" />未发货
		<?php }else{ ?> 
		<input name="logistics_state" type="radio" value="473" checked="checked"/>已发货
        <input name="logistics_state" type="radio" value="472"  />未发货
		<?php } ?>	      
       </td>
      </tr>
      <tr>
        <td>审核状态</td>
        <td>
        <?php 
		   $qmdd_menu_test = QmddMenuTest::model()->findAll('f_model="'.$this->model.'" and f_action="'.@$_REQUEST['from_page'].'"');
            $as = '';
            $nm = '';
            if(!empty($qmdd_menu_test))foreach($qmdd_menu_test as $qmt){
                $as .= $qmt->f_id.',';
                $nm .= $qmt->f_name.',';
            }
			

	$qmdd_role_new4 = QmddRoleNew::model()->find('f_rcode="D"');
	if(!empty($qmdd_role_new4)){
		$permission4 = explode(',',$qmdd_role_new4->f_opter);
	}
    //print_r($permission4);



	$qmdd_role_new3 = QmddRoleNew::model()->find('club_id='.get_session('club_id'));
    //echo $qmdd_role_new3->f_rcode;
	//echo '<br>';
	//echo $qmdd_role_new3->f_tcode;
	if(empty($qmdd_role_new3)){
		//echo'该单位未分配管理员';
	}else{
		//echo'该单位已分配管理员';
	}
	
	
	if(empty($qmdd_role_new3)){
		
	}else{
		
	   $qmdd_role_new = QmddRoleNew::model()->find('club_id='.get_session('club_id').' and f_rcode="'.$qmdd_role_new3->f_rcode.'"');          
		if(!empty($qmdd_role_new)){
			$ex = explode(',',$qmdd_role_new->f_opter);
		}
	//print_r($ex);
		
	}
				
		
	if(empty($qmdd_role_new3)){
		
	}else{
		    $qmdd_role_new2 = QmddRoleNew::model()->find('f_rcode="'.$qmdd_role_new3->f_tcode.'"');
            if(!empty($qmdd_role_new2)){
                $permission = explode(',',$qmdd_role_new2->f_opter);
            }
			//print_r($permission);
	}


	
   ?>
        
        
        
  <?php if(empty($qmdd_role_new3)){?>

            <?php if(!in_array('2842',$permission4) || !in_array('2848',$permission4)){?>
                      <?php echo '供应商审核权限已被关闭';?>
            <?php }else{?>
                         <input type="radio" name="ReturnGoods[ret_state]" value="372" id="ok1" onclick="aCheck1()" <?php if($model->orderdata->ret_state==372){echo 'checked="checked"';}?>/>审核通过
                         <input type="radio" name="ReturnGoods[ret_state]" value="373" id="ok2" onclick="bCheck2()" <?php if($model->orderdata->ret_state==373){echo 'checked="checked"';}?> />审核不通过
            <?php }?>
  <?php }elseif(!empty($qmdd_role_new3)){?>  
  
           <?php if(!in_array('2842',$permission4) || !in_array('2848',$permission4)){?>
                      <?php echo '供应商审核权限已被关闭';?>      
           <?php }elseif(in_array('2842',$ex) || in_array('2848',$ex)){?>
                                                       <input type="radio" name="ReturnGoods[ret_state]" value="372" id="ok1" onclick="aCheck1()" <?php if($model->orderdata->ret_state==372){echo 'checked="checked"';}?>/>审核通过
                                                       <input type="radio" name="ReturnGoods[ret_state]" value="373" id="ok2" onclick="bCheck2()" <?php if($model->orderdata->ret_state==373){echo 'checked="checked"';}?> />审核不通过
                                                
            <?php }else{?>
                       <?php echo '无审核权限';?>
            <?php }?> 
                        
           
  <?php }elseif(in_array('2842',$permission4) || in_array('2848',$permission4)){?>   
       
                         <input type="radio" name="ReturnGoods[ret_state]" value="372" id="ok1" onclick="aCheck1()" <?php if($model->orderdata->ret_state==372){echo 'checked="checked"';}?>/>审核通过
                         <input type="radio" name="ReturnGoods[ret_state]" value="373" id="ok2" onclick="bCheck2()" <?php if($model->orderdata->ret_state==373){echo 'checked="checked"';}?> />审核不通过

   <?php }elseif(!in_array('2842',$permission4) || !in_array('2848',$permission4)){?>       
         <?php echo '供应商审核权限已被关闭';?>

    <?php }elseif(in_array('2842',$ex) || in_array('2848',$ex)){?>
                         <input type="radio" name="ReturnGoods[ret_state]" value="372" id="ok1" onclick="aCheck1()" <?php if($model->orderdata->ret_state==372){echo 'checked="checked"';}?>/>审核通过
                         <input type="radio" name="ReturnGoods[ret_state]" value="373" id="ok2" onclick="bCheck2()" <?php if($model->orderdata->ret_state==373){echo 'checked="checked"';}?> />审核不通过

     <?php }else{?>
          <?php echo '无审核权限';?>
     <?php }?>
		  

            
        </td>
      </tr>
      <tr>
        <td>售后状态</td>
        <td>
        <?php 
/*		if($model->orderdata_return->logistics_id == 0 && $model->orderdata->ret_state==372){
			echo '待退款';
		}elseif($model->orderdata_return->logistics_id > 0 && $model->orderdata->ret_state==372){
			echo '待退货';
		}elseif($model->orderdata->ret_state==373){
		    echo '不予退换';
		}*/
		
	    ?>

    <select id="span1" name="ReturnGoods[after_sale_state]"
    <?php 
    if($model->orderdata->ret_state==373){
    echo 'style="display:none;"';
    }else{
    echo 'style="display:block;"';	
    }	
    ?> 
     onchange="gradeChange()">
      <option value="1151" >待退货</option>
      
      <?php if($model->change_base->F_NAME =='换货'){?>
      <?php }else{?>
      <option value="1153" <?php if($model->orderdata_return->logistics_id == 0){echo 'selected="selected"';}?> >待退款</option>
      <?php }?>
      
    </select>




    <div  id="span2"
    
    <?php 
    if($model->orderdata->ret_state==373){
    echo 'style="display:block;"';
    }else{
    echo 'style="display:none;"';	
    }	
    ?> 
     
    >不予退换</div>

<!--<select id="span2" style="display:none">
  <option value="">不予退换</option>
</select>-->
        </td>
      </tr>

      <tr  id="confirm_refund"  
      
			<?php 
            if($model->change_type==1138 || $model->change_type==1151  ){
            echo 'hidden=""';
            }else{
   
            }	
            ?> 
       >
      
        <td>确定退款金额</td>
        <td><?php 
		
		//echo $model->order_num;
		$order_record1 = OrderRecord::model()->find('order_num="'.$model->order_num.'" order by id DESC');
		//echo $order_record1->logistics_state;
		
		
		?>
   
     
<input type="text" name="refund_money" value="<?php echo $model->act_ret_money;?>"  id="select1" 
    <?php 
        if($model->change_type==1138 ||  $model->orderdata->ret_state==373){
        echo 'hidden=""';
        }else{
   
        }	
        ?> 
  />



        
        </td>
      </tr>
      <tr>
        <td>操作备注</td>
        <td><?php echo $form->textArea($model, 'desc', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'desc', $htmlOptions = array()); ?></td>
      </tr>
      
    </table>

<?php if($model->orderdata_return->logistics_id==0){?>
<?php }else{?>
<table width="100%" class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">退货地址设置<?php //if($state==371){?>&nbsp;&nbsp;<input id="address_select_btn" class="btn" type="button" value="选择地址"><?php //} ?></td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model,'return_club_name'); ?></td>
                    <td style="width:35%;"><?php echo ($state==371 || $state==372 || $state==373) ? $form->textField($model,'return_club_name',array('class'=>'input-text')) : $model->return_club_name; ?></td>
                    <td style="width:15%;"><?php echo $form->labelEx($model,'return_club_tel'); ?></td>
                    <td style="width:35%;">
                        <?php echo ($state==371 || $state==372 || $state==373) ? $form->textField($model,'return_club_tel',array('class'=>'input-text')) : $model->return_club_tel; ?>
                        <?php echo $form->error($model,'return_club_tel',$htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'return_club_address'); ?></td>
                    <td><?php echo ($state==371 || $state==372 || $state==373) ? $form->textField($model,'return_club_address',array('class'=>'input-text')) : $model->return_club_address; ?></td>
                    <td><?php echo $form->labelEx($model,'return_club_mail_code'); ?></td>
                    <td>
                        <?php echo ($state==371 || $state==372 || $state==373) ? $form->textField($model,'return_club_mail_code',array('class'=>'input-text')) : $model->return_club_mail_code; ?>
                        <?php echo $form->error($model,'return_club_mail_code',$htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
<?php }?>





<table class="mt15" id="t7" width="100%" style="table-layout:auto;">
            <tr class="table-title">
                <td colspan="4">操作信息</td>
            </tr>
            

            <tr>
                <td width="7%">可执行操作</td>
                <td colspan="3">
               
  <?php //echo get_session('lang_type');?>
   <?php if($model->orderdata->ret_state==371 || $model->orderdata->ret_state==0){?>
   
		<?php if(empty($qmdd_role_new3)){?>     
        
                  <?php if(!in_array('2839',$permission4) || !in_array('2845',$permission4)){?> 
                          <?php echo '供应商修改权限已被关闭';?>
                  <?php }else{?>
                          <?php  echo show_shenhe_box(array('baocun'=>'确定')); ?>
                          <button class="btn" type="button" onclick="we.back();">取消</button>  
                  <?php }?> 
					
  
                 
         <?php }elseif(!empty($qmdd_role_new3)){?>    
				  <?php if(!in_array('2839',$permission4) || !in_array('2845',$permission4)){?> 
                          <?php echo '供应商修改权限已被关闭';?>
                  <?php }elseif(in_array('2839',$permission4) || in_array('2845',$permission4)){?>
                          <?php  echo show_shenhe_box(array('baocun'=>'确定')); ?>
                          <button class="btn" type="button" onclick="we.back();">取消</button>                              
                  <?php }elseif(in_array('2839',$ex) || in_array('2845',$ex)){?>
                          <?php  echo show_shenhe_box(array('baocun'=>'确定')); ?>
                          <button class="btn" type="button" onclick="we.back();">取消</button>  
                  <?php }else{?>
                          无操作权限
                  <?php }?> 
                      
        <?php  }else{?>
                    无操作权限
        <?php  }?>    
                     
   <?php }elseif($model->orderdata->ret_state==372){?>
   
		<?php if(empty($qmdd_role_new3)){?>     
                
                          <?php if(!in_array('2839',$permission4) || !in_array('2845',$permission4)){?> 
                                  <?php echo '供应商修改权限已被关闭';?>
                          <?php }else{?>
                                  <?php  echo show_shenhe_box(array('baocun'=>'确定')); ?>
                                  <button class="btn" type="button" onclick="we.back();">取消</button>  
                          <?php }?> 
                            
          
                         
        <?php }elseif(!empty($qmdd_role_new3)){?>    
                          <?php if(!in_array('2839',$permission4) || !in_array('2845',$permission4)){?> 
                                  <?php echo '供应商修改权限已被关闭';?>
                          <?php }elseif( (in_array('2839',$permission4) || in_array('2845',$permission4)) && get_session('lang_type') ==0 ){?>
								  <?php  echo show_shenhe_box(array('baocun'=>'确定')); ?>
                                  <button class="btn" type="button" onclick="we.back();">取消</button> 
                          <?php }elseif(in_array('2839',$ex) || in_array('2845',$ex)){?>
                                  <?php  echo show_shenhe_box(array('baocun'=>'确定')); ?>
                                  <button class="btn" type="button" onclick="we.back();">取消</button>  
                          <?php }else{?>
                                  无操作权限
                          <?php }?> 
                      
        <?php  }else{?>
                    无操作权限
        <?php  }?>    
             
   <?php }elseif($model->orderdata->ret_state==373){?>
        
			<?php if(empty($qmdd_role_new3)){?>     
                    
                              <?php if(!in_array('2839',$permission4) || !in_array('2845',$permission4)){?> 
                                      <?php echo '供应商修改权限已被关闭';?>
                              <?php }else{?>
                                      <?php  echo show_shenhe_box(array('baocun'=>'确定')); ?>
                                      <button class="btn" type="button" onclick="we.back();">取消</button>  
                              <?php }?> 
                                
              
                             
            <?php }elseif(!empty($qmdd_role_new3)){?>    
                              <?php if(!in_array('2839',$permission4) || !in_array('2845',$permission4)){?> 
                                      <?php echo '供应商修改权限已被关闭';?>
                              <?php }elseif( (in_array('2839',$permission4) || in_array('2845',$permission4)) && get_session('lang_type') ==0 ){?>
									  <?php  echo show_shenhe_box(array('baocun'=>'确定')); ?>
                                      <button class="btn" type="button" onclick="we.back();">取消</button>         
                              <?php }elseif(in_array('2839',$ex) || in_array('2845',$ex)){?>
                                      <?php  echo show_shenhe_box(array('baocun'=>'确定')); ?>
                                      <button class="btn" type="button" onclick="we.back();">取消</button>  
                              <?php }else{?>
                                      无操作权限
                              <?php }?> 
                          
            <?php  }else{?>
                        无操作权限
            <?php  }?>    
           
   <?php }?>
                                
      
                </td>
                </tr>

              <tr>
                <td rowspan="2">操作记录</td>
                <td width="35%">操作人</td>
                <td width="28%">操作时间</td>
                <td width="30%">操作内容</td>
            </tr>                 
             <tr>
                <td width="35%"><?php
				 //echo $order_record1->operator_gfid;
				 $QmddAdministrators1 = QmddAdministrators::model()->find('id="'.$order_record1->operator_gfid.'"');
				 echo @$QmddAdministrators1->admin_gfnick;
				 ?>
                 </td>
                <td width="28%"><?php 
				
				if($model->orderdata->ret_state==0 || $model->orderdata->ret_state==371){
					echo '&nbsp;';
				}else{
					echo $model->uDate;
				}
				
				
				
				?></td>
                <td width="30%">
				<?php 
				if($model->orderdata->ret_state==373){
				  echo '审核不通过';
				}elseif($model->orderdata->ret_state==372){
				  echo '审核通过';
				}else{
				  //echo '待审核';
				}
				
				?> 
                <?php 
				if($model->orderdata->ret_state==373){
				  echo '/不予退换';
				}elseif($model->orderdata->ret_state==372){
				  if($model->orderdata_return->logistics_id == 0){
					  echo '/待退款';
				  }else{
					  echo '/待退货';
				  }
				}
				
				?>
                

                </td>
       
   
            </tr>
        </table>



            <!--<table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="6">售后信息</td>
                </tr>
                <tr>
                    <td style="width:12%;"><?php //echo $form->labelEx($model, 'order_num'); ?></td>
                    <td style="width:21.33%;"><?php //echo $model->order_num; ?></td>
                    <td style="width:12%;"><?php //echo $form->labelEx($model, 'order_gfid'); ?></td>
                    <td style="width:21.33%;"><?php //echo $model->gf_name; ?></td>
                    <td style="width:12%;"><?php //echo $form->labelEx($model, 'order_date'); ?></td>
                    <td style="width:21.33%;"><?php //echo $model->order_date; ?></td>
                </tr>
                <tr>
                    <td><?php //echo $form->labelEx($model, 'return_id'); ?></td>
                    <td><?php //echo $model->return_reason; ?></td>
                    <td><?php //echo $form->labelEx($model, 'reason'); ?></td>
                    <td colspan="3"><?php //echo $model->reason; ?></td>
                </tr>
                <tr>
                    <td><?php //echo $form->labelEx($model, 'img'); ?></td>
                    <td colspan="5">
                        <div class="upload_img fl" id="upload_pic_img">
                            <?php //if(!empty($img))foreach($img as $i) if($i) { $basepath = BasePath::model()->getPath(169); ?>
                                <a class="picbox" data-savepath="<?php //echo $i;?>" href="<?php //echo $basepath->F_WWWPATH.$i;?>" target="_blank">
                                    <img src="<?php //echo $basepath->F_WWWPATH.$i;?>" style="width:100px;height:100px;">
                                </a>
                            <?php //}?>
                        </div>
                    </td>
                </tr>
            </table>-->
            
            <?php //if($ct==1137 || $ct==1138) {?>
           <!-- <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">商品退回物流信息</td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php //echo $form->labelEx($model,'ret_logistics_name'); ?></td>
                    <td style="width:35%;"><?php //echo $model->ret_logistics_name; ?></td>
                    <td style="width:15%;"><?php // echo $form->labelEx($model,'ret_logistics'); ?></td>
                    <td style="width:35%;"><?php // echo $model->ret_logistics; ?></td>
                </tr>
            </table>-->
            <?php //}?>
        
        <!--<div class="mt15">
            <table style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">审核信息</td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php //echo $form->labelEx($model, 'after_sale_state'); ?></td>
                    <td style="width:;" colspan="3">
                        <?php
                             /*$whe = '';
                             if($ct==1137){
                                 $fid = '1150,1151,1153';
                             }
                             else if($ct==1138){
                                 $fid = '1150,1151,1287,1288';
                                 $whe = " order by FIND_IN_SET(`f_id`,'".$fid."')";
                             }
                             else{
                                 $fid = '1150,1151,1153,1287,1288';
                             }
                            $fid = '1150,1151,1153';
                            $whe = " order by FIND_IN_SET(`f_id`,'".$fid."')";
                            $disabled = '';
                            if($state==372){
                                $disabled = 'disabled';
                            }
                            $basecode = BaseCode::model()->getReturn($fid,$whe);
                            echo $form->dropDownList($model, 'after_sale_state',Chtml::listData($basecode,'f_id','F_NAME'),array('disabled'=>$disabled));*/
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php //echo $form->labelEx($model, 'desc'); ?></td>
                    <td colspan="3">
                        <?php //echo (!empty($model->order_data_id) && $model->orderdata->ret_state!=372) ? $form->textField($model, 'desc', array('class' => 'input-text')) : $model->desc; ?>
                        <?php //echo $form->error($model, 'desc', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td colspan="3">
                    	<?php //if($state!=372 && ($model->after_sale_state!=1154 || $model->after_sale_state!=1155)) echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过')); ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div>-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>

    $('.btn-blue').on('click',function(){
        var return_1 = $('.return_1');
        if(return_1.length>0){
            for(var i=0;i<return_1.length;i++){
                // var ret_count = $('#ret_count'+i).val();
                var ret_money = $('#ret_money'+i).val();
                var ret_state = $('#goods_num_'+i+'_ret_state').val();
                // if(ret_count==''){
                //     $('#ret_count'+i).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
                //     we.msg('minus','请填写实退数');
                //     return false;
                // }
                if(ret_money==''){
                    $('#ret_money'+i).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
                    we.msg('minus','请填写应退货金额');
                    return false;
                }
                else if(ret_state==''){
                    we.msg('minus','请选择审核操作');
                    return false;
                }
                else{
                    // $('#ret_count'+i).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
                    $('#ret_money'+i).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
                }
            }
        }
    });

    $('.input-text').blur(function(){
        $(this).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
    });
</script>
<script>
$('#address_select_btn').on('click', function(){
        var club_id = <?php echo get_session('club_id'); ?>;
        if (club_id=='') {
            we.msg('minus','抱歉，系统没有获取到供应商');
            return false;
        }
        $.dialog.data('address_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/clubaddress");?>&club_id='+club_id,{
            id:'dizhi',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'80%',
            height:'80%',
            close: function () {
                if($.dialog.data('address_id')>0){
                    $('#ReturnGoods_return_club_address').val($.dialog.data('address')).trigger('blur');
                    $('#ReturnGoods_return_club_name').val($.dialog.data('name')).trigger('blur');
                    $('#ReturnGoods_return_club_tel').val($.dialog.data('phone')).trigger('blur');
                    $('#ReturnGoods_return_club_mail_code').val($.dialog.data('zipcode')).trigger('blur');
                }
            }
        });
    });
	
	
function aCheck1(){
	
document.getElementById("span1").style.display="block";
document.getElementById("span2").style.display="none";
 
<?php //if($model->change_type==1138 || $model->change_type==1151 || ($model->change_type==1137 && $model->mall_sales_order_data1->logistics_id != 0) ){?> 
 
<?php if($model->change_type==1138 || $model->change_type==1151 ){?>

<?php }else{?>
$("#confirm_refund").show();
$("#select1").show();
<?php }?>


}
function bCheck2(){ 
document.getElementById("span1").style.display="none";  
document.getElementById("span2").style.display="block";
$("#confirm_refund").hide();
$("#select1").hide();
}

function gradeChange(){
          var vs = $('#span1 option:selected').val();
          //alert(vs);
          if(vs=="0"){
          	$("#select1").hide();
          }

		  else if(vs=="1151"){
			  
			 <?php if($model->change_base->F_NAME == '换货'){?>
			        $("#select1").hide();
					$("#confirm_refund").hide();
			 <?php }else{?>
			        $("#select1").show();
					$("#confirm_refund").show();
			 <?php }?>
			  
					

          }	
		  
		  else if(vs=="1153"){
          	$("#select1").show();
			$("#select2").hide();
			$("#confirm_refund").show();
          }
	  		  
	
}


</script>