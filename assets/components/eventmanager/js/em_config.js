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
var EventManager = function(config) {
	config = config || {};
	EventManager.superclass.constructor.call(this,config);
};
Ext.extend(EventManager,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('eventmanager',EventManager);

var EventManager = new EventManager();

EventManager.main = function(config) { // Config for page.Home
    config = config || {};
    Ext.applyIf(config,{ 
        components: [{ 
            xtype: 'eventmanager-overview',
            renderTo: 'eventmanager-main' // Div that should be in your page 
        }]
    }); 
    EventManager.main.superclass.constructor.call(this,config);
};
Ext.extend(EventManager.main,MODx.Component); // Extend it from the MODx.Component class.
Ext.reg('eventmanager-main',EventManager.main); // First parameter is the xtype to be referenced, second the config

Ext.onReady(function() { 
    MODx.load({ xtype: 'eventmanager-main'}); 
});