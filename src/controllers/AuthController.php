<?php
namespace creativecommunityai\reativeCommunityAI\xenforouserintegration\controllers;

use Craft;
use craft\web\Controller;
use creativecommunityai\xenforouserintegration\XenForoUserIntegration;
use yii\web\Response;

class AuthController extends Controller
{
    protected array|int|bool $allowAnonymous = ['login'];

    public function actionLogin(): ?Response
    {
        $this->requirePostRequest();

        $username = Craft::$app->request->getBodyParam('username');
        $password = Craft::$app->request->getBodyParam('password');
        $redirect = Craft::$app->request->getBodyParam('redirect', ''); // Get the redirect URL

        $user = XenForoUserIntegration::$plugin->xenForoService->authenticateUser($username, $password);

        if ($user) {
            Craft::$app->user->loginByUserId($user['user_id']);

            // Store the user groups in the session or user attribute
            Craft::$app->session->set('xenforo_user_groups', $user['groups']);

            return $this->redirect($redirect ?: 'members-area'); // Redirect to the specified URL or default to members area
        }

        Craft::$app->session->setFlash('error', 'Invalid username or password.');
        return $this->redirectToPostedUrl();
    }
}