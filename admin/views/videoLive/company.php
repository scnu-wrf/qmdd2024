<style>

.platform-body {


padding: 2px;

width: 100%;

height: 630px;

overflow:hidden;

box-sizing: content-box;

}
.main-box{
width: 79%;height: 100%;float: left;border:1px solid white;
}
.main-video-live{
 
  width: 100%;

  height: 90%;

  float:left;border:1px solid black;

  position: relative;

  box-sizing: border-box;


}

.main-video-box {

width: 70%;

height: 100%;

float:left;border:1px solid white;

position: relative;

box-sizing: border-box;

}


.main-video-right {

width: 29%;

height: 100%;

float:left;

border:1px solid white;

position: relative;

margin-left: 0.5%;
 
}


.video-right{

  width: 19%;

  height:100%;

  float:left;

  border:1px solid white;

  position: relative;

  overflow:hidden;

  overflow-y:auto;

  box-sizing: border-box;

}

.video-right-box {

width: 100%;

height: 50px;

position: relative;

overflow: hidden;

box-sizing: border-box;

border:1px solid black;
 
}

.main-video-setbox {

position: relative;

width: 100%;

height: 20%;

box-sizing: content-box;

}

.small-icon{

position: relative;

width: 25%;

box-sizing: content-box;

display: inline-block;

}
.small-title{

position: relative;

width: 70%;

box-sizing: content-box;

display: inline;

}

.div-set-on{
  float:left;
  border:1px solid black;
  border-radius:10px;
  background-color:#00FF7F;
  width: 50px;
  text-align: center;
  margin-left: 5px;
  cursor:pointer;
}

.div-set-close{
  float:left;
  border:1px solid black;
  border-radius:10px;
  background-color:red;
  width: 50px;
  text-align: center;
  margin-left: 5px;
  cursor:pointer;
}

.div-set{
  float:left;
  border:1px solid black;
  border-radius:10px;
  background-color:white;
  width: 50px;
  text-align: center;
  margin-right: 5px;
  cursor:pointer;
}

.setBox{
  overflow:hidden;
  margin-bottom:3px;
}
.span-set{
  float:left;border:1px solid white;
}

.record-box{
  height: 75%;width:100%;margin-top: 20px;
}

.set-record-box{
  height: 25%;width:100%;border: 1px solid ;
}

.reward-record-box{
  height: 74%;width:100%;border: 1px solid ;
}

.input-box{
  width: 100%;height:10%;float:left;border:1px solid black;position: relative;box-sizing: border-box;
}

.send-input{
  width:80%;height:50%;margin-top: 1.5%;margin-left:10px;border-radius:50px;padding-left:1.5%;padding-top:0.5%;font-size: 15px;
}

.send-button{
  margin-left: 1%;width:10%;height: 50%;border-radius:50px;
}
.span-button{
  float:right;border:1px solid black;margin-right: 1%;margin-top: 2%;width:3%;height: 40%;text-align: center;cursor:pointer;padding-top: 0.5%;border-radius:10px;
}
.gridtable {
width: 100%;

}
.gridtable th {
padding: 4px;
border-style: outset;
}

</style>

<div class="box-title c">
  <h1><i class="fa fa-table"></i>直播监控</h1>
  <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
</div><!--box-title end-->
<div class="platform-body">
  <?php $state=['关闭','打开',"直播",'录播'];  ?>
<div class="main-box">
  <div class="main-video-live">
     <div class="main-video-box">
          <img src="http://127.0.0.1/hsyii/uploads/image/rose.jpg" width="100%" height="100%">
    </div> 
    <div  class="main-video-right"> 
        <div class="main-video-setbox">
             <div class="setBox">
                <h3><?php echo $mainVideo->title;?></h3>
             </div>
              <div class="setBox">
                   <span class="span-set">
                     <?php echo $mainVideo->getAttributeLabel("is_online").": ";?> 
                   </span>
                    <div id="is_online" <?php if(!$mainVideo->is_online) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
                      <?php echo $state[$mainVideo->is_online];;?>
                    </div>
                 </div>
              <div  class="setBox">
                   <span class="span-set">
                     <?php echo $mainVideo->getAttributeLabel("is_reward").": ";?> 
                   </span>
                    <div id="is_reward" <?php if(!$mainVideo->is_reward) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
                      <?php echo $state[$mainVideo->is_reward];?>
                    </div>
                 </div>
                <div  class="setBox">
                     <span class="span-set">
                       <?php echo $mainVideo->getAttributeLabel("is_talk").": ";?> 
                     </span>
                     <div id="is_talk" <?php if(!$mainVideo->is_talk) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
                        <?php echo $state[$mainVideo->is_talk];;?>
                      </div>
                 </div>
                 <div class="setBox">
                     <span class="span-set">
                       <?php echo $mainVideo->getAttributeLabel("line_show").": ";?> 
                     </span>
                    <div id="line_show" <?php if($mainVideo->line_show) { ?>class="div-set" <?php }else{ ?>class="div-set-on"<?php }?>>
                        <?php echo $state[$mainVideo->line_show+2];;?>
                      </div>
                 </div>
          </div>
          <div class="record-box">
               <div class="reward-record-box">  
                  <div style="height: 10%; width:101%;margin-left:-0.5%;margin-top:-0.1%;">
                   <table class="gridtable">
                   <tr>
                    <th>打赏者</th>
                    <th>获打赏者</th>
                    <th><?php echo $message->getAttributeLabel("live_reward_name")?></th>
                    <th><?php echo $message->getAttributeLabel("live_reward_price")?></th>
                    </tr></table>
                  </div>
                    <div id="scroll1" style="overflow-x: auto; overflow-y: auto; height: 88%;width:98%;margin-left: 1%;margin-top: 1%;">
                   
                    <table class="gridtable">
                    <?php foreach ($rewardRecord as $v){?>
                      <tr>
                        <td><?php echo $v->s_gfid?></td>
                        <td><?php if(!empty($v->live_reward_gf_name)) echo $v->live_reward_gf_name;else echo $v->live_reward_actor_name;?></td>  
                        <td><?php echo $v->live_reward_name?></td>  
                        <td><?php echo $v->live_reward_price?></td>  
                      </tr>
                    <?php }?>
                 </table></div>
               </div>
               <div class="set-record-box">
                <span style="height: 5%"><h3>设置记录</h3></span>
                  <div id="scroll2" style="overflow-x: auto; overflow-y: auto; height:75%; width:98%;margin-left: 1%">
                 <table class="gridtable">
                    <?php foreach ($setRecord as $v){?>
                      <tr><td><?php echo base64_decode($v->m_message);?></td></tr>
                    <?php }?>
                 </table>
                  </div>
               </div>
          </div>
      </div>
  </div>
    <div class="input-box">
      <input type="text" class="send-input">
      <button class="send-button" onclick="sendMessage()">发送</button>
      <span class="span-button">常用</span>
    </div>
</div>
  <div class="video-right">
    <?php  foreach ($model as $k) { if($k->id==$mainVideo->id) continue; ?>
      <a id="<?php echo $k->id;?>" href="<?php echo $this->createUrl('platform', array('id'=>$k->id));?>">
       <div class="video-right-box" id='<?php echo $k->id;?>'>
            <div class="small-icon">
              <img src="http://127.0.0.1/hsyii/uploads/image/rose.jpg" width="100%" height="48px">
            </div>
            <div class="small-title">
              <h3 style="display:inline;"><?php echo $k->title;?></h3>
           </div>
      </div>
    </a>
    <?php }?> 
  </div>
</div>
<script>
   $(".setBox>div").on('click', function(){
      var attr=$(this).attr("id");
      var id=<?php echo $mainVideo->id;?>;
       if(attr=="line_show")
      {
          if($(this).attr("class")=="div-set")
          {
            $(this).attr("class","div-set-on").text("直播");
            update(id,attr,0);
          }
          else{
             $(this).attr("class","div-set").text("录播");;
            update(id,attr,1);
          }
          return;
      }
      if($(this).attr("class")=="div-set-close")
         {
          $(this).attr("class","div-set-on").text("打开");
          update(id,attr,1);
         } 
      else  {$(this).attr("class","div-set-close").text("关闭");update(id,attr,0);}
    });

   function update(id,attr,state)
   {
       $.ajax({
            type: "get",
            url:'<?php echo $this->createUrl("VideoLive/UpdateState");?>',
            data:{id:id,attr:attr,state:state},
            dataType:"json",
            error: function(request) {
                console.log(request);
                alert('设置失败');
            },
            success: function(data) {
                $('#scroll2>table').append('<tr><td>'+data.message+'</td></tr>');
                var setHeight = $("#scroll2")[0].scrollHeight;
                $("#scroll2").scrollTop(rewardHeight);
            }
         });
   }



   function sendMessage()
   {
      var arr1=[];
       arr1.push(<?php echo $mainVideo->id;?>);
        $('.video-right').find('a').each(function(){
            arr1.push($(this).attr('id'));
        });
      var id=we.implode(',',arr1);
      var message=$('.send-input').val();
      $.ajax({
          type:"get",
          url:'<?php echo $this->createUrl("VideoLive/sendMessage")?>',
          data:{message:message,target:id},
          dataType:"json",
          error:function(request){
              console.log(request);
                alert('有错误');
          },
           success: function(data) {
              $('.send-input').val("");
            }
        });
    
   }

    var rewardHeight = $("#scroll1")[0].scrollHeight;
     $("#scroll1").scrollTop(rewardHeight);
    var setHeight = $("#scroll2")[0].scrollHeight;
     $("#scroll2").scrollTop(rewardHeight);

</script>


