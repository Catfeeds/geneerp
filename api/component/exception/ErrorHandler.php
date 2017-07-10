<?php

namespace api\component\exception;

use yii\base\ErrorHandler as BaseErrorHandler;
use common\models\SystemLog;
class ErrorHandler extends BaseErrorHandler {

    public function renderException($exception) {
        if ($exception) {
            $code = $exception->getCode();
            $msg = $exception->getMessage();
            $file = $exception->getFile();
            $line = $exception->getLine();
            $err_msg = $msg . "[file:{$file}][line:{$line}][errcode:$code.][url:{$_SERVER['REQUEST_URI']}][post:" . http_build_query($_POST) . "]";
            SystemLog::add($err_msg);
        }
        header('HTTP/1.1 ' . $exception->statusCode . ' ' . $this->_getStatusCodeMessage($exception->statusCode));
        header('Content-type: application/json; charset=utf-8');
        echo json_encode(['success' => 0, 'status' => $exception->statusCode, 'message' => $exception->getMessage(), 'data' => null], JSON_UNESCAPED_UNICODE);
    }

    protected function _getStatusCodeMessage($status) {
        $codes = [
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        ];
        return isset($codes[$status]) ? $codes[$status] : '';
    }

}
