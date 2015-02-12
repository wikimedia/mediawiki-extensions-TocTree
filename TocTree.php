<?php
/*
 * Setup and Hooks for the TocTree extension
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

// extension i18n
$wgMessagesDirs['TocTree'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['TocTree'] = __DIR__ . '/TocTree.i18n.php';

// autoloader
$wgAutoloadClasses['TocTreeHooks'] = __DIR__ . '/TocTree.hooks.php';

// hooks
$wgHooks['BeforePageDisplay'][] = 'TocTreeHooks::wfTocTreeParserOutput';
$wgHooks['GetPreferences'][] = 'TocTreeHooks::onTocPreferences';

// default user options
$wgDefaultUserOptions['toc-floated'] = false;
$wgDefaultUserOptions['toc-expand'] = false;

// resources
$wgResourceModules['ext.toctree'] = array(
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'TocTree/modules',
	'styles' => 'ext.toctree.css',
	'scripts' => 'ext.toctree.js',
);

// credits
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'TocTree',
	'url' => '//www.mediawiki.org/wiki/Extension:TocTree',
	'descriptionmsg' => 'toctree-desc',
	'author' => array( 'Roland Unger', 'Matthias Mullie' ),
	'version' => '1.12.0',
	'license-name' => 'GPL-2.0+'
);
