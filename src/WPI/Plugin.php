<?php

/**
 * This file is part of the hyyan/woo-poly-integration plubin.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WPI;

/**
 * Plugin
 *
 * @author Hyyan
 */
class Plugin
{

    /**
     * Constrcut the plugin
     */
    public function __construct()
    {
        $this->register();
    }

    /**
     * Register plugin
     *
     * The plugin will register its core if the requirements full filled , otherwise
     * it will show an admin error message
     *
     * @return boolean false if plugin can not be activated
     */
    public function register()
    {
        if (!static::canActivate()) {
            add_action('admin_notices', function () {
                printf('<div id="message" class="error"><p>%s</p></div>', __('Hyyan WooCommerce Polylang Integration Plugin can not function correctly , the plugin requires WooCommerce and Polylang plugins', 'wpi'));
            });

            return false;
        }

        $this->registerCore();
    }

    /**
     * Check if the plugin can be activated
     *
     * @return boolean true if can be activated , false otherwise
     */
    public static function canActivate()
    {
        $requiredPlugins = array(
            'polylang/polylang.php',
            'woocommerce/woocommerce.php'
        );

        $plugins = apply_filters('active_plugins', get_option('active_plugins'));

        foreach ($requiredPlugins as $name) {
            if (!in_array($name, $plugins)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Add plugin core classes
     */
    public function registerCore()
    {
        require_once __DIR__.'/Pages.php';
        require_once __DIR__.'/Login.php';
        require_once __DIR__.'/Cart.php';

        new Pages();
        new Login();
        new Cart();
    }

}
