<?php

use common\models\Upload;
use common\widgets\uploader\UploaderAsset;

$bundle = UploaderAsset::register($this);
?>
<style>.progress {margin:0;border-radius:0;}</style>
<input name="<?= $name ?>_old" type="hidden" value="<?= $value; ?>">
<input name="<?= $name ?>" type="hidden" id="upload_<?= $name ?>" value="<?= $value; ?>">
<div class="container_div" id="container_<?= $name ?>">
    <button type="button" class="btn btn-default" id="pickfiles_<?= $name ?>"><i class="icon icon-folder-open-alt"></i> 选择文件</button>
    <button type="button" class="btn btn-default" id="uploadfiles_<?= $name ?>"><i class="icon icon-upload"></i> 上传</button>
</div>

<div class="filelist_div" id="filelist_<?= $name ?>">
    <?php
    if ($value) {
        $array = explode(',', $value);
        foreach ($array as $v) {
            $id = md5($v);
            if (Upload::isImages($v)) {
                echo '<div class="upload_div" id="upload_div' . $id . '"><img id="img' . $id . '" data-toggle="lightbox" data-image="' . Upload::getFileUrl($v, true) . '" src="' . Upload::getThumb($v) . '" data-path="' . $v . '" width="130px" height="100px"><div class="upload_title"></div><div class="upload_size"><span class="delete" onClick="javascript:deleteFileMsg' . $name . '(\'' . $id . '\');" id="delete' . $id . '" data-val="' . $id . '">删除</span></div></div>';
            } else {
                echo '<div class="upload_div" id="upload_div' . $id . '"><img id="img' . $id . '" src="' . Upload::getThumb($v) . '" data-path="' . $v . '" width="130px" height="100px"><div class="upload_title"></div><div class="upload_size"><span class="delete" onClick="javascript:deleteFileMsg' . $name . '(\'' . $id . '\');" id="delete' . $id . '" data-val="' . $id . '">删除</span></div></div>';
            }
        }
    }
    ?>
</div>
<script type="text/javascript">
    var message = {
        '-100': '发生错误',
        '-200': 'http网络错误',
        '-300': '磁盘读写错误',
        '-400': '安全问题产生错误',
        '-500': '初始化时产生错误',
        '-600': '文件太大',
        '-601': '文件类型不符合要求',
        '-602': '选取了重复的文件',
        '-700': '图片格式错误',
        '-701': '内存错误',
        '-702': '文件太大'
    };
    var uploader_<?= $name ?> = new plupload.Uploader({
        runtimes: 'html5,flash,silverlight,html4',
        browse_button: 'pickfiles_<?= $name ?>', // you can pass an id...
        container: 'container_<?= $name ?>',
        file_data_name: 'UploadForm[file]',
        url: '<?= $upload_url; ?>',
        flash_swf_url: '<?= $bundle->baseUrl; ?>/js/Moxie.swf',
        silverlight_xap_url: '<?= $bundle->baseUrl; ?>/js/Moxie.xap',
        multipart_params: <?= json_encode($param) ?>,
        multi_selection: true, //是否可以在文件浏览对话框中选择多个文件
        //max_file_count: 6,
        //drop_element: 'filelist',
        //dragdrop: true,
        filters: {
            max_file_size: '2mb', //文件上传最大限制
            //prevent_duplicates: true, //不允许选取重复文件
            mime_types: [
                {title: 'files', extensions: '*'}
            ]
        },
        init: {
            PostInit: function () {
                $('#uploadfiles_<?= $name ?>').on('click', function () {
                    uploader_<?= $name ?>.start();
                    return false;
                });
            },
            FilesAdded: function (up, files) {
                var array = <?= json_encode(Yii::$app->params['image_extensions']); ?>;
                plupload.each(files, function (file) {
                    var ext = getFileName(file.name);
                    var img = array.indexOf(ext) > -1 ? 'waiting-generic.png' : 'not_available-generic.png';
                    var upload_str = '<div class="upload_div" id="upload_div' + file.id + '"><div class="progress_div"><div class="progress" id="progress' + file.id + '"><div id="bar' + file.id + '" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;"></div></div></div><img id="img' + file.id + '" src="<?= $bundle->baseUrl; ?>/img/' + img + '" width="130px" height="100px" alt="' + file.name + '"><div class="upload_title">' + file.name + '</div><div class="upload_size">' + plupload.formatSize(file.size) + ' <span class="delete" onClick="javascript:deleteFileMsg<?= $name ?>(\'' + file.id + '\');" style="display:none;" id="delete' + file.id + '" data-val="' + file.id + '">删除</span><span class="cancel" onClick="javascript:cancelMsg(\'' + file.id + '\');" id="cancel' + file.id + '" data-val="' + file.id + '"></span></div></div>';
                    $('#filelist_<?= $name ?>').append(upload_str);
                });
            },
            UploadProgress: function (up, file) {
                $('#bar' + file.id).attr('aria-valuenow', file.percent);
                $('#bar' + file.id).css('width', file.percent + '%');

            },
            BeforeUpload: function (up, file) {
                $('#progress' + file.id).css('visibility', 'visible');
                $('#pickfiles_<?= $name ?>').prop('disabled', true);
                $('#uploadfiles_<?= $name ?>').prop('disabled', true);
                //提交表单按钮禁止点击
                var btn = $('.form-ajax').find('button[type=submit]').last();
                if (btn.length > 0) {
                    btn.prop('disabled', true);
                }
            },
            FileUploaded: function (up, file, response) {
                var res = $.parseJSON(response.response);
                $('#progress' + file.id).fadeOut('slow').css('visibility', 'hidden');
                if (res.error === 0) {
                    var upload_picture_path = $('#upload_<?= $name ?>').val();//获取文件路径值
                    if (upload_picture_path) {//如果有值就格式化为数组
                        var array = upload_picture_path.split(',');
                    } else {
                        var array = new Array();//为空就新建数组对象
                    }
                    array.push(res.fileurl);//把上传成功后的文件路径加入数组
                    $('#upload_<?= $name ?>').val(array.join(','));//把数组希尔字段之中以供保存到数据库中
                    $('#img' + file.id).attr('src', res.thumb).attr('data-path', res.fileurl);
                    //去除取消按钮
                    $('#cancel' + file.id).remove();
                    //显示删除按钮
                    $('#delete' + file.id).css('display', 'block');
                } else {
                    $('#upload_div' + file.id).remove();
                    bootbox.alert(res.message);
                }
            },
            UploadComplete: function (up, files) {
                $('#pickfiles_<?= $name ?>').prop('disabled', false);
                $('#uploadfiles_<?= $name ?>').prop('disabled', false);
                //提交表单按钮恢复可以点击
                var btn = $('.form-ajax').find('button[type=submit]').last();
                if (btn.length > 0) {
                    btn.prop('disabled', false);
                }
            },
            Error: function (up, err) {
                bootbox.alert('错误提示：' + message[err.code]);
            }
        }
    });
    uploader_<?= $name ?>.init();
    //获取文件名
    function getFileName(o) {
        var pos = o.lastIndexOf('.');
        return o.substring(pos + 1);
    }

    function cancelMsg(id) {
        $('#upload_div' + id).remove();
    }
    function deleteFileMsg<?= $name ?>(id) {
        bootboxConfirm(function (result) {
            if (result) {
                //删除参数
                var data = <?= json_encode($param) ?>;
                var path = $('#img' + id).attr('data-path');
                data['path'] = path;
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: '<?= $delete_url; ?>',
                    data: data,
                    success: function (result) {
                        if (result.status === 1) {
                            //更新本次提交的文件路径
                            var array = $('#upload_<?= $name ?>').val().split(',');//已上传文件路径
                            $.each(array, function (i, n) {
                                if (path === n) {
                                    array.splice(i, 1);//从已上传的文件路径中移除
                                }
                            });
                            $('#upload_<?= $name ?>').val(array.join());//更新上传文件路径的字段值
                            $('#upload_div' + id).remove();
                            bootbox.hideAll();
                        }
                    }, error: function (xhr) {
                        bootbox.alert('错误提示：' + xhr.statusText);
                    }
                });
            } else {
                bootbox.hideAll();
            }
        });
    }
</script>
