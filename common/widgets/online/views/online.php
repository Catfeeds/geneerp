<?php

use common\widgets\online\OnlineAsset;

$bundle = OnlineAsset::register($this);
?>
<div id="online">
    <div class="top"><img src="<?= $bundle->baseUrl; ?>/img/close.png" class="close"></div>
    <div class="middle">
        <?php
        $count = count($list);
        foreach ($list as $k => $v) {
            if (strpos($v, '|') !== false) {
                $array = explode('|', $v);
                $class = '';
                if ($k === 0) {
                    $class = ' class="first"';
                } elseif ($k === $count - 1) {
                    $class = ' class="last"';
                }
                ?>
                <a<?= $class; ?> target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?= $array[1]; ?>&site=qq&menu=yes"><?= $array[0]; ?></a>
                <?php
            }
        }
        ?>
        <div class="qrcode"><img src="<?= $bundle->baseUrl; ?>/img/qrcode.png" alt="扫一扫二维码"></div>  
    </div>
    <a href="#"><img src="<?= $bundle->baseUrl; ?>/img/float_bottom.png" alt="点击返回顶部"></a>
</div>
<div class="right_bar"><img src="<?= $bundle->baseUrl; ?>/img/right_bar.jpg"></div>
<script>
    $(function () {
        $('.right_bar').click(function () {
            $(this).hide();
            $('#online').show();
        });
        $('#online .close').click(function () {
            $('.right_bar').show();
            $('#online').hide();
        });
    });
</script>