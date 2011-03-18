<?php
$xpdo_meta_map['Events']= array (
  'package' => 'eventManager',
  'version' => '1.1',
  'table' => 'em_events',
  'fields' => 
  array (
    'eventid' => NULL,
    'title' => NULL,
    'description' => NULL,
    'date' => NULL,
    'capacity' => NULL,
    'last_signup' => NULL,
  ),
  'fieldMeta' => 
  array (
    'eventid' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'pk',
      'generated' => 'native',
    ),
    'title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '200',
      'phptype' => 'string',
      'null' => false,
    ),
    'description' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '2000',
      'phptype' => 'string',
      'null' => false,
    ),
    'date' => 
    array (
      'dbtype' => 'int',
      'precision' => '15',
      'phptype' => 'integer',
      'null' => false,
    ),
    'capacity' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => true,
    ),
    'last_signup' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => true,
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
        'eventid' => 
        array (
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'Reservations' => 
    array (
      'class' => 'Reservations',
      'local' => 'eventid',
      'foreign' => 'eventid',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
