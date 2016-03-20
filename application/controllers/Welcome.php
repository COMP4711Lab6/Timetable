<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function index()
	{
		$this->data["daysofweek"] = $this->timetable->getDaysOfWeek();
    $this->data["courses"] = $this->timetable->getCourses();
    $this->data["periods"] = $this->timetable->getPeriods();

    $this->data['pagetitle'] = "Index";
    $this->data['pagebody'] = 'timetable_all';
		$this->render();
	}

	public function search()
	{
		$inputDay = $this->input->post('day');
    $inputPeriod = $this->input->post('period');

    $dayMatch = $this->timetable->searchDaysOfWeek($inputDay,$inputPeriod);
    $courseMatch = $this->timetable->searchCourses($inputDay,$inputPeriod);
    $periodMatch = $this->timetable->searchPeriods($inputDay,$inputPeriod);

    if ($dayMatch != null
    	&& $courseMatch != null
    	&& $periodMatch != null) {
    	$this->data['bingo'] = "Bingo!";

    	$periods = array();
	    $periods[] = $periodMatch;
	    $this->data['periods'] = $periods;
    }

    $this->data['pagetitle'] = "Search Result";
		$this->data['pagebody'] = 'timetable_single';
		$this->render();
	}

}
