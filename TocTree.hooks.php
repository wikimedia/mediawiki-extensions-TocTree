<?php

/**
 * Some hooks for TocTree extension.
 */
class TocTreeHooks {
	/**
	 * Hook: BeforePageDisplay
	 *
	 * @param OutputPage $out
	 * @return bool
	 */
	public static function wfTocTreeParserOutput( OutputPage &$out ) {
		if ( $out->isTOCEnabled() ) {
			$out->addModules( 'ext.toctree' );
		}

		return true;
	}

	/**
	 * Hook: GetPreferences
	 *
	 * @param User $user
	 * @param array $preferences
	 * @return bool
	 */
	public static function onTocPreferences( User $user, array &$preferences ) {
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

		return true;
	}
}
