jQuery(document).ready(function($) {
    // Add this at the very top of your frontend.js file
    console.log('GSAP Frontend script loaded');
    console.log('GSAP available:', typeof gsap !== 'undefined');

    // Initialize GSAP animations when DOM is ready
    initGSAPFadeIn();

    function initGSAPFadeIn() {
        $('.dgsp-gsap-fadein-content').each(function() {
            var $element = $(this);
            var duration = parseFloat($element.data('duration')) || 1;
            var delay = parseFloat($element.data('delay')) || 0;
            var triggerScroll = $element.data('trigger-scroll') === 'on';
            
            console.log('GSAP Module found:', {
                duration: duration,
                delay: delay,
                triggerScroll: triggerScroll
            });
            
            if (triggerScroll) {
                // Use Intersection Observer for scroll trigger
                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            console.log('Triggering GSAP animation');
                            gsap.fromTo(entry.target,
                                { opacity: 0, y: 30 },
                                {
                                    opacity: 1,
                                    y: 0,
                                    duration: duration,
                                    delay: delay,
                                    ease: "power2.out"
                                }
                            );
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });
                
                observer.observe($element[0]);
            } else {
                // Trigger immediately
                console.log('Triggering GSAP animation immediately');
                gsap.fromTo($element[0],
                    { opacity: 0, y: 30 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: duration,
                        delay: delay,
                        ease: "power2.out"
                    }
                );
            }
        });
    }
    
    // Re-initialize when new content is loaded (for Visual Builder)
    $(document).on('et_pb_after_init_modules', function() {
        console.log('Re-initializing GSAP modules');
        initGSAPFadeIn();
    });
    
    // Also try a backup method for the Visual Builder
    if (window.et_pb_custom && window.et_pb_custom.modules) {
        window.et_pb_custom.modules.push(function() {
            initGSAPFadeIn();
        });
    }
    if (window.et_pb_custom && window.et_pb_custom.modules) {
        window.et_pb_custom.modules.push(function() {
            initGSAPFadeIn();
        });
    }

    
});