<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\UserProfile;

ssm\assets\CommonAsset::register($this);
?>
<div class="panel panel-default">
    <div class="panel-heading"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> 个人资料</div>
    <div class="panel-body">
        <form class="form-ajax form-horizontal" action="<?= Url::to(['index']) ?>" method="post" autocomplete="off" onsubmit="return false;">
            <div class="form-group">
                <label class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?= Yii::$app->user->identity->c_user_name ?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">昵称</label>
                <div class="col-sm-10">
                    <?php if ($model->c_nick_name) { ?>
                        <p class="form-control-static"><?= $model->c_nick_name ?></p>
                    <?php } else { ?>
                        <input data-rule="昵称:required;username;length(2~20)" type="text" class="form-control" name="UserProfile[c_nick_name]" maxlength="20">
                        <span class="help-block">填写后不可更改，与平台业务名称冲突的昵称，平台将有可能收回</span>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">性别</label>
                <div class="col-sm-10">
                    <?php
                    foreach (UserProfile::getSex() as $k => $v) {
                        $selectstr = $k == $model->c_sex ? ' checked="checked"' : '';
                        echo '<label class="radio-inline"><input type="radio" name="UserProfile[c_sex]" value="' . $k . '"' . $selectstr . '>' . $v . '</label>';
                    }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">出生年月日</label>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-4"><select id="select_year" class="form-control" name="select_year"<?= $model->c_birthday ? ' rel="' . date('Y', $model->c_birthday) . '"' : '' ?>></select></div>
                        <div class="col-sm-4"><select id="select_month" class="form-control" name="select_month"<?= $model->c_birthday ? ' rel="' . date('m', $model->c_birthday) . '"' : '' ?>></select></div>
                        <div class="col-sm-4"><select id="select_day" class="form-control" name="select_day"<?= $model->c_birthday ? ' rel="' . date('d', $model->c_birthday) . '"' : '' ?>></select></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">现居住地</label>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-4"><select id="c_province_id" class="form-control" name="UserProfile[c_province_id]"></select></div>
                        <div class="col-sm-4"><select id="c_city_id" class="form-control" name="UserProfile[c_city_id]"></select></div>
                        <div class="col-sm-4"><select id="c_area_id" class="form-control" name="UserProfile[c_area_id]"></select></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">详细地址</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="UserProfile[c_address]" rows="3"><?= Html::encode($model->c_address) ?></textarea>
                    <span class="help-block">无需输入省市县，建议您如实填写详细收货地址，例如街道名称，门牌号码，楼层和房间号等信息</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function () {
        //区域下拉
        var opts = {
            data: districtData,
            selClass: '',
            head: '请选择区域',
            minWidth: 0,
            select: ['#c_province_id', '#c_city_id', '#c_area_id'],
            defVal: [<?= $model->c_province_id ?>,<?= $model->c_city_id ?>,<?= $model->c_area_id ?>]
        };
        new LinkageSel(opts);

        $.BirthdayPicker();
    });
</script>