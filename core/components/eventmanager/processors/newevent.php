<?php
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
	
	$ne = $modx->newObject('Events');
	$ne->fromArray($p);
	if ($ne->save()) {
		return $modx->toJSON(array('success' => true,'message' => 'Succesfully saved the event data.','total' => 0,'data' => array(),'object' => array()));
	} else {
		return jsonError('Unknown error. '.serialize($p));
	}
?>