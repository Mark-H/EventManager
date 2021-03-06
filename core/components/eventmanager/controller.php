﻿<?php
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
	
	include_once MODX_CORE_PATH.'components/eventmanager/initiate.php';

	$em_assets = $modx->getOption('assets_url').'components/eventmanager/';
	// Fetch the main config
	$modx->regClientStartupScript($em_assets.'js/em_config.js');
	// Fetch the home screen (overview) js
	$modx->regClientStartupScript($em_assets.'js/em_overview.js');
	
	$o = '<div id="eventmanager-main"></div>
	<div id="popupwindow"></div>';
	
	// Fetch the default lexicon for use later.
	$modx->lexicon->load('eventmanager:default');  

	// Return the empty divs
	return $o;

?>