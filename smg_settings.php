<?php

//Setting page

add_action( 'admin_menu', 'simple_metadata_generator_add_admin_menu' );
add_action( 'admin_init', 'smg_global_fields' );

//Register settings

add_action( 'admin_menu', 'simple_metadata_generator_add_admin_menu' );

function simple_metadata_generator_add_admin_menu(){
	$page_title = __('Métadonnées', 'simplemetadatagenerator'); 
	$menu_title = __('Métadonnées', 'simplemetadatagenerator'); 
	$capability = 'manage_options'; 
	$menu_slug= 'metadata-settings'; 
	$function = 'simple_metadata_generator_options_page';
	$icon_url = 'dashicons-media-code'; 
	$position = 80;
	 add_menu_page( 
		 $page_title,
		 $menu_title,
		 $capability,
		 $menu_slug,
		 $function,
		 $icon_url,
		 $position 
	 ); 
} 

//Fields

function smg_global_fields() { 

	register_setting( 'smg_global_options', 'simple_metadata_generator_settings' );

	add_settings_section(
		'smg_global_each_section', 
		__( 'Affichage des métadonnées', 'simplemetadatagenerator' ), 
		'smg_settings_call', 
		'smg_global_options'
	);
	
	add_settings_field( 
		'simple_metadata_generator_opengraph', 
		__( 'Open Graph (Facebook)', 'simplemetadatagenerator' ), 
		'smg_og_function', 
		'smg_global_options', 
		'smg_global_each_section' 
	);
	
	add_settings_field( 
		'simple_metadata_generator_twittercard', 
		__( 'Twitter', 'simplemetadatagenerator' ), 
		'smg_twitter_card_function', 
		'smg_global_options', 
		'smg_global_each_section' 
	);
	
	add_settings_field( 
		'simple_metadata_generator_twitter_id', 
		__( 'Identifiant Twitter', 'simplemetadatagenerator' ), 
		'smg_twitter_id_function', 
		'smg_global_options', 
		'smg_global_each_section' 
	);
	
	add_settings_field( 
		'simple_metadata_generator_image_format', 
		__( 'Type de carte (Twitter)', 'simplemetadatagenerator' ), 
		'smg_twitter_card_format_function', 
		'smg_global_options', 
		'smg_global_each_section' 
	);
	
	add_settings_field( 
		'simple_metadata_generator_default_image', 
		__( 'Image par défaut (OG et Twitter)', 'simplemetadatagenerator' ), 
		'smg_image_function', 
		'smg_global_options', 
		'smg_global_each_section' 
	);
	
	add_settings_field( 
		'simple_metadata_generator_dublincore', 
		__( 'Dublin Core (DC)', 'simplemetadatagenerator' ), 
		'smg_dc_function', 
		'smg_global_options', 
		'smg_global_each_section' 
	);
	
	add_settings_field( 
		'simple_metadata_generator_description', 
		__( 'HTML Description', 'simplemetadatagenerator' ), 
		'smg_html_description_function', 
		'smg_global_options', 
		'smg_global_each_section' 
	);	
	
	add_settings_field( 
		'simple_metadata_generator_keywords', 
		__( 'HTML Keywords', 'simplemetadatagenerator' ), 
		'smg_keywords_function', 
		'smg_global_options', 
		'smg_global_each_section' 
	);
}

//Form to display with each function (OG, Twitter, DC, HTML)

//Open Graph

function smg_og_function() { 
	$get_meta = get_option( 'simple_metadata_generator_settings' );
?>
	<input name='simple_metadata_generator_settings[simple_metadata_generator_opengraph]' value='0' type='hidden'>
	<input type='checkbox' name='simple_metadata_generator_settings[simple_metadata_generator_opengraph]' <?php checked( $get_meta['simple_metadata_generator_opengraph'], 1 ); ?> value='1'>
<?php }

//Twitter

function smg_twitter_card_function() { 
	$get_meta = get_option( 'simple_metadata_generator_settings' );
?>
	<input name='simple_metadata_generator_settings[simple_metadata_generator_twittercard]' value='0' type='hidden'>
	<input type='checkbox' name='simple_metadata_generator_settings[simple_metadata_generator_twittercard]' <?php checked( $get_meta['simple_metadata_generator_twittercard'], 1 ); ?> value='1'>
<?php }

function smg_image_function() { 
	$get_meta = get_option( 'simple_metadata_generator_settings' );
		if (empty ($get_meta['simple_metadata_generator_default_image'])) : 
			$meta_image = ''; 
		else : 
			$meta_image = $get_meta['simple_metadata_generator_default_image'];
		endif;
	?>
	<input class='bdn' type='text' id='smg-meta-image' name='simple_metadata_generator_settings[simple_metadata_generator_default_image]' value='<?php echo $meta_image; ?>'>
	<input class='btn' type='button' id='smg-meta-image-button' value='<?php _e( 'Envoyer votre image', 'simplemetadatagenerator' )?>' />
	<p class="ita">
		<?php _e('Voir les tailles recommandées par les réseaux sociaux pour le partage, 800px minimum.', 'simplemetadatagenerator'); ?> 
	</p>	
					
				<div id="smg-meta-image-display">
					<img src="<?php echo $meta_image; ?>" id="smg-meta-image-default" />			
					<div class="clear"></div>
					<button class="btn" id="delete"><?php _e('Supprimer l\'image', 'simplemetadatagenerator'); ?></button>
				</div>
				
			<?php 
}

function smg_twitter_card_format_function() { 
	$get_meta = get_option( 'simple_metadata_generator_settings' );
?>
	<select name='simple_metadata_generator_settings[simple_metadata_generator_image_format]'>
		<option value='1' <?php selected( $get_meta['simple_metadata_generator_image_format'], 1 ); ?>>Summary</option>
		<option value='2' <?php selected( $get_meta['simple_metadata_generator_image_format'], 2 ); ?>>Summary large image</option>
	</select>
	<p class="ita">
		<?php _e('Type de présentation : résumé (petite image) ou résumé avec une grande image.', 'simplemetadatagenerator'); ?> 
	</p>
<?php }

function smg_twitter_id_function() { 
	$get_meta = get_option( 'simple_metadata_generator_settings' );
		if ( empty ( $get_meta['simple_metadata_generator_twitter_id'] ) ) : 
			$twitterid = ''; 
		else : 
			$twitterid = $get_meta['simple_metadata_generator_twitter_id'];
		endif;
?>
	<input type='text' class='bdn' name='simple_metadata_generator_settings[simple_metadata_generator_twitter_id]' placeholder='<?php _e('@monId', 'simplemetadatagenerator'); ?>' value='<?php echo $twitterid; ?>'>
	<p class="ita">
		<?php _e('Votre identifiant Twitter @MonNom', 'simplemetadatagenerator'); ?> 
	</p>
<?php }

//DC
function smg_dc_function() { 
	$get_meta = get_option( 'simple_metadata_generator_settings' );
?>
	<input name='simple_metadata_generator_settings[simple_metadata_generator_dublincore]' value='0' type='hidden'>
	<input type='checkbox' name='simple_metadata_generator_settings[simple_metadata_generator_dublincore]' <?php checked( $get_meta['simple_metadata_generator_dublincore'], 1 ); ?> value='1'>
<?php
}

//HTML
function smg_keywords_function() { 
	$get_meta = get_option( 'simple_metadata_generator_settings' );
		if ( empty ( $get_meta['simple_metadata_generator_keywords'] ) ) : 
			$keywords = ''; 
		else : 
			$keywords = $get_meta['simple_metadata_generator_keywords'];
		endif;
?>
	<textarea class='bdn' type='text' name='simple_metadata_generator_settings[simple_metadata_generator_keywords]'><?php echo $keywords; ?></textarea>
	<p class="ita">
		<?php _e('Entrez maximum 20 mots-clés, séparés par une virgule. Ils doivent décrire le plus précisément votre site/vos contenus', 'simplemetadatagenerator'); ?> 
	</p>
<?php }

function smg_html_description_function() { 
	$get_meta = get_option( 'simple_metadata_generator_settings' );
		if ( empty ( $get_meta['simple_metadata_generator_description'] ) ) : $description = ''; 
			else : $description = $get_meta['simple_metadata_generator_description'];
		endif;
?>
	<textarea class='bdn' type='text' name='simple_metadata_generator_settings[simple_metadata_generator_description]'><?php echo $description; ?></textarea>
	<p class="ita">
		<?php _e('La métadonnée "Description" ne peut comporter plus de 200 signes. Son contenu s\'affiche, par exemple, comme description dans les résultats des moteurs de recherche ou comme texte par défaut lors du partage sur les réseaux sociaux.', 'simplemetadatagenerator'); ?> 
	</p>
<?php }

//Callback
function smg_settings_call() { 
	echo __( '<p id="txt">4 types de métadonnées sont disponibles : Open Graph, Twitter Card, Dublin Core et les métadonnées HTML relatives aux mots-clés et à la description du site/des contenus.</p>', 'simplemetadatagenerator' );
}

//Generate
function simple_metadata_generator_options_page() { ?>
	<form action='options.php' method='post'>
		<h1><?php __('Métadonnées', 'simplemetadatagenerator') ?></h1>
		<?php
		settings_fields( 'smg_global_options' );
		do_settings_sections( 'smg_global_options' );
		submit_button();
		?>

	</form>
<?php }

//Image loader
add_action( 'admin_enqueue_scripts', 'smg_admin_js_css' );
function smg_admin_js_css() {
	global $pagenow;
	$plugin_dir_uri = plugin_dir_url( __FILE__ );
		if($pagenow == 'admin.php') :
			wp_enqueue_style( 'smg_style', $plugin_dir_uri . 'inc/style.css' );
			wp_enqueue_media();
			wp_register_script( 'smg-script-js', $plugin_dir_uri . 'inc/script.js', array( 'jquery' ) );
			wp_localize_script( 'smg-script-js', 'smg_meta_image',
				array(
				'title' => __( 'Choisir votre image', 'simplemetadatagenerator' ),
				'button' => __( 'Utiliser cette image', 'simplemetadatagenerator' ),
				)
			);
			wp_enqueue_script( 'smg-script-js' );
		endif;
}
?>