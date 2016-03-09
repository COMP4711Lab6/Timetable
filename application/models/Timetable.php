<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 3/9/16
 * Time: 9:59 AM
 */
class Timetable extends CI_Model{
    protected $xml = null;
    protected $courses = array();
    protected $periods = array();
    protected $days = array();

    public function  __construct()
    {
        parent::construct();
        $this -> xml = simplexml_load_file(DATAPATH,"courses.xml");

    }
}