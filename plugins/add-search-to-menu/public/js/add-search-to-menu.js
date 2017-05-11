
( function( $ ) {
"use strict";
	$(document).ready(function(){

		$( 'li.search-menu a' ).on( 'click', function( e ) {

			 // Cancel the default action
			e.stopPropagation();

			if ( $( this ).parent().parent().css( 'position' ) === 'static' ) {
				$( this ).parent().parent().css( 'position', 'relative' );
			}

			if ( $( this ).parent().hasClass( 'dropdown' ) ) {
				$( this ).parent().find( 'form' ).fadeToggle();
			} else if ( $( this ).parent().hasClass( 'sliding' ) ) {
				$( this ).parent().find( 'form' ).animate( { width:'300' } );
				$( this ).parent().find( 'form input[type="search"], form input[type="text"]' ).focus();
				$( this ).parent().addClass( 'open' );
			} else if ( $( this ).parent().hasClass( 'full-width-menu' ) ) {
				$( this ).parent().addClass('active-search');
				$( this ).parent().find( 'form' ).animate( { width:'100%' } );
				$( this ).parent().addClass( 'open' );
				$( this ).parent().find( 'form input[type="search"], form input[type="text"]' ).focus();
			}
		} );
	} );

	$( 'li.search-menu form input[type="search"], li.search-menu form input[type="text"]' ).on( 'click', function( e ) {
		 e.stopPropagation(); // This is the preferred method.
		return false;
	} );

	$( window ).click( function() {
		if ( $( 'li.search-menu' ).hasClass( 'open' ) ) {
			$( 'li.search-menu form' ).animate(
				{ width:'0' },
				400,
				function() {
					$( 'li.search-menu' ).removeClass( 'active-search' );
					$( 'li.search-menu' ).removeClass( 'open' );
				}
			);
		} else if ( $( 'li.search-menu' ).hasClass( 'dropdown' ) ){
			$( 'li.search-menu form' ).fadeOut();
		}
	});

} )( jQuery );