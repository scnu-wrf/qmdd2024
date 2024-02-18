<div class="box">
    <div class="box-title c">
        <h1> <span>当前界面：首页》管理机构》添加机构</span> </h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    </div>
    <!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加', $this->createUrl('create'), '添加'); ?>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div>


        <div class="box-table">
            <table class="list" style="text-align:left;">
                <thead>
                    <tr>
                        <th width="20" class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th width="49">序号</th>
                        <th width="137"><?php echo $model->getAttributeLabel('club_code'); ?></th>
                        <th width="140"><?php echo $model->getAttributeLabel('company'); ?></th>
                        <th width="129">机构类型</th>
                        <th width="81"><?php echo $model->getAttributeLabel('apply_name'); ?></th>
                        <th width="103"><?php echo $model->getAttributeLabel('contact_phone'); ?></th>
                        <th width="103">开通项目</th>
                        <th width="103">项目名称</th>

                        <th width="172"><?php echo $model->getAttributeLabel('apply_time'); ?></th>
                        <th width="172">状态</th>
                        <th width="146">操作</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $index = 1;foreach ($arclist as $v){?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->club_code; ?></td>
                            <td><?php echo $v->company; ?></td>
                            <td><?php if (!empty($v->club_type_f_ctcode->f_ctname)) echo $v->club_type_f_ctcode->f_ctname; ?></td>
                            <td><?php echo $v->apply_name; ?></td>
                            <td><?php echo $v->contact_phone; ?></td>
                            <td><?php echo ClubProject::model()->count('club_id=' . $v->id . ' and project_state=506') ?></td>
                            <?php
                                $Project_array = ClubProject::model()->findAll('club_id=' . $v->id . ' and project_state=506');
                                $tx = '';
                                foreach ($Project_array as $h) {
                                    $tx .= $h->project_name . ',';
                                }
                                $tx = rtrim($tx, ',');
                                ?>
                            <td style="width:150px;" title="<?= $tx; ?>">
                                <?php echo '<span style="display:inline-block;width: 150px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">' . $tx . '</span>'; ?>
                            </td>

                            <td><?php echo date('Y-m-d H:i:s', strtotime($v->apply_time)); ?></td>
                            <td><?php if (!empty($v->baseCode_state->F_NAME)) echo $v->baseCode_state->F_NAME; ?></td>
                            <td>
                                <?php echo show_command('修改', $this->createUrl('update', array('id' => $v->id, 'action' => 'index_xmgs'))); ?>
                                <?php echo show_command('删除', '\'' . $v->id . '\''); ?>
                            </td>
                        </tr>
                    <?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c">
            <?php $this->page($pages); ?>
        </div>
    </div>
    <!--box-content end-->
</div>
<!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
    //时分秒：
    $(function() {
        var $start_time = $('#start_date');
        var $end_time = $('#end_date');
        $start_time.on('click', function() {
            var end_input = $dp.$('end_date')
            WdatePicker({
                startDate: '%y-%M-%D',
                dateFmt: 'yyyy-MM-dd',
                alwaysUseStartDate: false,
                onpicked: function() {
                    end_input.click();
                },
                maxDate: '#F{$dp.$D(\'end_date\')}'
            });
        });
        $end_time.on('click', function() {
            WdatePicker({
                startDate: '%y-%M-%D',
                dateFmt: 'yyyy-MM-dd',
                alwaysUseStartDate: false,
                minDate: '#F{$dp.$D(\'start_date\')}'
            });
        });
    });



    function on_exam() {
        $('#to_day').val(1);
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        document.getElementById('click_submit').click();
    }
</script>