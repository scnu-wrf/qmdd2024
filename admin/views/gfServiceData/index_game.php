<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-home"></i>当前界面：赛事/活动/培训>赛事管理><a class="nav-a">赛事报名服务列表</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->   
    <div class="box-content">
        <div class="box-search" style="border:none; margin:0">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                        <span>赛事：</span>
                        <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                    </label>
                    <label style="margin-right:10px;">
                        <span>项目：</span>
                        <select name="data_id" id="data_id">
                            <option value="">请选择</option>
                        </select>
                    </label>
                  <label style="margin-right:10px;">
                      <span>关键字</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入服务名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                  </label>
                  <button onclick="submitType='find';" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check" style="text-align:center;">序号</th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('order_num');?></th> 
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('order_type');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('service_name');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('order_state');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('is_pay');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('service_data_name');?></th>                      
                        <th style="text-align:center; width:70px;"><?php echo $model->getAttributeLabel('add_time');?></th> 
                        <th style="text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                    $index = 1;
                     foreach($arclist as $v){ ?>
                    <tr>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td> 
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->order_type_name; ?></td>
                        <td><?php echo $v->service_name; ?></td>
                        <td><?php echo $v->order_state_name; ?></td>
                        <td><?php echo $v->is_pay_name; ?></td>
                        <td><?php echo $v->gf_name; ?></td>
                        <td><?php echo $v->service_data_name; ?></td>
                        <td><?php echo $v->add_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_game', array('id'=>$v->id));?>" title="详情"><i class="fa fa-edit"></i></a>

                        </td>
                        </td>
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
changeGameid($('#game_id'));
    function changeGameid(obj){
        var obj = $(obj).val();
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['data_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    var s_html = '<option value>请选择</option>';
                    for(var i=0;i<data.length;i++){
                        s_html += '<option value="'+data[i]['id']+'" '+((data[i]['id']==pr) ? 'selected>' : '>')+data[i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                }
            });
        }
    }
</script>