<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class MY_Controller extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;      // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */
    function __construct()
    {
        parent::__construct();

        $this->data = array();
        $this->data['pagetitle'] = 'Timetable';
        $this->data['searchForm'] = $this->createSearchDropdown();
    }

    /**
     * Render this page
     */
    function render()
    {
        // Load pagebody view into base template
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
        $this->data['data'] = &$this->data;

        $this->parser->parse('_template', $this->data);
    }

    private function createSearchDropdown()
    {
        $data = array();
        $data['daysSearch'] = form_dropdown('day', $this->timetable->getDays());
        $data['periodSearch'] = form_dropdown('period', $this->timetable->getTimeSlots());

        return $this->parser->parse('searchForm', $data, true);
    }

}