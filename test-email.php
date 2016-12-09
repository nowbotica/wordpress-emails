<?php
/**
 * Template Name: Test Email
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

<?php get_header(); ?>

	<h1>Emails</h1>

<button>search from current campiagns</button>

<div id="primary">
	<div id="content" role="main">
		<div style="box-sizing: border-box; width:50%; padding:20px; float:left;background: black;border-radius: 19px;border:1px solid silver;">
			<iframe src="http://utility.ecowelle.com/email/email-style-one/" width="500" height="1000" id="email-style-one">
			</iframe>
		</div>
		<div style="box-sizing: border-box; width:50%; padding:20px; float:left;">
	<!-- <iframe id="iframe-preview" > -->
		<?php while ( have_posts() ) : the_post(); ?>
			<h5><b>To:</b> <?php the_field('to'); ?></h5>
			<h5><b>CC:</b> <?php the_field('cc'); ?></h5>
			<h5><b>Subject:</b> <?php the_field('subject'); ?></h5>

			<form id="emails-builder">
			<input type="hidden" name="email_to" value="<?php the_field('to'); ?>">
			<input type="hidden" name="email_cc" value="<?php the_field('cc'); ?>">
			<input type="hidden" name="email_subject" value="<?php the_field('subject'); ?>">
			<!-- 	  First name:<br>
				  <input type="text" name="firstname"><br>
				  Last name:<br>
				  <input type="text" name="lastname"> -->
				  <!-- <input type="submit" value="Send Now" id="sendform"> -->
				  <input type="submit" value="Send Now" id="sendform">
			</form>
			<section class="content" style="visibility: hidden;">
				<div class="editable-1"><?php the_field('intro_text'); ?></div>
				<div><?php the_field('call_to_action_link'); ?></div>
				<div><?php the_field('call_to_action_message'); ?></div>
				<div class="editable-2"><?php the_field('secondary_text'); ?></div>
			</section>


		<?php endwhile; // end of the loop. ?>
		</div>

	</div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>
