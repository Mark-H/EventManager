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
 * EventManager; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package EventManager
 */

EventManager.overview = function(config) {
	config = config || {};
	Ext.QuickTips.init();
	Ext.form.Field.prototype.msgTarget = 'side';
	Ext.apply(config,{
		border: false,
		baseCls: 'modx-formpanel',
		items: [{
			html: '<h2>'+_('eventmanager')+'</h2>',
			border: false,
			cls: 'modx-page-header'
		},{
            xtype: 'modx-tabs' // Use the MODx class template
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false, autoHeight: true, bodyStyle: 'padding: 10px' }
            ,border: true
            ,items: [{
                title: _('eventmanager.current')
                ,defaults: { border: false, autoHeight: true, bodyStyle: 'padding-bottom: 10px' }
                ,items: [{
                    html: '<p>'+_('eventmanager.current.description')+'</p>'
                },{  
					html: '<p>'+_('eventmanager.current.howtouse')+'</p>'
				},{
					xtype: 'eventmanager-events-current'
				}]
            },{
                title: _('eventmanager.past')
                ,defaults: { border: false, autoHeight: true, bodyStyle: 'padding-bottom: 10px' }
                ,items: [{
                    html: '<p>'+_('eventmanager.past.description')+'</p>'
                },{ 
					html: '<p>'+_('eventmanager.past.howtouse')+'</p>'
				}]
            }]
        }]
	});
    EventManager.overview.superclass.constructor.call(this,config);
};
Ext.extend(EventManager.overview,MODx.Panel); // Extend it from the base MODx Panel
Ext.reg('eventmanager-overview',EventManager.overview); // Register xtype (template)


/* Grid view */
EventManager.events.current = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		url: MODx.config.assets_url+'components/eventmanager/connector.php'
		,id: 'currentgrid'
		,baseParams: { action: 'listevents', type: 'current' }
		,fields: ["eventid","title","description","date","capacity","last_signup","date-date","date-time"]
		,paging: true
		,autosave: false
		,remoteSort: true
		,primaryKey: 'eventid'
		,items: [{
			xtype: 'tbbutton' 
			,text: _('eventmsnager.toolbar.newevent')
			,handler: function(btn,e) {
				if (typeof newEventWindow == 'undefined') {
					newEventWindow = MODx.load({
						xtype: 'eventmanager-new-event'
						,listeners: {
							'success': function() {
								newEventWindow.hide();
								this.reload();
							}
						}
					});
				}
				newEventWindow.show(e.target);
			}

		}]
		,columns: [{
			header: _('eventmanager.event.eventid') 
			,dataIndex: 'eventid'
			,sortable: true
			,width: 4
			,hidden: true
		},{
			header: _('eventmanager.event.title') 
			,dataIndex: 'title'
			,sortable: true
			,width: 14
		},{
			header: _('eventmanager.event.description') 
			,dataIndex: 'description'
			,sortable: true
			,width: 20
		},{
			header: _('eventmanager.event.date')
			,dataIndex: 'date'
			,sortable: true
			,width: 16
		},{
			header: _('eventmanager.event.capacity') // Max reservations
			,dataIndex: 'capacity'
			,sortable: true
			,width: 18
		},{
			header: _('eventmanager.event.last_signup') // Time until a reservation can be made
			,dataIndex: 'last_signup'
			,sortable: true
			,width: 18
		}]
		,listeners: {
			'cellcontextmenu': function(grid, row, col, eventObj){
				var _contextMenu = new Ext.menu.Menu({
					items: [{
						text: _('eventmanager.cm.viewreservations') 
					},'-',{
						text: _('eventmanager.cm.modify')
						,handler: function(grid, row, col, eventObj) {
							if (typeof updateEventWindow == 'undefined') {
								updateEventWindow = MODx.load({
									xtype: 'eventmanager-update-event' 
									,listeners: {
										'success': function() {
											updateEventWindow.hide();
											window.location.reload(true);
										}
									}
								});
							}
							var ggrecord = Ext.ComponentMgr.get('currentgrid').getSelectionModel().getSelected().json;							
							Ext.ComponentMgr.get('updateEventForm').setValues(ggrecord);
							updateEventWindow.show(); 
						}
					},{
						text: _('eventmanager.cm.duplicate')
					},'-',{
						text: _('eventmanager.cm.delete') 
						,handler: function() {
							Ext.Msg.confirm(_('eventmanager.cm.delete'),'Are you sure you want to delete this event?',function (btn,text) {
								//console.log(btn);
								if (btn == 'yes') {
									/*url: MODx.config.assets_url+'components/eventmanager/connector.php'
									,params: {
										action: 'delete'
									}*/
								} else {
									//console.log('What? no');
								}
							});
						}
					}]
				});
				_contextMenu.showAt(eventObj.getXY());
			}
		}
		
		
    });
    EventManager.events.current.superclass.constructor.call(this,config);
};
Ext.extend(EventManager.events.current,MODx.grid.Grid);
Ext.reg('eventmanager-events-current',EventManager.events.current);


/* ***** EventManager new event window ****** */

EventManager.window.newEvent = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('eventmanager.toolbar.newevent')
        ,url: MODx.config.assets_url+'components/eventmanager/connector.php'
        ,baseParams: {
            action: 'newevent'
        }
        ,width: 600
        ,fields: [/*{
            xtype: 'hidden'
            ,name: 'id'
        },*/{
            xtype: 'textfield'
            ,fieldLabel: _('eventmanager.event.title')
            ,name: 'title'
            ,anchor: '90%'
			,allowBlank: false
        },{
            xtype: 'textarea'
            ,fieldLabel: _('eventmanager.event.description')
            ,name: 'description'
            ,anchor: '90%'
			,allowBlank: false
        },{
            xtype: 'datefield'
            ,fieldLabel: _('eventmanager.event.date')
            ,name: 'date-date'
            ,anchor: '90%'
			,format: 'Y-m-d'
			,allowBlank: false
        },{
            xtype: 'timefield'
            ,fieldLabel: _('eventmanager.event.time')
            ,name: 'date-time'
            ,anchor: '90%'
			,format: 'H:i:s'
			,allowBlank: false
            //,submitValue: false
        },{
			xtype: 'numberfield'
			,fieldLabel: _('eventmanager.event.capacity')
			,name: 'capacity'
			,anchor: '90%'
			,minValue: 0
		},{
			xtype: 'numberfield'
			,fieldLabel: _('eventmanager.event.last_signup.hours')
			,name: 'last_signup'
			,anchor: '90%'
			,minValue: 0
		}]
        ,keys: []
    });
    EventManager.window.newEvent.superclass.constructor.call(this,config);
};
Ext.extend(EventManager.window.newEvent,MODx.Window);
Ext.reg('eventmanager-new-event',EventManager.window.newEvent);

/* ***** Update events ***** */
EventManager.window.updateEvent = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('eventmanager.cm.modify')
		,id: 'updateEventForm'
        ,url: MODx.config.assets_url+'components/eventmanager/connector.php'
        ,baseParams: {
            action: 'modifyevent'
        }
        ,width: 600
        ,fields: [{
            xtype: 'hidden'
            ,name: 'eventid'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('eventmanager.event.title')
            ,name: 'title'
            ,anchor: '90%'
			,allowBlank: false
        },{
            xtype: 'textarea'
            ,fieldLabel: _('eventmanager.event.description')
            ,name: 'description'
            ,anchor: '90%'
			,allowBlank: false
        },{
            xtype: 'datefield'
            ,fieldLabel: _('eventmanager.event.date')
            ,name: 'date-date'
            ,anchor: '90%'
			,format: 'Y-m-d'
			,allowBlank: false
        },{
            xtype: 'timefield'
            ,fieldLabel: _('eventmanager.event.time')
            ,name: 'date-time'
            ,anchor: '90%'
			,format: 'H:i:s'
			,allowBlank: false
            //,submitValue: false
        },{
			xtype: 'numberfield'
			,fieldLabel: _('eventmanager.event.capacity')
			,name: 'capacity'
			,anchor: '90%'
			,minValue: 0
		},{
			xtype: 'numberfield'
			,fieldLabel: _('eventmanager.event.last_signup.hours')
			,name: 'last_signup'
			,anchor: '90%'
			,minValue: 0
		}]
        ,keys: []
    });
    EventManager.window.updateEvent.superclass.constructor.call(this,config);
};
Ext.extend(EventManager.window.updateEvent,MODx.Window);
Ext.reg('eventmanager-update-event',EventManager.window.updateEvent);