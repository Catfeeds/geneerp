<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use common\messages\Common;
use common\extensions\CheckRule;
use common\controllers\_CommonController;
use common\models\_CommonModel;
use backend\models\AdminOperationLog;

class _BackendController extends _CommonController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 公共模块创建
     * @param array $model 模型
     * @param array $data 自定义数据格式 [模型名称=>数据数组] 如: [Ad => ['c_title'=>'test','c_status'=>1]] 默认是接收POST数据
     * @return type
     */
    protected function commonCreate($model, $data = null) {
        if (is_null($data)) {
            $data = Yii::$app->request->post();
        }
        if ($model->load($data)) {
            if (array_key_exists('c_create_time', $model->attributes)) {
                $model->c_create_time = time();
            }
            if ($model->validate()) {
                $result = $model->save();
                $result ? $this->adminLog(_CommonModel::OPERATION_ADD, _CommonModel::RESULT_SUCCESS, $model->c_id, null, $model->attributes) : $this->adminLog(_CommonModel::OPERATION_ADD, _CommonModel::RESULT_FAIL, $model->c_id, null, $model->attributes);
                if ($result) {
                    $this->flashSuccess('新增操作成功');
                    return true;
                } else {
                    $this->flashError($model, '新增操作失败');
                    return false;
                }
            } else {
                $this->flashError($model, '新增验证未通过');
                return false;
            }
        } else {
            $this->flashError(null, Yii::t('common', Common::SYSTEM_LOAD_FAIL));
            return false;
        }
    }

    /**
     * 公共模块更新
     * @param array $model 模型
     * @param array $data 自定义数据格式 [模型名称=>数据数组] 如: [Ad => ['c_title'=>'test','c_status'=>1]] 默认是接收POST数据
     * @return type
     */
    protected function commonUpdate($model, $data = null) {
        $data_before = $model->attributes; //在本次更新之前的数据
        if (is_null($data)) {
            $data = Yii::$app->request->post();
        }
        if ($model->load($data)) {
            if ($model->validate()) {
                $result = $model->save();
                $result ? $this->adminLog(_CommonModel::OPERATION_UPDATE, _CommonModel::RESULT_SUCCESS, $model->c_id, $data_before, $model->attributes) : $this->adminLog(_CommonModel::OPERATION_UPDATE, _CommonModel::RESULT_FAIL, $model->c_id, $data_before, $model->attributes);
                if ($result) {
                    $this->flashSuccess('编辑操作成功');
                    return true;
                } else {
                    $this->flashError($model, '编辑操作失败');
                    return false;
                }
            } else {
                $this->flashError($model, '编辑验证未通过');
                return false;
            }
        } else {
            $this->flashError(null, Yii::t('common', Common::SYSTEM_LOAD_FAIL));
            return false;
        }
    }

    //公共模块更新 按排序更新
    protected function commonUpdateSort($model_name, $field = 'c_sort') {
        $ids = Yii::$app->request->post('id');
        $sort = Yii::$app->request->post('sort');
        if ($ids) {
            foreach ($ids as $k => $id) {
                $model_name::updateAll([$field => (int) $sort[$k]], ['c_id' => $id]);
            }
            $this->flashSuccess('排序操作成功');
            $this->ajaxSuccess();
        } else {
            $this->flashError(null, 'ID参数无效');
            $this->ajaxError();
        }
    }

    /**
     * 按自定义字段更新字段值 可批量操作 $id, $value, $field = 'c_status'
     * @param type $model_name
     * @param type $update_where 更新数组
     * @param type $condition_where 查询条件数组
     * @param type $return_ajax 是否返回AJAX
     */
    protected function commonUpdateField($model_name, $update_where, $condition_where, $return_ajax = false) {
        $result = $model_name::updateAll($update_where, $condition_where);
        $success = $result ? _CommonModel::RESULT_SUCCESS : _CommonModel::RESULT_FAIL;
        $this->adminLog(_CommonModel::OPERATION_UPDATE, $success, 0, null, ArrayHelper::merge($update_where, $condition_where));
        if ($result) {
            $this->flashSuccess('更新操作成功');
            if ($return_ajax) {
                return $this->ajaxSuccess();
            } else {
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            $this->flashError(null, '更新操作失败');
            if ($return_ajax) {
                return $this->ajaxError();
            } else {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    /**
     * 删除操作 可批量删除
     * @param type $model_name
     * @param type $id
     * @param type $return_ajax 是否返回AJAX
     * @return type
     */
    protected function commonDelete($model_name, $id, $return_ajax = false) {
        if ($id === null) {
            $id = explode(',', Yii::$app->request->post('id'));
        }
        if ($id) {
            $list = $model_name::find()->where(['c_id' => $id])->all();
            foreach ($list as $model) {
                $model->delete();
                if ($model->getErrors()) {//有错误
                    $this->adminLog(_CommonModel::OPERATION_DELETE, _CommonModel::RESULT_FAIL, $model->c_id, $model->attributes);
                    $this->flashError($model);
                    if ($return_ajax) {
                        return $this->returnAjaxError($model);
                    } else {
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                } else {
                    $this->adminLog(_CommonModel::OPERATION_DELETE, _CommonModel::RESULT_SUCCESS, $model->c_id, $model->attributes);
                }
            }
            $this->flashSuccess('删除操作成功');
            if ($return_ajax) {
                return $this->ajaxSuccess();
            } else {
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            $this->flashError(null, 'ID参数无效');
            if ($return_ajax) {
                return $this->ajaxError();
            } else {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    /**
     *  加入操作日志
     * @param type $type 操作类型 1新增 2编辑 3删除
     * @param type $status 操作结果状态 1成功 2失败
     * @param type $id 操作对象的ID
     * @param type $data_before 在本次更新或删除之前的数据
     * @param type $data_add 本次新增或更新的数据
     */
    protected function adminLog($type, $status, $id = 0, $data_before = null, $data_add = null) {
        if (isset(Yii::$app->params['system_log_status']) && Yii::$app->params['system_log_status'] === '1') {
            $log['c_route'] = Yii::$app->controller->getRoute();
            $log['c_object_id'] = (int) $id;
            $log['c_status'] = $status;
            $log['c_type'] = $type;
            if ($data_add) {
                $log['c_data_add'] = json_encode($data_add, JSON_UNESCAPED_UNICODE);
            }
            if ($data_before) {
                $log['c_data_before'] = json_encode($data_before, JSON_UNESCAPED_UNICODE);
            }
            AdminOperationLog::add($log);
        }
    }

    public function flashError($model = null, $msg = '操作失败') {
        if ($model) {
            $error = $model->getFirstErrors();
            if ($error) {
                $msg = array_values($error)[0];
            }
        }
        Yii::$app->getSession()->setFlash('error', $msg);
    }

    public function flashSuccess($msg = '操作成功') {
        Yii::$app->getSession()->setFlash('success', $msg);
    }

    /**
     * 权限判断
     * @param type $action
     * @return type
     */
    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            $route = Yii::$app->controller->getRoute();
            if (CheckRule::checkRole($route)) {
                return true;
            } else {
                CheckRule::isLogin() ? self::alert(Yii::t('common', Common::SYSTEM_PERMISSION_DENIED)) : $this->redirect(Url::to(['site/login']));
            }
        }
        return false;
    }

}
