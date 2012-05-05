<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thatn extends CI_Controller {

	// I want to send parameters to the index controller, so we need a remap.
	public function _remap($method)
	{
	  $param_offset = 2;

	  // Default to index
	  if ( ! method_exists($this, $method))
	  {
	    // We need one more param
	    $param_offset = 1;
	    $method = 'index';
	  }

	  // Since all we get is $method, load up everything else in the URI
	  $params = array_slice($this->uri->rsegment_array(), $param_offset);

	  // Call the determined method with all params
	  call_user_func_array(array($this, $method), $params);
	}

	public function index($main_colour=FALSE, $secondary_colour=FALSE, $page=0)
	{

		// Create an empty view data array which we'll populate later
		$view_data = array();

		// I want to use the form helper in the view, so we'll load that now
		$this->load->helper('form');

		$limit = 3; // Used for pagination. The number of lighter/darker colours.

		// Data can either be POSTed or sent as URI segments
		if ($this->input->post()){

			// No validation yet, the hexwheel library covers that.
			$main_colour 		= $this->input->post('main_colour');
			$secondary_colour 	= $this->input->post('secondary_colour');

		}

		// If a main colour has been POSTed or set as a URI segment
		if( $main_colour ){

			// Load up the hexwheel library, which validates hex colours, and can alter their brightness
			$this->load->library('HexWheel');

			// Set the original main colour
			if( $this->hexwheel->set_colour($main_colour) ){ // If the hex is invalid set_colour will return false

				// We need to keep track of the original colour in case of paging
				$original_colour = $this->hexwheel->colour;

				// If we received a page, we need to offset the main colour's brightness
				$step = $page * $limit;

				// Adjust the colour to account for brightness change
				$page_colour = $this->hexwheel->brightness((-15 * $page) + 100);

				// Set the altered colour before creating lighter/darker colours
				$this->hexwheel->set_colour($page_colour);

				// Create new colours with altered brightness. Negative brightness values create darker colours and vice versa.
				$view_data['colour_1']	 	= $this->hexwheel->brightness(105);
				$view_data['colour_2']	 	= $this->hexwheel->brightness(110);
				$view_data['colour_4']		= $this->hexwheel->brightness(115);

				$view_data['colour1']	 	= $this->hexwheel->brightness(95);
				$view_data['colour2']	 	= $this->hexwheel->brightness(90);
				$view_data['colour4']	 	= $this->hexwheel->brightness(85);

				// Let's try altering the saturation too
				$view_data['colour_sat_1']  = $this->hexwheel->saturation(75);
				$view_data['colour_sat_2']  = $this->hexwheel->saturation(50);
				$view_data['colour_sat_4']  = $this->hexwheel->saturation(0);

				$view_data['colour_sat1']  = $this->hexwheel->saturation(125);
				$view_data['colour_sat2']  = $this->hexwheel->saturation(150);
				$view_data['colour_sat4']  = $this->hexwheel->saturation(200);

				// Send the main colour (the original colour with any adjustments made for the page) to the view
				$view_data['page_colour'] 		= $this->hexwheel->colour;

				// Send the original main colour, without any adjustments. This is needed for pagination.
				$view_data['original_colour'] 	= $original_colour;

				// Send the page number.
				$view_data['page'] = $page;


			}else{

				// If the colour didn't pass validation, send it to the view unchanged for the user to see what they did wrong
				$view_data['original_colour'] = $main_colour;

			}

			// The secondary colour is used as a background. If it wasn't set and the user changed page then it'll be set as 0 in the URI segment
			if( $secondary_colour && $secondary_colour !== 0 ){

				// Send the colour through hexwheel to validate it. If it doesn't validate, we'll send back the orignal string to the view
				if( $this->hexwheel->set_colour( $secondary_colour ) ){
					$secondary_colour = $this->hexwheel->colour;
				}

			// Make sure the view knows that the secondary colour wasn't set.
			}else $secondary_colour = FALSE;

			// Send the secondary colour to the view
			$view_data['secondary_colour'] = $secondary_colour;

			// Send any errors from hexwheel to the view
			$view_data['display_errors'] = $this->hexwheel->errors;

		}

		// And finally load the view. If I get around to AJAXifying, there'll be a seperate view fro AJAX and regular html here.
		$this->load->view('thatn', $view_data);
	}
}

/* End of file thatn.php */
/* Location: /application/controllers/thatn.php */