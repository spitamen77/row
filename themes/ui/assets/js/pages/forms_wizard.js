$(function() {
    // wizard
    unibox_wizard.advanced_wizard();
    unibox_wizard.vertical_wizard();
});

// wizard
unibox_wizard = {
    content_height: function(this_wizard,step) {
        var this_height = $(this_wizard).find('.step-'+ step).actual('outerHeight');
        $(this_wizard).children('.content').animate({ height: this_height }, 140, bez_easing_swiftOut);
    },
    advanced_wizard: function() {
        var $wizard_advanced = $('#wizard_advanced'),
            $wizard_advanced_form = $('#wizard_advanced_form');

        if ($wizard_advanced.length) {
            $wizard_advanced.steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                trigger: 'change',
                onInit: function(event, currentIndex) {
                    unibox_wizard.content_height($wizard_advanced,currentIndex);
                    // reinitialize textareas autosize
                    unibox_forms.textarea_autosize();
                    // reinitialize checkboxes
                    unibox_md.checkbox_radio($(".wizard-icheck"));
                    $(".wizard-icheck").on('ifChecked', function(event){
                        console.log(event.currentTarget.value);
                    });
                    // reinitialize uikit margin
                    unibox_uikit.reinitialize_grid_margin();
                    // reinitialize selects
                    unibox_forms.select_elements($wizard_advanced);
                    // reinitialize switches
                    $wizard_advanced.find('span.switchery').remove();
                    unibox_forms.switches();
                    // resize content when accordion is toggled
                    $('.uk-accordion').on('toggle.uk.accordion',function() {
                        $window.resize();
                    });

                    setTimeout(function() {
                        $window.resize();
                    },100);
                },
                onStepChanged: function (event, currentIndex) {
                    unibox_wizard.content_height($wizard_advanced,currentIndex);
                    setTimeout(function() {
                        $window.resize();
                    },100)
                },
                onStepChanging: function (event, currentIndex, newIndex) {
                    var step = $wizard_advanced.find('.body.current').attr('data-step'),
                        $current_step = $('.body[data-step=\"'+ step +'\"]');

                    // check input fields for errors
                    $current_step.find('.parsley-row').each(function() {
                        $(this).find('input,textarea,select').each(function() {
                            $(this).parsley().validate();
                        });
                    });

                    // adjust content height
                    $window.resize();

                    return $current_step.find('.md-input-danger').length ? false : true;
                },
                onFinished: function() {
                    var form_serialized = JSON.stringify( $wizard_advanced_form.serializeObject(), null, 2 );
                    UIkit.modal.alert('<p>Wizard data:</p><pre>' + form_serialized + '</pre>');
                }
            })/*.steps("setStep", 2)*/;

            $window.on('debouncedresize',function() {
                var current_step = $wizard_advanced.find('.body.current').attr('data-step');
                unibox_wizard.content_height($wizard_advanced,current_step);
            });

            // wizard
            $wizard_advanced_form
                .parsley()
                .on('form:validated',function() {
                    setTimeout(function() {
                        unibox_md.update_input($wizard_advanced_form.find('.md-input'));
                        // adjust content height
                        $window.resize();
                    },100)
                })
                .on('field:validated',function(parsleyField) {

                    var $this = $(parsleyField.$element);
                    setTimeout(function() {
                        unibox_md.update_input($this);
                        // adjust content height
                        var currentIndex = $wizard_advanced.find('.body.current').attr('data-step');
                        unibox_wizard.content_height($wizard_advanced,currentIndex);
                    },100);

                });

        }
    },
    vertical_wizard: function() {
        var $wizard_vertical = $('#wizard_vertical');
        if ($wizard_vertical.length) {
            $wizard_vertical.steps({
                headerTag: "h3",
                bodyTag: "section",
                enableAllSteps: true,
                enableFinishButton: false,
                transitionEffect: "slideLeft",
                stepsOrientation: "vertical",
                onInit: function(event, currentIndex) {
                    unibox_wizard.content_height($wizard_vertical,currentIndex);
                },
                onStepChanged: function (event, currentIndex) {
                    unibox_wizard.content_height($wizard_vertical,currentIndex);
                }
            });
        }
    }

};