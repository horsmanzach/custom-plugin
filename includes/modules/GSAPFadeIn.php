<?php

class DGSP_GSAPFadeIn extends ET_Builder_Module {

    public $slug       = 'dgsp_gsap_fadein';
    public $vb_support = 'on';
    public $child_title_var = 'admin_label';
    public $child_title_fallback = 'GSAP Module';

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'Your Name',
        'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__('GSAP Fade In', 'dgsp-divi-gsap-modules');
        $this->main_css_element = '%%order_class%%';
        
        // Enable advanced options
        $this->settings_modal_toggles = array(
            'general'  => array(
                'toggles' => array(
                    'main_content' => esc_html__('Content', 'dgsp-divi-gsap-modules'),
                    'animation' => esc_html__('GSAP Animation', 'dgsp-divi-gsap-modules'),
                ),
            ),
        );

        $this->advanced_fields = array(
            'borders'               => array(),
            'margin_padding'        => array(),
            'filters'               => array(),
            'box_shadow'            => array(),
            'button'                => false,
        );
    }

    public function get_fields() {
        return array(
            'module_text' => array(
                'label'           => esc_html__('Content', 'dgsp-divi-gsap-modules'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Enter the content that will fade in.', 'dgsp-divi-gsap-modules'),
                'toggle_slug'     => 'main_content',
            ),
            'gsap_duration' => array(
                'label'           => esc_html__('Animation Duration (seconds)', 'dgsp-divi-gsap-modules'),
                'type'            => 'range',
                'option_category' => 'configuration',
                'default'         => '1',
                'range_settings'  => array(
                    'min'  => '0.1',
                    'max'  => '5',
                    'step' => '0.1',
                ),
                'toggle_slug'     => 'animation',
                'description'     => esc_html__('Set the duration of the fade in animation.', 'dgsp-divi-gsap-modules'),
            ),
            'gsap_delay' => array(
                'label'           => esc_html__('Animation Delay (seconds)', 'dgsp-divi-gsap-modules'),
                'type'            => 'range',
                'option_category' => 'configuration',
                'default'         => '0',
                'range_settings'  => array(
                    'min'  => '0',
                    'max'  => '5',
                    'step' => '0.1',
                ),
                'toggle_slug'     => 'animation',
                'description'     => esc_html__('Set the delay before the animation starts.', 'dgsp-divi-gsap-modules'),
            ),
            'trigger_on_scroll' => array(
                'label'           => esc_html__('Trigger on Scroll', 'dgsp-divi-gsap-modules'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'off' => esc_html__('No', 'dgsp-divi-gsap-modules'),
                    'on'  => esc_html__('Yes', 'dgsp-divi-gsap-modules'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'animation',
                'description'     => esc_html__('Whether to trigger the animation when the element comes into view.', 'dgsp-divi-gsap-modules'),
            ),
        );
    }

    public function render($attrs, $content = null, $render_slug = '') {
        // Get the module properties
        $gsap_duration = $this->props['gsap_duration'];
        $gsap_delay = $this->props['gsap_delay'];
        $trigger_on_scroll = $this->props['trigger_on_scroll'];
        
        // Get content using the field name we defined
        $module_text = $this->props['module_text'];
        
        // Process the content
        $module_text = $this->_render_module_content($module_text, $render_slug);
        
        // Create unique ID for this module instance
        $module_id = 'dgsp-gsap-' . wp_rand(1000, 9999);

        // Add data attributes for JavaScript
        $data_attrs = sprintf(
            'data-duration="%s" data-delay="%s" data-trigger-scroll="%s"',
            esc_attr($gsap_duration),
            esc_attr($gsap_delay),
            esc_attr($trigger_on_scroll)
        );

        // Create the output
        $output = sprintf(
            '<div id="%s" class="%s dgsp-gsap-fadein-content" %s style="opacity: 0;">
                %s
            </div>',
            esc_attr($module_id),
            esc_attr($this->module_classname($render_slug)),
            $data_attrs,
            $module_text
        );

        return $output;
    }

    protected function _render_module_content($content, $render_slug) {
        return $this->_esc_attr($content);
    }
}

new DGSP_GSAPFadeIn;
?>