<?php

/**
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage Bytewirev3
 * @since Bytewirev3 1.0
 */

include_once("theme_config.php");

add_action( 'after_setup_theme', 'xenba_setup' ); 
 

/* helpers 
		
	SIDEBAR
	
	if ( function_exists('register_sidebar') ):
	    register_sidebar(array(

		"before_widget" => "",
		
		"after_widget" => "",
		
		"before_title" => "<h4>",
		
		"after_title" => "</h4>",
		
		"name" => "Blog Sidebar"

		));	
	endif;
	
	REGISTER A POST TYPE
	
	register_post_type( 'services',
			array(
				'labels' => array(
					'name' => __( 'Services' ),
					'singular_name' => __( 'Services' ),
					'add_new' => __( 'Add new' ),
					'add_new_item' => __( 'Add New Service' ),
					'edit' => __( 'Edit' ),
					'edit_item' => __( 'Edit Service' ),
					'new_item' => __( 'New Service' ),
					'view' => __( 'View Service' ),
					'view_item' => __( 'View Service' ),
					'search_items' => __( 'Search Services' ),
					'not_found' => __( 'No services found' ),
					'not_found_in_trash' => __( 'No services found in Trash' ),
					'parent' => __( 'Parent services' ),
				),
				'public' => true,
				'query_var' => true,
				'menu_position' => 5,
				'show_ui' => true,
				'supports' => array('title','editor','thumbnail','custom-fields','page-attributes','revisions'),
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'hierarchical' => true
			)
		);	
		
	CUSTOM TAXONOMY

	register_taxonomy( 'service_category', 'services', array( 'hierarchical' => true, 'label' => __('Service Category', 'series'), 'query_var' => 'service_category', 'rewrite' => array( 'slug' => 'service_category' ) ) );	


// =========== 
// ! The main setup for the blog  
// ===========

/**
 * Sets up the blog accordingly
 *
 * @since JT Photography 1.0
 */ 

if( ! function_exists('xenba_setup')){
	
	function xenba_setup(){	
		
		add_editor_style();
		
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 260, 200, true ); 
				
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'twentyten' ),
		) );
		
		if ( function_exists('register_sidebar') ):
		    register_sidebar(array(

			"before_widget" => "",
			
			"after_widget" => "",
			
			"before_title" => "<h4>",
			
			"after_title" => "</h4>",
			
			"name" => "Site sidebar"

			));	
		endif;		
		
	
	}

}

if ( ! function_exists( 'jt_photography_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since JT Photography 1.0
 */
function jt_photography_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'jt_photography_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since JT Photography 1.0
 */
function jt_photography_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">link</a>.', 'jt_photography' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">link</a>.', 'jt_photography' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">link</a>.', 'jt_photography' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;
 
if ( ! function_exists( 'checkdata' ) ) :

function checkdata($data,$type){
	if($type==1){
		if(strlen($data)>30){
			return 0;
		} elseif(ereg('[^0-9]', $data)) {
			return 0;
		} else {
			return $data;
		}
	}
	elseif($type==2){
		return addslashes(strip_tags(trim($data)));		
	}
	elseif($type==3){
		if(strlen($data)>50){
			return 0;
		}elseif (ereg('[^A-Za-z0-9]', $data)){
			return 0;
		}else{
			return $data;
		}	
	} elseif($type==4) {
		if(strlen($data)>50){
			return 0;
		}elseif (ereg('[^-A-Za-z0-9_!| ]', $data)){
			return 0;
		}else{
			return $data;
		}	
	} elseif($type==5) {
		if(strlen($data)>200){
			return 0;
		}elseif (ereg('[^-A-Za-z0-9_!| ]', $data)){
			return 0;
		}else{
			return $data;
		}	
	} elseif($type==6) {
		if(strlen($data) < 6) {
			return 0;
		} else {
			return $data;
		}
	}
}

endif;

if ( ! function_exists( ' is_tree' ) ) :
function is_tree( $pid ) {      // $pid = The ID of the page we're looking for pages underneath
    global $post;               // load details about this page

    if ( is_page($pid) )
        return true;            // we're at the page or at a sub page

    $anc = get_post_ancestors( $post->ID );
    foreach ( $anc as $ancestor ) {
        if( is_page() && $ancestor == $pid ) {
            return true;
        }
    }

    return false;  // we arn't at the page, and the page is not an ancestor
}
endif;

if ( ! function_exists( 'dimox_breadcrumbs' ) ) :
function dimox_breadcrumbs() {
 
  $delimiter = '&nbsp;&raquo;&nbsp;';
  $home = 'Home'; // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    global $post;
    $homeLink = get_bloginfo('url');
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;
 
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
      echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
  
  }
} // end dimox_breadcrumbs()
endif;

if ( ! function_exists( 'checkEmail' ) ) :

function checkEmail($email){
  return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

endif;

if ( ! function_exists( 'isValidURL' ) ) :

function isValidURL($url) {
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

endif;


if ( ! function_exists( 'bytewire_comment' ) ) :

function bytewire_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID() ?>">
		
			<div class="comment-left">
				<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, "48" ); ?>
			</div>
			<div class="comment-right">
				<div class="comment-right-inner">
					<?php if ($comment->comment_approved == '0') : ?>
						<?php $awaiting = '<span class="small moderation">(Comment awaiting moderation)</span>'; ?>
					<?php endif; ?>

				
					<p style="margin: 0px 0px 5px 0px;">
					<?php printf(__('<span class="name">%s</span><span class="small says">says:</span>%s<br><span class="smaller date">%s %s</span>'), get_comment_author_link(),$awaiting,get_comment_date(),  get_comment_time()) ?>
					</p>

					<?php comment_text();?>
					<p style="margin: 3px 0px 0px 0px;">
						<span class="reply-link ie6"><a rel="nofollow" class="comment-reply-link" href="<?=the_permalink()?>?replytocom=<?php comment_ID() ?>#respond" onclick="return addComment.moveForm('-<?php comment_ID() ?>', '<?php comment_ID() ?>', 'respond', '1')">Reply</a></span>
					</p>
				</div><!-- .comment-right-inner (end) -->
              </div><!-- .comment-right (end) -->
              <div class="clear"></div>
              </div>
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'twentyten'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

if( ! function_exists( 'jt_photo_contact ')) :

	function jt_photo_contact(){
	
		$errors = 0;
	
		if(isset($_POST['sub-contact']) && isset($_POST['contact_name']) && isset($_POST['contact_email']) && isset($_POST['contact_message']) && isset($_POST['contact_answer'])) {
			$name = checkdata($_POST['contact_name'],4);
			$email = checkEmail($_POST['contact_email']);
			$subject = checkdata($_POST['contact_subject'],4);
			$details = htmlspecialchars(stripslashes(strip_tags(nl2br($_POST['contact_message']))));
			$answer = checkdata($_POST['contact_answer'],1);
			
			if($email) {
				if($name) {
						if($details) {
							if($answer){
							
							if($answer==4){
							
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
														
							$html_text = "<h2>Email from Jeff Turnbull Contact form submittal</h2><hr><b>From:</b> ".$name."</br><b>Email Address:</b> ".$email."<br><b>Subject:</b> ".$subject."<br><b>Message:</b> ".nl2br($details);
							
							//PingEmails($html_text,$plain_text,$to_email,$name,"Bytewire Contact Form");
							
							$success = 1;
														
							$to      = 	get_bloginfo('admin_email');;
							$subject = 'Jeff Turnbull Contact: '.$subject;
							$headers.= 'From: webmaster@jeffturnbull.com' . "\r\n" .
							    'Reply-To: '.$email . "\r\n" .
							    'X-Mailer: PHP/' . phpversion();

							mail($to, $subject, $html_text, $headers);		
							
							$message = gettext("Thank you for contacting us, we will get back to you shortly!");					
							
							}else{
								$errors++;
								$message = gettext("Wrong. Your answer for 2 x 2 was wrong, please try again.");
							}
							
							}else{
								$errors++;
								$message = gettext("Please enter a valid number for the answer of 2 x 2.");
							}
				
						} else {
							$errors++;
							$message = gettext("You must enter a message.");
						}
				} else {
					$errors++;
					$message = gettext("You must enter a name.");
				}
			} else {
				$errors++;
				$message = gettext("You must enter a valid email address.");
			}

		}else{
			$errors++;
			$message = gettext("Some required fields we're missing, please check and submit again.");
		}
		
		return array($message,$errors);
	}

endif;

if( ! function_exists( 'jt_photo_social_media')):

	function jt_photo_social_media($return = false){
		$var = '';
		$var.= '<h3>Get in touch with me</h3>';
		$var.= '<p>Telephone: 01376 323915</p>';
		$var.= 'Connect with us:';
		$var.= '<ul class="social_media">';
		$var.= '<li><a href="http://www.facebook.com/JeffTurnbullPhotography" target="_blank"><img src="'.get_bloginfo('stylesheet_directory').'/assets/images/facebook.jpg"></a></li>';
		$var.= '<li><a href="http://twitter.com/#!/jeffturnbull" target="_blank"><img src="'.get_bloginfo('stylesheet_directory').'/assets/images/twitter.jpg"></a></li>';
		$var.= '<li><a href="mailto:jeff@jeffturnbull.com" target="_blank"><img src="'.get_bloginfo('stylesheet_directory').'/assets/images/email.jpg"></a></li>';
		$var.= '<li><a href="http://www.linkedin.com/in/jeffturnbull" target="_blank"><img src="'.get_bloginfo('stylesheet_directory').'/assets/images/linked_in.jpg"></a></li>';
		$var.= '<li><img src="'.get_bloginfo('stylesheet_directory').'/assets/images/skype.jpg"></li>';
		$var.= '</ul>';
		
		if($return)
			return $var;
		else
			echo $var;
		
	}

endif;

if(!function_exists( 'jt_update')){
	function jt_update($content){
		if(is_page()){
			return $content;
		}else{
		if(!is_home()){
			/* $button = '<div style="float:right;margin-left:20px;"><a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>'; */
			return $content;
		}else{
			return $content;	
		}
		}
	}
}

if(!function_exists( 'load_sidebar_content_images')){
	function load_sidebar_content_images($content=false){
	
		/* pick array */
		
		$wedding = array(
			get_bloginfo('stylesheet_directory').'/assets/images/Square-Wedding-1.jpg',
			get_bloginfo('stylesheet_directory').'/assets/images/Square-Wedding-2.jpg',
			get_bloginfo('stylesheet_directory').'/assets/images/Square-Wedding-3.jpg'
		);
		
		$commercial = array(
			get_bloginfo('stylesheet_directory').'/assets/images/Square-Commercial-1.jpg',
			get_bloginfo('stylesheet_directory').'/assets/images/Square-Commercial-2.jpg'
		);
		
		$portraits = array(
			get_bloginfo('stylesheet_directory').'/assets/images/Square-Portrait-1.jpg',
			get_bloginfo('stylesheet_directory').'/assets/images/Square-Portrait-2.jpg',
			get_bloginfo('stylesheet_directory').'/assets/images/Square-Portrait-3.jpg'		
		);
	
		if (have_posts()) : while (have_posts()) : the_post();
						
			if(get_the_ID()==99 || get_the_ID()==15){
				/* portraits */
				$images = array(
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Portrait-1.jpg',
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Portrait-2.jpg',
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Portrait-3.jpg'
				);
			}elseif(get_the_ID()==101 || get_the_ID()==17){
				/* commercial */
				$images = array(
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Commercial-1.jpg',
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Commercial-2.jpg'
				);
			}elseif(get_the_ID()==70 || get_the_ID()==13 || get_the_ID()==102){
				/* weddings */
				$images = array(
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Wedding-1.jpg',
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Wedding-2.jpg',
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Wedding-3.jpg'
				);
			}elseif(get_the_ID()==144){
			
				$images = array(
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Wedding-1.jpg',
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Wedding-2.jpg',
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Portrait-1.jpg',
					get_bloginfo('stylesheet_directory').'/assets/images/Square-Portrait-3.jpg'	
				);				
				
			}else{
				
				$wed_rand = array_rand($wedding,1);
				$comm_rand = array_rand($commercial,1);
				$port_rand = array_rand($portraits,1);
								
				$images = array(
					$wedding[$wed_rand],
					$commercial[$comm_rand],
					$portraits[$port_rand]
				);	
								
			}	
			
		endwhile;endif;
		
/*
		$images = array(
			get_bloginfo('stylesheet_directory').'/assets/images/commercial-1.jpg',
			get_bloginfo('stylesheet_directory').'/assets/images/commercial-2.jpg',
			get_bloginfo('stylesheet_directory').'/assets/images/Wedding-extra.jpg'	
		);
		
*/
		$ret = '';
		
		if(count($images)>0){
		
		foreach($images as $v):
			
			$ret.='<div class="content-image"><img src="'.$v.'"></div>';
			
		endforeach;
		
		return $ret;
		
		}
		
		return false;

	}
}

if(!function_exists('get_link_more_posts')){
	function get_link_more_posts(){
		if($_GET['pg']){
			if(is_numeric($_GET['pg'])){
				$page = $_GET['pg'];
			}
		}else{
			$page = 1;
		}
		
		$amount = $page*4;
		$view = '#post-'.($amount+1);
		
		if($page){
			$pagi = '?pg='.($page+1);
		}
		
		$count_posts = wp_count_posts();

		$published_posts = $count_posts->publish;
		
		if($amount<$published_posts){
		
			$link = array('<a href="'.get_bloginfo('url').'/blog/'.$pagi.$view.'">More blog posts <span class="orange">&raquo;</span></a>',$amount);
		
		}else{
		
			$link = '';
			
		}
		
		return $link;
		
	}
}

if(!function_exists('jt_is_odd')){
	function jt_is_odd($number){
  		return $number & 1;
	}	
}

if(!function_exists('jt_photo_get_blocks')){
	function jt_photo_get_blocks(){
		
		$ret.= '<div class="grid grid-14">';
		$ret.= jt_photo_social_media(true);
		$ret.= '</div>';
					
		return $ret;
				
	}

}

function my_wp_nav_menu_args( $args = '' )
{
	$args['container'] = false;
	return $args;
} // function

if(!function_exists('new_excerpt_length')){
function new_excerpt_length($length) {
	return 25;
}
}


/** 

* Some filtering to do for this last bit

*/

class Jt_custom_walker extends Walker_Nav_Menu
{
function start_el($output, $item, $depth, $args) {


print_r($item);

global $wp_query;
$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
$class_names = $value = '';
$classes = empty( $item->classes ) ? array() : (array) $item->classes;
$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
$class_names = '';
$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
$item_output = $args->before;


$item_output .= '<a target="_top"'. $attributes .'>';
$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
$item_output .= '</a>';
$item_output .= $args->after;
$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
}
}

add_filter('excerpt_length', 'new_excerpt_length'); 

add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

add_filter('the_content', 'jt_update', 8);

