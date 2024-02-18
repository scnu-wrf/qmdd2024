
<div class="box">
  <div class="box-title c">
    <h1></span><i class="fa fa-table"></i>当前界面：：会员 》会员管理 》<a href="index.php?r=gfUserLock/index">会员冻结/解冻</a> 》解冻操作</span></h1>
    <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span> </div>
  <div class="box-content"> 
    
    <div class="box-detail-tab mt15">
      <ul class="c">
          <li ><a href="<?=$this->createUrl('gfUserLock/index')?>">冻结</a></li>
          <li class="current">解冻</li>
      </ul>
    </div>
    <div class="box-header"> 
      <a class="btn" href="javascript:;" id="immediatelyThaw">立即解冻</a> <a class="btn" href="javascript:;" id="normalThaw">常规解冻</a> 
    </div>
    <!--box-header end-->
    <div class="box-search">
      <form action="<?php echo Yii::app()->request->url;?>" method="get">
        <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
        <label style="margin-right:10px;"> 
          <!--<span>关键字：</span>-->
          <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号/昵称">
        </label>
        <label style="margin-right:20px;"> <span>账号状态：</span>
          <select name="user_state">
            <option value="">请选择</option>
            <?php $base_code=BaseCode::model()->getReturn('1282,1283,507');?>
            <?php foreach($base_code as $v){?>
            <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('user_state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME; ?></option>
            <?php }?>
          </select>
        </label>
        <button class="btn btn-blue" type="submit">查询</button>
      </form>
    </div>
    <!--box-search end-->
    <div class="box-table">
      <table class="list">
        <thead>
          <tr>
            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
            <th >序号</th>
            <th ><?php echo $model->getAttributeLabel('GF_ACCOUNT');?></th>
            <th ><?php echo $model->getAttributeLabel('GF_NAME');?></th>
            <th ><?php echo $model->getAttributeLabel('user_state');?></th>
            <th ><?php echo $model->getAttributeLabel('lock_date_start');?></th>
            <th ><?php echo $model->getAttributeLabel('lock_date_end');?></th>
            <th >操作</th>
          </tr>
        </thead>
        <tbody>
          <?php $index = 1; foreach($arclist as $v){ ?>
          <tr>
            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->GF_ID); ?>"></td>
            <td ><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
            <td ><?php echo $v->GF_ACCOUNT; ?></td>
            <td ><?php echo $v->GF_NAME; ?></td>
            <td ><?php echo $v->user_state_name; ?></td>
            <td ><?php echo $v->lock_date_start; ?></td>
            <td ><?php echo $v->lock_date_end; ?></td>
            <td ><a onclick="clickToThaw(<?php echo $v->GF_ID;?>,0)" class="btn">立即解冻</a> <a onclick="clickToThaw(<?php echo $v->GF_ID;?>,1)" class="btn">常规解冻</a></td>
            <?php $index++; } ?>
          </tr>
        </tbody>
      </table>
    </div>
    <!--box-table end-->
    
    <div class="box-page c">
      <?php $this->page($pages);?>
    </div>
  </div>
  <!--box-content end--> 
</div>
<!--box end--> 
<script>

 // 每页全选
    $('#j-checkall').on('click', function(){
        var $this = $(this);
        var $temp1 = $('.check-item .input-check');
        var $temp2 = $('.box-table .list tbody tr');
        if($this.is(':checked')){
            $temp1.each(function(){
                this.checked = true;
            });
            $temp2.addClass('selected');
        }else{
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });


    function click_li() {
        window.location.href="<?php echo $this->createUrl('gfUserLock/index',array()); ?>";
    }

    function clickToThaw(GF_ID,thawMode) {
      var can1 = function(){
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('tothaw');?>',
			data: {GF_ID: GF_ID,thawMode: thawMode},
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
	
			$.fallr('show', {
            buttons: {
                button1: {text: '是', danger: true, onclick: can1},
                button2: {text: '否'}
            },
            content: '是否解冻？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
	
	}
	
	
	
	$("#batchThaw").on("click",function(){
		 var str="";
		 
		 $(".check-item .input-check:checked").each(function () {
				str+=$(this).attr('value')+',';
		 })
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }else{
            we.msg('minus','你未选中记录' );
			return false;
		}
		 clickToThaw(str);
			　　//console.log(str);
	})


	$("#immediatelyThaw").on("click",function(){
		 var str="";
		 var thawMode = 0;
		 
		 $(".check-item .input-check:checked").each(function () {
				str+=$(this).attr('value')+',';
		 })
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }else{
            we.msg('minus','你未选中记录' );
			return false;
		}
		 clickToThaw(str,thawMode);
			　　//console.log(str);
	})


	$("#normalThaw").on("click",function(){
		 var str="";
		 var thawMode = 1;
		 
		 $(".check-item .input-check:checked").each(function () {
				str+=$(this).attr('value')+',';
		 })
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }else{
            we.msg('minus','你未选中记录' );
			return false;
		}
		 clickToThaw(str,thawMode);
			　　//console.log(str);
	})




</script> 
