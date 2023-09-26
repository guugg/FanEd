<?php

namespace TypechoPlugin\FanEd;


use Widget\Options;
use Typecho\Plugin;
use Typecho\Common;
use Typecho\Plugin\Exception;
use Utils\Helper;
use TypechoPlugin\FanEd\app\App_Post;


require_once 'app/App_Magic.php';

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

// 是否为开发环境  true  false
$options = Helper::options();
define('IS_VITE_DEVELOPMENT', false);
define('VITE_SERVER', 'http://localhost:3200');
define('DIST_DEF', 'assets');
define('ADMIN_URI',  $options->adminUrl);
define('DIST_URI',  $options->pluginUrl . '/faned/' . DIST_DEF);
define('DIST_PATH', $options->pluginDir     . '/faned/' . DIST_DEF);


class Magic
{
    /**
     * 获取插件 URL
     * @param string $uri URI
     * @return string
     */
    public static function pluginUrl($uri = "")
    {
        return Common::url($uri, Helper::options()->pluginUrl . '/FanEd');
    }

    /**
     * 激活插件
     * @return string
     * @throws Exception
     */
    public static function activate(): string
    {
        Plugin::factory('admin/menu.php')->navBar    = array(__class__, 'render');

        // 编辑器
        Plugin::factory('admin/write-post.php')->richEditor    = array(__class__, 'editorjs');
        Plugin::factory('admin/write-page.php')->richEditor    = array(__class__, 'editorjs');

        // markdown 引擎
        // Plugin::factory('Widget_Abstract_Contents')->markdown = array(__CLASS__, 'disableParser');
        Plugin::factory('Widget_Abstract_Contents')->content = array(__CLASS__, 'content');
        Plugin::factory('Widget_Abstract_Contents')->excerpt = array(__CLASS__, 'excerpt');

        // 添加自定义方法到header
        Plugin::factory('Widget_Archive')->header = array(__CLASS__, 'header');

        return _t("插件启用成功");
    }

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     */
    public static function render()
    {
        echo '<span class="message success">'
            . htmlspecialchars(Options::alloc()->plugin('FanEd')->word)
            . '</span>';
    }

    /**
     * 编辑器实现方法
     *
     * @access public
     * @return void
     */
    public static function editorjs($post)
    {



        $options = Helper::options();
        include 'editor/editor-api.php';
?>
        <script>
            window.uploadURL = '<?php Helper::security()->index('/action/upload?cid=CID'); ?>';
        </script>
<?php

    }

    // header方法
    public static function header()
    {
        return App_Post::psotheader();
    }

    public static function content($text)
    {

        return '<div id="fantext" style="display: none;">' . $text . '</div>'; // 此处保持原样不做处理，直接返回原始内容

    }

    public static function excerpt($text, $conent)
    {
        return '<div id="fantext" style="display: none;">' . $text . '</div>';
    }
}
