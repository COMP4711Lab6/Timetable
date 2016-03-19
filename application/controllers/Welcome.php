<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function index()
	{
    $this->data['pagebody'] = 'timetable_all';
		$this->render();
	}

	public function search()
	{
		$this->data['pagebody'] = 'timetable_search';
		$this->render();
	}

}
