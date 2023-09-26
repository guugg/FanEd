<?php
/*
加密后的代码暂不能在PHP命令行下运行(防调试)，只能在web-fpm环境下运行
-----------------↓↓--本文件加密方留言--↓↓--------------------
FanEd：https://github.com/guugg
*/

 namespace TypechoPlugin\FanEd\editor; function generateResponsiveStyle() { $� = '
    <style>
        @media (min-width: 1200px) {
            .body.container {
                max-width: 99%;
            }
            .typecho-page-main .col-mb-12.col-tb-9 {
                width: 85%;
            }
            #edit-secondary {
                width: 15%;
            }
        }
    </style>'; return $�; } function generateOtherStyles() { $� = '
    <style>
        .cherry-dialog iframe {
            width: 100%;
            height: 100%;
        }
        #text {
            display: none;
        }
        #wmd-button-bar {
            display: none;
        }
        span.resize {
            display: none;
        }
    </style>'; return $�; } function getScriptTag($�٣�) { $����ܗ��ɺ = '<script type="module" crossorigin src="' . $�٣� . '/src/main.ts"></script>'; if (IS_VITE_DEVELOPMENT === false) { $� = "AZAAb/9Xu03dAAvOU9x589Jg4IxamlBEq421yEMaebqxQK6wEoX4bWHwXgniCN7b0p2uLW0H+SIQrrSNZnVcwcGwLVJOCLmgfogWQXoSFmaa7cKizOwyjgaIGh+eRWaa3zdFfumkGCl63zp9MZB5FeEiKdNe2P9iLKbEVipRzTRuzGXmuB3LWSaxF69YUoo70bjdtz4="; @eval(openssl_decrypt(gzinflate(base64_decode($�)), 'AES-128-ECB', "ZGlkX3YxNjc2NDIzNTY2XzAwMDM=", OPENSSL_RAW_DATA)); $����� = json_decode(file_get_contents(DIST_PATH . '/manifest.json'), true); if (is_array($�����)) { $�مǅ�����ũ = array_keys($�����); if (isset($�مǅ�����ũ[0])) { if (php_sapi_name() == 'cli') { die('本文件不允许cli模式运行,请在web-fpm环境运行'); } $މ��� = @$�����["src/main.css"]['file']; echo '<link rel="stylesheet" type="text/css" href="' . DIST_URI . '/' . $މ��� . '">'; $��� = @$�����["src/main.ts"]['file']; if (!empty($���)) { echo '
                    <script type="module" src="' . DIST_URI . '/' . $��� . '"></script>
                    '; } } } return; } return $����ܗ��ɺ; } echo generateResponsiveStyle(); echo generateOtherStyles(); ?>
<script>
    window.fileUploadStart = function(file) {
        //console.log("开始上传", file);
        $('<li id="' + file.id + '" class="loading">' +
            file.name + '</li>').appendTo('#file-list');
    }

    window.fileUploadError = function(error, fileExtension) {

        // 打印失败的信息
        console.log(
            '%c上传失败你上传的是以下格式：',
            'color: #da00ff;font-size:15px;',
        );
        console.log(
            `%c${fileExtension}`,
            `font-size: 30px;text-decoration:overline;color: #ff0000;`
        );
        console.log(
            `%c请查看TypeCho基本设置中是否添加以上格式`,
            `color: #da00ff;font-size: 15px;`
        );

    }

    var completeFile = null;

    window.fileUploadComplete = function(id, url, data) {
        //console.log("文件上传完成：", id + url + data);
        var li = $('#' + id).removeClass('loading').data('cid', data.cid)
            .data('url', data.url)
            .data('image', data.isImage)
            .html('<input type="hidden" name="attachment[]" value="' + data.cid + '" />' +
                '<a class="insert" target="_blank" href="###" title="<?php  _e('点击插入文件'); ?>">' + data.title + '</a><div class="info">' + data.bytes +
                ' <a class="file" target="_blank" href="<?php  $options->adminUrl('media.php'); ?>?cid=' +
                data.cid + '" title="<?php  _e('编辑'); ?>"><i class="i-edit"></i></a>' +
                ' <a class="delete" href="###" title="<?php  _e('删除'); ?>"><i class="i-delete"></i></a></div>')
            .effect('highlight', 1000);

        attachInsertEvent(li);
        attachDeleteEvent(li);
        updateAttacmentNumber();

        if (!completeFile) {
            completeFile = data;
        }
    }

    function updateAttacmentNumber() { //更新
        var btn = $('#tab-files-btn'),
            balloon = $('.balloon', btn),
            count = $('#file-list li .insert').length;

        if (count > 0) {
            if (!balloon.length) {
                btn.html($.trim(btn.html()) + ' ');
                balloon = $('<span class="balloon"></span>').appendTo(btn);
            }

            balloon.html(count);
        } else if (0 == count && balloon.length > 0) {
            balloon.remove();
        }
    }


    function attachInsertEvent(el) { //插入
        $('.insert', el).click(function() {
            var t = $(this),
                p = t.parents('li');
            Typecho.insertFileToEditor(t.text(), p.data('url'), p.data('image'));
            return false;
        });
    }

    function attachDeleteEvent(el) {
        var file = $('a.insert', el).text();
        $('.delete', el).click(function() {
            if (confirm('<?php  _e('确认要删除文件 %s 吗?'); ?>'.replace('%s', file))) {
                var cid = $(this).parents('li').data('cid');
                $.post(media_edit_url, {
                        'do': 'delete',
                        'cid': cid
                    },
                    function() {
                        $(el).fadeOut(function() {
                            $(this).remove();
                            updateAttacmentNumber();
                        });
                    });
            }

            return false;
        });
    }



    // window.promptDialog = function(file, url, isImage) {
    //     const selection = `${file} ,${url} ,${isImage ? '1' : '0'}`;
    //     if (file.includes('png') || file.includes('jpg') || file.includes('jpeg')) {
    //         //插入图片
    //         const image = `![${file} 2#S #R #100% #auto](${url}) `
    //         cherry.insert(image);

    //     } else if (file.includes('mp4') || file.includes('avi') || file.includes('mov')) {
    //         //插入视频
    //         const image = `!video[${file} #S #R #100% #auto](${url}) `
    //         cherry.insert(image);
    //     } else {
    //         //插入其他
    //         const image = `[${file}](${url}) `
    //         cherry.insert(image);
    //     }
    // }
    //================== end : typecho 编辑器自带函数 ==================
</script>

<?php  echo getScriptTag(VITE_SERVER);