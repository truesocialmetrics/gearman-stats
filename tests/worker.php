<?php
$worker = new GearmanWorker();
$worker->addServer('127.0.0.1', 4730);

$worker->addFunction('test1', 'test1');
$worker->addFunction('test2', 'test2');

// infinite loop
while ($worker->work()) {};

function test1() {}
function test2() {}