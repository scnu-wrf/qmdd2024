<div class="box">
    <div class="box-title c">
        <h1>
            <?php 
                if($_REQUEST['index']==1){
                    echo '当前界面：培训/活动》课程结算》课程结算统计';
                }elseif($_REQUEST['index']==2){
                    echo '当前界面：财务 》课程结算统计';
                }
            ?>
        </h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="current" style="padding:0 10px;">课程结算统计</li>
                <li style="padding:0 10px;"><a href="<?php echo $this->createUrl('index_stat_data',array('club_id'=>get_session('club_id'),'index'=>$_REQUEST['index']));?>">日结算明细</a></li>
            </ul>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="index" value="<?php echo Yii::app()->request->getParam('index');?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:100px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label>
                    <span>课程标题：</span>
                    <input style="width:200px;" class="input-text" type="text" id="course_title" name="course_title" value="<?php echo Yii::app()->request->getParam('course_title');?>" placeholder="请输入课程标题">
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号/账号/发布单位">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('course_code');?></th>
                        <th><?php echo $model->getAttributeLabel('course_title');?></th>
                        <th>销售数量</th>
                        <th>实收总额（元）</th>
                        <th>结算总额（元）</th>
                        <th>平台毛利率（%）</th>
                        <th>平台结算总额（元）</th>
                        <th>单位毛利率（%）</th>
                        <th>单位结算总额（元）</th>
                        <?php if($_REQUEST['index']==2){ ?>
                            <th>结算单位名称</th>
                        <?php } ?>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $index = 1; foreach($arclist as $v){
                        $count=GfServiceData::model()->count('order_type=1537 and service_id='.$v->id.' and state=2 and pay_confirm=1');
                        $num=0;
                        $gf_money=0;
                        $club_money=0;
                        $signList = GfServiceData::model()->findAll('order_type=352 and service_id='.$v->id.' and pay_confirm=1');
                        foreach($signList as $b){
                            $num=$num+($b->buy_price-$b->free_money);
                            $gf_money=$gf_money+($b->gf_money);
                            $club_money=$club_money+($b->club_money);
                        }
                    ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->course_code; ?></td>
                            <td><?php echo $v->course_title; ?></td>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $num; ?></td>
                            <td><?php echo $num; ?></td>
                            <td><?php echo floatval($v->gf_gross).'%'; ?></td>
                            <td><?php echo $gf_money; ?></td>
                            <td><?php echo floatval($v->club_gross).'%'; ?></td>
                            <td><?php echo $club_money; ?></td>
                            <?php if($_REQUEST['index']==2){ ?>
                                <td><?php echo $v->course_club_name; ?></td>
                            <?php } ?>
                            <td>
                                <a class="btn" href="<?php echo $this->createUrl('index_stat_data',array('club_id'=>$v->course_club_id,'title'=>$v->id,'index'=>$_REQUEST['index']));?>" title="明细">明细</a>
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
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    var $start=$('#start');
    var $end=$('#end');
    $start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>