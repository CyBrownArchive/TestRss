<?php

require_once __DIR__.'/../vendor/autoload.php';

use Desarrolla2\RSSClient\RSSClient;

$app = new Silex\Application();
date_default_timezone_set('utc');

$app['debug'] = true;

$app['twig'] = $app->share(function () {
    $loader = new Twig_Loader_String();
    return new Twig_Environment($loader);
});

$app->get('/', function () use ($app) {
    $client = new RSSClient();

    $client->addFeeds(array(
            'http://sebsauvage.net/links/index.php?do=rss'
                ), 'news'
        );

    $feeds = $client->fetch('news');
    return $app['twig']->render('<ul>{% for feed in feeds %}<li>{{ feed.title }}</li>{% endfor %}</ul>', array('feeds' => $feeds));
});

return $app;
