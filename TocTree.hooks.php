<?php

/**
 * Some hooks for TocTree extension.
 */
class TocTreeHooks {
	/**
	 * Hook: BeforePageDisplay
	 *
	 * @param $out OutputPage
	 * @return bool
	 */
	public static function parserOutput( &$out ) {
		if ( $out->getUser()->getOption( 'toc-floated', false ) ) {
			$out->addModuleStyles( 'ext.toctree.floated' );
		}
		if ( !$out->getUser()->getOption( 'toc-expand', false ) ) {
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
	public static function globalVars( &$vars, $out ) {
		$vars['tocTreeExpandMsg'] = $out->msg( 'showtoc' )->text();
		$vars['tocTreeCollapseMsg'] = $out->msg( 'hidetoc' )->text();
		$vars['tocTreeCollapsed'] = $out->getUser()->getOption( 'toc-floated', false );
		$vars['tocTreeFloatedToc'] = !$out->getUser()->getOption( 'toc-expand', false );
		return true;
	}

	/**
	 * Hook: GetPreferences
	 *
	 * @param $user User
	 * @param $preferences array
	 * @return bool
	 */
	public static function preferences( $user, &$preferences ) {
		$preferences['toc-expand'] = array(
			'type' => 'toggle',
			'label-message' => 'toctree-tog-expand',
			'section' => 'misc/toctree',
		);

		$preferences['toc-floated'] = array(
			'type' => 'toggle',
			'label-message' => 'toctree-tog-floated',
			'section' => 'misc/toctree',
		);

		return true;
	}
}
