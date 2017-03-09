<?php

namespace OpenCFP\Provider\Gateways;

use OpenCFP\Http\API\ProfileController;
use OpenCFP\Http\API\TalkController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

class ApiGatewayProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['controller.api.profile'] = function ($app) {
            return new ProfileController($app['application.speakers.api']);
        };

        $app['controller.api.talk'] = function ($app) {
            return new TalkController($app['application.speakers.api']);
        };
    }

    public function boot(Application $app)
    {
        /* @var $api ControllerCollection */
        $api = $app['controllers_factory'];

        $api->before(new RequestCleaner($app['purifier']));
        $api->before(function (Request $request) {
            $request->headers->set('Accept', 'application/json');

            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : []);
            }
        });

        if ($app->config('application.secure_ssl')) {
            $api->requireHttps();
        }

        $api->get('/me', 'controller.api.profile:handleShowSpeakerProfile');
        $api->get('/talks', 'controller.api.talk:handleViewAllTalks');
        $api->post('/talks', 'controller.api.talk:handleSubmitTalk');
        $api->get('/talks/{id}', 'controller.api.talk:handleViewTalk');

        $app->mount('/api', $api);
    }
}
