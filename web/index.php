<?php
/**
 * @copywright jpdrawneek
 * @author John-Paul Drawneek <jpd@drawneek.co.uk>
 */
require_once __DIR__.'/../vendor/autoload.php';
define('APP_ROOT', __DIR__ . '/../src');
$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/templates',
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));
$app['ION'] = $app->share(function () {
    return new Test2\Services\ION(new \GuzzleHttp\Client());
});

$app->match('/', 'Test2\\Controllers\\Index::index');
$app->match('/brands/{search}', 'Test2\\Controllers\\Brand::search');

$app->run();
