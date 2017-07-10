<?php

use yii\widgets\ActiveForm;
use common\extensions\Util;
use common\models\Upload;

$this->title = '网站设置';
?>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">网站设置</a></li>
    <li><a href="#tab2" data-toggle="tab">上传设置</a></li>
    <li><a href="#tab3" data-toggle="tab">商城设置</a></li>
    <li><a href="#tab4" data-toggle="tab">邮箱设置</a></li>
    <li><a href="#tab5" data-toggle="tab">短信设置</a></li>
    <li><a href="#tab6" data-toggle="tab">插件设置</a></li>
    <li><a href="#tab7" data-toggle="tab">系统设置</a></li>
</ul>
<?php $form = ActiveForm::begin(); ?> 
<div class="box box-primary">
    <div class="box-body tab-content">
        <div class="tab-pane active" id="tab1">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th class="w200">网站域名</th>
                    <td><input class="form-control" type="text" name="site[domian_frontend]" maxlength="50" value="<?= isset($data['site']['domian_frontend']) ? $data['site']['domian_frontend'] : Yii::$app->request->getHostInfo(); ?>"></td>
                </tr>
                <tr>
                    <th>后台域名</th>
                    <td><input class="form-control" type="text" name="site[domian_backend]" maxlength="50" value="<?= isset($data['site']['domian_backend']) ? $data['site']['domian_backend'] : Yii::$app->request->getHostInfo(); ?>"></td>
                </tr>
                <tr>
                    <th>文件域名</th>
                    <td><input class="form-control" type="text" name="site[domian_file]" maxlength="50" value="<?= isset($data['site']['domian_file']) ? $data['site']['domian_file'] : Yii::$app->request->getHostInfo(); ?>"></td>
                </tr>
                <tr>
                    <th>接口域名</th>
                    <td><input class="form-control" type="text" name="site[domian_api]" maxlength="50" value="<?= isset($data['site']['domian_api']) ? $data['site']['domian_api'] : Yii::$app->request->getHostInfo(); ?>"></td>
                </tr>
                <tr>
                    <th class="w200">网站名称</th>
                    <td><input class="form-control" type="text" name="site[site_title]" maxlength="255" value="<?= isset($data['site']['site_title']) ? $data['site']['site_title'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>网站首页附加标题</th>
                    <td><input class="form-control" type="text" name="site[site_seo]" maxlength="255" value="<?= isset($data['site']['site_seo']) ? $data['site']['site_seo'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>网站首页关键词</th>
                    <td><input class="form-control" type="text" name="site[site_keywords]" maxlength="255" value="<?= isset($data['site']['site_keywords']) ? $data['site']['site_keywords'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>网站SEO描述信息</th>
                    <td><textarea class="form-control" rows="3" name="site[site_description]"><?= isset($data['site']['site_description']) ? $data['site']['site_description'] : ''; ?></textarea></td>
                </tr>
                <tr>
                    <th>第三方统计代码</th>
                    <td><textarea class="form-control" rows="3" name="site[site_js]"><?= isset($data['site']['site_js']) ? $data['site']['site_js'] : ''; ?></textarea></td>
                </tr>
                <tr>
                    <th>ICP备案序号</th>
                    <td><input class="form-control" type="text" name="site[site_icp]" maxlength="255" value="<?= isset($data['site']['site_icp']) ? $data['site']['site_icp'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>联系人</th>
                    <td><input class="form-control" type="text" name="site[site_contact]" maxlength="255" value="<?= isset($data['site']['site_contact']) ? $data['site']['site_contact'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>手机</th>
                    <td><input class="form-control" type="text" name="site[site_mobile]" maxlength="255" value="<?= isset($data['site']['site_mobile']) ? $data['site']['site_mobile'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>客服电话</th>
                    <td><input class="form-control" type="text" name="site[site_phone]" maxlength="255" value="<?= isset($data['site']['site_phone']) ? $data['site']['site_phone'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>邮箱</th>
                    <td><input class="form-control" type="text" name="site[site_email]" maxlength="50" value="<?= isset($data['site']['site_email']) ? $data['site']['site_email'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>地址</th>
                    <td><input class="form-control" type="text" name="site[site_address]" maxlength="50" value="<?= isset($data['site']['site_address']) ? $data['site']['site_address'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>微信号</th>
                    <td><input class="form-control" type="text" name="site[site_weixin]" maxlength="255" value="<?= isset($data['site']['site_weixin']) ? $data['site']['site_weixin'] : ''; ?>"></td>
                </tr>
            </table>
        </div>

        <div class="tab-pane" id="tab2">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th class="w200">图片上传开关</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['upload']['upload_picture_status']) && $data['upload']['upload_picture_status'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="upload[upload_picture_status]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>附件上传开关</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['upload']['upload_file_status']) && $data['upload']['upload_file_status'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="upload[upload_file_status]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>附件下载需要登录</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['upload']['upload_file_login']) && $data['upload']['upload_file_login'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="upload[upload_file_login]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>缩略图设置</th>
                    <td>
                        <?php
                        foreach (Upload::getThumbType() as $k => $v) {
                            $selectstr = isset($data['upload']['upload_thumb_type']) && $data['upload']['upload_thumb_type'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="upload[upload_thumb_type]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>缩略图宽高</th>
                    <td>
                        <div class="row">
                            <div class="col-xs-2">
                                <label>50>= 长 <=500</label><input class="form-control" type="text" name="upload[upload_thumb_width]" maxlength="3" value="<?= isset($data['upload']['upload_thumb_width']) ? $data['upload']['upload_thumb_width'] : 200; ?>">
                            </div>
                            <div class="col-xs-2">
                                <label>50>= 宽 <=500</label><input class="form-control" type="text" name="upload[upload_thumb_height]" maxlength="3" value="<?= isset($data['upload']['upload_thumb_height']) ? $data['upload']['upload_thumb_height'] : 200; ?>">
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="tab-pane" id="tab3">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th class="w200">商品货号前缀</th>
                    <td>
                        <div class="row">
                            <div class="col-xs-2">
                                <input class="form-control" type="text" name="shop[number_prefix]" maxlength="50" value="<?= isset($data['shop']['number_prefix']) ? $data['shop']['number_prefix'] : 'JJ'; ?>">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>邮箱或手机注册时用户名前缀</th>
                    <td>
                        <div class="row">
                            <div class="col-xs-2">
                                <input class="form-control" type="text" name="shop[username_prefix]" maxlength="50" value="<?= isset($data['shop']['username_prefix']) ? $data['shop']['username_prefix'] : 'JJ'; ?>">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>自动取消未支付订单</th>
                    <td>
                        <div class="row">
                            <div class="col-xs-2">
                                <input class="form-control" type="text" name="shop[order_auto_cancel_hour]" maxlength="3" value="<?= isset($data['shop']['order_auto_cancel_hour']) ? $data['shop']['order_auto_cancel_hour'] : 48; ?>">
                            </div>
                        </div>
                        <p class="help-block">默认2天 48小时</p>
                    </td>
                </tr>
                <tr>
                    <th>自动确认收货</th>
                    <td>
                        <div class="row">
                            <div class="col-xs-2">
                                <input class="form-control" type="text" name="shop[order_auto_finish_hour]" maxlength="3" value="<?= isset($data['shop']['order_auto_finish_hour']) ? $data['shop']['order_auto_finish_hour'] : 360; ?>">
                            </div>
                        </div>
                        <p class="help-block">默认15天 360小时</p>
                    </td>
                </tr>
                <tr>
                    <th>自动商品评价</th>
                    <td>
                        <div class="row">
                            <div class="col-xs-2">
                                <input class="form-control" type="text" name="shop[order_auto_comment_hour]" maxlength="3" value="<?= isset($data['shop']['order_auto_comment_hour']) ? $data['shop']['order_auto_comment_hour'] : 720; ?>">
                            </div>
                        </div>
                        <p class="help-block">默认30天 720小时</p>
                    </td>
                </tr>
                <tr>
                    <th>用户收货地址最大数量</th>
                    <td>
                        <div class="row">
                            <div class="col-xs-2">
                                <input class="form-control" type="text" name="shop[user_address_max]" maxlength="3" value="<?= isset($data['shop']['user_address_max']) ? $data['shop']['user_address_max'] : 10; ?>">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>发票税率</th>
                    <td>
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="shop[shop_tax]" maxlength="3" value="<?= isset($data['shop']['shop_tax']) ? $data['shop']['shop_tax'] : 0; ?>">
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </div>
                        <p class="help-block">当买家需要发票的时候就要增加<商品金额> X <税率>的费用</p>
                    </td>
                </tr>
                <tr>
                    <th>评论</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['shop']['comment_status']) && $data['shop']['comment_status'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="shop[comment_status]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>创建订单判断商品库存</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['shop']['store_status']) && $data['shop']['store_status'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="shop[store_status]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="tab-pane" id="tab4">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th class="w200">发送类型</th>
                    <td>
                        <?php
                        $email_send_type = [1 => '即时发送', 2 => '队列发送'];
                        foreach (Util::getStatusText(null, $email_send_type) as $k => $v) {
                            $selectstr = isset($data['email']['email_send_type']) && $data['email']['email_send_type'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="email[email_send_type]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>发送邮件方式</th>
                    <td>
                        <?php
                        $send_type = [1 => '第三方SMTP方式', 2 => '本地mail邮箱'];
                        foreach (Util::getStatusText(null, $send_type) as $k => $v) {
                            $selectstr = isset($data['email']['smtp_type']) && $data['email']['smtp_type'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input class="showhide" data-show="1|smtp_type" data-hide="2|smtp_type" type="radio" name="email[smtp_type]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>发送邮件地址</th>
                    <td><input data-rule="email" class="form-control" type="text" name="email[email_send]" maxlength="50" value="<?= isset($data['email']['email_send']) ? $data['email']['email_send'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>安全协议</th>
                    <td>
                        <?php
                        $email_safe = [0 => '默认', 1 => 'SSL', 2 => 'TLS'];
                        foreach (Util::getStatusText(null, $email_safe) as $k => $v) {
                            $selectstr = isset($data['email']['email_safe']) && $data['email']['email_safe'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="email[email_safe]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tbody class="smtp_type" style="<?= isset($data['email']['smtp_type']) && $data['email']['smtp_type'] == 2 ? 'display:none' : ''; ?>">
                    <tr>
                        <th>SMTP地址</th>
                        <td><input class="form-control" type="text" name="email[email_smtp]" maxlength="50" value="<?= isset($data['email']['email_smtp']) ? $data['email']['email_smtp'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th>用户名</th>
                        <td><input class="form-control" type="text" name="email[smtp_user]" maxlength="50" value="<?= isset($data['email']['smtp_user']) ? $data['email']['smtp_user'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th>密码</th>
                        <td><input class="form-control" type="password" name="email[smtp_password]" maxlength="50" value="<?= isset($data['email']['smtp_password']) ? $data['email']['smtp_password'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th>端口号</th>
                        <td><input class="form-control" type="text" name="email[smtp_port]" maxlength="5" value="<?= isset($data['email']['smtp_port']) ? $data['email']['smtp_port'] : 25; ?>"></td>
                    </tr>
                </tbody>
                <tr>
                    <th>测试邮件地址</th>
                    <td><input data-rule="email" class="form-control" type="text" name="email[email_test]" maxlength="50" value="<?= isset($data['email']['email_test']) ? $data['email']['email_test'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>邮件发送参数</th>
                    <td>
                        <div class="row">
                            <div class="col-xs-3">
                                <label>邮箱验证有效期(单位秒)</label><input class="form-control" type="text" name="email[email_expire]" maxlength="3" value="<?= isset($data['email']['email_expire']) ? $data['email']['email_expire'] : 300; ?>">
                            </div>
                            <div class="col-xs-3">
                                <label>邮箱发送间隔(单位秒)</label><input class="form-control" type="text" name="email[email_send_time]" maxlength="3" value="<?= isset($data['email']['email_send_time']) ? $data['email']['email_send_time'] : 60; ?>">
                            </div>
                            <div class="col-xs-3">
                                <label>同一IP每天发送总数</label><input class="form-control" type="text" name="email[email_ip_count]" maxlength="3" value="<?= isset($data['email']['email_ip_count']) ? $data['email']['email_ip_count'] : 50; ?>">
                            </div>
                            <div class="col-xs-3">
                                <label>同一用户每天发送总数</label><input class="form-control" type="text" name="email[email_send_count]" maxlength="3" value="<?= isset($data['email']['email_send_count']) ? $data['email']['email_send_count'] : 50; ?>">
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="tab-pane" id="tab5">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th class="w200">发送类型</th>
                    <td>
                        <?php
                        $sms_send_type = [1 => '即时发送', 2 => '队列发送'];
                        foreach (Util::getStatusText(null, $sms_send_type) as $k => $v) {
                            $selectstr = isset($data['sms']['sms_send_type']) && $data['sms']['sms_send_type'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="sms[sms_send_type]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>阿里大于app_key</th>
                    <td><input class="form-control" type="text" name="sms[sms_app_key]" maxlength="50" value="<?= isset($data['sms']['sms_app_key']) ? $data['sms']['sms_app_key'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>阿里大于app_secret</th>
                    <td><input class="form-control" type="password" name="sms[sms_app_secret]" maxlength="50" value="<?= isset($data['sms']['sms_app_secret']) ? $data['sms']['sms_app_secret'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>默认短信签名</th>
                    <td><input class="form-control" type="text" name="sms[sms_sign_name]" maxlength="50" value="<?= isset($data['sms']['sms_sign_name']) ? $data['sms']['sms_sign_name'] : ''; ?>"></td>
                </tr>
                <tr>
                    <th>短信发送参数</th>
                    <td>
                        <div class="row">
                            <div class="col-xs-3">
                                <label>短信验证有效期(单位秒)</label><input class="form-control" type="text" name="sms[sms_expire]" maxlength="3" value="<?= isset($data['sms']['sms_expire']) ? $data['sms']['sms_expire'] : 300; ?>">
                            </div>
                            <div class="col-xs-3">
                                <label>短信发送间隔(单位秒)</label><input class="form-control" type="text" name="sms[sms_send_time]" maxlength="3" value="<?= isset($data['sms']['sms_send_time']) ? $data['sms']['sms_send_time'] : 60; ?>">
                            </div>
                            <div class="col-xs-3">
                                <label>同一IP每天发送总数</label><input class="form-control" type="text" name="sms[sms_ip_count]" maxlength="3" value="<?= isset($data['sms']['sms_ip_count']) ? $data['sms']['sms_ip_count'] : 50; ?>">
                            </div>
                            <div class="col-xs-3">
                                <label>同一用户每天发送总数</label><input class="form-control" type="text" name="sms[sms_send_count]" maxlength="3" value="<?= isset($data['sms']['sms_send_count']) ? $data['sms']['sms_send_count'] : 50 ?>">
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="tab-pane" id="tab6">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th class="w200">在线客服开关</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['plugin']['qq_open']) && $data['plugin']['qq_open'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input class="showhide" data-show="1|qq_list" data-hide="2|qq_list" type="radio" name="plugin[qq_open]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr class="qq_list" style="<?= isset($data['plugin']['qq_open']) && $data['plugin']['qq_open'] == 2 ? 'display:none' : '' ?>">
                    <th>在线客服QQ</th>
                    <td><input class="form-control" type="text" name="plugin[qq_list]" maxlength="255" value="<?= isset($data['plugin']['qq_list']) ? $data['plugin']['qq_list'] : ''; ?>">
                        <p class="help-block">示例：蔓荆子|19744244,素食派|42344344  如果多个QQ用英文逗号隔开</p>
                    </td>
                </tr>
                <tr>
                    <th>音乐播放开关</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['plugin']['player_open']) && $data['plugin']['player_open'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input class="showhide" data-show="1|player_url" data-hide="2|player_url" type="radio" name="plugin[player_open]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr class="player_url" style="<?= isset($data['plugin']['player_open']) && $data['plugin']['player_open'] == 2 ? 'display:none' : '' ?>">
                    <th>音乐地址</th>
                    <td><textarea class="form-control" rows="3" name="plugin[player_url]"><?= isset($data['plugin']['player_url']) ? $data['plugin']['player_url'] : '' ?></textarea></td>
                </tr>
                <tr>
                    <th>特别公告开关</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['plugin']['notice_open']) && $data['plugin']['notice_open'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input class="showhide" data-show="1|notice_open" data-hide="2|notice_open" type="radio" name="plugin[notice_open]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr class="notice_open" style="<?= isset($data['plugin']['notice_open']) && $data['plugin']['notice_open'] == 2 ? 'display:none' : '' ?>">
                    <th>特别公告</th>
                    <td><textarea class="form-control" rows="3" name="plugin[notice_message]"><?= isset($data['plugin']['notice_message']) ? $data['plugin']['notice_message'] : ''; ?></textarea></td>
                </tr>
            </table>
        </div>

        <div class="tab-pane" id="tab7">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th class="w200">前台访问开关</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['system']['system_site_open']) && $data['system']['system_site_open'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input class="showhide" data-show="2|close_msg" data-hide="1|close_msg" type="radio" name="system[system_site_open]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr class="close_msg" style="<?= isset($data['system']['system_site_open']) && $data['system']['system_site_open'] == 1 ? 'display:none' : '' ?>">
                    <th class="w200">前台停止访问通知</th>
                    <td><textarea class="form-control" rows="3" name="system[system_site_close_msg]"><?= isset($data['system']['system_site_close_msg']) ? $data['system']['system_site_close_msg'] : ''; ?></textarea></td>
                </tr>
                <tr>
                    <th>前台用户登录开关</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['system']['user_login_status']) && $data['system']['user_login_status'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="system[user_login_status]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>前台操作日志开关</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['system']['user_log_status']) && $data['system']['user_log_status'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="system[user_log_status]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>后台操作日志开关</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['system']['system_log_status']) && $data['system']['system_log_status'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="system[system_log_status]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>手机注册开关</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['system']['mobile_register_status']) && $data['system']['mobile_register_status'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="system[mobile_register_status]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>邮箱注册开关</th>
                    <td>
                        <?php
                        foreach (Util::getStatusOpenClose() as $k => $v) {
                            $selectstr = isset($data['system']['email_register_status']) && $data['system']['email_register_status'] == $k ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="system[email_register_status]" value="' . $k . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>前台模板</th>
                    <td>
                        <?php
                        foreach ($dir_array as $v) {
                            $selectstr = isset($data['system']['system_template']) && $data['system']['system_template'] == $v ? ' checked="checked"' : '';
                            echo '<label class="radio-inline"><input type="radio" name="system[system_template]" value="' . $v . '"' . $selectstr . '> ' . $v . '</label>';
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
                <th class="w200"></th>
                <td><button class="btn btn-primary" type="submit">提交</button></td>
            </tr>
        </table>
    </div>
</div>
<?php ActiveForm::end(); ?>