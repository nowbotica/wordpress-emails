<?php
/**
 * @package Emails
 * @version 1.6
 */
/*
Plugin Name: Emails
Plugin URI: http://wordpress.org/plugins/emails
Description: Emails
Author: Andrew MacKay
Version: 1.6
Author URI: http://nowbotica.com/
*/

class EcowelleEmails {


		/**
         * A Unique Identifier
         */
		 protected $ecowelle_Emails;

        /**
         * A reference to an instance of this class.
         */
        private static $instance;

        /**
         * The array of templates that this plugin tracks.
         */
        protected $templates;

        /**
		 * Returns an instance of this class. 
		 * Works by adding an instance of our class to the WordPress header using the add_filter() function.
		 * origin: http://www.wpexplorer.com/wordpress-page-templates-plugin/
		 */
		public static function get_instance() {

			if( null == self::$instance ) {
				self::$instance = new EcowelleEmails();
			} 

			return self::$instance;

		}

		/**
		 * Initializes the plugin by setting filters and administration functions.
		 * // utilises WordPress’s inbuilt add_filter() function to add an instance of our class into key points along the WordPress initialisation timeline. 
		 * // Pattern: the ‘__construct’ method (this will be run when the class is instantiated).
		 */
		private function __construct() {
			$this->templates = array();


			// Add a filter to the attributes metabox to inject template into the cache.
			add_filter(
				'page_attributes_dropdown_pages_args',
				array( $this, 'register_project_templates' ) 
			);


			// Add a filter to the save post to inject out template into the page cache
			add_filter(
				'wp_insert_post_data', 
				array( $this, 'register_project_templates' ) 
			);


			// Add a filter to the template include to determine if the page has our 
			// template assigned and return it's path
			add_filter(
				'template_include', 
				array( $this, 'view_project_template') 
			);


			// Add your templates to this array.
			$this->templates = array(
				'goodtobebad-template.php' => 'It\'s Good to Be Bad',
			);
				
		}








}


function stored_emails() {
  $labels = array(
    'name'               => _x( 'Emails', 'post type general name' ),
    'singular_name'      => _x( 'Email', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Email' ),
    'edit_item'          => __( 'Edit Email' ),
    'new_item'           => __( 'New Email' ),
    'all_items'          => __( 'All Emails' ),
    'view_item'          => __( 'View Email' ),
    'search_items'       => __( 'Search Emails' ),
    'not_found'          => __( 'No Emails found' ),
    'not_found_in_trash' => __( 'No Emails found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Emails'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our products and product specific data',
    'menu_icon'     => 'dashicons-media-text',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor'),
    // 'supports'      => array( 'title', 'editor', 'comments' ),
	'taxonomies'    => array( 'email_themes', 'email_templates' ),
    'has_archive'   => true,
  );
  register_post_type( 'emails', $args ); 
}
add_action( 'init', 'stored_emails' );

function email_templates() {
	// create a new taxonomy
		// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Email Templates', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Email Template', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Email Templates', 'textdomain' ),
		'all_items'         => __( 'All Email Templates', 'textdomain' ),
		'parent_item'       => __( 'Parent Email Template', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Email Template:', 'textdomain' ),
		'edit_item'         => __( 'Edit Email Template', 'textdomain' ),
		'update_item'       => __( 'Update Email Template', 'textdomain' ),
		'add_new_item'      => __( 'Add New Email Template', 'textdomain' ),
		'new_item_name'     => __( 'New Email Template Name', 'textdomain' ),
		'menu_name'         => __( 'Email Template', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'public'            => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav'       => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'email_templates' ),
	);

	register_taxonomy( 'email_templates', array( 'emails' ), $args );
}
add_action( 'init', 'email_templates' );

function email_themes() {
	// create a new taxonomy
		// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Email Themes', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Email Theme', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Email Themes', 'textdomain' ),
		'all_items'         => __( 'All Email Themes', 'textdomain' ),
		'parent_item'       => __( 'Parent Email Theme', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Email Theme:', 'textdomain' ),
		'edit_item'         => __( 'Edit Email Theme', 'textdomain' ),
		'update_item'       => __( 'Update Email Theme', 'textdomain' ),
		'add_new_item'      => __( 'Add New Email Theme', 'textdomain' ),
		'new_item_name'     => __( 'New Email Theme Name', 'textdomain' ),
		'menu_name'         => __( 'Email Theme', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'public'            => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav'       => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'email_themes' ),
	);

	register_taxonomy( 'email_themes', array( 'emails' ), $args );
}
add_action( 'init', 'email_themes' );

function get_emails_archive_template( $archive_template ) {
     global $post;

     if ( is_post_type_archive ( 'emails' ) ) {
          $archive_template = dirname( __FILE__ ) . '/archive-emails.php';
     }
     return $archive_template;
}
add_filter( 'archive_template', 'get_emails_archive_template' ) ;

function get_emails_single_template( $single_template ) {
     global $post;

     if ( is_singular ( 'emails' ) ) {
          $single_template = dirname( __FILE__ ) . '/single-emails.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_emails_single_template' ) ;

/**
 * Proper way to enqueue scripts and styles
 */
function emails_css() {
    wp_enqueue_style( 'emails_css', WP_PLUGIN_URL . '/emails/emails.css' );
    // wp_enqueue_script( 'script-name', WP_PLUGIN_URL . '/emails/emails.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'emails_css' );

	# Include the Autoloader (see "Libraries" for install instructions)
	require 'vendor/autoload.php'; //WP_PLUGIN_URL . '/emails/
	use Mailgun\Mailgun;
function prefix_ajax_do_email() {


	$data = $_POST['data'];
   
	$email_to = 'soyasorcery@gmail.com';//$data['to'];
	// $email_cc = //$data['cc'];
    $email_subject = 'Appoinment Reminder'; 
    // $data['subject'];
	// // echo $data;

	// // # Instantiate the client.
	$mgClient = new Mailgun('key-58b3f6a84079df263d81e3a1cd338d34');

	// print_r($mgClient);
	// die();
	$domain = "http://mailserver.snowbotic.com";



	$email_data = array(
	    'from'    => 'Andrew MacKay <andrew.mackay@snowbotica.com>',
	    'to'      => $email_to,
	    'subject' => $email_subject,
	    'text'    => $domain
	);
	    // 'cc'	  => $email_cc,

	$result = $mgClient->sendMessage($domain, $email_data);
    
	 echo json_encode(array('type'=>'success', 'message'=>$result));

	// # Make the call to the client.

	wp_die();       
}
add_action( 'wp_ajax_do_email', 'prefix_ajax_do_email' );
add_action('wp_ajax_nopriv_do_email', 'do_email');


// function get_emails_post_type_template($single_template) {
//  global $post;

//  if ($post->post_type == 'books') {
//       $single_template = dirname( __FILE__ ) . '/single-emails.php';
//  }
//  return $single_template;
// }

// add_filter( "single_template", "get_emails_post_type_template" ) ;



// // This just echoes the chosen line, we'll position it later
// function hello_emails() {
// 	$chosen = hello_emails_get_lyric();
// 	echo "<p id='dolly'>$chosen</p>";
// }

// // Now we set that function up to execute when the admin_notices action is called
// add_action( 'admin_notices', 'hello_emails' );






// We need some CSS to position the paragraph
// function emails_css() {
// 	// This makes sure that the positioning is also good for right-to-left languages
// 	$x = is_rtl() ? 'left' : 'right';

// 	echo "
// 	<style type='text/css'>
// 	#emails {
// 		float: $x;
// 		padding-$x: 15px;
// 		padding-top: 5px;		
// 		margin: 0;
// 		font-size: 11px;
// 	}
// 	</style>
// 	";
// }

// add_action( 'admin_head', 'emails_css' );


// /**
//  * This example will work at least on WordPress 2.6.3, 
//  * but maybe on older versions too.
//  */
// add_action( 'admin_init', 'wpdocs_plugin_admin_init' );
// add_action( 'admin_menu', 'wpdocs_plugin_admin_menu' );
    
// /**
//  * Register our stylesheet.
//  */
// function wpdocs_plugin_admin_init() {
//     wp_register_style( 'wpdocsPluginStylesheet', plugins_url( 'stylesheet.css', __FILE__ ) );
// }
 
// /**
//  * Register our plugin page and hook stylesheet loading.
//  */
// function wpdocs_plugin_admin_menu() {
//     $page = add_submenu_page( 'edit.php', 
//         __( 'Wpdocs Plugin', 'textdomain' ), 
//         __( 'Wpdocs Plugin', 'textdomain' ),
//         'administrator',
//         __FILE__, 
//         'wpdocs_plugin_manage_menu' );
   
//     add_action( "admin_print_styles-{$page}", 'wpdocs_plugin_admin_styles' );
// }
 
// /**
//  * Enqueue our stylesheet.
//  */
// function wpdocs_plugin_admin_styles() {
//     wp_enqueue_style( 'wpdocsPluginStylesheet' );
// }
 
// /**
//  * Output our admin page.
//  */
// function wpdocs_plugin_manage_menu() {
//      // ...
// }