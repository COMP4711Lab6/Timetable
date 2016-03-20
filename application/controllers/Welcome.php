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

    // Display the result found if there are no conflicts
    if (count($dayMatch) == 1
    	&& count($courseMatch) == 1
    	&& count($periodMatch) == 1) {

    	$this->data['bingo'] = "Bingo!";
    	$periods = array();
	    $periods[] = $periodMatch;
	    $this->data['periods'] = $periods;
    }
    // Uh oh, we found a conflict in the schedule, display an error
    else if (count($dayMatch) > 1
    			|| count($courseMatch) > 1
    			|| count($periodMatch) > 1) {

    	$days = "Day Entries: " . count($dayMatch) . ", ";
			$courses = "Course Entries: " . count($courseMatch) . ", ";
			$periods = "Period Entries: " . count($periodMatch);
    	$this->data['duplicates'] = $days . $courses . $periods;
    }
    // No entires found :(
    else {
    	$this->data['bingo'] = "No Bingo :(";
    }

    $this->data['pagetitle'] = "Search Result";
		$this->data['pagebody'] = 'timetable_single';
		$this->render();
	}

}
