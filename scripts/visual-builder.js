// Visual Builder React Component Registration
console.log('Registering Visual Builder React component...');

// Wait for Divi's module system to be ready
document.addEventListener('DOMContentLoaded', function () {

    // Check if Divi's module system is available
    if (typeof window.et_pb_custom !== 'undefined' && window.et_pb_custom.modules) {
        console.log('Divi module system found, registering component...');

        // Register our custom render function
        window.et_pb_custom.modules.push(function ($module) {
            if ($module.hasClass('dgsp_gsap_fadein')) {
                console.log('Rendering GSAP module in Visual Builder');

                // Replace the content with our own
                var $inner = $module.find('.et_pb_module_inner');
                if ($inner.length > 0) {
                    $inner.html(`
                        <div class="visual-builder-gsap-content" style="padding: 20px; border: 2px solid blue; background: #f0f8ff;">
                            <h3>GSAP Fade In Module</h3>
                            <p><strong>Visual Builder Preview</strong></p>
                            <p>This content will have GSAP animation on the frontend.</p>
                            <p>Configure animation settings in the module options.</p>
                        </div>
                    `);

                    // Make sure it's visible
                    $module.css('opacity', '1');
                    $inner.css('opacity', '1');
                }
            }
        });
    }

    // Also try a more direct approach - monitor for modules and replace content
    setInterval(function () {
        jQuery('.dgsp_gsap_fadein .et_pb_module_inner').each(function () {
            var $inner = jQuery(this);
            var currentContent = $inner.html();

            // If we see the function string, replace it
            if (currentContent.indexOf('function(') === 0 || currentContent.indexOf('rawContentProcesser') !== -1) {
                console.log('Replacing broken content in Visual Builder');
                $inner.html(`
                    <div class="visual-builder-gsap-content" style="padding: 20px; border: 2px solid blue; background: #f0f8ff;">
                        <h3>GSAP Fade In Module</h3>
                        <p><strong>Visual Builder Preview</strong></p>
                        <p>This content will have GSAP animation on the frontend.</p>
                        <p>Configure animation settings in the module options.</p>
                        <div style="margin-top: 10px; font-size: 12px; color: #666;">
                            Note: This is a preview. Actual content and animation will appear on the frontend.
                        </div>
                    </div>
                `);
            }
        });
    }, 1000);

});

// Also register for React component updates
if (typeof window.et_fb !== 'undefined') {
    console.log('ET FB system available');
}

console.log('Visual Builder script setup complete');