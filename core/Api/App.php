<?php
/**
 * App api
 *
 * @since      1.0.0
 * @author     Beeketing
 *
 */

namespace Beeketing\CheckoutBoost\Api;


use Beeketing\CheckoutBoost\Data\Constant;
use BKCheckoutBoostSDK\Api\CommonApi;
use BKCheckoutBoostSDK\Data\AppCodes;
use BKCheckoutBoostSDK\Libraries\SettingHelper;

class App extends CommonApi
{
    private $api_key;

    /**
     * App constructor.
     *
     * @param $api_key
     */
    public function __construct( $api_key )
    {
        $this->api_key = $api_key;
        $setting_helper = new SettingHelper();
        $setting_helper->set_app_setting_key( \BKCheckoutBoostSDK\Data\AppSettingKeys::CHECKOUTBOOST_KEY );
        $setting_helper->set_plugin_version( CHECKOUTBOOST_VERSION );

        parent::__construct(
            $setting_helper,
            CHECKOUTBOOST_PATH,
            CHECKOUTBOOST_API,
            $api_key,
            AppCodes::CHECKOUTBOOST,
            Constant::PLUGIN_ADMIN_URL
        );
    }

    /**
     * Get routers
     *
     * @return array
     */
    public function get_routers()
    {
        $result = $this->get( 'cboost/routers' );

        if ( $result && !isset( $result['errors'] ) ) {
            foreach ( $result as &$item ) {
                if ( strpos( $item, 'http' ) === false ) {
                    $end_point = CHECKOUTBOOST_PATH;
                    if ( CHECKOUTBOOST_ENVIRONMENT == 'local' ) {
                        $end_point = str_replace( '/app_dev.php', '', $end_point );
                    }
                    $item = $end_point . $item;
                }
            }

            return $result;
        }

        return array();
    }

    /**
     * Get api urls
     *
     * @return array
     */
    public function get_api_urls()
    {
        return array_merge( array(
            'reports' => $this->get_url( 'cboost/reports/{type}' ),
            'app_data' => $this->get_url( 'cboost/data' ),
        ), parent::get_api_urls() );
    }
}