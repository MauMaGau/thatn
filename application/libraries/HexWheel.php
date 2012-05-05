<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/*
		@author: dtownsend@gmail.com / http://dtownsend.co.uk

		A hex-based colour converter.
		Currently only supports altering brightness.
	*/
	class HexWheel{

		public $colour 		= ''; // The colour set using set_colour
		public $errors		= array();

		private $exploded_colour; // hex values as array(rr,gg,bb)


		public function __construct( ){
			// Nope, don't need to do anything here
		}

		/*
			Set the main colour. This must be called before any adjustments are made.
			Requires a 3 or 6 character hex colour value.
			Returns TRUE on success, FALSE on error.
		*/
		public function set_colour( $hex_colour ){

			try{
				$colour = $this->validateHex($hex_colour);

				$this->exploded_colour = $this->explodeHex($colour);
				$this->colour = $colour;
			}
			catch(Exception $e){
				return FALSE;
			}

			return TRUE;
		}

		/*
			Validate and sanitize the hex code.
			Requires a 3 or 6 digit hex colour value
			Returns a 6-char hex value
		*/
		public function validateHex( $hex_colour ){

			// Sanitize input to filter out any nasties, and trim any whitespace
			$hex_colour = filter_var(trim($hex_colour), FILTER_SANITIZE_STRING);

			// Validate hex code. Make sure it's either 3 or digits, and valid hex.
			// Needs some regex. Joy.
			// "(^[0-9a-fA-F]{6}$)|(^[0-9a-fA-F]{3}$)" match either 6 single hex characters, or 3. Try 3 last to prevent matching 3 chars in a 4/5 char string.
			if( preg_match('/(^[0-9a-fA-F]{6}$)|(^[0-9a-fA-F]{3}$)/', $hex_colour) < 1 ){

				$this->errors[] = "Invalid hex colour (#$hex_colour). Must be 3 or 6 hex characters (eg. 123, a12, a12345).";
				throw new Exception();

			}

			// Convert the hex to 6 chars.
			if(strlen($hex_colour) === 3){
				$hex_colour = $this->explodeHex($hex_colour);
				$hex_colour = $this->implodeHex($hex_colour);
			}

			return $hex_colour;

		}

		/*
			Adjust the lightness of $this->colour
			Requires a 'percentage' int.
			Negative numbers reduce brightness, positive increases brightness.
		*/
		public function brightness( $step )
		{
			if( ! is_numeric($step) ){
				$this->errors[] = 'Step must be a number';
				return FALSE;
			}

			$rgb = $this->exploded_colour; //ff,00,00
			$rgb = $this->hexdecArr($rgb); //255,0,0

			$hsl = $this->rgbhsl($rgb);

			$hsl['l'] = $hsl['l'] * ($step / 100);

			$rgb = $this->hslrgb($hsl);

			$rgb = $this->dechexArr($rgb);

			$rgb = $this->implodeHex($rgb);

			return $rgb;
		}

		/*
			Adjust the lightness of $this->colour
			Requires a 'percentage' int.
			Negative numbers reduce brightness, positive increases brightness.
		*/
		public function saturation( $step )
		{
			if( ! is_numeric($step) ){
				$this->errors[] = 'Step must be a number';
				return FALSE;
			}

			$rgb = $this->exploded_colour; //ff,00,00
			$rgb = $this->hexdecArr($rgb); //255,0,0

			$hsl = $this->rgbhsl($rgb);

			$hsl['s'] = $hsl['s'] * ($step / 100);

			$rgb = $this->hslrgb($hsl);

			$rgb = $this->dechexArr($rgb);

			$rgb = $this->implodeHex($rgb);

			return $rgb;
		}

		/*
			Convert an rgb array (r,g,b) to an hsl array (h,s,l).
			rgb should be set[0,255]
		*/
		private function rgbhsl(array $rgb)
		{

			// make rgb percetages
			foreach($rgb as &$v){
				$v /= 255;
			}

    		// Arrange the rgb values numerically
			asort($rgb,SORT_NUMERIC);

			// To access the values numerically yet maintain an associative array, we need to create another array that maps numeric indexes to the associative keys
			$keys = array_keys($rgb);


    		$hsl = array(
    			'h' => ($rgb[$keys[2]] + $rgb[$keys[0]]) / 2,
    			's' => ($rgb[$keys[2]] + $rgb[$keys[0]]) / 2,
    			'l' => ($rgb[$keys[2]] + $rgb[$keys[0]]) / 2
    		);

    		//
		    if($rgb[$keys[2]] == $rgb[$keys[0]]){

		        $hsl['h'] = 0;
		        $hsl['s'] = 0; // achromatic

		    }else{

		    	// calculate chroma as $d (chroma = max(rgb) - min(rgb))
		        $d = $rgb[$keys[2]] - $rgb[$keys[0]];

		        if( $hsl['l'] > 0.5 )
		        {
	        		$hsl['s'] = $d / (2 - $rgb[$keys[2]] - $rgb[$keys[0]]);
	        	}else{
	        		$hsl['s'] = $d / ($rgb[$keys[2]] + $rgb[$keys[0]]);
	        	}

	        	// calculate hue using some mathey stuff (http://en.wikipedia.org/wiki/HSL_color_space)
		        switch($rgb[$keys[2]]){
		            case $rgb['r']: $hsl['h'] = ($rgb['g'] - $rgb['b']) / $d + ($rgb['g'] < $rgb['b'] ? 6 : 0); break;
		            case $rgb['g']: $hsl['h'] = ($rgb['b'] - $rgb['r']) / $d + 2; break;
		            case $rgb['b']: $hsl['h'] = ($rgb['r'] - $rgb['g']) / $d + 4; break;
		        }
		        $hsl['h'] /= 6;
		    }

		    $hsl['h'] *= 360; // express hue as degrees
		    $hsl['h'] = $hsl['h'] > 360 ? 360 : $hsl['h'];
		    $hsl['s'] *= 100; // express saturation as percentage
		    $hsl['s'] = $hsl['s'] > 100 ? 100 : $hsl['s'];
		    $hsl['l'] *= 100; // express lightness as percentage
		    $hsl['l'] = $hsl['l'] > 100 ? 100 : $hsl['l'];

		    return $hsl;
		}

		/*
			Convert an hsl array (h,s,l) to an rgb array (r,g,b).
			hsl should be h:degrees, s:percentage, l:percentage (css hsl)
		*/
		private function hslrgb($hsl){

			$hsl['h'] /= 360; // convert hue from degrees
			$hsl['s'] /= 100;
			$hsl['l'] /= 100;

		    $rgb = array('r'=>0,'g'=>0,'b'=>0);

		    if($hsl['s'] == 0){
		        $rgb['r'] = $rgb['g'] = $rgb['b'] = $hsl['l']; // achromatic
		    }else{


		        $q = $hsl['l'] < 0.5 ? $hsl['l'] * (1 + $hsl['s']) : $hsl['l'] + $hsl['s'] - $hsl['l'] * $hsl['s'];
		        $p = 2 * $hsl['l'] - $q;
		        $rgb['r'] = $this->hue2rgb($p, $q, $hsl['h'] + 1/3);
		        $rgb['g'] = $this->hue2rgb($p, $q, $hsl['h']);
		        $rgb['b'] = $this->hue2rgb($p, $q, $hsl['h'] - 1/3);
		    }

		    return array( 'r'=>$rgb['r'] * 255, 'g'=>$rgb['g'] * 255, 'b'=>$rgb['b'] * 255 );
		}

		/*
			Convert hue to rgb
		*/
		private function hue2rgb($p, $q, $t){
            if($t < 0) $t += 1;
            if($t > 1) $t -= 1;
            if($t < 1/6) return $p + ($q - $p) * 6 * $t;
            if($t < 1/2) return $q;
            if($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;
            return $p;
        }


		/*
			Convert a hex colour value to array(rr, gg, bb)
			Requires either a 3-char or 6-char hex value
			Returns a 6-char hex value
		*/
		private function explodeHex($colour){

			if(strlen($colour) === 3){
				$return = array(
					'r'=>$colour[0].$colour[0],
					'g'=>$colour[1].$colour[1],
					'b'=>$colour[2].$colour[2]
				);
			}elseif(strlen($colour) === 6){
				$return = array(
					'r'=>$colour[0].$colour[1],
					'g'=>$colour[2].$colour[3],
					'b'=>$colour[4].$colour[5]
				);
			}else{
				$this->error = "Incorrect string length ".strlen($colour);
				return FALSE;
			}

			return $return;

		}

		/*
			Convert array(rr,gg,bb) to a 6-char hex value
		*/
		private function implodeHex(array $colour){

			return $colour['r'].$colour['g'].$colour['b'];

		}

		/*
			Convert a hex array to decimal array
		*/
		private function hexdecArr(array $hex)
		{
			foreach($hex as &$v){
				$v = hexdec($v);
			}

			return $hex;
		}

		/*
			Convert decimal array to double value hex array (eg 1 becomes 01, 255 becomes ff)
		*/
		private function dechexArr(array $dec)
		{

			// convert each value to hex, being careful of a few pitfalls.
			foreach($dec as &$v){

				$v = round($v);

				if($v < 1){
					$v = '00';
				}elseif($v < 10){
					$v = str_pad($v, 2, 0, STR_PAD_LEFT);
				}elseif($v < 16){
					$v = $v;
				}elseif($v > 255){
					$v = 'ff';
				}else{
					$v = dechex($v);
				}

				if(strlen($v) === 1){

					$v .= $v;
				}

			}

			return $dec;
		}

	}



?>