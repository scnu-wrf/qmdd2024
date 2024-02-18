<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>规则内容</th>
                    </tr>
                </thead>
                <tbody>
                    <?php //foreach($arclist as $v) {?>
                        <?php 
                            // $basepath = BasePath::model()->getPath(164);
                            // $content = get_html($basepath->F_WWWPATH.$v->intro_content, $basepath);
                        ?>
                        <tr>
                            <td><?php //echo strip_html_tags(array('style','script','meta','title'),$content); ?></td>
                        </tr>
                    <?php //}?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->