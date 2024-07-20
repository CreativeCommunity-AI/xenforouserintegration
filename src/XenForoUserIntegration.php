<?php
namespace CreativeCommunityAI\xenforouserintegration;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\services\Gql;
use craft\events\RegisterGqlMutationsEvent;
use CreativeCommunityAI\xenforouserintegration\gql\Mutations;
use CreativeCommunityAI\xenforouserintegration\models\Settings;
use CreativeCommunityAI\xenforouserintegration\services\XenForoService;
use yii\base\Event;

class XenForoUserIntegration extends Plugin
{
    public static $plugin;

    public bool $hasCpSettings = true;

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'xenForoService' => XenForoService::class,
        ]);

        // Register the GraphQL mutations
        Event::on(Gql::class, Gql::EVENT_REGISTER_GQL_MUTATIONS, function(RegisterGqlMutationsEvent $event) {
            $event->mutations = array_merge($event->mutations, Mutations::getMutations());
        });

        // Register controller
        Craft::$app->getUrlManager()->addRules([
            'login' => 'xenforouserintegration/auth/login',
        ], false);
    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate(
            'xenforouserintegration/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}