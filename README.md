TweeGearmanStat
=======
Version 1.0.0 Created by Rostislav Mykhajliw

Introduction
------------

TweeGearmanStat is a simple adapter for monitrong your Gearman queue for php


Features / Goals
----------------

* Having a simple class  for monitong Queue on webside
* Use a standard command "status" and provide result as array
* Work with multiple gearman servers

Installation
------------

### Main Setup

#### With composer

1. Add this project and [Cdn](https://github.com/necromant2005/cdn) in your composer.json:

```json
"require": {
    "necromant2005/gearman-stats": "@dev",
}
```

2. Now tell composer to download TweeCdn by running the command:

```bash
$ php composer.phar update
```

#### Usage

```php
$adapter = new \TweeGearmanStat\Queue\Gearman(array(
    'h1' => array('host' => '10.0.0.1', 'port' => 4730, 'timeout' => 1),
    'h2' => array('host' => '10.0.0.2', 'port' => 4730, 'timeout' => 1),
));
$status = $adapter->status();
var_dump($status);
```

With default timeout 5 sec
```php
$adapter = new \TweeGearmanStat\Queue\Gearman(array(
    'h1' => array('host' => '10.0.0.1', 'port' => 4730),
    'h2' => array('host' => '10.0.0.2', 'port' => 4730),
));
$status = $adapter->status();
var_dump($status);
```
