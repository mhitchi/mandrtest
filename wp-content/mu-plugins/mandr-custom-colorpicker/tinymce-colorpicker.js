tinymce.PluginManager.add( 'wptextcolor', function( editor ) {

	'use strict';

	var $ = window.jQuery,
		settings = tinymce.settings.tinyMCEColorPicker || {},
		colors = [],
		customColors = settings.customColors || [];

	if ( ! $ ) {
		return;
	}

	function colorPalette() {
		return customColors;
	}

	function setActiveColor( property, color, recalc ) {
		var colors = $( '.tinymce-cp-body-' + property + ' .iris-palette' ).removeClass( 'active' );
		color = color || editor.dom.toHex( editor.dom.getStyle( editor.selection.getNode(), property ) );

		if ( recalc ) {
			colors.each( function() {
				var hex = editor.dom.toHex( $( this ).css( 'background-color' ) );
				$( this ).addClass( property + '-' + hex.slice( 1, 7 ) ).data( 'color', hex );
			} );
		}

		if ( color ) {
			colors.filter( '.' + property + '-' + color.slice( 1, 7 ) ).first().addClass( 'active' );
		}
	}

	function createButton( name, command, property, tooltip ) {

		editor.addButton( name, {
			type: 'colorbutton',
			tooltip: tooltip,
			selectcmd: command,
			panel: {
				role: 'application',
				ariaRemember: true,
				html: function() {
					return '' +
						'<div class="tinymce-cp-body-' + property + '">' +
							'<input type="text" value="#8224e3" class="tinymce-cp-value">' +
						'</div>' +
						'<div class="tinymce-cp-footer">' +
							( settings.nonce ? '<button class="button tinymce-cp-custom">Add a color</button>' : '' ) +
							'<button class="button button-primary tinymce-cp-apply">Apply</button>' +
							'<div class="clear"></div>' +
						'</div>';
				},
				onPostRender: function() {
					var paletteContainer, picker,
						button = this.parent(),
						chosenColor = false,
						chosingColor = false,
						panel = $( this.getEl() ),
						applyButton = panel.find( '.tinymce-cp-apply' ).prop( 'disabled', true ),
						customButton = panel.find( '.tinymce-cp-custom' );

					function togglePanel() {
						chosenColor = false;
						chosingColor = ! chosingColor;

						if ( ! paletteContainer || ! picker ) {
							paletteContainer = panel.find( '.iris-palette-container' );
							picker = panel.find( '.iris-picker-inner, .wp-picker-input-wrap' );
						}

						paletteContainer.add( picker ).toggle();
						customButton.text( chosingColor ? 'Back' : 'Add a color' );
						applyButton.prop( 'disabled', true );
					}

					panel.find( '.tinymce-cp-value' ).wpColorPicker( {
						hide: false,
						palettes: colorPalette(),
						change: function( event, ui ) {
							var color = ui.color.toString();

							if ( ! chosingColor ) {
								setActiveColor( property, color, false );
							} else {
								chosenColor = color;
							}

							applyButton.prop( 'disabled', false );
						},
						clear: function() {
							chosenColor = '';
						}
					} );

					customButton.on( 'click', function() {
						togglePanel();
					} );

					applyButton.on( 'click', function( event ) {
						var color, customPalette, index, save, palette,
							ajaxurl = window.ajaxurl || settings.ajaxurl;

						if ( ! paletteContainer ) {
							paletteContainer = panel.find( '.iris-palette-container' );
						}

						palette = paletteContainer.find( 'a' );

						if ( chosingColor && chosenColor ) {
							color = chosenColor;

							customPalette = palette.slice( 79 );

							$.each( customPalette, function( i, element ) {
								if ( $( element ).hasClass( 'active' ) ) {
									index = i;
									return false;
								}
							} );

							if ( index ) {
								customColors.splice( index - 1, 1, chosenColor );
								save = true;
							} else if ( customColors.length < 20 ) {
								customColors.push( chosenColor );
								save = true;
							}

							$( '.tinymce-cp-value' ).iris( 'option', 'palettes', colorPalette() );

							togglePanel();
						} else {
							$.each( palette, function( i, element ) {
								if ( $( element ).hasClass( 'active' ) ) {
									color = $( element ).data( 'color' );
									return false;
								}
							} );
						}

						if ( editor.dom.toHex( editor.dom.getStyle( editor.selection.getNode(), property ) ) !== color ) {
							editor.execCommand( command, false, color );
						}

						button.color( color );
						button.hidePanel();
					} );

					setActiveColor( property, false, true );
				}
			},
			onclick: function() {
				this._color && editor.execCommand( command, false, this._color );
			},
			onPostRender: function() {
				var button = this;

				editor.on( 'click keyup', function() {
					var color = editor.dom.toHex( editor.dom.getStyle( editor.selection.getNode(), property ) );
					color && button.color( color );
				} );

				$( '.mce-colorbutton .mce-open' ).on( 'click', function() {
					setActiveColor( property, false, true );
				} );
			}
		} );

	}

	createButton( 'forecolor', 'ForeColor', 'color', 'Text color' );
} );
