<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Admin;
use Moosh\MooshCommand;

class EditorManage extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('manage', 'editor');
        $this->addArgument('action');
        $this->addArgument('editorname');
    }

    public function execute()
    {
        global $CFG;

        $action = $this->arguments[0];
        $editor = $this->arguments[1];

        // Get currently installed and enabled editors.
        $available_editors = editors_get_available();
        if (!empty($editor) and empty($available_editors[$editor])) {
            echo "The editor is not valid\n";
        }

        $active_editors = explode(',', $CFG->texteditors);
        foreach ($active_editors as $key=>$active) {
            if (empty($available_editors[$active])) {
                unset($active_editors[$key]);
            }
        }

        switch ($action) {
            case 'disable':
                // Remove from enabled list.
                if (in_array($editor, $active_editors)) {
                    $key = array_search($editor, $active_editors);
                    unset($active_editors[$key]);
                }
                break;

            case 'enable':
                // Add to enabled list.
                if (!in_array($editor, $active_editors)) {
                    $active_editors[] = $editor;
                    $active_editors = array_unique($active_editors);
                }
                break;

            case 'down':
                $key = array_search($editor, $active_editors);
                // Check auth plugin is valid.
                if ($key !== false) {
                    // Move down the list.
                    if ($key < (count($active_editors) - 1)) {
                        $fsave = $active_editors[$key];
                        $active_editors[$key] = $active_editors[$key + 1];
                        $active_editors[$key + 1] = $fsave;
                    }
                }
                break;

            case 'up':
                $key = array_search($editor, $active_editors);
                // Check auth is valid.
                if ($key !== false) {
                    // Move up the list.
                    if ($key >= 1) {
                        $fsave = $active_editors[$key];
                        $active_editors[$key] = $active_editors[$key - 1];
                        $active_editors[$key - 1] = $fsave;
                    }
                }
                break;

            default:
                echo "The action " . $action . " is not valid\n";
                break;
        }

        // At least one editor must be active.
        if (empty($active_editors)) {
            $active_editors = array('textarea');
        }

        set_config('texteditors', implode(',', $active_editors));
        \core_plugin_manager::reset_caches();
        echo "The editors valid are : ";
        foreach ($active_editors as $key=>$active) {
            echo $active . " ";
        }
        echo "\n";
    }
}
