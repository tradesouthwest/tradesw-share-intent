jQuery(document).ready(function($) {
    // Check if the AJAX object is defined.
    if (typeof tpc_ajax_object === 'undefined') {
        console.error('tpc_ajax_object is not defined.');
        return;
    }

    /**
     * Show a transient admin notice.
     *
     * @param {string} message The message to display.
     * @param {string} type The notice type (success, error).
     */
    function showNotice(message, type) {
        const notice = $('#tpc-message');
        notice.removeClass('notice-success notice-error').addClass('notice-' + type);
        notice.find('p').text(message);
        notice.slideDown();
        setTimeout(function() {
            notice.slideUp();
        }, 5000);
    }

    /**
     * Handle the AJAX request to save a category.
     *
     * @param {string} pluginSlug The slug of the plugin.
     * @param {string} category The category to save.
     * @param {object} button The button element that triggered the action.
     */
    function saveCategory(pluginSlug, category, button) {
        // Disable the button to prevent multiple clicks.
        button.prop('disabled', true).text('Saving...');

        const data = {
            'action': 'tpc_save_category',
            'nonce': tpc_ajax_object.nonce,
            'plugin_slug': pluginSlug,
            'category': category
        };

        $.post(tpc_ajax_object.ajax_url, data, function(response) {
            button.prop('disabled', false).text('Save');
            if (response.success) {
                showNotice(tpc_ajax_object.i18n.categorySaved, 'success');
                // Reload the page to reflect the changes. In a more advanced version, we could update the DOM dynamically.
                location.reload();
            } else {
                showNotice(response.data.message || 'Error saving category.', 'error');
            }
        }).fail(function() {
            button.prop('disabled', false).text('Save');
            showNotice('An error occurred.', 'error');
        });
    }

    /**
     * Handle the AJAX request to remove a category.
     *
     * @param {string} pluginSlug The slug of the plugin.
     */
    function removeCategory(pluginSlug) {
        const data = {
            'action': 'tpc_remove_category',
            'nonce': tpc_ajax_object.nonce,
            'plugin_slug': pluginSlug
        };

        $.post(tpc_ajax_object.ajax_url, data, function(response) {
            if (response.success) {
                showNotice(tpc_ajax_object.i18n.categoryRemoved, 'success');
                location.reload();
            } else {
                showNotice(response.data.message || 'Error removing category.', 'error');
            }
        }).fail(function() {
            showNotice('An error occurred.', 'error');
        });
    }

    // Event listener for saving a category.
    $('.tpc-uncategorized-section').on('click', '.tpc-save-button', function() {
        const item = $(this).closest('.tpc-plugin-item');
        const pluginSlug = item.data('plugin-slug');
        const category = item.find('.tpc-category-select').val();

        if (pluginSlug && category) {
            saveCategory(pluginSlug, category, $(this));
        } else {
            showNotice('Please select a category.', 'error');
        }
    });

    // Event listener for removing a category.
    $('.tpc-categorized-section').on('click', '.tpc-remove-button', function() {
        const item = $(this).closest('.tpc-categorized-item');
        const pluginSlug = item.data('plugin-slug');

        if (pluginSlug) {
            removeCategory(pluginSlug);
        }
    });
});
