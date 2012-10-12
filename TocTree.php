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

$wgExtensionCredits['parserhook']['TocTree'] = array(
	'path' => __FILE__,
	'name' => 'TocTree',
	'url' => 'http://www.wikivoyage.org/tech/TocTree_extension',
	'descriptionmsg' => 'toctree-desc',
	'author' => 'Roland Unger',
	'version' => '1.1'
);

$commonModuleInfo = array(
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'TocTree/modules',
);
$wgResourceModules['ext.toctree'] = array(
	'styles' => 'ext.toctree.css',
	'scripts' => 'ext.toctree.js',
) + $commonModuleInfo;
$wgResourceModules['ext.toctree.collapsed'] = array(
	'styles' => 'ext.toctree.collapsed.css',
) + $commonModuleInfo;
$wgResourceModules['ext.toctree.floated'] = array(
	'styles' => 'ext.toctree.floated.css',
) + $commonModuleInfo;

$wgHooks['BeforePageDisplay'][] = 'wfTocTreeParserOutput';
$wgHooks['MakeGlobalVariablesScript'][] = 'wfTocTreeGlobalVars';
$wgHooks['GetPreferences'][] = 'onTocPreferences';

/**
 * Hook: BeforePageDisplay
 *
 * @param $out OutputPage
 * @return bool
 */
function wfTocTreeParserOutput( &$out )  {
	if ( $out->getUser()->getOption('toc-floated', false ) ) {
		$out->addModuleStyles( 'ext.toctree.floated' );
	}
	if ( !$out->getUser()->getOption('toc-expand', false ) ) {
		$out->addModuleStyles( 'ext.toctree.collapsed' );
	}

	$out->addModules( 'ext.toctree' );
	return true;
}

/**
 * Hook: MakeGlobalVariablesScript
 *
 * @param $vars array
 * @param $out OutputPage
 * @return bool
 */
function wfTocTreeGlobalVars( &$vars, $out ) {
	global $wgUser;
	$vars['tocTreeExpandMsg'] = wfMsg( 'showtoc' );
	$vars['tocTreeCollapseMsg'] = wfMsg( 'hidetoc' );
	$vars['tocTreeCollapsed'] = $out->getUser()->getOption('toc-floated', false );
	$vars['tocTreeFloatedToc'] = !$out->getUser()->getOption('toc-expand', false );
	return true;
}

/**
 * Hook: GetPreferences
 *
 * @param $user User
 * @param $preferences array
 * @return bool
 */
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
