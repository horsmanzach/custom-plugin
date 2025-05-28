<?php

class DGSP_GSAPFadeIn extends ET_Builder_Module {

    public $slug       = 'dgsp_gsap_fadein';
    public $vb_support = 'on';

    public function init() {
        $this->name = esc_html__('GSAP Fade In', 'dgsp-divi-gsap-modules');
    }

    public function get_fields() {
        return array(
            'test_content' => array(
                'label' => 'Test Content',
                'type'  => 'text',
                'default' => 'Hello World Test',
            ),
        );
    }

    public function render($attrs, $content = null, $render_slug = '') {
        $test_content = $this->props['test_content'];
        
        // Check if we're in Visual Builder and handle accordingly
        $is_visual_builder = function_exists('et_core_is_fb_enabled') && et_core_is_fb_enabled();
        
        if ($is_visual_builder) {
            // Visual Builder - super simple output
            return sprintf(
                '<div class="test-gsap-module" style="padding: 20px; border: 2px solid blue;">
                    <h3>VISUAL BUILDER MODE</h3>
                    <p>Hardcoded: This should show in Visual Builder</p>
                    <p>From field: %s</p>
                    <p>Is VB: %s</p>
                </div>',
                esc_html($test_content),
                $is_visual_builder ? 'TRUE' : 'FALSE'
            );
        } else {
            // Frontend - normal output
            return sprintf(
                '<div class="test-gsap-module" style="padding: 20px; border: 2px solid green;">
                    <h3>FRONTEND MODE</h3>
                    <p>Hardcoded: This should show on frontend</p>
                    <p>From field: %s</p>
                </div>',
                esc_html($test_content)
            );
        }
    }
}

new DGSP_GSAPFadeIn;
?>