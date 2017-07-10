<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\extensions\Util;
use common\models\MarketCard;
use common\models\MarketTicket;
use backend\forms\MarketTicketSearch;

class MarketTicketController extends _BackendController {

    public function actionIndex() {
        $searchModel = new MarketTicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionCreate() {
        $model = new MarketTicket();
        if (Yii::$app->request->isPost) {
            if ($this->commonCreate($model)) {
                return $this->refresh();
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            if ($this->commonUpdate($model)) {
                return $this->refresh();
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id) {
        if (Yii::$app->request->isPost) {
            return $this->commonDelete(MarketTicket::className(), $id);
        }
    }

    public function actionAdd($id) {
        if (Yii::$app->request->isPost) {
            $count = (int) Yii::$app->request->post('ajaxparams');
            if ($count) {
                $result = MarketTicket::add($id, $count);
                $result ? $this->ajaxSuccess() : $this->ajaxError();
            } else {
                $this->ajaxError();
            }
        }
    }

    public function actionExport($id) {
        $this->export($id);
    }

    /**
     * Excel导出
     * @return type
     */
    private function export($id) {
        $result = MarketCard::findId(['c_ticket_id' => $id], true);
        $field = MarketCard::getExportField();
        $field_values = array_values($field);
        $field_keys = array_keys($field);

        require Yii::getAlias('@common/extensions/PHPExcel.php');
        $excel = new \PHPExcel();

        //Excel表格式
        $letter = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

        //填充表头信息
        foreach ($field_values as $k => $v) {
            $excel->getActiveSheet()->setCellValue($letter[$k] . '1', $v);
            $excel->getActiveSheet()->getStyle($letter[$k] . '1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
            $excel->getActiveSheet()->getStyle($letter[$k] . '1')->getFill()->getStartColor()->setARGB('4EEE94');
        }

        //填充表格信息
        foreach ($result as $k => $v) {
            $j = 0;
            foreach ($v as $kk => $vv) {
                if (in_array($kk, $field_keys)) {
                    $size = 20;
                    if ($vv && in_array($kk, ['c_start_time', 'c_end_time', 'c_create_time'])) {
                        $vv = date('Y-m-d H:i:s', $vv);
                    } elseif ($kk == 'c_status') {
                        $vv = Util::getStatusText($vv);
                    } elseif ($kk == 'c_is_used') {
                        $vv = MarketCard::getUsedStatus($vv);
                    } elseif ($kk == 'c_is_send') {
                        $vv = MarketCard::getSendStatus($vv);
                    }
                    $excel->getActiveSheet()->setCellValue($letter[$j] . ($k + 2), $vv);
                    $excel->getActiveSheet()->getColumnDimension($letter[$j])->setWidth($size);
                    $excel->getActiveSheet()->getStyle($letter[$j] . ($k + 2))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $j++;
                }
            }
        }

        $excel->getActiveSheet()->getPageSetup()->setFitToWidth('1');
        $write = new \PHPExcel_Writer_Excel5($excel);
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control:must-revalidate, post-check=0, pre-check=0');
        header('Content-Type:application/force-download');
        header('Content-Type:application/vnd.ms-execl');
        header('Content-Type:application/octet-stream');
        header('Content-Type:application/download');
        header('Content-Disposition:attachment;filename=card_' . date('YmdHis') . '.xls');
        header('Content-Transfer-Encoding:binary');
        $write->save('php://output');
        exit;
    }

    protected function findModel($id) {
        if (($model = MarketTicket::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
