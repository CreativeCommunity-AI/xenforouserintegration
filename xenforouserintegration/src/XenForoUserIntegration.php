<?php
namespace creativecommunityai\xenforouserintegration;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\services\Gql;
use craft\events\RegisterGqlMutationsEvent;
use creativecommunityai\xenforouserintegration\gql\Mutations;
use creativecommunityai\xenforouserintegration\models\Settings;
use creativecommunityai\xenforouserintegration\services\XenForoService;
use yii\base\Event;

class XenForoUserIntegration extends Plugin
{
    public static $plugin;

    public bool $hasCpSettings = true;

    public function init()
    {
        Craft::info('XenForoUserIntegration init method called', __METHOD__);
        parent::init();
        self::$plugin = $this;

        Craft::info('XenForoUserIntegration plugin self assigned', __METHOD__);

        $this->setComponents([
            'xenForoService' => XenForoService::class,
        ]);

        Craft::info('XenForoUserIntegration components set', __METHOD__);

        Event::on(Gql::class, Gql::EVENT_REGISTER_GQL_MUTATIONS, function(RegisterGqlMutationsEvent $event) {
            Craft::info('Registering GQL Mutations', __METHOD__);
            $event->mutations = array_merge($event->mutations, Mutations::getMutations());
        });

        Craft::$app->getUrlManager()->addRules([
            'login' => 'xenforouserintegration/auth/login',
        ], false);

        Craft::info('XenForoUserIntegration initialization complete', __METHOD__);
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