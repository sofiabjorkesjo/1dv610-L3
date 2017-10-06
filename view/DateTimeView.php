<?php

class DateTimeView {

	public function show() {
		$nameOfDay = date("l");
		$dateOfDay = date("jS");
		$month = date("F");
		$year = date("o");
		$time = date("G:i:s");

		$timeString = $nameOfDay . ", the " . $dateOfDay . " of " . $month . " " . $year . ", The time is " . $time;
		return '<p>' . $timeString . '</p>';
	}
}