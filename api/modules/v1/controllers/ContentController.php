<?php

namespace api\modules\v1\controllers;

use Yii;
use api\controllers\_ApiController;
use common\extensions\Util;
use common\models\Upload;
use common\models\Content;

class ContentController extends _ApiController {

    public $modelClass = 'common\models\Content';

    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete'], $actions['options']);

        return $actions;
    }

    public function actionContentList() {
        try {
            $keyword = Util::filterStringRelace(Yii::$app->request->post('keyword')); //关键词搜索
            $sort_field = Yii::$app->request->post('sort_field', 'c_id'); //排序字段
            $sort_type = (int) Yii::$app->request->post('sort_type', 2); //排序方式 1顺序 2倒序
            $category_id = (int) Yii::$app->request->post('category_id'); //类别
            $page = (int) Yii::$app->request->post('page', 1); //分页
            $pagesize = (int) Yii::$app->request->post('pagesize', 10); //页码
            //按字段排序
            if (in_array($sort_field, ['c_id', 'c_hits', 'c_sort'])) {
                $orderby = [$sort_field => ($sort_type == 1 ? SORT_ASC : SORT_DESC)];
            } else {
                $orderby = ['c_id' => ($sort_type == 1 ? SORT_ASC : SORT_DESC)];
            }

            $query = Content::find()->where(['c_status' => Content::STATUS_YES])->with('contentCategory');
            if ($keyword) {
                $query->orFilterWhere(['like', 'c_title', $keyword]);
                $query->orFilterWhere(['like', 'c_keyword', $keyword]);
                $query->orFilterWhere(['like', 'c_author', $keyword]);
                $query->orFilterWhere(['like', 'c_source_site', $keyword]);
            }
            $list = $query->offset(($page - 1) * $pagesize)->limit($pagesize * $page)->orderby($orderby)->all();
            $data = [];
            foreach ($list as $v) {
                $data[] = [
                    'id' => $v->c_id,
                    'title' => $v->c_id . $v->c_title,
                    'description' => $v->c_description,
                    'category_title' => isset($v->contentCategory->c_title) ? $v->contentCategory->c_title : '',
                    'author' => $v->c_author,
                    'thumb' => Upload::getThumbOne($v->c_picture, true),
                    'time' => date('Y-m-d', $v->c_create_time)
                ];
            }
            $this->successJson($data);
        } catch (\Exception $ex) {
            $this->errorJson($ex->getMessage());
        }
    }

    public function actionContentDetail() {
        try {
            $id = (int) Yii::$app->request->post('id');
            if ($id) {
                $row = Content::findOne($id);
                if ($row && $row->c_status == Content::STATUS_YES) {
                    $picture_list = Upload::getFileList($row->c_picture);
                    $file_list = Upload::getFileList($row->c_file);
                    $picture_array = $file_array = [];
                    if ($picture_list) {
                        foreach ($picture_list as $picture) {
                            $picture_array[] = Upload::getUploadUrl() . $picture;
                        }
                    }
                    if ($file_list) {
                        foreach ($file_list as $file) {
                            $file_array[] = Upload::getUploadUrl() . $file;
                        }
                    }
                    $data = [];
                    $data['title'] = $row->c_id . $row->c_title;
                    $data['author'] = $row->c_author;
                    $data['hits'] = $row->c_hits;
                    $data['user_id'] = $row->c_user_id;
                    $data['time'] = date('Y-m-d', $row->c_create_time);
                    $data['picture'] = $picture_array;
                    $data['file'] = $file_array;
                    $data['content'] = isset($row->contentText->c_pc_content) ? $row->contentText->c_pc_content : '';

                    $this->successJson($data);
                } else {
                    $this->errorJson('信息不存在');
                }
            } else {
                $this->errorJson('参数ID不能为空');
            }
        } catch (\Exception $ex) {
            $this->errorJson($ex->getMessage());
        }
    }

}
