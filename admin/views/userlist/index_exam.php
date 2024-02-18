<?php
    if(!isset($_REQUEST['country'])){ $_REQUEST['country'] = ''; }
    if(!isset($_REQUEST['province'])){  $_REQUEST['province'] = ''; }
?>
</style>
<style>
</style>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>
                当前界面：会员 》实名管理 》实名认证审核 <?php // echo empty($_REQUEST['state']) ? '实名认证审核' : '实名认证审核 》待审核'; ?>
            </span>
            <script>var webstate = <?php echo $_REQUEST['state']; ?></script>
        </h1>
        <span style="float: right; padding-right: 15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top: 15px; border: 0px;">
            <ul class="c">
                <li id="waitting_for_exam" style="width:150px;"><a href="javascript:;" onclick="on_exam(1);">待审核：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></a></li>
                <li id="exam_list" style="width:150px;"><a href="javascript:;" onclick="on_exam(0);">审核记录</a></li>
            </ul>
        </div><!--box-detail-tab end-->

    <?php // if(empty($_REQUEST['state'])){ ?>
		<!-- <div class="box-header">
            <span class="exam" onclick="on_exam();"><p>待审核：<span style="color:red;font-weight: bold;"><?php // echo $count1; ?></span></p></span>
        </div> -->
	<?php // } ?>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
       
                <label style="margin-right:10px;">
                    <?php if(Yii::app()->request->getParam('state') == 0) { ?>
                    <span>审核日期：</span>
                    <input style="width:100px;" class="input-text" type="text" id="realname_time" name="realname_time" value="<?php echo $realname_time;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="realname_entertime" name="realname_entertime" value="<?php echo $realname_entertime;?>">
                    <?php }else{ ?>
                    <!-- <span>申请日期：</span> -->
                    <?php }?>
                 
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="账号/昵称/姓名">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
          
            </form>
        </div><!--box-search end-->
         <div class="box-table">
        <?php 
         $coumnName='GF_ACCOUNT,GF_NAME,ZSXM,real_sex_name,native,security_phone,id_card_type';
         $cmdstr='审核:update_exam';//,题目:PisaExamsData/index::题目';//操作的命令
         echo showGridData($this,$model,$arclist,'GF_ID',$coumnName,$cmdstr);
        ?>
        
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    $(function(){
        var $realname_time=$('#realname_time');
        var $realname_entertime=$('#realname_entertime');
        $realname_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        $realname_entertime.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });

    // 切换待审核与审核记录
    function on_exam(state){
        // var exam = $('.exam p span').text();
        // if(exam > 0){
        // if($('#state').val() == 0) {
        if(state == '1') {
            $('#state').val(1);
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('click_submit').click();
        }else {
            $('#state').val(0);
            document.getElementById('click_submit').click();
        }
    }
    // 页面加载完成时添加导航栏选中
    $(window).load(function() {
        if(webstate == 0) {
            document.getElementById('waitting_for_exam').className='';
            document.getElementById('exam_list').style.backgroundColor='#FDE9D9';
            document.getElementById('exam_list').className='current';
        }else if(webstate == 1) {
            document.getElementById('exam_list').className='';
            document.getElementById('waitting_for_exam').style.backgroundColor='#FDE9D9';
            document.getElementById('waitting_for_exam').className='current';
        }
    });

    onchangeCountry($('#country'));
    function onchangeCountry(obj){
        var obj = $('#country option:selected').attr('tvalue');
        var province = $('#province');
        var pr = '<?php echo $_REQUEST['province']; ?>';
        var s_html = '<option value>请选择</option>';
        if(obj!=''){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('province'); ?>&id='+obj,
                dataType: 'json',
                success: function(data){
                    if(data!=''){
                        for(var i=0;i<data.length;i++){
                            s_html += '<option value="'+data[i]['region_name_c']+'" '+((data[i]['region_name_c']==pr) ? 'selected>' : '>')+data[i]['region_name_c']+'</option>';
                        }
                        $('#province').css('display','inline-block');
                    }
                    province.html(s_html);
                }
            })
        }
        else{
            province.html(s_html);
        }
    }
</script>
