<?php
/**
 * Admin page setup
 *
 * @since      1.0.0
 * @author     Beeketing
 */

namespace Beeketing\CheckoutBoost\PageManager;


use Beeketing\CheckoutBoost\Data\Constant;

class AdminPage
{
    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->hooks();
    }

    /**
     * Setup Hooks
     *
     * @since 1.0.0
     */
    public function hooks()
    {
        add_action( 'admin_menu', array( $this, 'app_menu' ), 200 );
    }

    /**
     * Sidebar tab
     *
     * @since 1.0.0
     */
    public function app_menu()
    {
        // Add to admin_menu
        add_menu_page(
            'Checkout Boost Menu Page',
            __( 'Checkout Boost' ),
            'edit_theme_options',
            Constant::PLUGIN_ADMIN_URL,
            array( $this, 'main_page_content' ),
            plugins_url( 'dist/images/icon.png', CHECKOUTBOOST_PLUGIN_DIRNAME )
        );
    }

    /**
     * Main page content.
     *
     * @since 1.0.0
     */
    public function main_page_content()
    {
        include( CHECKOUTBOOST_PLUGIN_DIR . 'templates/admin/index.html' );
    }
}