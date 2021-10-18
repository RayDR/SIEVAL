<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group   = ENVIRONMENT;
$query_builder  = TRUE;

$db_hostname    = 'localhost';
$db_username    = 'root';
$db_password    = '120517rys';
$db_database    = 'sipat';

$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost:1521/orcl',
    'username' => 'db_username', 
    'password' => 'db_password', 
    'database' => 'db_name',
    'dbdriver' => 'oci8',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

$db['development'] = array(
    'dsn'   => '',
    'hostname' => $db_hostname,
    'username' => $db_username,
    'password' => $db_password,
    'database' => $db_database,
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

$db['development'] = array(
    'dsn'   => '',
    'hostname' => $db_hostname,
    'username' => $db_username,
    'password' => $db_password,
    'database' => $db_database,
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

// BD Alternativas ( En caso de fallas )

$fo_hostname    = 'localhost';
$fo_username    = 'root';
$fo_password    = 'Setab2021';
$fo_database    = 'sipat';

$db['default']['failover'] = array(
    array(
            'hostname' => $fo_hostname,
            'username' => $fo_username,
            'password' => $fo_password,
            'database' => $fo_database,
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => TRUE,
            'db_debug' => TRUE,
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt'  => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE
    ),
);