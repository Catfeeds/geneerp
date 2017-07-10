<?php

$this->beginContent('@app/views/' . Yii::$app->controller->template . '/layouts/main.php');
?>
<?= $content; ?>
<?php

$this->endContent();
