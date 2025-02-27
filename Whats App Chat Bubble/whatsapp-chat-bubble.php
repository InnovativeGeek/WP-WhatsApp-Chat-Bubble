
<?php
/*
Plugin Name: WhatsApp Chat Bubble
Description: Adds a WhatsApp chat bubble to your website.
Version: 1.0
Author: <a href="https://www.christianmartell.com" target="_blank" rel="noopener noreferrer">Innovative Geek</a>
*/

// Add settings page to admin menu
function whatsapp_chat_bubble_menu() {
    add_options_page(
        'WhatsApp Chat Bubble Settings',
        'WhatsApp Chat',
        'manage_options',
        'whatsapp-chat-bubble',
        'whatsapp_chat_bubble_settings_page'
    );
}
add_action('admin_menu', 'whatsapp_chat_bubble_menu');

// Settings page content
function whatsapp_chat_bubble_settings_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    // Handle form submission
    if (isset($_POST['whatsapp_phone'])) {
        update_option('whatsapp_phone', sanitize_text_field($_POST['whatsapp_phone']));
        echo '<div class="updated"><p><strong>Settings saved.</strong></p></div>';
    }

    $whatsapp_phone = get_option('whatsapp_phone', '');
    ?>
    <div class="wrap">
        <h2>WhatsApp Chat Bubble Settings</h2>
        <form method="post" action="">
            <label for="whatsapp_phone">Enter your WhatsApp phone number (with country code, e.g., 15551234567):</label><br>
            <input type="text" name="whatsapp_phone" id="whatsapp_phone" value="<?php echo esc_attr($whatsapp_phone); ?>"><br>
            <input type="submit" class="button-primary" value="Save Changes">
        </form>
    </div>
    <?php
}

// Add chat bubble to footer
function whatsapp_chat_bubble_add_to_footer() {
    $whatsapp_phone = get_option('whatsapp_phone', '');
    if (!empty($whatsapp_phone)) {
        ?>
        <div id="whatsapp-chat-bubble" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
            <a href="https://wa.me/<?php echo esc_attr($whatsapp_phone); ?>" target="_blank" rel="noopener noreferrer">
                <img src="<?php echo plugin_dir_url(__FILE__) . 'whatsapp-icon.png'; ?>" alt="WhatsApp Chat" style="width: 60px; height: 60px; border-radius: 50%;">
            </a>
        </div>
        <?php
    }
}
add_action('wp_footer', 'whatsapp_chat_bubble_add_to_footer');

// Enqueue styles (optional, for custom styling)
function whatsapp_chat_bubble_enqueue_styles() {
    wp_enqueue_style('whatsapp-chat-bubble-style', plugin_dir_url(__FILE__) . 'css/whatsapp-bubble.css');
}
add_action('wp_enqueue_scripts', 'whatsapp_chat_bubble_enqueue_styles');


?>