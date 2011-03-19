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
<?php

  // Fetch package
  require_once (MODX_CORE_PATH . 'components/eventmanager/initiate.php');

  $v = $hook->getValues();
  // FormIt should be validating the fields except for the event, so validate.
  
  $err = false;
  $event = $modx->getObject('Events',$v['eventid']);
  if (!$event) {
    $hook->addError('eventid','Activiteit niet gevonden.');
    $err = true;
  } else {
    $capacity = $event->get('capacity');
    
    //$hook->addError('debug','Capacity: '.$capacity );
    
    if ($capacity > 0) {
      $last_signup = $event->get('last_signup');
      $date = $event->get('date');
      
      //$hook->addError('debug','Last signup: '.$last_signup.', date: '.$date);
      
      if ($last_signup > 0) {
        $date = $date + ($last_signup * 3600);
        //$hook->addError('debug','Date set to '.$date.'. Current date: '.time());
      }
      if ($date < time()) {
        $hook->addError('eventid','Online reserveren voor deze activiteit is niet meer mogelijk.');
        $err = true;
      }
      if ($err == false) {
        //$hook->addError('debug','No error found.. fetch reservations.');
        $reservations = count($event->getMany('Reservations'));
        //$hook->addError('debug',' Reservations: '.$reservations);
        if (($capacity - $reservations) < $v['tickets']) {
          $hook->addError('tickets','Er zijn helaas geen '.$v['tickets'].' meer beschikbaar.');
          $err = true;
        }
      }
    }
  }
  
  if ($err == false) {
    // Add the reservation
    $nr = $modx->newObject('Reservations');
    $nr->fromArray($v);
    $nr->set('time',time());
    if (!$nr->save()) {
      $err = true;
      $hook->addError('eventid','Er is iets fout gegaan met het opslaan. Neem aub contact op met het beheer.');
    }
    else {
      $hook->setValues(array(
        'event.title' => $event->get('title'),
        'event.description' => $event->get('description'),
        'event.date' => $event->get('date'),
        'reservationid' => $nr->getPrimaryKey()));
    }
  }
  
  return ($err === false) ? true : false;​