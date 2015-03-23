<?

namespace OpeningTimes;
use DatePeriod;
use DateTime;
use DateInterval;
use OpeningTimes\OverrideFactory;

class Calendar {

	protected $_slots = [];
	protected $_baseHours = [];
	protected $_slotPeriod = null;
	protected $_overrides = [];
	protected $_bookingPeriod = null;
	protected $_from = null;
	protected $_to = null;

 	/*
	 *	Constructor
	 *  $base_hours : the base hours for this venue, specified by object with start and end date keyed by day number.
	 *  $slot_period : the period between bookings you wish to display to the user, in seconds (20 minutes = 20 * 60).
	 *  $booking_period : the period before a table can be booked again in the event of a booking, in seconds.
	 */

	public function __construct($baseHours, $overrideItems, $slotPeriod, $bookingPeriod){
		$this->_baseHours = $baseHours;
		$this->_slotPeriod = $slotPeriod;
		$this->_bookingPeriod = $bookingPeriod;
		$this->_overrides = new OverrideFactory();
		$this->_overrideItems = $overrideItems;
		$this->_rawCalendar = [];

		return $this;
	}

	public function from($start){
		$this->_from = $start;
		return $this;
	}

	public function to($end){
		$this->_to = $end;
		return $this;
	}

	public function build(){
		$this->_rawCalendar = $this->_applyOverrides($this->getDaysInPeriod());
		return $this;
	}

	public function getDailyTimes(){
		$calendar = [];
		foreach($this->_rawCalendar as $date => $data){

			$times = [];
			foreach($data['hours'] as $serving => $hours){
				if(!$hours['start']){
					$times[$serving] = false;
				} else {
					$times[$serving] = [
						'from' => new DateTime('@'.($data['date']->getTimestamp() + $hours['start'])),
						'to' => new DateTime('@'.($data['date']->getTimestamp() + $hours['end']))
					];
				}
			}

			$calendar[] = [
				'date' => $data['date'],
				'times' => $times
			];
		}

		return $calendar;
	}

	protected function _applyOverrides($days){
		return $this->_overrides->apply($days, $this->_overrideItems);
	}

	public function getDaysInPeriod(){

		$dayDates = new DatePeriod(
		     new DateTime('@'.$this->_from),
		     new DateInterval('P1D'),
		     new DateTime('@'.$this->_to)
		);

		$days = [];

		foreach($dayDates as $date){
			$days[$date->format('m-d-Y')] = ['date' => $date, 'hours' => $this->_baseHours[$date->format('N')]];
		}
		
		return $days;
	}

}

