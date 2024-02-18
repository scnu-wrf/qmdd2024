<div class="box">
    <div class="box-title c">
        <h1>当前界面：首页 》资产管理 》体育豆</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php 
        $data['num']= ClubList::model()->find('id='.get_session('club_id')); 
        $gfCredit= GfCredit::model()->find('object=734 and beans_num>consume_beans_num and beans_date_start<"'.date('Y-m-d H:i:s').'" and beans_date_end>"'.date('Y-m-d H:i:s').'"');
        ?>
        <div class="box-header">
            <span class="exam"><a style="color:#333;" href="<?php echo $this->createUrl('gfCreditHistory/index');?>">当前积分：<b class="red"><?php echo $data['num']['club_credit']; ?></b></a></span>
            <span class="exam"><a style="color:#333;" href="<?php echo $this->createUrl('index');?>">当前体育豆：<b class="red"><?php echo $data['num']['beans']; ?></b></a></span>
            <?php if(!empty($gfCredit)){?>
                <a class="btn" href="javascript:;" onclick="fnExchange();"><i class="fa fa-plus"></i>积分兑换体育豆</a>
            <?php }?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
				<label style="margin-right:20px;">
                    <span>兑换类型：</span>
                    <?php echo downList($object,'f_id','F_NAME','object'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入账号/名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>管理账号</th>
                        <th>名称</th>
                        <th>兑换类型</th>
                        <th>兑换内容</th>
                        <th>增加豆数</th>
                        <th>消耗豆数</th>
                        <th>剩余体育豆</th>
                        <th>日期</th>
                    </tr>
                </thead>
                <tbody>
<?php
$index = 1;
 foreach($arclist as $v){ ?>
                    <tr>
                        <td><span class="num num-1"><?php echo $index; ?></td>
                        <td><?php echo $v->got_beans_code;?></td>
                        <td><?php echo $v->got_beans_name;?></td>
                        <td><?php if(!is_null($v->baseCode))echo $v->baseCode->F_NAME; ?></td>
                        <td><?php echo $v->got_beans_reson_name;?></td>
                        <td><?php echo $v->got_beans_num; ?></td>
                        <td><?php echo $v->consume_beans_num; ?></td>
                        <td>
                            <?php if(!empty($v->gfuser)){
                                echo $v->gfuser->beans;
                            }elseif(!empty($v->clubname)){
                                echo $v->clubname->beans;
                            }?>
                        </td>
                        <td><?php echo $v->uDate;?></td>
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
</script>
<script>
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        var end_input=$dp.$('end_date')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
    });

    // 积分兑换
    var fnExchange=function(){
        $.dialog.open('<?php echo $this->createUrl('gfCreditHistory/exchange',array('pid' => get_session('club_id')));?>',{
            id:'jifen',
            lock:true,
            opacity:0.3,
            title:'积分兑换体育豆',
            width:'600px',
            height:'60%',
            close: function () {
                if($.dialog.data('status')==1){
                    window.location.reload(true);
                }
            }
        });
    };
</script>