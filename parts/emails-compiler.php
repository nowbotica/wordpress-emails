<?php
$term_list = wp_get_post_terms($post->ID, 'email_templates', array("fields" => "all"));
$tax_name = $term_list[0]->name;
$tax_desc = $term_list[0]->description;
$tax_slug = $term_list[0]->slug;
?>
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
	<?php include( 'templates/newsletter-2.php');?>

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