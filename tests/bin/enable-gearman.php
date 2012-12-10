<?php
$filename = '/etc/default/gearman-server';

$content = file_get_contents($filename);

$content = str_replace('ENABLED="false"', 'ENABLED="true"', $content);

file_put_contents($filename, $content);