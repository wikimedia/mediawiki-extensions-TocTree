<?php

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'TocTree' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['TocTree'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for TocTree extension. ' .
		'Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the TocTree extension requires MediaWiki 1.32+' );
}
