<?php
class Timetable extends CI_Model {

    public $xml = null;
    protected $daysofweek = array();
    protected $courses = array();
    protected $periods = array();

    public function __construct() {
        $this->xml = simplexml_load_string(file_get_contents('data/timetable.xml'));

        foreach ($this->xml->daysofweek->day as $day) {
            foreach ($day->booking as $book) {
                $element = array();
                $element['day'] = (string) $day['name'];
                $element['time'] = (string) $book['time'];
                $element['coursename'] = (string) $book->coursename;
                $element['teacher'] = (string) $book->teacher;
                $element['location'] = (string) $book->location;
                $element['classtype'] = (string) $book->classtype;
                $this->daysofweek[] = new Booking($element);
            }
        }

        foreach ($this->xml->courses->course as $course) {
            foreach ($course->booking as $book) {
                $element = array();
                $element['coursename'] = (string) $course['name'];
                $element['time'] = (string) $book['time'];
                $element['day'] = (string) $book->dayofweek;
                $element['teacher'] = (string) $book->teacher;
                $element['location'] = (string) $book->location;
                $element['classtype'] = (string) $book->classtype;
                $this->courses[] = new Booking($element);
            }
        }


        foreach ($this->xml->periods->timeslot as $period) {
            foreach ($period->booking as $book) {
                $element = array();
                $element['day'] = (string) $book['day'];
                $element['time'] = (string) $period['time'];
                $element['coursename'] = (string) $book->coursename;
                $element['teacher'] = (string) $book->teacher;
                $element['location'] = (string) $book->location;
                $element['classtype'] = (string) $book->classtype;
                $this->periods[] = new Booking($element);
            }
        }
    }

    public function getDaysOfWeek() {
        return $this->daysofweek;
    }

    public function getPeriods(){
        return $this->periods;
    }

    public function getCourses(){
        return $this->courses;
    }

    /**
     * Generates array of values for days slot dropdown menu
     * @return array
     */
    public function getDays() {
        return array('Monday' => 'Monday',
                    'Tuesday' => 'Tuesday',
                    'Wednesday' => 'Wednesday',
                    'Thursday' => 'Thursday',
                    'Friday' => 'Friday'
                    );
    }

    /**
     * Generates array of values for time slot dropdown menu
     * @return array
     */
    public function getTimeSlots(){
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
     * Search the Day facet
     * @param $day the day value from input
     * @param $timeslot the time value from input
     * @return mixed bookings on that day and time
     */
    public function searchDaysOfWeek($day, $timeslot){
        $days = array();

        foreach($this->daysofweek as $booking){
            if($booking->day == $day && $booking->time == $timeslot){
                $days[] = $booking;
            }
        }
        return $days;
    }

    /**
     * Search the Courses facet
     * @param $day the day value from input
     * @param $timeslot the time value from input
     * @return mixed bookings on that day and time
     */
    public function searchCourses($day, $timeslot){
        $courses = array();

        foreach($this->courses as $booking){
            if($booking->day == $day && $booking->time == $timeslot){
                return $booking;
            }
        }
        return $courses;
    }

    /**
     * Search the Periods facet
     * @param $day the day value from input
     * @param $timeslot the time value from input
     * @return mixed bookings on that day and time
     */
    public function searchPeriods($day, $timeslot){
        $periods = array();

        foreach($this->periods as $booking){
            if($booking->day == $day && $booking->time == $timeslot){
                return $booking;
            }
        }
        return $periods;
    }

}

/**
 * Class Booking
 * Represents a single booking
 */
class Booking extends CI_Model {

    public $day;
    public $time;
    public $coursename;
    public $teacher;
    public $location;
    public $classtype;

    public function __construct($booking) {
        $this->day = (string) $booking['day'];
        $this->time = (string) $booking['time'];
        $this->coursename = (string) $booking['coursename'];
        $this->teacher = (string) $booking['teacher'];
        $this->location = (string) $booking['location'];
        $this->classtype = (string) $booking['classtype'];
    }
}