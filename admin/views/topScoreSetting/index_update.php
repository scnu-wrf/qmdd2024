<style>
    .box-search div{ display:inline-block; }
    #keywords{ margin-left: 12px; }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名》排名榜》排名等级设置</h1>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-detail">
    		<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    		<div class="box-detail-bd">
    			<div style="display:block;" class="box-detail-tab-item">
    				<table>
    					<tr>
    						<td width="15%">排名等级名称</td>
    						<td>
    							<?php echo $form->textField($model, 'F_ShowName', array('class' => 'input-text')); ?>
    							<?php echo $form->error($model, 'F_ShowName', $htmlOptions = array()); ?>
    						</td>
    					</tr>
    					<tr>
    						<td width="15%">相应赛事等级</td>
    						<td>
    							<?php echo $form->dropDownList($model, 'F_NAME', Chtml::listData(BaseCode::model()->getCode(158), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
    							<?php echo $form->error($model, 'F_NAME', $htmlOptions = array()); ?>
    						</td>
    					</tr>
    					<tr>
    						<td>操作</td>
    						<td>
    							<?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                                <button id="baocun" onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                                <button class="btn" type="button" onclick="we.back();">取消</button>
    						</td>
    					</tr>
    				</table>
    			</div><!--box-detail-tab-item end-->
    		</div><!--box-detail-bd end-->
    		<?php $this->endWidget();?>
    	</div><!--box-detail end-->
    </div><!--box-content end-->
</div><!--box end-->
