<?php
    check_request('game_id',0);
    check_request('data_id',0);
    check_request('back',0);
    check_request('Signup_date','');
    check_request('Signup_date_end','');
    $keywords2 = empty($_REQUEST['keywords2']) ? $keywords2 : $_REQUEST['keywords2'];
    $Signup_date = empty($_REQUEST['Signup_date']) ? $Signup_date : $_REQUEST['Signup_date'];
    $Signup_date_end = empty($_REQUEST['Signup_date_end']) ? $Signup_date_end : $_REQUEST['Signup_date_end'];
?>
<div class="box">
    <div style="position: fixed;margin-top: -165px;width: 99.4%;background-color: #f2f2f2;z-index: 99;">
        <div class="box-title c" style="width: 99%;position: fixed;background-color: #F2F2F2;z-index: 99;">
            <h1>当前界面：赛事/排名 》赛事报名 》报名费用明细</h1>
            <span style="float:right;">
                <?php if($_REQUEST['back']==1) {?>
                    <a class="btn" href="<?php echo $this->createUrl('game_money_statistics',array('Signup_date'=>$_REQUEST['Signup_date'],'Signup_date_end'=>$_REQUEST['Signup_date_end'],'keywords'=>$keywords2)); ?>">返回上一层</a>
                <?php  }?>
                <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
            </span>
        </div><!--box-title end-->
        <div class="box-detail-tab" style="position: fixed;width: 99.4%;top: 53px;z-index: 99;">
            <ul class="c">
                <li><a href="<?php echo $this->createUrl('game_money_statistics'); ?>">赛事费用统计</a></li>
                <li class="current"><a href="<?php echo Yii::app()->request->url; ?>">报名费用明细</a></li>
            </ul>
        </div>
        <div class="box-search" style="margin-top: 100px;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="Signup_date" value="<?php echo $Signup_date;?>">
                <input type="hidden" name="Signup_date_end" value="<?php echo $Signup_date_end;?>">
                <input type="hidden" name="keywords2" value="<?php echo $keywords2;?>">
                <label style="margin-right:10px;">
                    <span>选择赛事：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>竞赛项目：</span>
                    <select name="data_id" id="data_id">
                        <option value="">请选择</option>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>起止时间：</span>
                    <input style="width:120px;" type="text" class="input-text" id="star_time" name="star_time" value="<?php echo Yii::app()->request->getParam('star_time'); ?>">
                    <span>-</span>
                    <input style="width:120px;" type="text" class="input-text" id="end_time" name="end_time" value="<?php echo Yii::app()->request->getParam('end_time'); ?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:150px;" type="text" class="input-text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="赛事编号/赛事名称/发布单位">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
    </div>
    <div class="box-content" style="margin: 0px;">
        <div class="box-table" style="margin-top: 165px;">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('shopping_order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('service_game_id');?></th>
                        <th>赛事项目</th>
                        <th>报名人</th>
                        <th>赛事费用（元）</th>
                        <th>收费方式</th>
                        <th>实付金额（元）</th>
                        <th>支付方式</th>
                        <th>支付时间</th>
                        <th><?php echo $model->getAttributeLabel('supplier_id1');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
                            <td><?php echo $v->shopping_order_num; ?></td>
                            <td><?php echo $v->service_name; ?></td>
                            <td>
							<?php 
								$project=GameListData::model()->findAll('game_id=' . $v->service_id .' group by project_id');
								$tx='';
								if(count($project)>=2){
									$tx=$project[0]['project_name'].' '.$project[1]['project_name'].'...';
								} elseif (count($project)==1) {
									$tx=$project[0]['project_name'];
								} 
								echo $tx;
							?>
							</td>
                            <td><?php echo $v->gf_account.' ('.$v->gf_name.')'; ?></td>
                            <td><?php echo number_format($v->buy_price-$v->free_money,2); ?></td>
							<td></td>
                            <td><?php echo number_format($v->buy_price-$v->free_money,2); ?></td>
							<td></td>
							<td><?php echo $v->pay_confirm_time; ?></td>
                            <td><?php echo $v->supplier_name; ?></td>
                            <td>
								<a class="btn" href="<?php echo $this->createUrl('money_details',array('id'=>$v->id));?>" title="详情">详情</a>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    changeGameid($('#game_id'));
    function changeGameid(obj){
        var obj = $(obj).val();
        var s_html = '<option value>请选择</option>';
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['data_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    for(var i=0;i<data.length;i++){
                        s_html += '<option value="'+data[i]['id']+'" '+((data[i]['id']==pr) ? 'selected>' : '>')+data[i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                }
            });
        }
        else{
            $('#data_id').html(s_html);
        }
    }

    $(function(){
        var $star_time=$('#star_time');
        var $end_time=$('#end_time');
        $star_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });
</script>