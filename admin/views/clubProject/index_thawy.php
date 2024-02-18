<div class="box" div style="font-size: 9px">
    <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: middle;float: right; margin-right: 10px;"><i class="fa fa-refresh"></i>刷新</a>
	<div class="box-title c"><h1>当前界面：项目》单位项目管理》项目冻结/解冻》解冻</h1></div>
    <div class="box-content">
        <div class="box-detail-tab mt15">
            <ul class="c">
                <li ><a href="<?=$this->createUrl('index_cold')?>">冻结</a></li>
                <li class="current">解冻</li>
            </ul>
        </div>
    	<div class="box-header">
            <a class="btn" onclick="remedy('check',0)">立即解冻</a>
            <a class="btn" onclick="remedy('check',1)">常规解冻</a>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        </div><!--box-header end -->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>账号状态：</span>
                    <?php echo downList($project_state,'f_id','F_NAME','project_state'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('p_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th>冻结项目</th>
                        <th><?php echo $model->getAttributeLabel('lock_reason');?></th>
                        <th>冻结状态</th>
                        <th><?php echo $model->getAttributeLabel('lock_date_start');?></th>
                        <th><?php echo $model->getAttributeLabel('lock_date_end');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1;foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->p_code; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->lock_reason; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo date('Y-m-d H:i:s',strtotime($v->lock_date_start));?></td>
                        <td><?php echo date('Y-m-d H:i:s',strtotime($v->lock_date_end));?></td>
                        <td>
                            <a class="btn" onclick="remedy(<?=$v->id?>,0)">立即解冻</a>
                            <a class="btn" onclick="remedy(<?=$v->id?>,1)">常规解冻</a>
                        </td>
                    </tr>
                <?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

var $start_date=$('#start_date');
var $end_date=$('#end_date');
$start_date.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
});
$end_date.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
});

 // 每页全选
 $('#j-checkall').on('click', function(){
    var $this = $(this);
    var $temp1 = $('.check-item .input-check');
    var $temp2 = $('.box-table .list tbody tr');
    if($this.is(':checked')){
        $temp1.each(function(){
            this.checked = true;
        });
        $temp2.addClass('selected');
    }else{
        $temp1.each(function(){
            this.checked = false;
        });
        $temp2.removeClass('selected');
    }
});

function remedy(a,b){
    var str='';
    if(a=='check'){
        $.each($('.check-item input:checkbox:checked'),function(){
            str+=$(this).val()+',';
        });
        if(str.length > 0){
            str = str.substring(0, str.lastIndexOf(','));
        }
    }else{
        str=a;
    }
    if(str==''){
        we.msg('minus', '请选中解冻数据');
        return false;
    }
    var can1 = function(){
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('remedy');?>&id='+str+'&way='+b,
			// data: '',
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
	$.fallr('show', {
        buttons: {
            button1: {text: '是', danger: true, onclick: can1},
            button2: {text: '否'}
        },
        content: '是否解冻？',
        icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
}

</script>