#!/usr/bin/php
<?php

set_time_limit(0);
include "./classes/MoepUtil.class.php";
define('MOEPBOT_DATA',    './data');

ini_set('memory_limit', '1024000000');

$memory_limit = ini_get('memory_limit');

$sleep = 5000; // sleeptime in microseconds
$count = 0;
$store = array();

class stuff {
	private $stuff = array();
	public function make() {
		$data = MoepUtil::loadArray('./memleak.testdata');
		$data[] = time();
		$data[] = date('Y-m-d-H-i-s', time());
		$data[] = rand(0,10000);
		$data[] = rand(0,10000);
		$data[] = rand(0,10000);
		$data[] = rand(0,10000);
		$data[] = rand(0,10000);
		MoepUtil::saveArray($data, './memleak.testdata');
		$this->stuff[] = $data;
		#var_dump($data);
	}
}

while (true) {
	$count++;
	$stuff = new stuff();
	$stuff->make();
	$store[] = $stuff;
	print 'mem='.memory_get_usage().' of '.$memory_limit.' Bytes, count='.$count."\n";

	if (0 === $count % 10)  {
		#print "cleaning up...\n";
		$count = 0;
		$store = array();
	}
	usleep($sleep);
}
?>
