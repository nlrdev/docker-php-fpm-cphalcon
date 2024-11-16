<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Autoload\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;

$basePath = realpath(dirname(__DIR__));
define('BASE_PATH', $basePath);
$appPath = join_paths($basePath, 'app');
define('APP_PATH', $appPath);

$loader = new Loader();

$controllers = join_paths($appPath, "controllers");
$models = join_paths($appPath, "models");

$loader->setDirectories(
    [
        $controllers,
        $models,
    ]
);
$loader->register();

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($container);

try {
    // Handle the request
    $response = $application->handle(
        $_GET['_url'] ?? '/'
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}


function join_paths() {
    $parts = func_get_args();
    if (sizeof($parts) === 0) return '';
    $prefix = ($parts[0] === DIRECTORY_SEPARATOR) ? DIRECTORY_SEPARATOR : '';
    $processed = array_filter(array_map(function ($part) {
        return rtrim($part, DIRECTORY_SEPARATOR);
    }, $parts), function ($part) {
        return !empty($part);
    });
    return $prefix . implode(DIRECTORY_SEPARATOR, $processed);
}