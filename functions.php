<?php

// Hide admin bar in frontend
show_admin_bar( false );

/* Remove WordPress version from header for security */
remove_action('wp_head', 'wp_generator');

/* Remove login errors for security */
add_filter('login_errors', create_function('$a', "return null;"));

/* Register the widget columns */
    if ( function_exists('register_sidebar') ){
		register_sidebar(Array(
		'name' => 'Sidebar',
		'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
		));
    };

/* Get category ID by name */	
function get_category_id($cat_name){
	$term = get_term_by('name', $cat_name, 'category');
	return $term->term_id;
}

// Add Featured Image Support
add_theme_support( 'post-thumbnails' );

/* Custom Menu */
add_action('init', 'register_custom_menu');
 
function register_custom_menu() {
register_nav_menu('main_menu', __('Main Menu'));
}

function add_first_and_last($output) {
  $output = preg_replace('/class="menu-item/', 'class="first-menu-item menu-item', $output, 1);
  $output = substr_replace($output, 'class="last-menu-item menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
  return $output;
}
add_filter('wp_nav_menu', 'add_first_and_last');

// Insertar Breadcrumb
function the_breadcrumb() {
 
  $delimiter = '&raquo;';
  $name = 'Inicio'; //text for the 'Home' link
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div>';
 
    global $post;
    $home = get_bloginfo('url');
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . '';
      single_cat_title();
      echo '' . $currentAfter;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
 
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
 
    } elseif ( is_single() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_search() ) {
      echo $currentBefore . 'Resultados de &#39;' . get_search_query() . '&#39;' . $currentAfter;
 
    } elseif ( is_tag() ) {
      echo $currentBefore . 'Art&iacute;culos etiquetados con &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Art&iacute;culos publicados por ' . $userdata->display_name . $currentAfter;
 
    } elseif ( is_404() ) {
      echo $currentBefore . 'P&aacute;gina no encontrada' . $currentAfter;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
 
  }
}

// fin breadcrumb

// Cortar número de palabras
function string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}
// Cortar número de palabras

/* +++ Custom Login Logo +++ */
add_action('login_head', 'my_custom_login_logo');

function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/css/images/login-logo.png) !important; }
    </style>';
}
/* +++ Custom Login Logo +++ */


/* +++ Custom Admin Logo +++ */
add_action('admin_head', 'my_custom_logo');

function my_custom_logo() {
   echo '
      <style type="text/css">
        #header-logo { background-image: url('.get_bloginfo('template_directory').'/css/images/admin-logo.png) !important; width:200px; }
		#wphead { background:#FFF; !important }
      </style>
   ';
}
/* +++ Custom Admin Logo +++ */

/* +++ Funciones para el extracto +++ */

// Para extender el máximo de 55 palabras
function pixelkit_excerpt_length($length) {
	return 100;
}
add_filter('excerpt_length', 'pixelkit_excerpt_length');

// Para cambiar el [...] que viene por defecto
function new_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'new_excerpt_more');
/* +++ Funciones para el extracto +++ */


/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
function pk_customizer( $wp_customize ) {

	$wp_customize->remove_section('static_front_page');

	// SECCIÓN OPCIONES GENERALES
    $wp_customize->add_section(
        'general_options',
        array(
            'title' => 'Opciones Generales',
            'description' => 'Para que algunos de estos contenidos se muestren en los diferentes idiomas, los textos se deben separar con este tipo de etiquetas: <code>&lt;!--:es--&gt;</code> ... <code>&lt;!--:--&gt;</code> .<br>
            Se puede copiar y pegar este ejemplo como base:<br>
			<code>&lt;!--:es--&gt;Espa&ntilde;ol&lt;!--:--&gt;&lt;!--:en--&gt;English&lt;!--:--&gt;&lt;!--:pt--&gt;Portuegu&ecirc;s&lt;!--:--&gt;</code>',
            'priority' => '35',
        )
    );
    // IDIOMAS
	$wp_customize->add_setting(
		'hide_language_options'
	);
	$wp_customize->add_control(
	    'hide_language_options',
	    array(
	        'type' => 'checkbox',
	        'label' => 'Esconder opciones de idiomas',
	        'section' => 'general_options',
            'priority' => '1',
	    )
	);
	// SLOGAN
	$wp_customize->add_setting(
	    'slogan',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'slogan',
	    array(
	        'label' => 'Slogan',
	        'section' => 'general_options',
	        'type' => 'text',
            'priority' => '2',
	    )
	);
	// CONTENIDO ERROR404
	$wp_customize->add_setting(
	    'ID404',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'ID404',
	    array(
	        'label' => 'ID P&aacute;gina Error 404',
	        'section' => 'general_options',
	        'type' => 'text',
            'priority' => '3',
	    )
	);

	// SECCIÓN REDES SOCIALES
    $wp_customize->add_section(
        'social_options',
        array(
            'title' => 'Redes Sociales',
            'description' => 'Inserte aqu&iacute; las direcciones web de las redes disponibles. Deje en blanco para deshabilitar.',
            'priority' => '36',
        )
    );
	// FACEBOOK
	$wp_customize->add_setting(
	    'url_facebook',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url_facebook',
	    array(
	        'label' => 'URL Facebook',
	        'section' => 'social_options',
	        'type' => 'text',
            'priority' => '1',
	    )
	);    
	// TWITTER
	$wp_customize->add_setting(
	    'url_twitter',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url_twitter',
	    array(
	        'label' => 'URL Twitter',
	        'section' => 'social_options',
	        'type' => 'text',
            'priority' => '2',
	    )
	);
	// LINKEDIN
	$wp_customize->add_setting(
	    'url_linkedin',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url_linkedin',
	    array(
	        'label' => 'URL Linkedin',
	        'section' => 'social_options',
	        'type' => 'text',
            'priority' => '3',
	    )
	);

	// SECCIÓN PORTADA
    $wp_customize->add_section(
        'homepage_options',
        array(
            'title' => 'Portada',
            'description' => 'T&iacute;tulos, textos y links en la portada.',
            'priority' => '37',
        )
    );
	// TITULO SERVICIOS
	$wp_customize->add_setting(
	    'soluciones-titulo',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'soluciones-titulo',
	    array(
	        'label' => 'T&iacute;tulo Secci&oacute;n Servicios',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '1',
	    )
	);
	// TEXTO SERVICIOS
	class Custom_Textarea_Control extends WP_Customize_Control {
	    public $type = 'textarea';
	 
	    public function render_content() {
	        ?>
	        <label>
	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	        </label>
	        <?php
	    }
	}
	$wp_customize->add_setting(
		'soluciones-parrafo',
		array(
	    	'default' => '',
		)
	);
	 
	$wp_customize->add_control(
		new Custom_Textarea_Control(
		$wp_customize, 'soluciones-parrafo',
			array(
			    'label' => 'Texto descripci&oacute;n Servicios',
			    'section' => 'homepage_options',
			    'settings' => 'soluciones-parrafo',
		        'priority' => '2',
			)
		)
	);
	// TITULO BOTON 1
	$wp_customize->add_setting(
	    'titulo-caluga-1',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'titulo-caluga-1',
	    array(
	        'label' => 'T&iacute;tulo Bot&oacute;n 1',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '3',
	    )
	);
	// URL BOTON 1
	$wp_customize->add_setting(
	    'url-boton-caluga-1',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url-boton-caluga-1',
	    array(
	        'label' => 'URL Bot&oacute;n 1',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '4',
	    )
	);
	// TITULO BOTON 2
	$wp_customize->add_setting(
	    'titulo-caluga-2',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'titulo-caluga-2',
	    array(
	        'label' => 'T&iacute;tulo Bot&oacute;n 2',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '5',
	    )
	);
	// URL BOTON 2
	$wp_customize->add_setting(
	    'url-boton-caluga-2',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url-boton-caluga-2',
	    array(
	        'label' => 'URL Bot&oacute;n 2',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '6',
	    )
	);
	// TITULO BOTON 3
	$wp_customize->add_setting(
	    'titulo-caluga-3',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'titulo-caluga-3',
	    array(
	        'label' => 'T&iacute;tulo Bot&oacute;n 3',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '7',
	    )
	);
	// URL BOTON 3
	$wp_customize->add_setting(
	    'url-boton-caluga-3',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url-boton-caluga-3',
	    array(
	        'label' => 'URL Bot&oacute;n 3',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '8',
	    )
	);
	// TITULO BOTON 4
	$wp_customize->add_setting(
	    'titulo-caluga-4',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'titulo-caluga-4',
	    array(
	        'label' => 'T&iacute;tulo Bot&oacute;n 4',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '9',
	    )
	);
	// URL BOTON 4
	$wp_customize->add_setting(
	    'url-boton-caluga-4',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url-boton-caluga-4',
	    array(
	        'label' => 'URL Bot&oacute;n 4',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '10',
	    )
	);
	// TITULO DESTACADOS
	$wp_customize->add_setting(
	    'titulo-destacados',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'titulo-destacados',
	    array(
	        'label' => 'T&iacute;tulo Art&iacute;culos Destacados',
	        'section' => 'homepage_options',
	        'type' => 'text',
            'priority' => '11',
	    )
	);


}

add_action( 'customize_register', 'pk_customizer' );


//END ?>
