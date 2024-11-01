<?php

namespace TF\AccessPackage;

class Ajax
{
    public function __construct()
    {
        \add_action('wp_ajax_tfap_customer_email', function () {
            $this->mail();
        });

        \add_action('wp_ajax_nopriv_tfap_customer_email', function () {
            $this->mail();
        });
    }

    private function mail()
    {
        $name = isset($_REQUEST['name']) ? \sanitize_text_field($_REQUEST['name']) : null;
        $email = isset($_REQUEST['email']) ? \sanitize_text_field($_REQUEST['email']) : null;
        $phone = isset($_REQUEST['phone']) ? \sanitize_text_field($_REQUEST['phone']) : null;
        $message = isset($_REQUEST['message']) ? \sanitize_text_field($_REQUEST['message']) : null;
        $title = isset($_REQUEST['title']) ? \sanitize_text_field($_REQUEST['title']) : null;
        $dealer = isset($_REQUEST['dealer']) ? \sanitize_text_field($_REQUEST['dealer']) : \get_option('admin_email');
        ob_start();
        ?>
        <h3><?php echo \esc_html($title); ?></h3>

        <?php if ($name) : ?>
            <p><strong>Namn: </strong><?php \esc_html_e($name); ?></p>
        <?php endif; ?>
        <?php if ($email) : ?>
            <p><strong>E-post: </strong><?php \esc_html_e($email); ?></p>
        <?php endif; ?>
        <?php if ($phone) : ?>
            <p><strong>Telefon: </strong><?php \esc_html_e($phone); ?></p>
        <?php endif; ?>
        <?php if ($message) : ?>
            <p><strong>Meddelande: </strong><?php \esc_html_e($message); ?></p>
        <?php endif; ?>

        <?php
        $body = ob_get_clean();
        $headers = ['Content-Type: text/html; charset=UTF-8', sprintf('Reply-To: %s <%s>', $name, $email)];
        $success = \wp_mail($dealer, sprintf('Intresseanmälan på %s från %s', $title, $name), $body, $headers);
        \wp_send_json_success($success ? 'mail' : "fail");
    }
}
