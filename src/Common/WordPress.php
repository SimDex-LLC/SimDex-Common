<?php

namespace SimDex\Common;

class WordPress
{
    public static function debug()
    {
        if (isset($_REQUEST['debug']) && $_REQUEST['debug']) {
            $start_time = Common::startTimer();

            if (!current_user_can('administrator')) {
                return;
            }

            $html = '
            <style>
                .simdex-debug {
                    max-width: 1000px;
                    overflow: auto;
                    padding: 25px;
                }

                .simdex-debug-admin {
                     margin-top: 50px;
                     margin-left: 180px;
                }

                .simdex-debug pre {
                    max-height: 500px;
                    overflow: auto;
                    padding: 25px;
                    margin-top: 25px;
                    margin-bottom: 25px;
                    border: 1px solid #999;
                    background-color: #eee;
                }

                .simdex-debug .php-info {
                    max-height: 1000px;
                    overflow: auto;
                    border: 1px solid #999;
                }
            </style>
            ';

            if (is_admin()) {
                $html .= '<div class="simdex-debug simdex-debug-admin">';
            } else {
                $html .= '<div class="simdex-debug simdex-debug-frontend">';
            }

            $html .= '
            <h2>SimDex Debug</h2>
            <ul>
                <li><a href="#debug-query">Query</a></li>
                <li><a href="#debug-post">Post</a></li>
                <li><a href="#debug-post-meta">Post Meta</a></li>
                <li><a href="#debug-author">Author</a></li>
                <li><a href="#debug-author-meta">Author Meta</a></li>
                <li><a href="#debug-current-user">Current User</a></li>
                <li><a href="#debug-current-user-meta">Current User Meta</a></li>
                <li><a href="#debug-woocommerce-product">WooCommerce Product</a></li>
                <li><a href="#debug-woocommerce">WooCommerce</a></li>
                <li><a href="#debug-php-request">PHP Request</a></li>
                <li><a href="#debug-php-cookie">PHP Cookie</a></li>
                <li><a href="#debug-php-session">PHP Session</a></li>
                <li><a href="#debug-php-server">PHP Server</a></li>
                <li><a href="#debug-php-settings">PHP Settings</a></li>
            </li>
            ';

            /* **************************************************
             * Query
             * ************************************************** */

            global $wp_query;

            if ($wp_query) {
                $html .= '
                <a id="debug-query"><h3>Query</h3></a>
                <pre>' . print_r($wp_query, true) . '</pre>
                ';
            }

            /* **************************************************
             * Post
             * ************************************************** */

            global $post;

            if ($post) {
                $html .= '
                <a id="debug-post"><h3>Post</h3></a>
                <pre>' . htmlspecialchars(print_r($post, true)) . '</pre>
                <a id="debug-post-meta"><h3>Post Meta</h3></a>
                <pre>' . htmlspecialchars(print_r(get_post_meta($post->ID), true)) . '</pre>
                ';
            }

            /* **************************************************
             * Post Author
             * ************************************************** */

            global $authordata;

            if ($authordata) {
                $html .= '
                <a id="debug-post-author"><h3>Post Author</h3></a>
                <pre>' . print_r($authordata, true) . '</pre>
                <a id="debug-post-author-meta"><h3>Post Author Meta</h3></a>
                <pre>' . print_r(get_user_meta($authordata->ID), true) . '</pre>
                ';
            }

            /* **************************************************
             * Current User
             * ************************************************** */

            $current_user = wp_get_current_user();

            if ($current_user) {
                $html .= '
                <a id="debug-current-user"><h3>Current User</h3></a>
                <pre>' . print_r($current_user, true) . '</pre>
                <a id="debug-current-user-meta"><h3>Current User Meta</h3></a>
                <pre>' . print_r(get_user_meta($current_user->ID), true) . '</pre>
                ';
            }

            /* **************************************************
             * WooCommerce Product
             * ************************************************** */

            if ($post && $post->post_type == 'product' && function_exists('wc_get_product')) {
                $product = wc_get_product($post);

                $html .= '
                <a id="debug-woocommerce-product"><h3>WooCommerce Product</h3></a>
                <pre>' . print_r($product, true) . '</pre>
                ';
            }

            /* **************************************************
             * WooCommerce
             * ************************************************** */

            global $woocommerce;

            if ($woocommerce) {
                $html .= '
                <a id="debug-woocommerce"><h3>WooCommerce</h3></a>
                <pre>' . print_r($woocommerce, true) . '</pre>
                ';
            }

            /* **************************************************
             * PHP
             * ************************************************** */

            $html .= '
            <a id="debug-php-request"><h3>PHP Request</h3></a>
            <pre>' . print_r($_REQUEST, true) . '</pre>
            <a id="debug-php-cookie"><h3>PHP Cookie</h3></a>
            <pre>' . print_r($_COOKIE, true) . '</pre>
            ';

            if (isset($_SESSION)) {
                $html = '
                <a id="debug-php-session"><h3>PHP Session</h3></a>
                <pre>' . print_r($_SESSION, true) . '</pre>
                ';
            }

            $html .= '
            <a id="debug-php-server"><h3>PHP Server</h3></a>
            <pre>' . print_r($_SERVER, true) . '</pre>
            <a id="debug-php-settings"><h3>PHP Settings</h3></a>
            ';

            $html .= '<pre>';
            $html .= 'PHP Version: <strong>' . phpversion() . '</strong>' . PHP_EOL;
            $html .= 'PHP Memory Limit: <strong>' . ini_get('memory_limit') . '</strong>' . PHP_EOL;
            $html .= 'WordPress Memory Limit: <strong>' . WP_MEMORY_LIMIT . '</strong>' . PHP_EOL;
            $html .= 'WordPress Max Memory Limit: <strong>' . WP_MAX_MEMORY_LIMIT . '</strong>' . PHP_EOL;
            $html .= 'Display Errors: <strong>' . ini_get('display_errors') . '</strong>' . PHP_EOL;
            $html .= 'Error Log: <strong>' . ini_get('error_log') . '</strong>' . PHP_EOL;
            $html .= 'Error Reporting: <strong>' . ini_get('error_reporting') . '</strong>' . PHP_EOL;
            $html .= 'Max Execution Time: <strong>' . ini_get('max_execution_time') . ' seconds</strong>' . PHP_EOL;
            $html .= 'Max Input Time: <strong>' . ini_get('max_input_time') . ' seconds</strong>' . PHP_EOL;
            $html .= 'Max Input Variables: <strong>' . ini_get('max_input_vars') . '</strong>' . PHP_EOL;
            $html .= 'Open Base Dir: <strong>' . ini_get('open_basedir') . '</strong>' . PHP_EOL;
            $html .= 'Post Max Size: <strong>' . ini_get('post_max_size') . '</strong>' . PHP_EOL;
            $html .= 'Upload Max Filesize: <strong>' . ini_get('upload_max_filesize') . '</strong>' . PHP_EOL;
            $html .= '</pre>';

            $html .= '<p><a href="?debug=1&php_info=1">View All PHP Info</a></p>';

            if (isset($_GET['php_info']) && $_GET['php_info']) {
                $html = '<a id="debug-php-info"><h3>PHP Info</h3></a>';

                ob_start();
                phpinfo();
                $php_info = ob_get_contents();
                ob_get_clean();

                $html .= '<div class="php-info">' . $php_info . '</div>';
            }

            $seconds = Common::stopTimer($start_time);

            $html .= '
                <p>Debug Execution Time: <strong>' . $seconds . ' seconds</strong></p>
            </div><!-- End .simdex-debug -->
            ';

            echo $html;
        }
    }
}