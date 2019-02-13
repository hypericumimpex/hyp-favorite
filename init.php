<?php
/**
 * Plugin Name: HYP Favorite
 * Plugin URI: https://github.com/hypericumimpex/hyp-favorite/
 * Description: <code><strong>HYP Favorite</strong></code> oferă utilizatorilor posibilitatea de a crea, gestiona și partaja liste cu produse favorite.
 * Version: 2.2.8
 * Author: Romeo C.
 * Author URI: https://github.com/hypericumimpex/
 * Text Domain: yith-woocommerce-wishlist
 * Domain Path: /languages/
 * WC requires at least: 2.5.0
 * WC tested up to: 3.5.0
 *
 * @author Romeo C.
 * @package HYP Favorite
 * @version 2.0.0
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

if ( ! defined( 'YITH_WCWL' ) ) {
    define( 'YITH_WCWL', true );
}

if ( ! defined( 'YITH_WCWL_URL' ) ) {
    define( 'YITH_WCWL_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YITH_WCWL_DIR' ) ) {
    define( 'YITH_WCWL_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YITH_WCWL_INC' ) ) {
    define( 'YITH_WCWL_INC', YITH_WCWL_DIR . 'includes/' );
}

if ( ! defined( 'YITH_WCWL_INIT' ) ) {
    define( 'YITH_WCWL_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WCWL_SLUG' ) ) {
    define( 'YITH_WCWL_SLUG', 'yith-woocommerce-wishlist' );
}

if ( ! defined( 'YITH_WCWL_SECRET_KEY' ) ) {
    define( 'YITH_WCWL_SECRET_KEY', 'ky18RdyseqSoSPgdungS' );
}

if ( ! defined( 'YITH_WCWL_PREMIUM' ) ) {
    define( 'YITH_WCWL_PREMIUM', '1' );
}

if ( ! defined( 'YITH_WCWL_PREMIUM_INIT' ) ) {
    define( 'YITH_WCWL_PREMIUM_INIT', plugin_basename( __FILE__ ) );
}

/* Plugin Framework Version Check */
if( ! function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( YITH_WCWL_DIR . 'plugin-fw/init.php' ) ) {
    require_once( YITH_WCWL_DIR . 'plugin-fw/init.php' );
}
yit_maybe_plugin_fw_loader( YITH_WCWL_DIR  );

if( ! function_exists( 'yith_wishlist_constructor' ) ) {
    function yith_wishlist_constructor() {

        load_plugin_textdomain( 'yith-woocommerce-wishlist', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

        // Load required classes and functions
        require_once( YITH_WCWL_INC . 'functions.yith-wcwl.php' );
        require_once( YITH_WCWL_INC . 'class.yith-wcwl.php' );
        require_once( YITH_WCWL_INC . 'class.yith-wcwl-premium.php' );
        require_once( YITH_WCWL_INC . 'class.yith-wcwl-init.php' );
        require_once( YITH_WCWL_INC . 'class.yith-wcwl-install.php' );
        require_once( YITH_WCWL_INC . 'widgets/class.yith-wcwl-widget.php' );

        if ( is_admin() ) {
            require_once( YITH_WCWL_INC . 'class.yith-wcwl-admin-init.php' );
            require_once( YITH_WCWL_INC . 'class.yith-wcwl-admin-premium.php' );
        }

        if ( get_option( 'yith_wcwl_enabled' ) == 'yes' ) {
            require_once( YITH_WCWL_INC . 'class.yith-wcwl-ui.php' );
            require_once( YITH_WCWL_INC . 'class.yith-wcwl-shortcode.php' );
            require_once( YITH_WCWL_INC . 'class.yith-wcwl-shortcode-premium.php' );
        }

        // Let's start the game!

        /**
         * @deprecated
         */
        global $yith_wcwl;
        $yith_wcwl = YITH_WCWL_Premium();
    }
}
add_action( 'yith_wcwl_init', 'yith_wishlist_constructor' );

if( ! function_exists( 'yith_wishlist_install' ) ) {
    function yith_wishlist_install() {

        if ( ! function_exists( 'is_plugin_active' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }

        if ( ! function_exists( 'yit_deactive_free_version' ) ) {
            require_once 'plugin-fw/yit-deactive-plugin.php';
        }
        yit_deactive_free_version( 'YITH_WCWL_FREE_INIT', plugin_basename( __FILE__ ) );

        if ( function_exists( 'yith_deactive_jetpack_module' ) ) {
            global $yith_jetpack_1;
            yith_deactive_jetpack_module( $yith_jetpack_1, 'YITH_WCWL_PREMIUM_INIT', plugin_basename( __FILE__ ) );
        }

        if ( ! function_exists( 'WC' ) ) {
            add_action( 'admin_notices', 'yith_wcwl_install_woocommerce_admin_notice' );
        }
        else {
            do_action( 'yith_wcwl_init' );
        }
    }
}
add_action( 'plugins_loaded', 'yith_wishlist_install', 11 );

if( ! function_exists( 'yith_wcwl_install_woocommerce_admin_notice' ) ) {
    function yith_wcwl_install_woocommerce_admin_notice() {
        ?>
        <div class="error">
            <p><?php echo 'YITH WooCommerce Wishlist ' . __( 'is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-wishlist' ); ?></p>
        </div>
    <?php
    }
}