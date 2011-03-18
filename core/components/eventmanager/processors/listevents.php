<?php
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'date');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$dateFormat = $modx->getOption('dateFormat',$scriptProperties,$modx->getOption('manager_date_format').' '.$modx->getOption('manager_time_format'));
$type = $modx->getOption('type',$scriptProperties,'current');

$c = $modx->newQuery('Events');
$c->where(array(
	'date:>' => time()));
$count = $modx->getCount('Events',$c);
$c->sortby($sort,$dir);
$c->limit($limit,$start);
$events = $modx->getIterator('Events', $c);

/* iterate */
$list = array();
foreach ($events as $e) {
	$eArray = $e->toArray();
	$eArray['date-date'] = date('Y-m-d',$eArray['date']);
	$eArray['date-time'] = date('H:i:s',$eArray['date']);
	$eArray['date'] = date($dateFormat,$eArray['date']);
	$eArray['capacity'] = ($eArray['capacity'] > 0) ? $eArray['capacity'] : '';
	$list[] = $eArray;
}
return $modx->toJSON(array(
	'total' => $count,
	'results' => $list));
return $this->outputArray($list,$count);
?>
