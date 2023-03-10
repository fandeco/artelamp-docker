<?php
/*
 * This file is part of the MODX Revolution package.
 *
 * Copyright (c) MODX, LLC
 *
 * For complete copyright and license information, see the COPYRIGHT and LICENSE
 * files found in the top-level directory of this distribution.
 *
 * @package modx-test
*/

/**
 * Sample properties file for testing.
 *
 * @package modx-test
 */

/* define some properties */
$properties['runtime'] = strftime("%Y%m%dT%H%M%S");
$properties['config_key'] = 'test';

/* driver-specific connection properties */
/* mysql */
$properties['mysql_string_dsn_test']= 'mysql:host=93.90.219.68;dbname=artelamp;charset=utf8';
$properties['mysql_string_dsn_nodb']= 'mysql:host=93.90.219.68;charset=utf8';
$properties['mysql_string_dsn_error']= 'mysql:host=93.90.219.68;dbname=artelamp';
$properties['mysql_string_username']= 'artelamp';
$properties['mysql_string_password']= 'e4G7VwlFI2XMwThO';
$properties['mysql_array_options']= array(
    xPDO::OPT_HYDRATE_FIELDS => true,
    xPDO::OPT_HYDRATE_RELATED_OBJECTS => true,
    xPDO::OPT_HYDRATE_ADHOC_FIELDS => true,
);
$properties['mysql_array_driverOptions']= array();

/* sqlsrv */
$properties['sqlsrv_string_dsn_test']= 'sqlsrv:server=93.90.219.68;port=3306;database=artelamp';
$properties['sqlsrv_string_dsn_nodb']= 'sqlsrv:server=93.90.219.68;port=3306';
$properties['sqlsrv_string_dsn_error']= 'sqlsrv:server=93.90.219.68;port=3306';
$properties['sqlsrv_string_username']= 'artelamp';
$properties['sqlsrv_string_password']= 'e4G7VwlFI2XMwThO';
$properties['sqlsrv_array_options']= array(
    xPDO::OPT_HYDRATE_FIELDS => true,
    xPDO::OPT_HYDRATE_RELATED_OBJECTS => true,
    xPDO::OPT_HYDRATE_ADHOC_FIELDS => true,
);
$properties['sqlsrv_array_driverOptions']= array(/*PDO::SQLSRV_ATTR_DIRECT_QUERY => false*/);

/* PHPUnit test config */
$properties['xpdo_driver']= 'mysql';
$properties['logTarget']= array(
    'target' => 'file',
    'options' => array(
        'filename' => "unit_test_{$properties['runtime']}.log",
        'filepath' => dirname(__FILE__) . '/'
    )
);
$properties['logLevel']= modX::LOG_LEVEL_INFO;
$properties['context'] = 'web';
$properties['debug'] = true;
