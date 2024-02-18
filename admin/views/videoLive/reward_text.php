<style>
	::-webkit-scrollbar  
	{  
		width: 1px;  
		height: 1px;  
		background-color: #F5F5F5;  
	}  
	::-webkit-scrollbar-track  
	{  
		-moz-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-o-box-shadow:inset 0 0 6px rgba(0,0,0,0); 
		-ms-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		box-shadow: inset 0 0 6px rgba(0,0,0,0);  
		-moz-border-radius: 10px;  
		-webkit-border-radius: 10px;  
		-o-border-radius: 10px;  
		-ms-border-radius: 10px;  
		border-radius: 10px;  
		background-color: #F5F5F5;  
	}  
	::-webkit-scrollbar-thumb  
	{  
		-moz-border-radius: 10px;  
		-webkit-border-radius: 10px;  
		-o-border-radius: 10px;  
		-ms-border-radius: 10px;  
		border-radius: 10px;  
		-moz-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-o-box-shadow:inset 0 0 6px rgba(0,0,0,0); 
		-ms-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		box-shadow: inset 0 0 6px rgba(0,0,0,0);  
		background-color: #ccc;  
	}
</style>
<div id="scroll1" style="overflow-x: auto; overflow-y: auto; height: 88%;width:98%;margin-left: 1%;margin-top: 1%;">
    <table id="iframe_gridtable" class="gridtable" style="width: 100%;">
        <?php foreach ($rewardRecord as $v){?>
            <tr id="tr_<?php echo $v->id; ?>">
                <td style="width:15%;"><?php echo $v->s_gfaccount; ?></td>
                <td style="width:25%;"><?php if(!empty($v->live_reward_gf_name)){ echo $v->live_reward_gf_name;}else{ echo $v->live_reward_actor_name;} ?></td>
                <td style="width:15%;"><?php echo $v->live_reward_name?></td>
                <td style="width:15%;text-align:center;"><?php echo $v->live_reward_price?></td>
                <td style="width:30%;text-align:center;"><?php echo date("Y-m-d H:i",strtotime($v->s_time));?></td>
            </tr>
        <?php }?>
    </table>
</div>
<script>
    $(function(){
        // console.log(document.getElementById('scroll1').clientHeight);
        var rewardHeight = document.getElementById('iframe_gridtable').clientHeight;
        document.documentElement.scrollTop = rewardHeight;
        setInterval(function() {
        // setTimeout(function() {
            // window.location.reload(true);
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('top_comment',array('id'=>$t_id)); ?>',
                dataType: 'json',
                success: function(data){
                    var s_html = '';
                    // console.log(data);
                    for(var i=0;i<data.length;i++){
                        if($('#tr_'+data[i]['id']).length==0){
                            s_html += 
                                '<tr id="tr_'+data[i]['id']+'">'+
                                    '<td>'+data[i]['s_gfaccount']+'</td>'+
                                    '<td>'+data[i]['f_name']+'</td>'+
                                    '<td>'+data[i]['live_reward_name']+'</td>'+
                                    '<td>'+data[i]['live_reward_price']+'</td>'+
                                '</tr>';
                        }
                    }
                    // console.log(s_html);
                    if(s_html!=''){
                        $('#iframe_gridtable').append(s_html);
                        document.documentElement.scrollTop = rewardHeight;
                    }
                }
            });
        }, 5000);
    });
</script>