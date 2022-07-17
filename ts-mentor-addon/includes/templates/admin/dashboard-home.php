<?php
/**
 * Dashboard home template
 */

defined( 'ABSPATH' ) || die();
?>
<div class="ha-dashboard-panel">
    <div class="ha-home-banner">
        <div class="ha-home-banner__content">
            <img class="ha-home-banner__logo" src="<?php echo TS_MENTOR_ASSET_URL; ?>imgs/admin/halogo.svg" alt="">
            <span class="ha-home-banner__divider"></span>
            <h2><?php esc_html_e('Thanks a lot ', 'tsmentor'); ?><br><span><?php esc_html_e('for choosing HappyAddons', 'tsmentor'); ?></span></h2>
        </div>
    </div>
    <div class="ha-home-body">
        <div class="ha-row ha-py-5 ha-align-items-center">
            <div class="ha-col ha-col-6">
                <img class="ha-img-fluid ha-title-icon-size" src="<?php echo TS_MENTOR_ASSET_URL; ?>imgs/admin/knowledge.svg" alt="">
                <h3 class="ha-feature-title"><?php esc_html_e('Knowledge & Wiki', 'happy-elementor-addons'); ?></h3>
                <p class="f18"><?php esc_html_e('We have created full-proof documentation for you. It will help you to understand how our plugin works.', 'happy-elementor-addons'); ?></p>
                <a class="ha-btn ha-btn-primary" target="_blank" rel="noopener" href="https://happyaddons.com/go/docs"><?php esc_html_e('Take Me to The Knowledge Page', 'happy-elementor-addons'); ?></a>
            </div>
            <div class="ha-col ha-col-6">
                <img class="ha-img-fluid" src="<?php echo TS_MENTOR_ASSET_URL; ?>imgs/admin/art1.png" alt="">
            </div>
        </div>
        
        



    </div>
</div>
