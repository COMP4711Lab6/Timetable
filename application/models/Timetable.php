<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 3/9/16
 * Time: 9:59 AM
 */
class Timetable extends CI_Model{
    protected $xml = null;
    protected $days = null;
    protected $courses = null;
    protected $periods = null;

    /**
     * Timetable constructor.
     */
    public function  __construct()
    {
        $this->xml = simplexml_load_file('data/timetable.xml');

        foreach($this->xml->days->whichday as $dayofweek){
            foreach($dayofweek->booking as $book){
                $element = array();
                $element['whichday'] = (string)$dayofweek['whichday'];
                $element['timeslot'] = (string)$book['timeslot'];
                $element['class'] = (string)$book->class;
                $element['teacher'] = (string)$book->teacher;
                $element['location'] = (string)$book->location;
                $element['classtype'] = (string)$book->classtype;
                $this->days[] = new Booking($element);
            }
        }

        foreach($this->xml->courses->course as $course){
            foreach($course->booking as $book){
                $element = array();
                $element['course'] = (string)$course['name'];
                $element['timeslot'] = (string)$course['timeslot'];
                $element['day'] = (string)$book->dayofweek;
                $element['teacher'] = (string)$book->teacher;
                $element['location']=(string)$book->location;
                $element['classtype'] = (string)$book->classtype;
                $this->courses[] = new Booking($element);
            }
        }

        foreach($this->xml->periods->timeslot as $time){
            foreach($time->booking as $book) {
                $element = array();
                $element['dayofweek'] = (string)$book['day'];
                $element['timeslot'] = (string)$book['timeslot'];
                $element['class'] = (string)$book->class;
                $element['teacher'] = (string)$book->teacher;
                $element['location'] = (string)$book->location;
                $element['classtype'] = (string)$book->classtype;
                $this->periods[]= new Booking($element);
            }
        }
    }

    /**
     * @return accessor to days
     */
    public function getDays(){
        return $this->days;
    }

    /**
     * @return accessor to periods
     */
    public function getPeriods(){
        return $this->periods;
    }

    /**
     * @return accessor to courses
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @return array that makes the dropdown menu for days
     */
    public function  getDayOfWeek(){
        return array('Monday' => 'Monday',
                     'Tuesday'=>'Tuesday',
                     'Wednesday'=>'Wednesday',
                     'Thursday'=>'Thursday',
                      'Friday'=>'Friday');
    }

    /**
     * @return array that makes the dropdown menu for time slots
     */
    public function getTimeSlot(){
        return array (
            "8:30-10:20" => "8:30 to 10:20",
            "9:30-11:20" => "9:30 to 11:20",
            "10:30-12:20" => "10:30 to 12:20",
            "11:30-12:20" => "11:30 to 12:20",
            "12:30-14:20" => "12:30 to 14:20",
            "14:30-15:20" => "14:30 to 15:20",
            "15:30-17:20" => "15:30 to 17:20",
            "13:30-14:20" => "13:30 to 14:20",
            "12:30-13:20" => "12:30 to 13:20",
            "14:30-17:20" => "14:30 to 17:20"
        );
    }

    /**
     * Search for the course
     * @param $dayOfWeek day of the week from user input
     * @param $chosenTimeslot time slot from user input
     * @return booking object for that day at that time
     */
    public function searchDays($dayOfWeek,$chosenTimeslot){
        foreach($this->courses as $book){
            if($book->dayofweek == $dayOfWeek && $book->timeslot == $chosenTimeslot){
                return $book;
            }
        }
    }

    public function searchPeriods($dayOfWeek,$chosenTimeslot){
        foreach($this->periods as $book){
            if($book->timeslot == $chosenTimeslot && $book->day == $dayOfWeek){
                return $book;
            }
        }
    }


}

/**
 * Class Booking
 */
class Booking extends CI_Model{
    public $class;
    public $teacher;
    public $location;
    public $classtype;
    public $dayofweek;
    public $timeslot;

    /**
     * Booking constructor.
     * @param $booking booking object
     */
    public function __construct($booking)
    {
        $this->class = (string)$booking['class'];
        $this->teacher = (string)$booking['teacher'];
        $this->location = (string)$booking['location'];
        $this->classtype = (string)$booking['classtype'];
        $this->dayofweek = (string)$booking['dayofweek'];
        $this->timeslot = (string)$booking['timeslot'];
    }
}

