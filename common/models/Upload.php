<?php

namespace common\models;

use Yii;
use yii\imagine\Image;
use Imagine\Image\ManipulatorInterface;
use common\extensions\Util;

/**
 * This is the model class for table "{{%upload}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_path
 * @property string $c_extension
 * @property integer $c_user_type
 * @property integer $c_type
 * @property integer $c_status
 * @property integer $c_width
 * @property integer $c_height
 * @property string $c_object_id
 * @property string $c_user_id
 * @property string $c_size
 * @property string $c_create_time
 * @property string $c_update_time
 */
class Upload extends _CommonModel {

    const UPLOAD_PICTURE = 1;
    const UPLOAD_FILE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%upload}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_user_type', 'c_type', 'c_status', 'c_width', 'c_height', 'c_object_id', 'c_user_id', 'c_size', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 50],
            [['c_path'], 'string', 'max' => 255],
            [['c_extension'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_title' => '原文件名',
            'c_path' => '上传路径',
            'c_extension' => '扩展名',
            'c_user_type' => '用户类型 1后台 2用户',
            'c_type' => '附件类型 1图片 2附件',
            'c_status' => '状态 2未使用 1正常',
            'c_width' => '图片长度',
            'c_height' => '图片高度',
            'c_object_id' => '对象ID',
            'c_user_id' => '用户ID',
            'c_size' => '文件大小',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function getThumbType($type = null) {
        $array = [1 => '按比例缩放', 2 => '按固定大小缩放'];
        return Util::getStatusText($type, $array);
    }

    //判断后缀是否是图片格式
    public static function isImages($file) {
        if ($file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            return in_array($extension, Yii::$app->params['image_extensions']);
        }
        return false;
    }

    //文件上传地址
    public static function getUploadUrl() {
        return rtrim(Yii::$app->params['domian_file'], '/') . '/';
    }

    //文件上传路径
    public static function getUploadPath() {
        return realpath(Yii::getAlias('@upload')) . DIRECTORY_SEPARATOR;
    }

    /**
     * 获取文件URL
     * @param type $source_path 原始文件路径
     * @param type $return_nopic 如果为真返回暂无图片
     * @return type
     */
    public static function getFileUrl($source_path = '', $return_nopic = false) {
        if ($source_path) {
            $path = self::getUploadPath() . $source_path;
            if (is_file($path)) {
                return self::getUploadUrl() . $source_path;
            }
        }
        return $return_nopic ? self::getNoPic() : false;
    }

    //文件图片
    public static function getFilePic() {
        return self::getUploadUrl() . 'default/filepic.png';
    }

    //暂无图片或文件
    public static function getNoPic($return_nopic = true) {
        return $return_nopic ? self::getUploadUrl() . 'default/nopic.png' : Upload::getFilePic();
    }

    /**
     * 按图片地址获取缩略图地址
     * @param type $source_path 图片原始路径
     * @return type
     */
    public static function getThumb($source_path = null) {
        if ($source_path) {
            $default_path = self::getThumbPath($source_path); //默认缩略图路径
            $default_url = self::getThumbUrl($source_path); //默认缩略图URL
            if (is_file($default_path)) {//缩略图存在就直接返回URL 否则就从新从按配置生成缩略图
                return $default_url;
            } else {//重新生成缩略图
                $path = self::getUploadPath() . $source_path;
                if (is_file($path) && self::isImages($path)) {
                    //$mode 生成缩略图类型 THUMBNAIL_INSET按原图等比例缩略 THUMBNAIL_OUTBOUND按设置大小截取
                    $mode = Yii::$app->params['upload_thumb_type'] === '1' ? ManipulatorInterface::THUMBNAIL_INSET : ManipulatorInterface::THUMBNAIL_OUTBOUND;
                    self::getImagineThumb($source_path, $mode);
                    return $default_url;
                }
            }
        }
        return self::getNoPic();
    }

    /**
     * 获取缩略图路径
     * @param type $source_path 原始文件路径
     * @return type
     */
    private static function getThumbPath($source_path) {
        $size = self::getSize();
        return self::getUploadPath() . 'thumb' . DIRECTORY_SEPARATOR . $size[0] . '_' . $size[1] . DIRECTORY_SEPARATOR . $source_path;
    }

    /**
     * 获取缩略图URL
     * @param type $source_path 原始文件路径
     * @return type
     */
    public static function getThumbUrl($source_path = '') {
        $size = self::getSize();
        return self::getUploadUrl() . 'thumb/' . $size[0] . '_' . $size[1] . '/' . $source_path;
    }

    /**
     * 按图片地址获取缩略图地址 存放缩略图目录必须预先存在否则生成失败
     * @param type $source_path 图片原始路径
     * @param type $mode 生成缩略图类型 THUMBNAIL_INSET按原图等比例缩略 THUMBNAIL_OUTBOUND按设置大小截取
     * @return type
     */
    private static function getImagineThumb($source_path, $mode) {
        $size = self::getSize();
        $path = self::getUploadPath() . $source_path;
        $save_path = self::getThumbPath($source_path);
        Util::createDirList($save_path); //生成目录
        Image::thumbnail($path, $size[0], $size[1], $mode)->save($save_path);
    }

    /**
     * 获取缩略图的宽高
     * @return type
     */
    private static function getSize() {
        $width = isset(Yii::$app->params['upload_thumb_width']) && (int) Yii::$app->params['upload_thumb_width'] >= 50 && (int) Yii::$app->params['upload_thumb_width'] <= 500 ? (int) Yii::$app->params['upload_thumb_width'] : 200;
        $height = isset(Yii::$app->params['upload_thumb_height']) && (int) Yii::$app->params['upload_thumb_height'] >= 50 && (int) Yii::$app->params['upload_thumb_height'] <= 500 ? (int) Yii::$app->params['upload_thumb_height'] : 200;
        return [$width, $height];
    }

    /**
     * 通过文件路径获取缩略图
     * @param string $file_list 图片路径 可以是多个路径
     * @param bool $get_one 是否获取第一个
     */
    public static function getFileList($file_list, $get_one = false) {
        if ($file_list) {
            $array = explode(',', $file_list);
            if ($get_one) {
                return $array[0];
            }
            return $array;
        }
        return false;
    }

    /**
     * 通过文件路径获取缩略图
     * @param type $picture_list 图片路径 可以是多个路径
     * @param type $get_thumb 
     */
    public static function getThumbOne($picture_list, $get_thumb = true) {
        $picture = self::getFileList($picture_list, true);
        if ($picture) {
            if ($get_thumb) {
                return self::getThumb($picture);
            }
            return $picture;
        }
        return false;
    }

    /**
     * 返回上传文件的应用信息
     * @param type $name
     * @param type $extension
     * @return type
     */
    public static function getUploadInfo($name = '', $extension = 'jpg') {
        $filename = md5($name . $extension . time() . mt_rand(100000, 999999));
        $year = date('Y', time());
        $month = date('m', time());
        $day = date('d', time());
        $hour = date('H', time());
        $dir = [$year, $month, $day, $hour, $filename . '.' . $extension];
        $fileurl = implode('/', $dir); //返回上传的URL
        $filepath = implode(DIRECTORY_SEPARATOR, $dir); //文件上传的路径
        return ['name' => $filename, 'url' => $fileurl, 'path' => $filepath];
    }

    //新增文件
    public static function add($data) {
        $model = new Upload();
        $model->attributes = $data;
        $model->c_user_id = (int) Yii::$app->user->id;
        $model->c_status = self::STATUS_NO;
        $model->c_create_time = time();
        return $model->save();
    }

    //按文件路径更新状态和对象ID
    public static function updateByPath($object_id, $source_path) {
        if (is_array($source_path)) {
            foreach ($source_path as $path) {
                if ($path) {
                    if (!self::_updateByPath($object_id, $path)) {
                        return false;
                    }
                }
            }
            return true;
        } else {
            return self::_updateByPath($object_id, $source_path);
        }
    }

    private static function _updateByPath($object_id, $path) {
        $model = self::findByPath($path);
        if ($model) {
            $model->c_status = self::STATUS_YES;
            $model->c_object_id = $object_id;
            return $model->save();
        }
        return true;
    }

    /**
     * 更新上传文件
     * @param bool $is_insert 是否新增
     * @param int $id 当前操作的ID
     * @param int $type 上传类型 1图片 2附件
     * @param string $field_name 自定义字段名
     * @param string $data 自定义字图片数据 
     */
    public static function updateFile($is_insert, $id, $type = Upload::UPLOAD_PICTURE, $field_name = null, $data = null) {
        if ($data) {
            $file_list = $data;
            $file_list_old = [];
        } else {
            if ($field_name) {
                $name = $field_name; //上传字段名称
                $name_old = $field_name . '_old'; //原始上传字段名称
            } else {
                $name = $type == Upload::UPLOAD_PICTURE ? 'picture_list' : 'file_list';
                $name_old = $type == Upload::UPLOAD_PICTURE ? 'picture_list_old' : 'file_list_old';
            }
            $file_list = Yii::$app->request->post($name); //本次新增图片路径
            $file_list_old = Yii::$app->request->post($name_old); //原始图片路径
        }

        $array = $file_list ? explode(',', $file_list) : []; //本次图片上传的路径数组
        $array_old = $file_list_old ? explode(',', $file_list_old) : []; //原始图片路径数组 新增时为空 编辑时可能有图片路径
        //新增
        if ($is_insert) {
            return Upload::updateByPath($id, $array); //更新上传图片为已上传
        } else {
            $diff_array = array_diff($array, $array_old); //本次上传路径的差集
            $diff_array_old = array_diff($array_old, $array); //原始图片路径的差集
            //如果本次上传路径有差集，需要更新
            if ($file_list && $diff_array) {
                if (!Upload::updateByPath($id, $diff_array)) {
                    return false;
                }
            }
            //如果原始路径有差集，需要删除
            if ($file_list_old && $diff_array_old) {
                if (!Upload::deleteFile($diff_array_old, true)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 删除附件或图片及缩略图
     * @param array $source_path 原始文件路径
     * @param type $is_delete 是否删除数据库记录
     */
    public static function deleteFile($source_path, $is_delete = false) {
        if (is_array($source_path)) {
            foreach ($source_path as $path) {
                if (!self::_deleteFile($path, $is_delete)) {
                    return false;
                }
            }
            return true;
        } else {
            return self::_deleteFile($source_path, $is_delete);
        }
    }

    private static function _deleteFile($path, $is_delete = false) {
        if ($is_delete) {
            $model = self::findByPath($path);
            if ($model) {
                if (!$model->delete()) {
                    return false;
                }
            }
        }
        $file = self::getUploadPath() . $path;
        if (is_file($file)) {
            unlink($file); //删除原始文件
        }
        self::deleteThumb($path); //删除缩略图文件
        return true;
    }

    /**
     * 删除缩略图
     * @param type $source_path 原始文件路径
     */
    private static function deleteThumb($source_path) {
        $file = self::getThumbPath($source_path);
        if (is_file($file)) {
            unlink($file);
        }
    }

    //按文件路径查询
    public static function findByPath($path) {
        return Upload::findOne(['c_path' => $path]);
    }

}
