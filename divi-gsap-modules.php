<?php
/*
Plugin Name: Divi GSAP Modules
Plugin URI: https://yoursite.com
Description: Custom Divi modules with GSAP animations
Version: 1.0.0
Author: Your Name
License: GPL2
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// FORCE DEBUG TEST - This should show up somewhere
error_log('=== DIVI GSAP PLUGIN LOADED ===');

// Also try PHP error log directly
if (function_exists('error_log')) {
    error_log('DIVI GSAP: PHP error_log function available');
} else {
    // Write to a custom file if error_log doesn't work
    file_put_contents(ABSPATH . 'gsap-debug.txt', date('Y-m-d H:i:s') . " - Plugin loaded\n", FILE_APPEND);
}

define('DIVI_GSAP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DIVI_GSAP_PLUGIN_URL', plugin_dir_url(__FILE__));

class DiviGSAPModules {
    
    public function __construct() {
        // Use et_builder_ready since that's the one that's actually firing
        add_action('et_builder_ready', array($this, 'initialize_extension'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        
        // Keep some debug hooks for testing
        add_action('et_builder_ready', array($this, 'hook_test_et_builder_ready'));
    }
    
    public function hook_test_et_builder_ready() {
        error_log('DIVI GSAP: et_builder_ready hook fired!');
        file_put_contents(ABSPATH . 'gsap-debug.txt', date('Y-m-d H:i:s') . " - et_builder_ready fired\n", FILE_APPEND);
    }
    
    public function initialize_extension() {
        // Check if Divi is active and file exists
        if (class_exists('ET_Builder_Module')) {
            $extension_file = DIVI_GSAP_PLUGIN_DIR . 'includes/DiviGSAPExtension.php';
            if (file_exists($extension_file)) {
                require_once $extension_file;
                error_log('DIVI GSAP: Extension file loaded successfully');
                file_put_contents(ABSPATH . 'gsap-debug.txt', date('Y-m-d H:i:s') . " - Extension file loaded\n", FILE_APPEND);
            } else {
                error_log('DIVI GSAP: Extension file not found at: ' . $extension_file);
                file_put_contents(ABSPATH . 'gsap-debug.txt', date('Y-m-d H:i:s') . " - Extension file NOT found at: " . $extension_file . "\n", FILE_APPEND);
            }
        } else {
            error_log('DIVI GSAP: ET_Builder_Module class not found - Divi not active?');
            file_put_contents(ABSPATH . 'gsap-debug.txt', date('Y-m-d H:i:s') . " - ET_Builder_Module class not found\n", FILE_APPEND);
        }
    }
    
    public function enqueue_scripts() {
        // Enqueue GSAP from CDN
        wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), '3.12.2', true);
        
        // Debug: Log that we're enqueueing GSAP
        error_log('DIVI GSAP: Enqueuing GSAP from CDN');
        
        // Enqueue our custom scripts
        $frontend_js = DIVI_GSAP_PLUGIN_URL . 'scripts/frontend.js';
        if (file_exists(DIVI_GSAP_PLUGIN_DIR . 'scripts/frontend.js')) {
            wp_enqueue_script('divi-gsap-frontend', $frontend_js, array('gsap'), '1.0.0', true);
            error_log('DIVI GSAP: Enqueuing frontend.js');
        }
        
        // Force cache busting for visual-builder.js
        $visual_builder_js = DIVI_GSAP_PLUGIN_URL . 'scripts/visual-builder.js';
        $cache_buster = '?v=' . time(); // Force cache busting
        
        if (file_exists(DIVI_GSAP_PLUGIN_DIR . 'scripts/visual-builder.js')) {
            wp_enqueue_script(
                'divi-gsap-visual-builder', 
                $visual_builder_js . $cache_buster, 
                array('jquery'), 
                time(), // Use timestamp as version
                true
            );
            error_log('DIVI GSAP: Enqueuing visual-builder.js with cache buster: ' . $visual_builder_js . $cache_buster);
        } else {
            error_log('DIVI GSAP: visual-builder.js file NOT found');
        }
    }
}

// Initialize only after WordPress is fully loaded
add_action('init', function() {
    new DiviGSAPModules();
});

// Add admin notice to see if plugin is working
add_action('admin_notices', function() {
    if (current_user_can('manage_options')) {
        echo '<div class="notice notice-info"><p>DIVI GSAP Plugin is active!</p></div>';
    }
});

// Debug footer check for module class
add_action('wp_footer', function() {
    if (current_user_can('edit_posts')) {
        echo '<!-- DIVI GSAP DEBUG: ';
        echo class_exists('DGSP_GSAPFadeIn') ? 'Module class exists' : 'Module class NOT found';
        echo ' -->';
    }
});
?>