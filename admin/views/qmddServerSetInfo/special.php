
<div class="box">
  <div class="box-content">
    <div class="box-search">
      <form action="<?php echo Yii::app()->request->url;?>" method="get">
        <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
        <input type="hidden" name="id" value="<?php echo $_GET["id"];?>">
        <label style="margin-right:20px;">
          <span>选择日期：</span>
          <select id="sdate" name="sdate">
              <option value="">请选择</option>
          <?php for($j=0;$j<sizeof($datearr);$j++){
              $date=date("Y-m-d",$datearr[$j]);?>
              <option value="<?php echo $date; ?>"<?php if($sdate==$date){?> selected<?php }?>><?php echo $date;?></option>
          <?php }?>
          </select>
        </label>
        <button id="submit_button" class="btn btn-blue" type="submit" style="display: none;">查询</button>    
      </form>
    </div><!--box-search end-->
    <div class="box-table" style="overflow:auto;">
      <table class="list" style='table-layout:auto;white-space: nowrap;'>
        <tr class="table-title">
          <th width="15%">服务资源</th>
          <?php if(!empty($server_time)) foreach ($server_time as $t) { ?>
          <th width="80"><?php echo $t->start_time; ?><br><?php echo $t->end_time; ?></th>
          <?php }?>
        </tr>
        <tbody id="special_list">
<?php foreach($arclist as $v){ ?>
        <tr id="item_<?php echo $v->server_sourcer_id; ?>">
            <td><?php echo $v->s_name; ?></td>
            <input type="hidden" name="list_id" value="<?php echo $v->id; ?>">
            <input type="hidden" name="server_sourcer_id" value="<?php echo $v->server_sourcer_id; ?>">
        <?php if(!empty($server_time)) foreach ($server_time as $t) { ?>
        <?php $price='';
        $set_data=QmddServerSetData::model()->find('(info_id='.$id.' and list_id='.$v->id.' and s_date="'.$sdate.'" and s_timename="'.$t->timename.'") order by id DESC');
        if(!empty($set_data)) $price=$set_data->sale_price; ?>
            <td><input class="input-text" type="text" name="<?php echo $t->timename; ?>" value="<?php echo $price; ?>" style="width:40px;"></td>
        <?php }?>
        </tr>
<?php } ?>
        </tbody>
      </table>       
    </div><!--box-table end-->
    <!--a class="btn btn-blue" href="javascript:;" onclick="fnsubmit();">提交保存</a-->
  </div><!--box-content end-->
</div><!--box end-->
<?php $cnum=count($server_time); ?>
<script>
$('#sdate').on('change', function(){
  $('#submit_button').click();
});
$(function(){
  api = $.dialog.open.api;  //      art.dialog.open扩展方法
  if (!api) return;

  // 操作对话框
  api.button(
    {
      name:'保存',
      callback:function(){
          return fnsubmit();
      },
      focus:true
    },
    {
      name:'取消',
      callback:function(){
          return true;
      }
    }
  );
});

function fnsubmit(){
  var arr=new Array();
  var i=0;
  var sdate=$('#sdate').val();
  var id=<?php echo $id; ?>;
  //console.log(sdate);
  var cnum=<?php echo $cnum; ?>;
  if (sdate=='') {
    we.msg('minus','请先选择日期');
    return false;
  }
  $('#special_list').find('tr').each(function(){ 
    arr[i]={};
    var s_line=$(this).find('input');
    arr[i]['id']=s_line.eq(0).val();
    arr[i]['server_sourcer_id']=s_line.eq(1).val();
    for (var j=2; j <cnum+2; j++) {
      arr[i][s_line.eq(j).attr('name')]=s_line.eq(j).val();
    }
    i++;
  });
  we.loading('show');
  $.ajax({
    type: 'post',
    url: '<?php echo $this->createUrl('special_save');?>',
    data: {id:id,arr:arr,sdate:sdate},
    dataType: 'json',
    success: function(data) {
      if(data.status==1){
        we.loading('hide');
        we.success(data.msg, data.redirect);
      }else{
        we.loading('hide');
        we.msg('minus', data.msg);
      }
    }
  });
  return false;
}

</script>