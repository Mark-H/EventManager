<?php
  $path = MODX_CORE_PATH . 'components/eventmanager/';
  $package = $modx->addPackage('eventmanager',$path . 'model/');
  if (!$package) { return '<p>Fatal error: unable to load eventManager package.</p>'; }
?>