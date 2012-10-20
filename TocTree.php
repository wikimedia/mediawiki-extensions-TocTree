<?php
/*
 * Setup and Hooks for the TocTree extension for the Wikivoyage project
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Roland Unger
 * @copyright Copyright © 2007 - 2012 Roland Unger
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

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

$dir = __DIR__ . '/';
$wgAutoloadClasses['TocTreeHooks'] = $dir . 'TocTree.hooks.php';
$wgExtensionMessagesFiles['TocTree'] = $dir . 'TocTree.i18n.php';

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

$wgHooks['BeforePageDisplay'][] = 'TocTreeHooks::parserOutput';
$wgHooks['MakeGlobalVariablesScript'][] = 'TocTreeHooks::globalVars';
$wgHooks['GetPreferences'][] = 'TocTreeHooks::preferences';
