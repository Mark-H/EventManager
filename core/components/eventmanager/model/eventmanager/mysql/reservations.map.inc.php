<?php
$xpdo_meta_map['Reservations']= array (
  'package' => 'eventManager',
  'version' => '1.1',
  'table' => 'em_reservations',
  'fields' => 
  array (
    'reservationid' => NULL,
    'eventid' => NULL,
    'firstname' => NULL,
    'lastname' => NULL,
    'time' => NULL,
    'address' => NULL,
    'email' => NULL,
    'remarks' => NULL,
    'phone' => NULL,
  ),
  'fieldMeta' => 
  array (
    'reservationid' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'pk',
      'generated' => 'native',
    ),
    'eventid' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
    ),
    'firstname' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '200',
      'phptype' => 'string',
      'null' => false,
    ),
    'lastname' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '200',
      'phptype' => 'string',
      'null' => false,
    ),
    'time' => 
    array (
      'dbtype' => 'int',
      'precision' => '15',
      'phptype' => 'integer',
      'null' => false,
    ),
    'address' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '500',
      'phptype' => 'string',
      'null' => false,
    ),
    'email' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '200',
      'phptype' => 'string',
      'null' => false,
    ),
    'remarks' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '2000',
      'phptype' => 'string',
      'null' => false,
    ),
    'phone' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '30',
      'phptype' => 'string',
      'null' => false,
    ),
  ),
  'indexes' => 
  array (
    'PRIMARY' => 
    array (
      'alias' => 'PRIMARY',
      'primary' => true,
      'unique' => true,
      'columns' => 
      array (
        'reservationid' => 
        array (
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'Events' => 
    array (
      'class' => 'Events',
      'local' => 'eventid',
      'foreign' => 'eventid',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
