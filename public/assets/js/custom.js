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
        CKEDITOR.replace('editor-full', {
            height: 1500,
            extraPlugins: 'forms'
        });


        // Readonly editor
        // ------------------------------

        // Setup
        var editorReadOnly;

        // Setup
        var editorReadOnly = CKEDITOR.replace('editor-readonly', {
            height: 400,
            extraPlugins: 'forms'
        });

        // The instanceReady event is fired when an instance of CKEditor has finished
        // its initialization.
        editorReadOnly.on('instanceReady', function (ev) {
            editorReadOnly = ev.editor;

            // Show this "on" button.
            document.getElementById('readOnlyOn').style.display = '';

            // Event fired when the readOnly property changes.
            editorReadOnly.on('readOnly', function () {
                document.getElementById('readOnlyOn').style.display = this.readOnly ? 'none' : '';
                document.getElementById('readOnlyOff').style.display = this.readOnly ? '' : 'none';
            });
        });

        // Toggle readonly state
        function toggleReadOnly(isReadOnly) {
            // Change the read-only state of the editor.
            // http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-setReadOnly
            editorReadOnly.setReadOnly(isReadOnly);
        }
        document.getElementById('readOnlyOn').onclick = function() {
            toggleReadOnly();
        }
        document.getElementById('readOnlyOff').onclick = function() {
            toggleReadOnly(false);
        }


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



        // Inline editor
        // ------------------------------

        // We need to turn off the automatic editor creation first
        CKEDITOR.disableAutoInline = true;

        // The inline editor should be enabled on an element with "contenteditable" attribute set to "true".
        // Otherwise CKEditor will start in read-only mode.
        var introduction = document.getElementById('editor-inline');
        introduction.setAttribute('contenteditable', true);

        // Initialize
        CKEDITOR.inline('editor-inline', {
            // Allow some non-standard markup that we used in the introduction.
            extraAllowedContent: 'a(documentation);abbr[title];code',
            removePlugins: 'stylescombo'
        });
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
