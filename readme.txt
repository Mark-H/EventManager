EventManager is a component for MODX intended to make managing events easy. It allows
for making reservations online (no payment though) which are automatically entered
into a database and linked to the event. In the back-end component you can manage
your events, the capacity and any reservations for that event.

By using snippets you can display the events in any way using chunks to template them.

EventManager is far from finished / ready for the public, but feel free to fork, try it
out and report back. :)

Below you will find the complete specification for this project for informational purpose.

If you would like to fund development for this addon, please make a donation through paypal
to hamstra.mark [at] gmail [dot] com making sure you add "EventManager" in the description
so I know it's for this addon :)


##################################################
##     EventManager - Initial Specification     ##
##################################################

Mark Hamstra                       March 5th, 2011

This is a non-definite specification for an event
managing addon for the MODX CMF. 

##### Fundamental thoughts ######################

* The EventManager offers a way to manage events
  and offer site visitors online reservation
  opportunities. 

##### Available Fields ##########################

Event details:
* eventid: auto_increment unique ID (int)
* title: event title (string 200)
* description: plain text description (string 2000)
* date: unix style timestamp (int 15)
* capacity: max # of reservations (int 10)
* last_signup: hours before date where reservations
  can last be accepted. (int 10)
  
Reservation details:
* reservationid: auto_increment unique ID (int 11)
* eventid: reference to event (int 10)
* tickets: number of people for this reservation
  (int 10)
* firstname: name (string 200)
* lastname: name (string 200)
* time: unix style timestamp (int 15)
* address: plain text (string 500)
* email: (string 200)
* remarks: optional field for notes (string 2000)
* phone: (string 30)

##### 1. Current events tab #####################

* On the current events tab, you can view events
  that have a date specified that is later than
  now.
* A toolbar is available with a button ("Add new")
  and a search field. 
* Right clicking in the events grid gives the
  following context menu:
  * View reservations: view reservations for event
  * Change details: update event details
  * Duplicate: add new event with details prefilled
  * Remove event: remove event & linked reservations

##### 2. Past events tab ########################

* Toolbar with a Prune button which removes all
  data (incl reservations) for events older than
  30 days. 
* Right click context menu:
  * View details
  * View reservations

##### 3. View reservations ######################
  
* When opened through the context menu of events,
  it will filter on the right event.
* Search button available on toolbar with several
  search options. 
* (unsure) Dropdown to filter on events
* (unsure) Toggle past events
* Context menu on right click:
  * View details
  * Update reservation
  * Remove reservation
  
##### 4. Included snippets #####################

* emNewReservationHook: a hook for a FormIt form
  which is used to store the reservation in the db
  * Checks the event id passed:
    * Reservations allowed for event?
	* Capacity not yet reached?
  * Create reservation 
  * Set event detail values back to formit hook
    to use in a next hook (email)
* emListEvents: getResources for events.
  * Templating through &rowTpl and &outerTpl
  * &default which can be used in selectbox tpls
  * Automatically only includes upcoming events
    sorted ascending.
  * &reservationResource to create links to form
    when makingn a reservation is still possible
    * Only make link if capacity hasn't been
	  reached yet.