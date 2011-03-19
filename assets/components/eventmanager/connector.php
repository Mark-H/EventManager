<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('core_path').'components/eventmanager/';
require_once ($corePath.'initiate.php');

$modx->lexicon->load('eventmanager:default');

/* handle request */
$path = $corePath.'processors/';
$modx->request->handleRequest(array(
'processors_path' => $path,
'location' => ''));
?>