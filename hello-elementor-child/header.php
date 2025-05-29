<?php
// Your existing PHP code, if any...

// Define variables if they aren't already set to avoid errors
if ( ! isset( $viewport_content ) ) {
    $viewport_content = 'width=device-width, initial-scale=1';
}
if ( ! isset( $enable_skip_link ) ) {
    $enable_skip_link = true;
}
if ( ! isset( $skip_link_url ) ) {
    $skip_link_url = '#content';
}
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="<?php echo esc_attr( $viewport_content ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<script async type='text/javascript' src='https://static.klaviyo.com/onsite/js/klaviyo.js?company_id=TAvE8a'></script>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php if ( $enable_skip_link ) { ?>
<a class="skip-link screen-reader-text" href="<?php echo esc_url( $skip_link_url ); ?>"><?php echo esc_html__( 'Skip to content', 'hello-elementor' ); ?></a>
<?php } ?>

<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	if ( hello_elementor_display_header_footer() ) {
		if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
			get_template_part( 'template-parts/dynamic-header' );
		} else {
			get_template_part( 'template-parts/header' );
		}
	}
}
?>
