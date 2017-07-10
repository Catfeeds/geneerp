<textarea id="<?= $id; ?>" name="<?= $name; ?>" style="width:100%;height:<?= $height; ?>;visibility:hidden;"><?= htmlspecialchars($value); ?></textarea>
<p>您当前输入了 <span id="<?= $id; ?>_word_count">0</span> 个文字（包含HTML代码）</p>
<script>
    KindEditor.ready(function (K) {
        K.create('textarea[id="<?= $id; ?>"]', {
        filePostName :'UploadForm[file]', //上传的控件name
                uploadJson: '<?= $upload_url; ?>',
                extraFileUploadParams:<?= json_encode($param) ?>,
                autoHeightMode:true,
                afterCreate:function () {
                    this.sync();
                    this.loadPlugin('autoheight');
                },
                afterUpload : function (url) {
                    console.log(url);
                    //编辑上传允许上传的目录
                    var ary = <?= json_encode(Yii::$app->params['editor_dir']); ?>;
                    for (var i = 0; i < ary.length; i++) {
                        var find_str = ary[i] + '/';
                        if (url.indexOf(find_str) !== -1) {
                            //console.log(url.substring(url.indexOf(find_str)));
                            var input = '<input name="content_' + ary[i] + '[]" type="hidden" value="' + url.substring(url.indexOf(find_str)) + '">';
                            $('.editer_form').append(input);
                            break;
                        }
                    }
                },
                afterChange : function () {
                    K('#<?= $id; ?>_word_count').html(this.count());
                },
                filterMode : false, //关闭过滤模式，保留所有标签
                afterBlur: function () {
                    this.sync(); //如果发现有定义编辑器需要先同步后再提交否则获取不到编辑器内容
                },
                items: [
                        'source', 'fontsize', '|', 'undo', 'redo', '|', 'plainpaste', 'wordpaste', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                        'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                        'insertunorderedlist', '|',<?= $upload_url ? "'image', 'multiimage','flash', 'media', 'insertfile', '|'," : ''; ?>  'link', 'unlink', 'clearhtml', 'baidumap', 'fullscreen']
    });
    });
</script>