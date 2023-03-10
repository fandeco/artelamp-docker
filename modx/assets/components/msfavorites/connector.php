<?php
// For debug
//ini_set('display_errors', 1);
//ini_set('error_reporting', -1);

// Load MODX config
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
	require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
	require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}

//require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('msfavorites_core_path', null, $modx->getOption('core_path') . 'components/msfavorites/');
require_once $corePath . 'model/msfavorites/msfavorites.class.php';
$modx->msFavorites = new msFavorites($modx);

$modx->lexicon->load('msfavorites:default');

/* handle request */
$path = $modx->getOption('processorsPath', $modx->msFavorites->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));