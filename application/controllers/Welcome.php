<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$ports = Port::all();
		$this->render('step1', compact('ports'));
	}

	public function step2() {
		$origin = $this->input->post('origin');
		$destination = $this->input->post('destination');
		$date = $this->input->post('date');
		$adult = $this->input->post('adult');
		$children = $this->input->post('children');
		$infant = $this->input->post('infant');
		$departure_date = null;
		$return_date = null;
		$schedule_collection = null;

		/**
		 * seperate date to get departure date and return date
		 */
		if( strpos($date, '-') ) {
			$index = strpos($date, '-');
			$departure_date = substr($date, 0, $index);
			$return_date = substr($date, $index + 1, strlen($date) - $index);

			/**
			 * format date 'yyyy/mm/dd'
			 */
			$departure_date = date('Y-m-d', strtotime($departure_date));
			$return_date = date('Y-m-d', strtotime($return_date));
		} else {
			$departure_date = $date;
			$departure_date = date('Y-m-d', strtotime($departure_date));
		}
		/**
		 * get available routes base on origin and destination
		 */
		$routes = $this->getRoute( $origin, $destination );
		if( ! empty( $routes ) ) {
			$available_schedule = 0;
			foreach( $routes as $route ) {
				/**
				 * return collections of schedule
				 */
				$schedules = $this->getSchedule($route->id, $departure_date);
				
				/**
				 * check schedule if not empty
				 * redirect back if empty
				 */
				if( count($schedules) ) {
					foreach($schedules as $schedule) {
						$seats = $schedule->vessel->seatSection;
						$beds = $schedule->vessel->bedSection;
						$rooms = $schedule->vessel->roomSection;

						$seat_collection = $this->sectionRate($seats) ;
						$bed_collection = $this->sectionRate($beds);
						$room_collection = $this->sectionRate($rooms);

						/**
						 * set collection of schedule
						 */
						$vessel_collection = [
							'id' => $schedule->vessel->id,
							'name' => $schedule->vessel->name,
							'date' => $schedule->sched_date,
							'time' => $schedule->sched_time,
							'collection' => (object)[
								'seat' => $seat_collection,
								'bed' => $bed_collection,
								'room' => $room_collection
							]
						];
						$schedule_collection[] = (object)$vessel_collection;
					}

					/**
					 * increment available schedule
					 */
					$available_schedule++;
				}
			}

			// header('Content-Type: application/json');
			// echo json_encode($schedule_collection);
			// exit();

			if( ! $available_schedule ) {
				echo "no schedule's available";
				exit();
			}

			return $this->render('step2', compact('schedule_collection'));
			exit();
		}
		
		echo "no route's available ";
	}

	public function step3() {
		header('Content-Type: application/json');
		echo json_encode($this->input->post());
		exit();
	}

	public function sectionRate( $sections ) {
		/**
		 * if section is not 0 or not empty
		 * return set of collections
		 */
		$collection = [];
		if( count( $sections ) ) {
			foreach($sections as $section) {								
				/**
				 * get section regular rate
				 */
				$passenger = $section->rate->first()->passenger->name;
				$rate = $section->rate->first()->rate;

				$temp = [
					'section_id' => $section->id,
					'section' => $section->name,
					'passenger' => $passenger,
					'rate' => $rate
				];

				$collection[] = (object)$temp;
			}
			return (object)$collection;
		}
		return null;
	}

	/**
	 * @param $id int
	 */
	public function get_destination( $id ) {
		$routes = Route::where('from_port_id', $id)->get();
		$destinations = [];
		
		foreach($routes as $route) {
			$destinations[] = $route->destination;
		}

		die( json_encode($destinations) );
	}

	public function getRoute($origin, $destination) {
		$where = [
			[ 'from_port_id', $origin ],
			[ 'to_port_id', $destination ]
		];
		return Route::where($where)->get();
	}

	public function getSchedule($route_id, $date) {
		$where = [
			[ 'route_id', $route_id ],
			[ 'sched_date', $date ]
		];
		return Schedule::where($where)->get();
	}

	public function render( $page, $data = null ) {
		$this->load->view('template/header', $data);
		$this->load->view($page, $data);
		$this->load->view('template/footer', $data);
	}
}
