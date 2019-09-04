<?php
$time1 = new DateTime();
	$time2 = new DateTime('2000-01-01');
	$interval = $time1->diff($time2);
	var_dump($interval->format('%a'));
