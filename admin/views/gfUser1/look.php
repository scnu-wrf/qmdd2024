<style>.box-table .list tr th,.box-table .list tr td{text-align: center;}</style>
<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>日期</th>
                        <th>单位</th>
                        <th>项目</th>
                        <th>状态</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($arclist as $v){ ?>
                        <tr>
                            <td><?php echo $v->udate; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->club_status_name; ?></td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->