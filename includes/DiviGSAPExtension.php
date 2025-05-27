<?php

// Simple approach - no DiviExtension class
error_log('DIVI GSAP: DiviGSAPExtension.php file loaded');
file_put_contents(ABSPATH . 'gsap-debug.txt', date('Y-m-d H:i:s') . " - DiviGSAPExtension.php loaded\n", FILE_APPEND);

// Load the module directly
$module_file = plugin_dir_path(__FILE__) . 'modules/GSAPFadeIn.php';
error_log('DIVI GSAP: Looking for module at: ' . $module_file);

if (file_exists($module_file)) {
    require_once $module_file;
    error_log('DIVI GSAP: Module file loaded successfully');
    file_put_contents(ABSPATH . 'gsap-debug.txt', date('Y-m-d H:i:s') . " - Module file loaded\n", FILE_APPEND);
} else {
    error_log('DIVI GSAP: Module file NOT found at: ' . $module_file);
    file_put_contents(ABSPATH . 'gsap-debug.txt', date('Y-m-d H:i:s') . " - Module file NOT found at: " . $module_file . "\n", FILE_APPEND);
}
?>