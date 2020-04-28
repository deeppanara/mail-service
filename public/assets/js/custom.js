/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */

// Setup module
// ------------------------------

var Modals = function () {


    //
    // Setup module components
    //

    // Bootbox extension
    var _componentModalBootbox = function() {
        if (typeof bootbox == 'undefined') {
            console.warn('Warning - bootbox.min.js is not loaded.');
            return;
        }

        // Alert dialog
        $('#alert').on('click', function() {
            bootbox.alert({
                title: 'Check this out!',
                message: 'Native alert dialog has been replaced with Bootbox alert box.'
            });
        });

        // Confirmation dialog

        $('#delete_form').submit(function(e) {
            var currentForm = this;
            e.preventDefault();
            bootbox.confirm({
                title: 'Confirm !!!',
                message: 'Are you sure you want to delete this item?',
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-primary'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-link'
                    }
                },
                callback: function (result) {
                    if (result) {
                        currentForm.submit();
                    }
                }
            });

        });

    };

    // Bootstrap switch
    var _componentBootstrapSwitch = function() {
        if (!$().bootstrapSwitch) {
            console.warn('Warning - switch.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-check-input-switch').bootstrapSwitch();
    };

    // FAB
    var _componentFab = function() {
        if (!$().stick_in_parent) {
            console.warn('Warning - sticky.min.js is not loaded.');
            return;
        }

        // Add bottom spacing if reached bottom,
        // to avoid footer overlapping
        // -------------------------

        $(window).on('scroll', function() {
            if($(window).scrollTop() + $(window).height() > $(document).height() - 40) {
                $('.fab-menu-bottom-right').addClass('reached-bottom');
            }
            else {
                $('.fab-menu-bottom-right').removeClass('reached-bottom');
            }
        });

        // Initialize sticky button
        $('.fab-menu-sticky-right').stick_in_parent({
            offset_top: 22,
            parent: 'body'
        });
    };

    // CKEditor
    var _componentCKEditor = function() {
        if (typeof CKEDITOR == 'undefined') {
            console.warn('Warning - ckeditor.js is not loaded.');
            return;
        }

        // Full featured editor
        // ------------------------------

        // Setup
        CKEDITOR.replace('email_template_body_html', {
            height: 1500,
            extraPlugins: 'forms'
        });



        // Enter key configuration
        // ------------------------------

        // Define editor
        var editorKey;

        // Setup editor
        function changeEnter() {

            // If an editor instance exists, destroy it first.
            if (editorKey)
                editorKey.destroy(true);

            // Create an editor instance again, with appropriate settings.
            editorKey = CKEDITOR.replace('editor-enter', {
                height: 400,
                enterMode: Number(document.getElementById('xEnter').value),
                shiftEnterMode: Number(document.getElementById('xShiftEnter').value)
            });
        }

        // Trigger initialization
        changeEnter();

        // // Change configuration
        document.getElementById('xEnter').onchange = function() {
            changeEnter();
        }
        document.getElementById('xShiftEnter').onchange = function() {
            changeEnter();
        }




    };

    //
    // Return objects assigned to module
    //

    return {
        initComponents: function() {
            _componentModalBootbox();
            _componentBootstrapSwitch();
            _componentFab();
            _componentCKEditor();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    Modals.initComponents();
});
