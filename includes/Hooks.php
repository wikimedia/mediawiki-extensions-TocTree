<?php

/**
 * Some hooks for TocTree extension.
 */

namespace MediaWiki\Extension\TocTree;

use MediaWiki\Hook\BeforePageDisplayHook;
use MediaWiki\Preferences\Hook\GetPreferencesHook;
use OutputPage;
use Skin;
use User;

class Hooks implements
	BeforePageDisplayHook,
	GetPreferencesHook
{
	/**
	 * Hook: BeforePageDisplay
	 *
	 * @param OutputPage $out OutputPage object
	 * @param Skin $skin Skin object
	 */
	public function onBeforePageDisplay( $out, $skin ): void {
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
	public function onGetPreferences( $user, &$preferences ) {
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
