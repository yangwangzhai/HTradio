<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    /*
 * | ------------------------------------------------------------------- |
 * DATABASE CONNECTIVITY SETTINGS |
 * ------------------------------------------------------------------- | This
 * file will contain the settings needed to access your database. | | For
 * complete instructions please consult the 'Database Connection' | page of the
 * User Guide. | |
 * ------------------------------------------------------------------- |
 * EXPLANATION OF VARIABLES |
 * ------------------------------------------------------------------- |
 * |	['hostname'] The hostname of your database server. |	['username'] The
 * username used to connect to the database |	['password'] The password used to
 * connect to the database |	['database'] The name of the database you want to
 * connect to |	['dbdriver'] The database type. ie: mysql. Currently supported:
 * mysql, mysqli, postgre, odbc, mssql, sqlite, oci8 |	['dbprefix'] You can add
 * an optional prefix, which will be added |				 to the table name when using
 * the Active Record class |	['pconnect'] TRUE/FALSE - Whether to use a
 * persistent connection |	['db_debug'] TRUE/FALSE - Whether database errors
 * should be displayed. |	['cache_on'] TRUE/FALSE - Enables/disables query
 * caching |	['cachedir'] The path to the folder where cache files should be
 * stored |	['char_set'] The character set used in communicating with the
 * database |	['dbcollat'] The character collation used in communicating with
 * the database |				 NOTE: For MySQL and MySQLi databases, this setting is only
 * used | as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
 * |				 (and in table creation queries made with DB Forge). | There is an
 * incompatibility in PHP with mysql_real_escape_string() which | can make your
 * site vulnerable to SQL injection if you are using a | multi-byte character
 * set and are running versions lower than these. | Sites using Latin-1 or UTF-8
 * database character set and collation are unaffected. |	['swap_pre'] A default
 * table prefix that should be swapped with the dbprefix |	['autoinit'] Whether
 * or not to automatically initialize the database. |	['stricton'] TRUE/FALSE -
 * forces 'Strict Mode' connections |							- good for ensuring strict SQL while
 * developing | | The $active_group variable lets you choose which connection
 * group to | make active. By default there is only one group (the 'default'
 * group). | | The $active_record variables lets you determine whether or not to
 * load | the active record class
 */

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';//192.168.10.81
$db['default']['username'] = 'root';//bbrtv_vroad
$db['default']['password'] = '';//bbrtv.20131205
$db['default']['database'] = 'bbrtv_cmradio';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;




/*$db['weixin1003']['hostname'] = '120.25.149.28';
$db['weixin1003']['username'] = 'bbrtv_vroad';
$db['weixin1003']['password'] = 'vroad20150525ABCD';
$db['weixin1003']['database'] = 'bbrtv_vroad';
$db['weixin1003']['dbdriver'] = 'mysql';
$db['weixin1003']['dbprefix'] = '';
$db['weixin1003']['pconnect'] = TRUE;
$db['weixin1003']['db_debug'] = TRUE;
$db['weixin1003']['cache_on'] = FALSE;
$db['weixin1003']['cachedir'] = '';
$db['weixin1003']['char_set'] = 'utf8';
$db['weixin1003']['dbcollat'] = 'utf8_general_ci';
$db['weixin1003']['swap_pre'] = '';
$db['weixin1003']['autoinit'] = TRUE;
$db['weixin1003']['stricton'] = FALSE;*/










/*
$db['weixin910']['hostname'] = '192.168.10.81';
$db['weixin910']['username'] = 'bbrtv_weixin910';
$db['weixin910']['password'] = '20130916ADBSOP67867';
$db['weixin910']['database'] = 'bbrtv_weixin910';
$db['weixin910']['dbdriver'] = 'mysql';
$db['weixin910']['dbprefix'] = '';
$db['weixin910']['pconnect'] = TRUE;
$db['weixin910']['db_debug'] = TRUE;
$db['weixin910']['cache_on'] = FALSE;
$db['weixin910']['cachedir'] = '';
$db['weixin910']['char_set'] = 'utf8';
$db['weixin910']['dbcollat'] = 'utf8_general_ci';
$db['weixin910']['swap_pre'] = '';
$db['weixin910']['autoinit'] = TRUE;
$db['weixin910']['stricton'] = FALSE;

$db['weixin930']['hostname'] = '192.168.10.81';
$db['weixin930']['username'] = 'bbrtv_weixin930';
$db['weixin930']['password'] = '930weixin20140226';
$db['weixin930']['database'] = 'bbrtv_weixin930';
$db['weixin930']['dbdriver'] = 'mysql';
$db['weixin930']['dbprefix'] = '';
$db['weixin930']['pconnect'] = TRUE;
$db['weixin930']['db_debug'] = TRUE;
$db['weixin930']['cache_on'] = FALSE;
$db['weixin930']['cachedir'] = '';
$db['weixin930']['char_set'] = 'utf8';
$db['weixin930']['dbcollat'] = 'utf8_general_ci';
$db['weixin930']['swap_pre'] = '';
$db['weixin930']['autoinit'] = TRUE;
$db['weixin930']['stricton'] = FALSE;

$db['newsroom']['hostname'] = '192.168.0.31';
$db['newsroom']['username'] = 'weilunews';
$db['newsroom']['password'] = 'abcd20140213';
$db['newsroom']['database'] = 'newsroom';
$db['newsroom']['dbdriver'] = 'mysql';
$db['newsroom']['dbprefix'] = '';
$db['newsroom']['pconnect'] = TRUE;
$db['newsroom']['db_debug'] = TRUE;
$db['newsroom']['cache_on'] = FALSE;
$db['newsroom']['cachedir'] = '';
$db['newsroom']['char_set'] = 'utf8';
$db['newsroom']['dbcollat'] = 'utf8_general_ci';
$db['newsroom']['swap_pre'] = '';
$db['newsroom']['autoinit'] = TRUE;
$db['newsroom']['stricton'] = FALSE;

$db['newsgroup']['hostname'] = '192.168.0.31';
$db['newsgroup']['username'] = 'weilunews';
$db['newsgroup']['password'] = 'abcd20140213';
$db['newsgroup']['database'] = 'newsgroup';
$db['newsgroup']['dbdriver'] = 'mysql';
$db['newsgroup']['dbprefix'] = '';
$db['newsgroup']['pconnect'] = TRUE;
$db['newsgroup']['db_debug'] = TRUE;
$db['newsgroup']['cache_on'] = FALSE;
$db['newsgroup']['cachedir'] = '';
$db['newsgroup']['char_set'] = 'utf8';
$db['newsgroup']['dbcollat'] = 'utf8_general_ci';
$db['newsgroup']['swap_pre'] = '';
$db['newsgroup']['autoinit'] = TRUE;
$db['newsgroup']['stricton'] = FALSE;
*/

/* End of file database.php */
/* Location: ./application/config/database.php */