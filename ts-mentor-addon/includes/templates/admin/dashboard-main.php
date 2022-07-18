<?php
/**
 * Dashboard main template
 */

defined( 'ABSPATH' ) || die();
?>
<div class="ts">
<div class="container m-3">
    
    <form class="ts-dashboard" id="ts-dashboard-form">
        <div class="ts-dashboard-tabs" role="tablist">
            <div class="tabs is-boxed m-0">
                <ul>
                <?php
                $tab_count = 1;
                foreach ( self::get_tabs() as $slug => $data ) :
                    $slug = esc_attr( strtolower( $slug ) );
                    $class = 'ts-tabs__nav-item--' . $slug;

                    if ( empty( $data['renderer'] ) || ! is_callable( $data['renderer'] ) ) {
                        $class .= ' nav-item-is--link';
                    }

                    if ( $tab_count === 1 ) {
                        $class .= ' is-active';
                    }

                    if ( ! empty( $data['href'] ) ) {
                        $href = esc_url( $data['href'] );
                    } else {
                        $href = '#' . $slug;
                    }

                    printf( '<li class="%3$s"><a href="%1$s" aria-controls="tab-content-%2$s" id="tab-nav-%2$s" class="" role="tab">%4$s</a></li>',
                        $href,
                        $slug,
                        $class,
                        isset( $data['title'] ) ? $data['title'] : sprintf( esc_html__( 'Tab %s', 'tsmentor' ), $tab_count )
                    );

                    ++$tab_count;
                endforeach;
                ?>

                <li><button disabled class="ha-dashboard-tabs__nav-btn ha-dashboard-btn ha-dashboard-btn--lg ha-dashboard-btn--save" type="submit"><?php esc_html_e( 'Save Settings', 'happy-elementor-addons' ); ?></button></li>
                </ul>
            </div>
            <div class="ha-dashboard-tabs__content box">
                <?php
                $tab_count = 1;
                foreach ( self::get_tabs() as $slug => $data ) :
                    if ( empty( $data['renderer'] ) || ! is_callable( $data['renderer'] ) ) {
                        continue;
                    }

                    $class = 'ha-dashboard-tabs__content-item';
                    if ( $tab_count === 1 ) {
                        $class .= ' tab--is-active';
                    }

                    $slug = esc_attr( strtolower( $slug ) );
                    ?>
                    <div class="<?php echo $class; ?>" id="tab-content-<?php echo $slug; ?>" role="tabpanel" aria-labelledby="tab-nav-<?php echo $slug; ?>">
                        <?php call_user_func( $data['renderer'], $slug, $data ); ?>
                    </div>
                    <?php
                    ++$tab_count;
                endforeach;
                ?>
            </div>
        </div>
    </form>
</div>
</div>