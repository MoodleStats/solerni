<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\SimplePageBuilder;

use Piwik\Settings\SystemSetting;

class Settings extends \Piwik\Plugin\Settings
{
    /**
     * @var SystemSetting
     */
    public $menuTitle;

    /**
     * @var SystemSetting
     */
    public $content;

    protected function init()
    {
        $this->setIntroduction('This plugin lets you manage a custom page to display information to Piwik users.');
        $this->createMenuTitleSetting();
        $this->createDescriptionSetting();
    }

    private function createMenuTitleSetting()
    {
        $this->menuTitle = new SystemSetting('title', 'Title of the link');
        $this->menuTitle->readableByCurrentUser = true;
        $this->menuTitle->uiControlType = static::CONTROL_TEXT;
        $this->menuTitle->defaultValue  = 'Custom page';

        $this->addSetting($this->menuTitle);
    }

    private function createDescriptionSetting()
    {
        $this->content = new SystemSetting('content', 'Content of the page');
        $this->content->readableByCurrentUser = true;
        $this->content->uiControlType = static::CONTROL_TEXTAREA;
        $this->content->defaultValue  = '<h2>Welcome to Piwik!</h2>
Edit this text and write here your message that all users will have quick access to. HTML is supported. ';

        $this->content->description = <<<TEXT
You can use the following placeholders in your text: {date}, {period}, {idSite}, {token_auth}, {siteName} and {siteMainUrl}.
TEXT;

        $this->addSetting($this->content);
    }
}
