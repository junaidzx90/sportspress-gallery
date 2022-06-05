<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Gallery
 * @subpackage Gallery/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gallery
 * @subpackage Gallery/admin
 * @author     Md galleries <admin@easeare.com>
 */
class Gallery_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version; 
		
		add_image_size( 'gallery_thumb', '140','140', true );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_style( 'fancybox', plugin_dir_url( __FILE__ ) . 'css/fancybox.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gallery-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'admin-css', plugin_dir_url( __FILE__ ) . 'css/gallery-admin.css', array(), $this->version, 'all' );
		wp_enqueue_script( 'fancybox1', plugin_dir_url( __FILE__ ) . 'js/fancybox.js', array(  ), $this->version, false );
		wp_enqueue_script( 'generaljs', plugin_dir_url( __FILE__ ) . 'js/general.js', array( 'fancybox1' ), $this->version, true );
		wp_localize_script( 'generaljs', 'gallery_ajax', array(
			'ajaxurl' => admin_url("admin-ajax.php")
		) );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function public_enqueue_scripts() {
		wp_enqueue_style( 'fancybox1', plugin_dir_url( __FILE__ ) . 'css/fancybox.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gallery-public.css', array(), $this->version, 'all' );
		
		wp_enqueue_script( 'fancybox1', plugin_dir_url( __FILE__ ) . 'js/fancybox.js', array(  ), $this->version, false );
		wp_enqueue_script( 'jqform', plugin_dir_url( __FILE__ ) . 'js/jquery.form.min.js', array(  ), $this->version, false );
		wp_enqueue_script( 'generaljs', plugin_dir_url( __FILE__ ) . 'js/general.js', array( 'fancybox1' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gallery-post.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'gallery_ajax', array(
			'ajaxurl' => admin_url("admin-ajax.php")
		) );
		wp_localize_script( 'generaljs', 'gallery_ajax', array(
			'ajaxurl' => admin_url("admin-ajax.php")
		) );
	}

	function galleries_team_template($data){
		$galleries = array(
			'galleries' => array(
				'title' => __( 'Gallery', 'sportspress' ),
				'option' => 'sportspress_team_show_galleries',
				'action' => [$this,'sportspress_output_galleries'],
				'default' => 'yes',
			),
		);
		return array_merge($data, $galleries);
	}

	function galleries_player_template($data){
		$galleries = array(
			'galleries' => array(
				'title' => __( 'Gallery', 'sportspress' ),
				'option' => 'sportspress_player_show_galleries',
				'action' => [$this,'sportspress_output_galleries'],
				'default' => 'yes',
			),
		);
		return array_merge($data, $galleries);
	}
	
	function sportspress_output_galleries(){
		require_once plugin_dir_path( __FILE__ )."partials/public-gallery.php";
	}

	function gallery_meta_boxes(){
		$screens = ['sp_player'];
		foreach($screens as $screen){
			add_meta_box( 'user_gallery', 'Gallery', [$this,'admin_gallery_meta'], $screen, 'normal', 'default' );
		}
	}

	function admin_gallery_meta(){
		global $wpdb;
		$post_id = get_post()->ID;
		require_once plugin_dir_path( __FILE__ )."partials/admin-gallery.php";
	}

	// Woocommerce menuitem
	function junu_one_more_link( $menu_links ){
		// we will hook "gallery" later
		$new = array( 'gallery' => 'Gallery' );
	
		// array_slice() is good when you want to add an element between the other ones
		$menu_links = array_slice( $menu_links, 0, 1, true ) 
		+ $new 
		+ array_slice( $menu_links, 1, NULL, true );

		return $menu_links;
	}

	function junu_hook_endpoint( $url, $endpoint, $value, $permalink ){
		if( $endpoint === 'gallery' ) {
	 
			// ok, here is the place for your custom URL, it could be external
			$url = site_url().'/my-account/gallery';
	 
		}
		return $url;
	}

	function junu_add_endpoint() {
		add_rewrite_endpoint( 'gallery', EP_PAGES );
	}

	function junu_my_account_endpoint_content() {
		require_once plugin_dir_path( __FILE__ )."partials/user-gallery.php";
	}

	function upload_documents($file){
		$wpdir = wp_upload_dir(  );
		$max_upload_size = wp_max_upload_size();
		$fileSize = $file['size'];
		$imageFileType = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));

		$filename = rand(10,100);

		$folderPath = $wpdir['basedir'];
		$uploadPath = $folderPath."/galleries/$filename.$imageFileType";
		$uploadedUrl = $wpdir['baseurl']."/galleries/$filename.$imageFileType";

		if (!file_exists($folderPath."/galleries")) {
			mkdir($folderPath."/galleries", 0777, true);
		}

		// Allow certain file formats
		$allowedExt = array("jpg", "jpeg", "png", "PNG", "JPG", "gif");

		if(!in_array($imageFileType, $allowedExt)) {
			echo json_encode(array("error" => "Unsupported file format!"));
			die;
		}

		if ($fileSize > $max_upload_size) {
			echo json_encode(array("error" => "Maximum upload size $max_upload_size"));
			die;
		}

		if(empty($comp_alerts)){
			if (move_uploaded_file($file["tmp_name"], $uploadPath)) {
				return $uploadedUrl;
			}
		}
	}

	function store_gallery_image(){
		$imageUrl = '';
		if(isset($_POST['spg_image_url'])){
			$imageUrl = $_POST['spg_image_url'];			
		}
		if(empty($imageUrl)){
			if(isset($_FILES['spg_upload_image'])){
				$file = $_FILES['spg_upload_image'];
				$imageUrl = $this->upload_documents($file);
			}
		}

		if(!empty($imageUrl)){
			$gallery = get_user_meta(get_current_user_id(  ), 'gcb_gallery', true );
			if(!is_array($gallery)){
				$gallery = [];
			}

			$gallery[] = $imageUrl;
			update_user_meta( get_current_user_id(  ), 'gcb_gallery', $gallery );
			echo json_encode(array('success' => "Image successfully uploaded."));
			die;
		}

		echo json_encode(array("error" => "We're sorry you're having trouble uploading an image!"));
		die;
	}

	function delete_gallery_item(){
		if(isset($_POST['index']) && isset($_POST['user_id'])){
			$user_id = intval($_POST['user_id']);
			$index = intval($_POST['index']);

			$gallery = get_user_meta($user_id, 'gcb_gallery', true );
			if(!is_array($gallery)){
				$gallery = [];
			}

			if(array_key_exists($index, $gallery)){
				unset($gallery[$index]);
				update_user_meta( $user_id, 'gcb_gallery', $gallery );
			}

			echo json_encode(array('success' => "Image successfully deleted."));
			die;
		}
	}
}