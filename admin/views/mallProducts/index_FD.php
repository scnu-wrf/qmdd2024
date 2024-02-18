
<div class="box">
    <div class="box-title c">
      <h1><i class="fa fa-table"></i>财务商品分类</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('mallProducts/index_FD',array('fd'=>1));?>">已分类列表</a>
            <a class="btn" href="<?php echo $this->createUrl('mallProducts/index_FD',array('fd'=>0));?>">待分类（<?php echo $num; ?>）</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a class="btn btn-blue" href="javascript:;" onclick="fnsubmit();">提交保存</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>状态：</span>
                    <select name="state">
                        <option value="">请选择</option>
                        <?php if(is_array($base_code)) foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入商品名称/商品货号/商品编号" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                    
                </label>
                <label style="margin-right:10px;">
                    <span>分类编码：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入商品分类编码" name="code" value="<?php echo Yii::app()->request->getParam('code');?>">  
                </label>
                
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        <form id="form1" action="<?php echo $this->createUrl('mallProducts/fd_code_save');?>" method="post">
        	<table class="list" id="code_list">
                	<tr class="table-title">
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('product_code');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('supplier_code');?></th>
                        <th style="text-align:center" width="20%"><?php echo $model->getAttributeLabel('name');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('type');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('json_attr');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('supplier_id');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('finance_code');?></th>
                        <th style="text-align:center">财务分类</th>
                    </tr>
                    <?php 
					$index = 1;
					 foreach($arclist as $v){ ?>
                    <tr>
                        <td><?php echo $v->product_code; ?></td>
                        <td><?php echo $v->supplier_code; ?></td>
                        <td><?php echo $v->name; ?></td>
                        <td>
                            <?php if(!empty($v->type)){ 
							$types = MallProductsTypeSname::model()->findAll('tn_code in('.$v->type.') order by tn_code');						
								foreach($types as $names){
									
									echo $names->sn_name.' ';
                                    } 	
								} ?>
                        </td>
                        <td><?php echo $v->json_attr; ?></td>
                        <td><?php if(!empty($v->club_list)) echo $v->club_list->club_name; ?></td>
                        <td><input type="text" class="input-text" data-id="<?php echo $v->id; ?>" oninput="codeOnchange(this)" onpropertychange="codeOnchange(this)" placeholder="请输入编号" name="fd_list[<?php echo $v->id; ?>][finance_code]" value="<?php echo $v->finance_code; ?>" onblur="fdOnchange(this)"></td>
                        <td class="classify_box">
                         <?php if(!empty($v->finance_type)){ 
                            $finance_types = MallProductsTypeSname::model()->findAll('tn_code in('.$v->finance_type.') order by tn_code');                      
                                foreach($finance_types as $f){
                                    
                                    echo $f->sn_name.' ';
                                    }   
                            } ?>
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
          </form>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>

function fnsubmit(){
	var arr=new Array();
    var i=0;
	var id=0;
	var fd_code='';
    $('#code_list').find('.input-text').each(function(){
		
		arr[i]={};
        id=$(this).attr('data-id');
		fd_code=$(this).val();
        arr[i]['id']=id;
		arr[i]['fd_code']=fd_code;
		i=i+1;
		
    });
	
	$.ajax({
		type: 'post',
		url: '<?php echo $this->createUrl('fd_code_save');?>',
		data: {arr:arr},
		dataType: 'json',
		success: function(data) {
			if(data.status==1){
				we.success(data.msg, data.redirect);
			}else{
				we.msg('minus', data.msg);
			}
		}
	});
	return false;
}
function fdOnchange(obj){
    var changval=$(obj).val();
    if (changval!='' && length<7) {
        $(obj).focus();
        we.msg('minus', '财务编码至少是7位，请按正确的格式输入');
    }

}



                        
//输入商品编码获取分类	  
function codeOnchange(obj){
  var changval=$(obj).val();
  var t_html=''; 
  //console.log(changval); 
  if (changval.length>=7) {
	  $.ajax({
		type: 'post',
		url: '<?php echo $this->createUrl('validate');?>&code='+changval,
		data: {code:changval},
		dataType: 'json',
		success: function(data) {
			if(data!=null){
				t_html=t_html+'<span class="label-box" id="classify_item_'+data.code1+'" data-id="'+data.code1+'">'+data.tname1+'</span>'+
				'<span class="label-box" id="classify_item_'+data.code2+'" data-id="'+data.code2+'">'+data.tname2+'</span>'+
				'<span class="label-box" id="classify_item_'+data.code3+'" data-id="'+data.code3+'">'+data.tname3+'</span>'+
				'<span class="label-box" id="classify_item_'+data.code4+'" data-id="'+data.code4+'">'+data.tname4+'</span>';
				$(obj).parent().parent().find('.classify_box').html(t_html);
				//fnUpdateClassify();
			}else{
				we.msg('minus', '编码有误，没有获取到分类');
			}
		}
	});

  }
}
</script>
