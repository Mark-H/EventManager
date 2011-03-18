<?php
/*
 * EventManager
 *
 * Copyright 2010-2011 by Mark Hamstra (www.markhamstra.nl)
 *
 * This file is part of EventManager, a MODX Revolution addon to manage events
 * and event reservations.
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
 * VersionX; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package EventManager
 */
	function jsonError($msg, &$mdx) {
		return $mdx->toJSON(array('success' => false,'message' => $msg,'total' => 0,'data' => array(),'object' => array()));
	}
	
	$date = $_POST['date-date'].' '.$_POST['date-time'];
	$date2 = (date('m',$date) > 0) ? strtotime($date) : ''; 
	if ($date2 == '') { return jsonError('Unable to parse date: '.$date,$modx); }
	
	$p = array(
		'title' => $_POST['title'],
		'description' => $_POST['description'],
		'date' => (int)strtotime($_POST['date-date'].' '.$_POST['date-time']),
		'capacity' => (int)$_POST['capacity'],
		'last_signup' => (int)$_POST['last_signup']);
	
	$eo = $modx->getObject('Events',$_POST['eventid']);
	$eo->fromArray($p);
	if ($eo->save()) {
		return $modx->toJSON(array('success' => true,'message' => 'Succesfully saved the event data.','total' => 0,'data' => array(),'object' => array()));
	} else {
		return jsonError('Unknown error. '.serialize($p));
	}
?>