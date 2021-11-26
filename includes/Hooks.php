<?php

/**
 * Some hooks for TocTree extension.
 */

namespace MediaWiki\Extension\TocTree;

use OutputPage;
use User;

class Hooks {
	/**
	 * Hook: BeforePageDisplay
	 *
	 * @param OutputPage $out OutputPage object
	 */
	public static function onBeforePageDisplay( OutputPage $out ) {
		if ( $out->isTOCEnabled() ) {
			$out->addModules( 'ext.toctree' );
		}
	}

	/**
	 * Hook: GetPreferences
	 *
	 * @param User $user User whose preferences are being modified
	 * @param array &$preferences Preferences description array
	 */
	public static function onGetPreferences( User $user, array &$preferences ) {
		$preferences['toc-expand'] = [
			'type' => 'toggle',
			'label-message' => 'toctree-tog-expand',
			'section' => 'misc/toctree',
		];

		$preferences['toc-floated'] = [
			'type' => 'toggle',
			'label-message' => 'toctree-tog-floated',
			'section' => 'misc/toctree',
		];
	}
}
