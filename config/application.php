<?php
//$config['includePaths']['library'] = '/library';
//$config['includePaths']['models'] = '/models';

$config['database']['user'] = 'root';
$config['database']['password'] = 'root';
$config['database']['host'] = 'localhost';
$config['database']['database'] = 'test';
$config['database']['type'] = 'pdo';

$config['database']['options'][] = 'SET NAMES utf8';

$config['modules']['directory'] = '/modules';
$config['modules']['default'] = 'default';