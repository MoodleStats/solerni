<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    tool_xmldb
 * @copyright  2003 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Main xmldb action clasee
 *
 * Main xmldb action class. It implements all the basic
 * functionalities to be shared by each action.
*
* @package    tool_xmldb
* @copyright  2003 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
* @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
class XMLDBAction {

	/** @var bool Type of value returned by the invoke method, ACTION_GENERATE_HTML have contents to show, set by each specialized invoke*/
	protected $does_generate;

	/** @var string Title of the Action (class name, by default), set by parent init automatically*/
	protected $title;

	/** @var string Strings used by the action set by each specialized init, calling loadStrings*/
	protected $str;

	/** @var string  Output of the action, set by each specialized invoke, get with getOutput*/
	protected $output;

	/** @var string Last Error produced. Check when any invoke returns false, get with getError*/
	protected $errormsg;

	/** @var string Action to execute at the end of the invoke script*/
	protected $postaction;

	/** @var bool Actions must be protected by sesskey mechanism*/
	protected $sesskey_protected;

	/**
	 * Constructor
	 */
	function __construct() {
		$this->init();
	}

	/**
	 * Init method, every subclass will have its own,
	 * always calling the parent one
	 */
	function init() {
		$this->does_generate = ACTION_NONE;
		$this->title     = strtolower(get_class($this));
		$this->str       = array();
		$this->output    = NULL;
		$this->errormsg  = NULL;
		$this->subaction = NULL;
		$this->sesskey_protected = true;
	}

	/**
	 * Returns the type of output of the file
	 * @return bool
	 */
	function getDoesGenerate() {
		return $this->does_generate;
	}

	/**
	 * getError method, returns the last error string.
	 * Used if the invoke() methods returns false
	 * @return string
	 */
	function getError() {
		return $this->errormsg;
	}

	/**
	 * getOutput method, returns the output generated by the action.
	 * Used after execution of the invoke() methods if they return true
	 * @return string
	 */
	function getOutput() {
		return $this->output;
	}

	/**
	 * getPostAction method, returns the action to launch after executing
	 * another one
	 * @return string
	 */
	function getPostAction() {
		return $this->postaction;
	}

	/**
	 * getTitle method returns the title of the action (that is part
	 * of the $str array attribute
	 * @return string
	 */
	function getTitle() {
		return $this->str['title'];
	}

	/**
	 * loadStrings method, loads the required strings specified in the
	 * array parameter
	 * @param string[] $strings
	 */
	function loadStrings($strings) {
		// Load some commonly used strings
		if (get_string_manager()->string_exists($this->title, 'tool_xmldb')) {
			$this->str['title'] = get_string($this->title, 'tool_xmldb');
		} else {
			$this->str['title'] = $this->title;
		}

		// Now process the $strings array loading it in the $str atribute
		if ($strings) {
			foreach ($strings as $key => $module) {
				$this->str[$key] = get_string($key, $module);
			}
		}
	}

	/**
	 * main invoke method, it sets the postaction attribute
	 * if possible and checks sesskey_protected if needed
	 */
	function invoke() {

		global $SESSION;

		// Sesskey protection
		if ($this->sesskey_protected) {
			require_sesskey();
		}

		// If we are used any dir, save it in the lastused session object
		// Some actions can use it to perform positioning
		if ($lastused = optional_param ('dir', NULL, PARAM_PATH)) {
			$SESSION->lastused = $lastused;
		}

		$this->postaction = optional_param ('postaction', NULL, PARAM_ALPHAEXT);
		// Avoid being recursive
		if ($this->title == $this->postaction) {
			$this->postaction = NULL;
		}
	}

	/**
	 * launch method, used to easily call invoke methods between actions
	 * @param string $action
	 * @return mixed
	 */
	function launch($action) {

		global $CFG;

		// Get the action path and invoke it
		$actionsroot = "$CFG->dirroot/$CFG->admin/tool/xmldb/actions";
		$actionclass = $action . '.class.php';
		$actionpath = "$actionsroot/$action/$actionclass";

		// Load and invoke the proper action
		$result = false;
		if (file_exists($actionpath) && is_readable($actionpath)) {
			require_once($actionpath);
			if ($xmldb_action = new $action) {
				$result = $xmldb_action->invoke();
				if ($result) {
					if ($xmldb_action->does_generate != ACTION_NONE &&
							$xmldb_action->getOutput()) {
						$this->does_generate = $xmldb_action->does_generate;
						$this->title = $xmldb_action->title;
						$this->str = $xmldb_action->str;
						$this->output .= $xmldb_action->getOutput();
					}
				} else {
					$this->errormsg = $xmldb_action->getError();
				}
			} else {
				$this->errormsg = "Error: cannot instantiate class (actions/$action/$actionclass)";
			}
		} else {
			$this->errormsg = "Error: wrong action specified ($action)";
		}
		return $result;
	}

	/**
	 * This function will generate the PHP code needed to
	 * implement the upgrade_xxxx_savepoint() php calls in
	 * upgrade code generated from the editor. It's used by
	 * the view_structure_php and view_table_php actions
	 *
	 * @param xmldb_structure structure object containing all the info
	 * @return string PHP code to be used to mark a reached savepoint
	 */
	function upgrade_savepoint_php($structure) {
		global $CFG;

		// NOTE: $CFG->admin !== 'admin' is not supported in XMLDB editor, sorry.

		$path = $structure->getPath();
		$plugintype = 'error';

		if ($path === 'lib/db') {
			$plugintype = 'lib';
			$pluginname = null;

		} else {
			$path = dirname($path);
			$pluginname = basename($path);
			$path = dirname($path);
			$plugintypes = core_component::get_plugin_types();
			foreach ($plugintypes as $type => $fulldir) {
				if ($CFG->dirroot.'/'.$path === $fulldir) {
					$plugintype = $type;
					break;
				}
			}
		}

		$result = '';

		switch ($plugintype ) {
			case 'lib': // has own savepoint function
				$result = XMLDB_LINEFEED .
				'        // Main savepoint reached.' . XMLDB_LINEFEED .
				'        upgrade_main_savepoint(true, XXXXXXXXXX);' . XMLDB_LINEFEED;
				break;
			case 'mod': // has own savepoint function
				$result = XMLDB_LINEFEED .
				'        // ' . ucfirst($pluginname) . ' savepoint reached.' . XMLDB_LINEFEED .
				'        upgrade_mod_savepoint(true, XXXXXXXXXX, ' . "'$pluginname'" . ');' . XMLDB_LINEFEED;
				break;
			case 'block': // has own savepoint function
				$result = XMLDB_LINEFEED .
				'        // ' . ucfirst($pluginname) . ' savepoint reached.' . XMLDB_LINEFEED .
				'        upgrade_block_savepoint(true, XXXXXXXXXX, ' . "'$pluginname'" . ');' . XMLDB_LINEFEED;
				break;
			default: // rest of plugins
				$result = XMLDB_LINEFEED .
				'        // ' . ucfirst($pluginname) . ' savepoint reached.' . XMLDB_LINEFEED .
				'        upgrade_plugin_savepoint(true, XXXXXXXXXX, ' . "'$plugintype'" . ', ' . "'$pluginname'" . ');' . XMLDB_LINEFEED;
		}
		return $result;
	}
}
