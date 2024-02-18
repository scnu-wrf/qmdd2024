<?php
    //include_once $qmdd_init_file;
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(!isset($_REQUEST['team_id'])){
        $_REQUEST['team_id']=0;
    }
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(!isset($_REQUEST['game_name'])){
        $_REQUEST['game_name']='';
    }
    if(!isset($_REQUEST['data_type'])){
        $_REQUEST['data_type']=0;
    }
    if(!isset($_GET['order_num'])){
        $_GET['order_num']='';
    }
   
    $qmdd_path=get_qmdd_path();
    $yii_path=get_yii_path();
     $basecode=BaseCode::model()->getPayway();
?>
<div class="box" style="margin-left:0;">
    <div class="box-content" style=" border:none;">
        <div class="box-title c">
            <h1><i class="fa fa-table"></i>- 赛事成员收费明细</h1>
            <span class="back">
                <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
                <a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/index');?>');"><i class="fa fa-reply"></i>返回赛事列表</a>
            </span>
        </div><!--box-title end-->
        <div class="box-search" <?php if($_REQUEST['game_id']<>0) { ?>style="margin-left:10px;"<?php } ?>>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="team_id" value="<?php echo Yii::app()->request->getParam('team_id');?>">
                <input type="hidden" name="order_num" value="<?php echo $_GET["order_num"];?>">
                <input type="hidden" name="data_id" value="<?php echo $_REQUEST["data_id"];?>">
                <input type="hidden" name="game_id" value="<?php echo $_REQUEST["game_id"];?>">
                <input type="hidden" name="game_name" value="<?php echo  $_REQUEST['game_name'];?>">
                <input type="hidden" name="data_type" value="<?php echo $_REQUEST["data_type"];?>">
                <!-- <label style="margin-right:20px;">
                    <span>审核状态：</span>
                    <select name="state">
                        <option value="">请选择</option>
                        <?php //foreach($state as $v){?>
                        <option value="<?php //echo $v->f_id;?>"<?php //if(Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php //}?>><?php //echo $v->F_NAME;?></option>
                        <?php //}?>
                    </select>
                </label> -->
                <!-- <label style="margin-right:20px;">
                    <span>支付状态：</span>
                    <select name="is_pay">
                        <option value="">请选择</option>
                        <?php //foreach($is_pay as $v){?>
                        <option value="<?php //echo $v->f_id;?>"<?php //if(Yii::app()->request->getParam('is_pay')==$v->f_id){?> selected<?php //}?>><?php //echo $v->F_NAME;?></option>
                        <?php //}?>
                    </select>
                </label> -->
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入GF帐号 / 姓名 / 竞赛项目" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox" disabled></th>
                        <th class="list-id">序号</th>
                        <th><?php echo $model->getAttributeLabel('sign_account');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_name');?></th>
                        <th><?php echo $model->getAttributeLabel('team_name');?></th>
                        <th><?php echo $model->getAttributeLabel('game_money');?></th>
                        <th><?php echo $model->getAttributeLabel('insurance');?></th>
                        <th><?php echo $model->getAttributeLabel('is_pay');?></th>
                        <?php foreach ($basecode as $p) { ?>
                            <th><?php echo $p->F_NAME;?></th>
                        <?php } ?>
                        <th>其他</th>
                        <th><?php echo $model->getAttributeLabel('games_desc');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $index = 1;
                    $order=0;
                    $total=0;
                    $insurance=0;
                    $coupon=0;
                    $other=0;
                    $arr = array();
                    $r=0;
                    foreach($basecode as $b){
                        $r=$b->f_id;
                        $arr[$r]= 0;
                    }
                    foreach($arclist as $v){ 
                    $total+=$v->game_money;
                    $insurance+=$v->insurance;
                ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td> 
                        <td><?php echo $v->sign_account; ?></td>
                        <td><?php echo $v->sign_name; ?></td>
                        <td><?php echo $v->team_name; ?></td>
                        <td><?php echo $v->game_money; ?></td>
                        <td><?php echo $v->insurance; ?></td>
                        <td><?php echo $v->pay_name; ?></td>
                        <?php foreach ($basecode as $p) { ?>
                            <td><?php if($v->is_pay==$p->f_id){ $arr[$p->f_id]=$arr[$p->f_id]+$v->game_money; echo $v->game_money; }?></td>
                        <?php } ?>
                        <?php if($v->is_pay<10000){?><td></td><?php } else { ?>
                            <td><?php $other=$other+$v->game_money; echo $v->game_money; ?></td>
                        <?php } ?>
                        <td><?php echo $v->games_desc; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'data_id'=>$_REQUEST['data_id']));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <?php if($v->is_pay==463) { if($v->agree_state!=374){?>
                                <a class="btn" href="javascript:;" onclick="we.cancelsvi('<?php echo $v->id;?>', cancelsvi);" title="取消服务"><i class="fa fa-trash-o"></i></a>
                            <?php }}?>
                        </td>
                    </tr>
                <?php $index++; } ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1">小计</span></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $insurance; ?></td>
                        <td><?php echo $coupon; ?></td>
                        <td><?php echo $total; ?></td>
                        <?php foreach ($basecode as $p) { ?>
                            <td><?php echo $arr[$p->f_id]; ?></td>
                        <?php } ?>
                        <td><?php echo $other; ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div><!--box-table end-->       
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--gamesign-lt end-->
</div><!--box end-->
<script>
    // var cancel = '<?php echo $this->createUrl('cancel', array('id'=>'ID'));?>';
    var cancelsvi = '<?php echo $this->createUrl('cancelsvi', array('id'=>'ID'));?>';
</script>