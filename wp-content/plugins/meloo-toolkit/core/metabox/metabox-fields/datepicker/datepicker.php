<?php
/**
 * Date Picker Field Class
 *
 * @author Rascals Themes
 * @category Core
 * @package Toolkit Core
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed diCustomizer
}

if ( ! class_exists( 'RascalsBox_datepicker' ) ) {

	class RascalsBox_datepicker extends RascalsBox {

		private static $_initialized = false;
		private static $_args;
		private static $_saved_options;
		private static $_option;


		/**
         * Field Constructor.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
        */
		public function __construct( $option, $args, $saved_options ) {
			
			// Variables
			self::$_args = $args;
			self::$_saved_options = $saved_options;
			self::$_option = $option;

			// Only for first instance
			if ( ! self::$_initialized ) {
	            self::$_initialized = true;
	            
	        }

		}


		/**
         * Field Render Function.
         * Takes the vars and outputs the HTML
         *
         * @since 		1.0.0
         * @access  	public
        */
		public function render() {
			if ( isset( self::$_saved_options[self::$_option['id']] ) ) {
				self::$_option['std'] = self::$_saved_options[self::$_option['id']];
			}
			

			// Depedency
			if ( isset( self::$_option['dependency']) && is_array( self::$_option['dependency'] ) ) {
				echo '<div class="box-row clearfix dependent-hidden" data-depedency-el="' . esc_attr( self::$_option['dependency']['element'] ) .'" data-depedency-val="'.esc_attr( implode(',', self::$_option['dependency']['value'] ) ).'" data-id="' . esc_attr( self::$_option['id'] ) . '">';
			} else {
				echo '<div class="box-row clearfix">';
			}

				// Input Wrap
				echo '<div class="box-row-input">';

					// Label
					echo '<div class="box-tc box-tc-label">';
						if ( isset( self::$_option['name'] ) && ( self::$_option['name'] !== '' ) ) {	
							echo '<label for="' . esc_attr( self::$_option['id'] ) . '" >' . esc_attr( self::$_option['name'] ) . '</label>';
						}
					echo '</div>';

					// Input
					echo '<div class="box-tc box-tc-input">';
						if ( isset( self::$_option['sub_name'] ) && ( self::$_option['sub_name'] !== '' ) ) {	
							echo '<div class="sub-name">' . esc_attr( self::$_option['sub_name'] ) . '</div>';
						}
						echo '<input name="' . esc_attr( self::$_option['id'] ) . '" id="' . esc_attr( self::$_option['id'] ) . '" type="text" value="' . esc_html( self::$_option['std'] ) . '" class="datepicker-input"/>';

						// Display help
						if ( isset( self::$_option['desc'] ) && self::$_option['desc'] !== '' ) {
							echo '<p class="help-box">';
							$this->e_esc( self::$_option['desc'] );
							echo '</p>';
						}
					echo '</div>';

				echo '</div>';

				if ( ! isset( self::$_option['separator'] ) || ( self::$_option['separator'] === true ) ) {	
					echo '<div class="box-row-line"></div>';
				}

			
			echo '</div>';

		}

	}
}