<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('reward_type'); ?></th>
                        <th><?php echo $model->getAttributeLabel('gift_name'); ?></th>
                        <th><?php echo $model->getAttributeLabel('gift_money'); ?></th>
                        <th><?php echo $model->getAttributeLabel('redenv_money'); ?></th>
                        <th><?php echo $model->getAttributeLabel('gf_name1'); ?></th>
                        <th><?php echo $model->getAttributeLabel('reward_time'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
                            <td><?php echo ($v->m_type==32) ? '礼物' : '红包'; ?></td>
                            <td><?php echo $v->live_reward_name; ?></td>
                            <td><?php if($v->m_type==32) echo $v->live_reward_price; ?></td>
                            <td><?php if($v->m_type==40) echo $v->buy_price; ?></td>
                            <td><?php if(!empty($v->s_gfid) && !empty($v->gf_s_gfid)) echo $v->gf_s_gfid->GF_NAME; ?></td>
                            <td><?php echo $v->pay_time; ?></td>
                        </tr>
                    <?php $index++; }?>
                </tbody>
            </table>
        </div>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->