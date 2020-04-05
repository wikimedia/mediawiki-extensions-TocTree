/**
 * JavaScript functions for the TocTree extension
 * to display the toc structure
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Roland Unger
 * @author Matthias Mullie
 * @copyright © 2007 Roland Unger
 * v1.0 of 2007/11/04
 * @licence GPL-2.0-or-later
 */

( function () {
	function processClickEvent() {
		var $ul = $( this ).parent().parent().children( 'ul' );
		$ul.toggle();

		if ( $ul.is( ':visible' ) ) {
			$( this )
				.text( '−' )
				.attr( 'title', mw.msg( 'hidetoc' ) );
		} else {
			$( this )
				.text( '+' )
				.attr( 'title', mw.msg( 'showtoc' ) );
		}
	}

	function init( $content ) {
		var $toc = $content.find( '.toc' ).addBack( '.toc' ),
			$mainList = $toc.children( 'ul' ).children( 'li.toclevel-1' );

		if ( mw.user.options.get( 'toc-floated' ) ) {
			$toc.addClass( 'tocFloat' );
		}

		$mainList.each( function () {
			var $subList, $toggleSymbol, $toggleSpan;

			$( this ).css( 'position', 'relative' );
			$subList = $( this ).children( 'ul' );

			if ( $subList.length > 0 ) {
				$( this ).parent().addClass( 'tocUl' );

				$toggleSymbol = $( '<span>' ).addClass( 'toggleSymbol' );

				if ( mw.user.options.get( 'toc-expand' ) ) {
					$toggleSymbol
						.text( '−' )
						.attr( 'title', mw.msg( 'hidetoc' ) );

					$subList.show();
				} else {
					$toggleSymbol
						.text( '+' )
						.attr( 'title', mw.msg( 'showtoc' ) );

					$subList.hide();
				}
				$toggleSymbol.click( processClickEvent );

				$toggleSpan = $( '<span>' ).addClass( 'toggleNode' );
				$toggleSpan.append( '[', $toggleSymbol, ']' );

				$( this ).prepend( $toggleSpan );
			}
		} );
	}

	mw.hook( 'wikipage.content' ).add( init );
}() );
