<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>
<?php acf_form_head(); ?>

<div id="" class="" style="width:100%;padding:10px;min-height:100%;width:100%;box-sizing: border-box;float: left">
		<?php if ( have_posts() ) : ?>
<?php
// Start the loop.
while ( have_posts() ) : the_post();
//Echo a single value - $term_list is an array of objects. You must select one of the 
// array entries before you can reference its properties (fields).
$term_list = wp_get_post_terms($post->ID, 'email_templates', array("fields" => "all"));
$tax_name = $term_list[0]->name;
$tax_desc = $term_list[0]->description;
$tax_slug = $term_list[0]->slug;
?>
		
		<section class="preview-recipients">
		</section>
		<section class="mailgun-controls">
		</section>
		<section class="direct-emails">
			
			<h3><b>To: </b><?php the_field('to'); ?></h3>
			<h3><b>CC: </b><?php the_field('cc'); ?></h3>
			<h3><b>Subject: </b><?php the_field('subject'); ?></h3>
			<input type="hidden" name="email_cc" value="<?php the_field('cc'); ?>">
			<input type="hidden" name="email_subject" value="<?php the_field('subject'); ?>">

			<form id="emails-builder">
			<input type="hidden" name="email_to" value="<?php the_field('to'); ?>">
			<input type="hidden" name="email_cc" value="<?php the_field('cc'); ?>">
			<input type="hidden" name="email_subject" value="<?php the_field('subject'); ?>">
			<input type="submit" value="Send Now" id="sendform">
			</form>
			<?php //acf_form(); ?>
			<h2 class="emails"><?php echo  $tax_name?> Email</h2>
			<p><?php echo  $tax_desc?></p>
		</section>
		
	<section id="" class="preview-emails" role="main">
			<?php //include( 'parts/preview-mobile.php' ); ?>
			

			<?php if(     $tax_slug === 'basic' ):?>
				<?php include( 'templates/basic.php');?>

			<?php elseif( $tax_slug === 'hero'):?>
				<?php include( 'templates/hero.php');?>

			<?php elseif( $tax_slug === 'sidebar'):?>
				<?php include( 'templates/sidebar.php');?>

			<?php elseif( $tax_slug === 'marketing'):?>
				<?php include( 'templates/marketing.php');?>
			
			<?php elseif( $tax_slug === 'newsletter'):?>
				<?php include( 'templates/newsletter.php');?>
			
			<?php elseif( $tax_slug === 'newsletter-2'):?>
				<?php include( 'templates/newsletter 2.php');?>
			
			<?php elseif( $tax_slug === 'sidebar-hero'):?>
				<?php include( 'templates/sidebar-hero.php');?>
			
			<?php elseif( $tax_slug === 'order'):?>
				<?php include( 'templates/order.php');?>
			
			<?php elseif( $tax_slug === 'drip'):?>
				<?php include( 'templates/drip.php');?>
			
			<?php elseif( $tax_slug === 'password_reset'):?>
				<?php include( 'templates/password-reset.php');?>
			
			<?php elseif( $tax_slug === 'welcome.php'):?>
				<?php include( 'templates/welcome.php');?>
			
			<?php endif; ?>


			<?php

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :?>
				<div class="active-targets">

					<?php include('parts/comment-based-campaign-tracking.php'); ?>
				</div>
			<?php endif; ?>
			<?php 

			if ( is_singular( 'attachment' ) ) {
				// Parent post navigation.
				the_post_navigation( array(
					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'twentysixteen' ),
				) );
			} elseif ( is_singular( 'post' ) ) {
				// Previous/next post navigation.
				the_post_navigation( array(
					'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'twentysixteen' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Next post:', 'twentysixteen' ) . '</span> ' .
						'<span class="post-title">%title</span>',
					'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'twentysixteen' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Previous post:', 'twentysixteen' ) . '</span> ' .
						'<span class="post-title">%title</span>',
				) );
			} 
			?>
	</section><!-- .site-main -->

	<!-- <aside id="secondary" class="sidebar widget-area" role="complementary"> -->
	<?php /*
	<aside id="" style="width:30%;  float:left;" class="" role="complementary">
			<?php if(     $tax_slug === 'basic' ):?>
				<?php include( 'templates/basic.php');?>

			<?php elseif( $tax_slug === 'hero'):?>
				<?php include( 'templates/hero.php');?>

			<?php elseif( $tax_slug === 'sidebar'):?>
				<?php include( 'templates/sidebar.php');?>

			<?php elseif( $tax_slug === 'marketing'):?>
				<?php include( 'templates/marketing.php');?>
			
			<?php elseif( $tax_slug === 'newsletter'):?>
				<?php include( 'templates/newsletter.php');?>
			
			<?php elseif( $tax_slug === 'newsletter-2'):?>
				<?php include( 'templates/newsletter 2.php');?>
			
			<?php elseif( $tax_slug === 'sidebar-hero'):?>
				<?php include( 'templates/sidebar-hero.php');?>
			
			<?php elseif( $tax_slug === 'order'):?>
				<?php include( 'templates/order.php');?>
			
			<?php elseif( $tax_slug === 'drip'):?>
				<?php include( 'templates/drip.php');?>
			
			<?php elseif( $tax_slug === 'password_reset'):?>
				<?php include( 'templates/password-reset.php');?>
			
			<?php elseif( $tax_slug === 'welcome.php'):?>
				<?php include( 'templates/welcome.php');?>
			
			<?php endif; ?>
	</aside><!-- .sidebar .widget-area -->
	*/ ?>

			
		<?php endwhile;?>
<?php endif; ?>


</div><!-- .content-area -->

<!-- https://github.com/jjriv/emogrifier -->

<?php get_footer(); ?>

<!-- Sending Inline Images is documented here.

In the HTML, you'll reference the image like this:

<html>Inline image here: <img src="cid:test.jpg"></html>
Then, define a Multidict, to post the files to the API:

files=MultiDict([("inline", open("files/test.jpg"))])
Disclosure, I work for Mailgun. :) -->

<!-- # Make the call to the client.
$result = $mgClient->sendMessage($domain, array(
    'from'    => 'Excited User <YOU@YOUR_DOMAIN_NAME>',
    'to'      => 'foo@example.com',
    'cc'      => 'baz@example.com',
    'bcc'     => 'bar@example.com',
    'subject' => 'Hello',
    'text'    => 'Testing some Mailgun awesomness!',
    'html'    => '<html>Inline image: <img src="cid:test.jpg"></html>'
), array(
    'inline' => array('/path/to/test.jpg')
)); -->




<!-- // $time = current_time('mysql');

// $data = array(
//     'comment_post_ID' => 1,
//     'comment_author' => 'admin',
//     'comment_author_email' => 'admin@admin.com',
//     'comment_author_url' => 'http://',
//     'comment_content' => 'content here',
//     'comment_type' => '',
//     'comment_parent' => 0,
//     'user_id' => 1,
//     'comment_author_IP' => '127.0.0.1',
//     'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
//     'comment_date' => $time,
//     'comment_approved' => 1,
// );

// wp_insert_comment($data);
 -->