<?php
/**
 * Dashboard widgets tab template
 */

defined( 'ABSPATH' ) || die();

$widgets = self::get_widgets();
//$catwise_widgets = self::get_widget_map_catwise();
$inactive_widgets = \TS\Classes\ModuleManager::get_inactive_widgets();

$total_widgets_count = count( $widgets );


?>
<div class="ha-dashboard-panel">
    <div class="ha-dashboard-panel__header">
        <div class="ha-dashboard-panel__header-content">
            <h2><?php esc_html_e( 'Happy Widgets', 'happy-elementor-addons' ); ?></h2>
            <p class="f16"><?php printf( esc_html__( 'Here is the list of our all %s widgets. You can enable or disable widgets from here to optimize loading speed and Elementor editor experience. %sAfter enabling or disabling any widget make sure to click the Save Changes button.%s', 'happy-elementor-addons' ), $total_widgets_count, '<strong>', '</strong>' ); ?></p>

        </div>
    </div>

    <div class="ha-dashboard-widgets list">
        <?php


				if( $widgets ):
					foreach ( $widgets as $widget_key => $widget_data ) :
                        var_dump($widget_data);
                        $widget_data=$widget_data['modules'][$widget_key];
						$title = isset( $widget_data['label'] ) ? $widget_data['label'] : '';
						$icon = isset( $widget_data['icon'] ) ? $widget_data['icon'] : '';
						$is_pro = isset( $widget_data['is_pro'] ) && $widget_data['is_pro'] ? true : false;
						//$demo_url = isset( $widget_data['demo'] ) && $widget_data['demo'] ? $widget_data['demo'] : '';
						$is_placeholder = $is_pro && ! ts_has_pro();
						//$class_attr = 'ha-dashboard-widgets__item';

						if ( $is_pro ) {
							$class_attr .= ' item--is-pro';
						}

						$checked = '';

						if ( ! in_array( $widget_key, $inactive_widgets ) ) {
							$checked = 'checked="checked"';
						}

						if ( $is_placeholder ) {
							$class_attr .= ' item--is-placeholder';
							$checked = 'disabled="disabled"';
						}
						?>
                        
                          <div class="list-item">
                            <div class="list-item-image">
                              <i class="<?php echo $icon?>" aria-hidden="true"></i>
                            </div>

                            <div class="list-item-content">
                              <div class="list-item-title"><?php echo $title?></div>
                            </div>

                            <div class="list-item-controls">
                                <div class="field">
                                  <input id="ts-widget-<?php echo $widget_key; ?>" type="checkbox" name="switchRoundedDefault" class="switch is-rounded" <?php echo $checked; ?>>
                                </div>
                            </div>
                          </div>
                        
					<?php
					endforeach;
				endif;

	
        ?>
    </div>

    <div class="ha-dashboard-panel__footer">
        <button disabled class="ha-dashboard-btn ha-dashboard-btn--save" type="submit"><?php esc_html_e( 'Save Settings', 'happy-elementor-addons' ); ?></button>
    </div>
</div>
