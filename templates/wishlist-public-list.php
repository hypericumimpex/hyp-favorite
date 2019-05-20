<?php
/**
 * List of public wishlists
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.2.9
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>
<div class="yith-wcwl-public-lists">
	<?php
	if( ! empty( $wishlists ) ):
		foreach ( $wishlists as $wishlist ):
			$wishlist_url = YITH_WCWL()->get_wishlist_url( 'view' . '/' . $wishlist['wishlist_token'] );
			$wishlist_name = ( !empty( $wishlist['wishlist_name'] ) ) ? $wishlist['wishlist_name'] : get_option( 'yith_wcwl_wishlist_title' );
			?>
			<p><a href="<?php echo esc_attr( $wishlist_url )?>"><?php echo $wishlist_name ?></a></p>
			<?php
		endforeach;
	endif;
	?>
</div>
