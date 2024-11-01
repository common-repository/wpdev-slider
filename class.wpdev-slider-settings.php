<?php 

if( ! class_exists( 'WPDEV_Slider_Settings' )){
    class WPDEV_Slider_Settings{

        public static $options;

        public function __construct(){
            self::$options = get_option( 'wpdev_slider_options' );
            add_action( 'admin_init', array( $this, 'admin_init') );
        }

        public function admin_init(){
            
            register_setting( 'wpdev_slider_group', 'wpdev_slider_options', array( $this, 'wpdev_slider_validate' ) );

            add_settings_section(
                'wpdev_slider_main_section',
                esc_html__( 'How does it work?', 'wpdev-slider' ),
                null,
                'wpdev_slider_page1'
            );

            add_settings_section(
                'wpdev_slider_second_section',
                esc_html__( 'Other Plugin Options', 'wpdev-slider' ),
                null,
                'wpdev_slider_page2'
            );

            add_settings_field(
                'wpdev_slider_shortcode',
                esc_html__( 'Shortcode', 'wpdev-slider' ),
                array( $this, 'wpdev_slider_shortcode_callback' ),
                'wpdev_slider_page1',
                'wpdev_slider_main_section'
            );

            add_settings_field(
                'wpdev_slider_title',
                esc_html__( 'Slider Title', 'wpdev-slider' ),
                array( $this, 'wpdev_slider_title_callback' ),
                'wpdev_slider_page2',
                'wpdev_slider_second_section',
                array(
                    'label_for' => 'wpdev_slider_title'
                )
            );

            add_settings_field(
                'wpdev_slider_bullets',
                esc_html__( 'Display Bullets', 'wpdev-slider' ),
                array( $this, 'wpdev_slider_bullets_callback' ),
                'wpdev_slider_page2',
                'wpdev_slider_second_section',
                array(
                    'label_for' => 'wpdev_slider_bullets'
                )
            );

            add_settings_field(
                'wpdev_slider_style',
                esc_html__( 'Slider Style', 'wpdev-slider' ),
                array( $this, 'wpdev_slider_style_callback' ),
                'wpdev_slider_page2',
                'wpdev_slider_second_section',
                array(
                    'items' => array(
                        'style-1',
                        'style-2'
                    ),
                    'label_for' => 'wpdev_slider_style'
                )
                
            );
        }

        public function wpdev_slider_shortcode_callback(){
            ?>
            <span><?php esc_html_e( 'Use the shortcode [wpdev_slider] to display the slider in any page/post/widget', 'wpdev-slider' ); ?></span>
            <?php
        }

        public function wpdev_slider_title_callback( $args ){
            ?>
                <input 
                type="text" 
                name="wpdev_slider_options[wpdev_slider_title]" 
                id="wpdev_slider_title"
                value="<?php echo isset( self::$options['wpdev_slider_title'] ) ? esc_attr( self::$options['wpdev_slider_title'] ) : ''; ?>"
                >
            <?php
        }
        
        public function wpdev_slider_bullets_callback( $args ){
            ?>
                <input 
                    type="checkbox"
                    name="wpdev_slider_options[wpdev_slider_bullets]"
                    id="wpdev_slider_bullets"
                    value="1"
                    <?php 
                        if( isset( self::$options['wpdev_slider_bullets'] ) ){
                            checked( "1", self::$options['wpdev_slider_bullets'], true );
                        }    
                    ?>
                />
                <label for="wpdev_slider_bullets"><?php esc_html_e( 'Whether to display bullets or not', 'wpdev-slider' ); ?></label>
                
            <?php
        }

        public function wpdev_slider_style_callback( $args ){
            ?>
            <select 
                id="wpdev_slider_style" 
                name="wpdev_slider_options[wpdev_slider_style]">
                <?php 
                foreach( $args['items'] as $item ):
                ?>
                    <option value="<?php echo esc_attr( $item ); ?>" 
                        <?php 
                        isset( self::$options['wpdev_slider_style'] ) ? selected( $item, self::$options['wpdev_slider_style'], true ) : ''; 
                        ?>
                    >
                        <?php echo esc_html( ucfirst( $item ) ); ?>
                    </option>                
                <?php endforeach; ?>
            </select>
            <?php
        }

        public function wpdev_slider_validate( $input ){
            $new_input = array();
            foreach( $input as $key => $value ){
                switch ($key){
                    case 'wpdev_slider_title':
                        if( empty( $value )){
                            add_settings_error( 'wpdev_slider_options', 'wpdev_slider_message', esc_html__( 'The title field can not be left empty', 'wpdev-slider' ), 'error' );
                            $value = esc_html__( 'Please, type some text', 'wpdev-slider' );
                        }
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                    default:
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                }
            }
            return $new_input;
        }

    }
}

