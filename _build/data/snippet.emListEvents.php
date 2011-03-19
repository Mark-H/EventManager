<?php
/*
 * EventManager
 *
 * Copyright 2010-2011 by Mark Hamstra (contact via www.markhamstra.nl)
 *
 * This file is part of EventManager, a tool to manage events and reservations for MODX.
 *
 * EventManager is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * EventManager is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * EventManager; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package EventManager
 */
  // Fetch the package
  require_once (MODX_CORE_PATH . 'components/eventmanager/initiate.php');
  
  // See if there's a valid tpl chunk specified
  $rowTpl = $modx->getOption('rowTpl',$scriptProperties,'');
  if (($rowTpl == '') or ($modx->getChunk($rowTpl) == '')) {
    return '<p>Fatal error: no valid template chunk specified.</p>'; 
  }

  $limit = $modx->getOption('limit',$scriptProperties,3);
  $resRes = $modx->getOption('reserveResource',$scriptProperties,'');
  $default = $modx->getOption('default',$scriptProperties,'@GET eid');
  if (substr($default,0,4) == '@GET') { 
    $default = (is_numeric($_REQUEST[substr($default,5)])) ? $_REQUEST[substr($default,5)] : '';
  }
  // Prepare the criteria to fetch all events later than now 
  $c = $modx->newQuery('Events');
  $c->where(array(
    'date:>' => time()));
  $c->sortby('date','ASC');
  $c->limit($limit);
  
  // Fetch the results
  $events = $modx->getCollection('Events',$c);
  // Set total amount of events in placeholders
  $total = count($events);
  
  // Set an empty output variable to return later on
  $o = '';
  setlocale(LC_ALL, 'nl_NL');
  // Loop through the results
  
  foreach ($events as $e) {
    $phs = $e->toArray();
    $phs['date'] = strftime('%A %e/%m, %H:%M',$phs['date']);
    $phs['reservationlink'] = '<a href="'.$modx->makeUrl($resRes,'',array('eid' => $e->get('eventid'))).'">Reserveer nu online</a>';
    $phs['default'] = $default;
    $o .= $modx->getChunk($rowTpl, $phs);
  }
      
  // Return the results
  
  return $o;
?>