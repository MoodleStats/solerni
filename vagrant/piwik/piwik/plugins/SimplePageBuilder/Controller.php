<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\SimplePageBuilder;

use Piwik\Common;
use Piwik\Piwik;
use Piwik\View;

class Controller extends \Piwik\Plugin\Controller
{
    public function index()
    {
        $settings = new Settings();
        $pageContent = $settings->content->getValue();

        $pageContent = $this->replacePlaceholders($pageContent);

        return $this->renderTemplate('index', array(
            'content' => $pageContent,
        ));
    }

    private function replacePlaceholders($pageContent)
    {
        $values = array(
            '{date}'        => Common::getRequestVar('date'),
            '{period}'      => Common::getRequestVar('period'),
            '{idSite}'      => $this->site->getId(),
            '{token_auth}'  => Piwik::getCurrentUserTokenAuth(),
            '{siteName}'    => $this->site->getName(),
            '{siteMainUrl}' => $this->site->getMainUrl(),
        );

        $pageContent = str_replace(array_keys($values), $values, $pageContent);

        return $pageContent;
    }
}
