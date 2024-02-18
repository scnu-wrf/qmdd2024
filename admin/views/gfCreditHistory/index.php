<div class="box">
    <div class="box-title c">
        <h1>当前界面：首页 》资产管理 》积分</h1>
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
            <span class="exam"><a style="color:#333;" href="<?php echo $this->createUrl('index');?>">当前积分：<b class="red"><?php echo $data['num']['club_credit']; ?></b></a></span>
            <span class="exam"><a style="color:#333;" href="<?php echo $this->createUrl('beansHistory/index');?>">当前体育豆：<b class="red"><?php echo $data['num']['beans']; ?></b></a></span>
            <?php if(!empty($gfCredit)){?>
                <a class="btn" href="javascript:;" onclick="fnExchange();"><i class="fa fa-plus"></i>积分兑换体育豆</a>
            <?php }?>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_start" name="time_start" value="<?php echo $time_start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_end" name="time_end" value="<?php echo $time_end; ?>">
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
                        <th>获得积分</th>
                        <th>兑换数量</th>
                        <th>消耗积分</th>
                        <th>剩余积分</th>
                        <th>日期</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->account;?></td>
                            <td><?php echo $v->nickname;?></td>
                            <td><?php if(!empty($v->gfCredit->baseCode->F_NAME))echo $v->gfCredit->baseCode->F_NAME; ?></td>
                            <td><?php echo $v->got_credit_reson;?></td>
                            <td><?php echo $v->add_or_reduce==1?$v->credit:''; ?></td>
                            <td><?php if(!is_null($v->beansHistory))echo $v->beansHistory->got_beans_num; ?></td>
                            <td><?php echo $v->add_or_reduce==2?$v->credit:''; ?></td>
                            <td>
                                <?php if($v->object==502){
                                    if(!is_null($v->clubname))echo $v->clubname->club_credit;
                                }else{
                                    if(!is_null($v->gfuser))echo $v->gfuser->CREDIT;
                                } ?>
                            </td>
                            <td><?php echo $v->exchange_time;?></td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->        
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var $start_time=$('#time_start');
    var $end_time=$('#time_end');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

// 积分兑换
var fnExchange=function(){
    $.dialog.open('<?php echo $this->createUrl('exchange',array('pid' => get_session('club_id')));?>',{
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