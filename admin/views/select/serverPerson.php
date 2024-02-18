<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo Yii::app()->request->getParam('club_id');?>">
                <input type="hidden" name="service_type" value="<?php echo Yii::app()->request->getParam('service_type');?>">
                <label style="margin-right:10px;">
                    <span>项目：</span>
                    <?php echo downList($club_project_list, 'project_id', 'project_name','project_id'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:120px;" type="text" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入GF账号/姓名">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th colspan="9">点击选择</th>
                    </tr>
                    <tr>
                        <td>序号</td>
                        <td>服务者编码</td>
                        <td>GF帐号</td>
                        <td>姓名</td>
                        <td>项目</td>
                        <td>服务者类别</td>
                        <td>资质等级</td>
                        <td>服务者等级</td>
                        <td>服务者有效期</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <?php
                            $person = (!empty($v->qualifications_person)) ? true : false;
                            $anchored = '';
                            $project_id = '';
                            $account = ($person) ? $v->qualifications_person->qualification_gfaccount : '';
                            $list = QualificationsPerson::model()->findAll('qualification_gfaccount="'.$account.'" group by qualification_project_id');
                            if(!empty($list))foreach($list as $ls){
                                if(!empty($anchored)) $anchored .= '，';
                                if(!empty($project_id)) $project_id .= ',';
                                $anchored .= $ls->qualification_project_name;
                                $project_id .= $ls->qualification_project_id;
                            }
                        ?>
                        <tr data-id="<?php echo $v->id; ?>"
                            data-personid="<?php echo $v->qualification_person_id; ?>"
                            data-title="<?php if($person) echo $v->qualifications_person->qualification_name; ?>"
                            data-project-id="<?php echo $v->project_id; ?>"
                            data-project-name="<?php echo $v->project_name;?>"
                            data-gfid="<?php if($person) echo $v->qualifications_person->gfid; ?>"
                            data-email="<?php if($person) echo $v->qualifications_person->email; ?>"
                            data-account="<?php if($person) echo $v->qualifications_person->qualification_gfaccount;?>"
                            data-qcode="<?php if($person) echo $v->qualifications_person->qcode;?>"
                            data-qualification-gf-code="<?php if($person) echo $v->qualifications_person->qualification_gf_code;?>"
                            data-service-type="<?php if($person) echo $v->qualifications_person->qualification_type_id; ?>"
                            data-service-type-name="<?php if($person) echo $v->qualifications_person->qualification_type; ?>"
                            data-qualification-level="<?php if($person) echo $v->qualifications_person->qualification_level; ?>"
                            data-qualification-level-name="<?php if($person) echo $v->qualifications_person->qualification_level_name; ?>"
                            data-qualification-title="<?php if($person) echo $v->qualifications_person->qualification_title; ?>"
                            data-qualification-code-project="<?php if($person) echo $v->qualifications_person->qualification_code_project; ?>"
                            data-qualification-code="<?php if($person) echo $v->qualifications_person->qualification_code_type; ?>"
                            data-start-date="<?php if($person) echo $v->qualifications_person->start_date; ?>"
                            data-end-date="<?php if($person) echo $v->qualifications_person->end_date; ?>"
                            data-qualification-identity-type="<?php if($person) echo $v->qualifications_person->qualification_identity_type; ?>"
                            data-qualification-identity-type-name="<?php if($person) echo $v->qualifications_person->qualification_identity_type_name; ?>"
                            data-anchored-project-id="<?php echo $project_id; ?>"
                            data-anchored-project-name="<?php echo $anchored; ?>"
                        >
                            <td><?php echo $index; ?></td>
                            <td><?php if($person) echo $v->qualifications_person->qcode;?></td>
                            <td><?php if($person) echo $v->qualifications_person->qualification_gfaccount;?></td>
                            <td><?php if($person) echo $v->qualifications_person->qualification_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->type_name; ?></td>
                            <td><?php if($person) echo $v->qualifications_person->qualification_title; ?></td>
                            <td><?php if($person) echo $v->qualifications_person->qualification_level_name; ?></td>
                            <td><?php if($person) echo $v->qualifications_person->expiry_date_end; ?></td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        // api.button({  name: '取消'});
        $('.box-table tbody tr').on('click', function(){
            var $this=$(this);
            $.dialog.data('club_person_id', $this.attr('data-id'));
            $.dialog.data('person_id', $this.attr('data-personid'));
            $.dialog.data('person_name', $this.attr('data-title'));
            $.dialog.data('project_id', $this.attr('data-project-id'));
            $.dialog.data('project_name', $this.attr('data-project-name'));
            $.dialog.data('gfid', $this.attr('data-gfid'));
            $.dialog.data('email', $this.attr('data-email'));
            $.dialog.data('account', $this.attr('data-account'));
            $.dialog.data('qcode', $this.attr('data-qcode'));
            $.dialog.data('service_type', $this.attr('data-service-type'));
            $.dialog.data('service_type_name', $this.attr('data-service-type-name'));
            $.dialog.data('qualification_level', $this.attr('data-qualification-level'));
            $.dialog.data('qualification_level_name', $this.attr('data-qualification-level-name'));
            $.dialog.data('qualification_title', $this.attr('data-qualification-title'));
            $.dialog.data('qualification_code_project', $this.attr('data-qualification-code-project'));
            $.dialog.data('qualification_code', $this.attr('data-qualification-code'));
            $.dialog.data('anchored_project_id', $this.attr('data-anchored-project-id'));
            $.dialog.data('anchored_project_name', $this.attr('data-anchored-project-name'));
            $.dialog.data('start_date', $this.attr('data-start-date'));
            $.dialog.data('end_date', $this.attr('data-end-date'));
            $.dialog.data('qualification_identity_type', $this.attr('data-qualification-identity-type'));
            $.dialog.data('qualification_identity_type_name', $this.attr('data-qualification-identity-type-name'));
            $.dialog.data('qualification_gf_code', $this.attr('data-qualification-gf-code'));
            $.dialog.close();
        });
    });
</script>