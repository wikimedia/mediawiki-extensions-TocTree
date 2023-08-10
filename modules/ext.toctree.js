/**
 * JavaScript functions for the TocTree extension
 * to display the toc structure
 *
 * @package MediaWiki
 * @author Roland Unger
 * @author Matthias Mullie
 * @copyright © 2007 Roland Unger
 * v1.0 of 2007/11/04
 * @license GPL-2.0-or-later
 */

( function () {
	function processClickEvent() {
		var $ul = $( this ).parent().parent().children( 'ul' );
		$ul.toggle();

		if ( $ul.css( 'display' ) !== 'none' ) {
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

					$subList.css( 'display', '' );
				} else {
					$toggleSymbol
						.text( '+' )
						.attr( 'title', mw.msg( 'showtoc' ) );

					$subList.css( 'display', 'none' );
				}
				$toggleSymbol.on( 'click', processClickEvent );

				$toggleSpan = $( '<span>' ).addClass( 'toggleNode' );
				$toggleSpan.append( '[', $toggleSymbol, ']' );

				$( this ).prepend( $toggleSpan );
			}
		} );
	}

	mw.hook( 'wikipage.content' ).add( init );
}() );
