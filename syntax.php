<?php
/**
 * Bugzilla-links syntax plugin for DokuWiki
 *
 * @author Antonin Kral <a.kral@bobek.cz>
 * @author christian studer <christian.studer@meteotest.ch>
 * @license GPL2 http://www.gnu.org/licenses/gpl-2.0.html
 */

// Must be run within DokuWiki
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'syntax.php';

/**
 * The Bugzilla-links syntay plugin itself
 *
 * @author christian studer <christian.studer@meteotest.ch>
 */
class syntax_plugin_bugzillalinks extends DokuWiki_Syntax_Plugin {
	/**
	 * Gets plugin type
	 *
	 * @return string
	 */
	public function getType() {
		return 'substition';
	}

	/**
	 * Gets plugin sort order
	 *
	 * @return number
	 */
	public function getSort() {
		return 331; // Belongs to externallink somehow
	}


	/**
	 * Plugin mode connection
	 *
	 * @param string $mode
	 */
	public function connectTo($mode) {
		$this->Lexer->addSpecialPattern('[Bb]ug\s*\d+', $mode, 'plugin_bugzillalinks');
	}

	/**
	 * Match handling
	 *
	 * @param string $match
	 * @param string $state
	 * @param int $pos
	 * @param Doku_Handler $handler
	 * @return array
	 */
	public function handle($match, $state, $pos, Doku_Handler $handler){
        if ( preg_match('/^[Bb]ug\s*(\d+)$/', $match, $bugMatch) ) {
	      return array($match, $bugMatch[1]);
        }
        return array($match);
	}

	/**
	 * Render the output
	 *
	 * @param string $mode
	 * @param Doku_Renderer $renderer
	 * @param array $data
	 * @return boolean
	 */
	public function render($mode, Doku_Renderer $renderer, $data) {
		// Only render to xhtml
		if($mode != 'xhtml') return false;

		// Append the link to the issue
		$renderer->doc .= '<a class="bugzillalink" href="' . $this->getConf('bugzillaserver') . $data[1] . '">' . $data[0] . '</a>';

		return true;
	}
}
