<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\SimplePageBuilder;

use Piwik\Menu\MenuTop;

class Menu extends \Piwik\Plugin\Menu
{
    public function configureTopMenu(MenuTop $menu)
    {
        $settings = new Settings();
        $title = $settings->menuTitle->getValue();

        $menu->addItem($title, null, $this->urlForDefaultAction());
    }
}
