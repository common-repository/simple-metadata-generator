<?php

/***
Plugin Name: Simple Metadata Generator
Plugin URI: http://www.ohmybox.info
Description: Ajoute automatiquement les métadonnées HTML, Open Graph, Twitter Card et Dublin Core aux pages de votre thème.
Version: 0.4
Author: Laurence/OhMyBox.info
Author URI: http://www.ohmybox.info
Text domain: simplemetadatagenerator
Domain Path: /languages/
License: GPL2
Simple Metadata Generator is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
Simple Metadata Generator is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
***/

if (!defined( 'ABSPATH')) exit; 

function simplemetadatagenerator_init() {
	load_plugin_textdomain( 'simplemetadatagenerator', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
add_action('init', 'simplemetadatagenerator_init');

if (is_admin()) :
	require_once('smg_settings.php' );
else :
	require_once('smg_front.php' );
endif;
?>