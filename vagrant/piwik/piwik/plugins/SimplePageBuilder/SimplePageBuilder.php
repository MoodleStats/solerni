<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\SimplePageBuilder;

use Piwik\Plugin;

class SimplePageBuilder extends Plugin
{
    public function getListHooksRegistered()
    {
        return array(
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
        );
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/SimplePageBuilder/stylesheets/style.less";
        $stylesheets[] = "plugins/CoreHome/stylesheets/coreHome.less";
        $stylesheets[] = "plugins/Dashboard/stylesheets/dashboard.less";
    }
}
