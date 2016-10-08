<?php

$app->db = new \libs\Db($app->configs->db);

$app->cache = new \libs\Cache;

$app->cache->setPrefix($app->configs->name);

$app->cache->setCachePath($app->root('/storage/cache'));