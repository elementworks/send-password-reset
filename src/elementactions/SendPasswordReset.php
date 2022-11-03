<?php
/**
 * Send Password Reset Emails plugin for Craft CMS 3.x
 *
 * Add a send password reset email action to user index page action menu
 *
 * @link      https://springworks.co.uk
 * @copyright Copyright (c) 2020 Steve Rowling
 */

namespace elementworks\sendpasswordreset\elementactions;

use Craft;
use craft\base\ElementAction;
use craft\elements\db\ElementQuery;
use craft\elements\db\ElementQueryInterface;
use craft\elements\User;
use craft\helpers\Json;

/**
 * SendPasswordReset represents a Send Password Reset Email element action.
 *
 * @author Steve Rowling
 * @since 1.0.0
 */
class SendPasswordReset extends ElementAction
{
    /**
     * @inheritdoc
     */
    public function getTriggerLabel(): string
    {
        return Craft::t('send-password-reset', 'Send password');
    }

    /**
     * @inheritdoc
     */
    public function getTriggerHtml(): ?string
    {
        $type = Json::encode(static::class);
        $userId = Json::encode(Craft::$app->getUser()->getIdentity()->id);

        $js = <<<EOD
(function()
{
    var trigger = new Craft.ElementActionTrigger({
        type: {$type},
        batch: true,
        validateSelection: function(\$selectedItems)
        {
            for (var i = 0; i < \$selectedItems.length; i++)
            {
                if (\$selectedItems.eq(i).find('.element').data('id') == {$userId})
                {
                    return false;
                }
            }
            return true;
        }
    });
})();
EOD;

        Craft::$app->getView()->registerJs($js);

        return null;
    }

    /**
     * @inheritdoc
     */
    public function performAction(ElementQueryInterface $query): bool
    {
        /** @var ElementQuery $query */

        /** @var User[] $users */
        $users = $query->all();
        $usersService = Craft::$app->getUsers();

        foreach ($users as $user) {
            if (!$user->getIsCurrent()) {
                $usersService->sendPasswordResetEmail($user);
            }
        }

        $this->setMessage(Craft::t('send-password-reset', 'Password emails sent.'));

        return true;
    }
}