<?php

if(!isset($_REQUEST['data_id'])){
     $_REQUEST['data_id']=0;
 }
if(!isset($_REQUEST['game_id'])){
     $_REQUEST['game_id']=0;
 }
 if(!isset($_REQUEST['game_name'])){
     $_REQUEST['game_name']='';
 }
 if(!isset($_REQUEST['data_name'])){
     $_REQUEST['data_name']='';
 }
 
 if(!isset($_REQUEST['sign_name'])){
     $_REQUEST['sign_name']='';
 }
 if(!isset($_REQUEST['data_type'])){
     $_REQUEST['data_type']=0;
 }
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php echo $_REQUEST['game_name']; ?>-<?php echo $_REQUEST['data_name']; ?>-<?php echo $_REQUEST['sign_name']; ?>-得分历史</h1><?php if ($_REQUEST['game_id']>0) { ?><span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php if($_REQUEST['data_type']==665){ echo $this->createUrl('gameSignList/index_rank',array('game_id'=>$_REQUEST['game_id'],'game_name'=>$_REQUEST['game_name'],'data_id'=>$_REQUEST['data_id']));} else { echo $this->createUrl('gameTeamTable/index_rank',array('game_id'=>$_REQUEST['game_id'],'game_name'=>$_REQUEST['game_name'],'data_id'=>$_REQUEST['data_id']));}?>');"><i class="fa fa-reply"></i>返回</a></span><?php } ?></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <table class="list" >
                <thead>
                    <tr >
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'>轮次</th>
                        <th style='text-align: center;'>场次</th>
                        <th style='text-align: center;'>场次描述</th>
                        <th style='text-align: center;'>成绩</th>
         <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_votes_num');?></th>
        <th style='text-align: center;'>操作</th>
    </tr>
</thead>
        <tbody>

<?php 
$index = 1;
foreach($arclist as $v){ 
?>
<tr>
    <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
    <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
  <!--  <td style='text-align: center;'><?php /*echo $v->rounds; */?></td> -->
  <td><?php if($v->idr!=null) echo $v->idr->rounds; ?></td>
  <td><?php if($v->idr!=null) echo $v->idr->matches; ?></td>
  <td><?php if($v->idr!=null) echo $v->idr->describe; ?></td>
   <?php if($v->game_player_id==666)  { ?>
      <td style='text-align: center;'><?php echo $v->game_team_score;?></td>
       <?php } else{ ?>
       <td style='text-align: center;'><?php echo $v->game_score;?></td>
        <?php } ?>
    <td style='text-align: center;'><?php echo $v->game_votes_num; ?></td>
    <td>
<a class="btn" href="<?php echo $this->createUrl('gameListArrange/update', array('id'=>$v->arrange_id));?>" title="场次信息">场次信息</a>

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

</script>