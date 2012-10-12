<?php

/*
 * Setup and Hooks for the TocTree extension for the Wikivoyage project
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Roland Unger
 * @copyright Copyright © 2007 - 2012 Roland Unger
 * v 1.02 of 2012/08/30
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * v 1.01: Adding extension description
 * v 1.02: Adapting to v 1.20
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

# Internationalisation file
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['TocTree'] = $dir . 'TocTree.i18n.php';

# Default user options
$wgDefaultUserOptions ['toc-floated'] = false;
$wgDefaultUserOptions ['toc-expand'] = false;

$wgExtensionFunctions[] = 'wfSetupTocTree';

$wgExtensionCredits['parserhook']['TocTree'] = array(
	'path' => __FILE__,
	'name' => 'TocTree',
	'url' => 'http://www.wikivoyage.org/tech/TocTree_extension',
	'description' => 'Extension for the expansion and collapsing of the table of contents',
	'descriptionmsg' => 'toctree-desc',
	'author' => 'Roland Unger',
	'version' => '1.02' );

$wgHooks['BeforePageDisplay'][] = 'wfTocTreeParserOutput';

function wfTocTreeParserOutput( &$out )  {
	global $wgScriptPath, $wgOut, $wgUser, $wgJsMimeType;

	$wgOut->addLink(
		array(
			'rel' => 'stylesheet',
			'type' => 'text/css',
			'href' => $wgScriptPath . '/extensions/TocTree/TocTree.css'
		)
	);

	if ($wgUser->getOption('toc-floated', false)) {
		$floated = "true";
		$wgOut->addLink(
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => $wgScriptPath . '/extensions/TocTree/TocTreeFloated.css'
			)
		);
	}
	else $floated = "false";
	if ($wgUser->getOption('toc-expand', false)) $collapsed = "false";
	else {
		$collapsed = "true";
		$wgOut->addLink(
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => $wgScriptPath . '/extensions/TocTree/TocTreeCollapsed.css'
			)
		);
	}

	$wgOut->addScript( 
		"<script type=\"{$wgJsMimeType}\">" .
		"var tocTreeExpandMsg = \"" . Xml::escapeJsString(wfMsg('showtoc')) . "\"; " .
		"var tocTreeCollapseMsg = \"" . Xml::escapeJsString(wfMsg('hidetoc')) . "\"; " .
		"var tocTreeCollapsed = " . $collapsed . "; " .
		"var tocTreeFloatedToc = " . $floated . ";" .
		"</script>\n" 
	);

	$wgOut->addScript( 
		"<script type=\"{$wgJsMimeType}\" src=\"{$wgScriptPath}/extensions/TocTree/TocTree.js\">" .
		"</script>\n" 
	);

	return true;
}

function onTocPreferences( $user, &$preferences ) {

	$preferences['toc-expand'] = array(
		'type' => 'toggle',
		'label-message' => 'tog-toc-expand',
		'section' => 'misc/toctree',
	);

	$preferences['toc-floated'] = array(
		'type' => 'toggle',
		'label-message' => 'tog-toc-floated',
		'section' => 'misc/toctree',
	);

	return true;
}
 
function wfSetupTocTree() {
	global $wgHooks;

	$wgHooks['GetPreferences'][] = 'onTocPreferences';
	return true;
}

?>