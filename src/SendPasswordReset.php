<?php
/**
 * Send Password Reset plugin for Craft CMS 3.x
 *
 * Add send password reset email action to users element index page action menu
 *
 * @link      https://springworks.co.uk
 * @copyright Copyright (c) 2020 Steve Rowling
 */

namespace elementworks\sendpasswordreset;

use elementworks\sendpasswordreset\elementactions\SendPasswordReset as SendPasswordResetAction;

use Craft;
use craft\base\Element;
use craft\base\Plugin;
use craft\elements\User;
use craft\events\RegisterElementActionsEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\services\Plugins;
use craft\services\UserPermissions;
use craft\events\PluginEvent;

use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Steve Rowling
 * @package   SendPasswordReset
 * @since     1.0.0
 *
 */
class SendPasswordReset extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * SendPasswordReset::$plugin
     *
     * @var SendPasswordReset
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * SendPasswordReset::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Do something after we're installed
//        Event::on(
//            Plugins::class,
//            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
//            function (PluginEvent $event) {
//                if ($event->plugin === $this) {
//                    // We were just installed
//                }
//            }
//        );

        // Add to user action menu
        Event::on(User::class, Element::EVENT_REGISTER_ACTIONS, function(RegisterElementActionsEvent $event) {

            if (Craft::$app->user->checkPermission('sendPasswordReset')) {
                $event->actions[] = new SendPasswordResetAction();
            }
        });

        // Add custom user permissions to control display of Password Reset action menu item
        Event::on(
            UserPermissions::class,
            UserPermissions::EVENT_REGISTER_PERMISSIONS,
            function(RegisterUserPermissionsEvent $event) {
                $event->permissions['Send Password Reset Action'] = [
                    'sendPasswordReset' => [
                        'label' => 'Access Send Password Reset from User Index Action Menu',
                    ],
                ];
            }
        );

        /**
 * Logging in Craft involves using one of the following methods:
 *
 * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
 * Craft::info(): record a message that conveys some useful information.
 * Craft::warning(): record a warning message that indicates something unexpected has happened.
 * Craft::error(): record a fatal error that should be investigated as soon as possible.
 *
 * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
 *
 * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
 * the category to the method (prefixed with the fully qualified class name) where the constant appears.
 *
 * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
 * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
 *
 * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
 */
        Craft::info(
            Craft::t(
                'send-password-reset',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

  }
