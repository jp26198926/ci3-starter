<?php
	class Custom_function
	{
		/*
		private $CI = null; 
		
		function __construct()
		{
			$this->CI =& get_instance();
		}
		*/
		
		public function is_allowed_module($module_name, $prefix="")
		{
			$result = false;
			
			if (isset($_SESSION[$prefix . '_logged_in'][$prefix . '_modules'])){
				
				$allowed_module = $_SESSION[$prefix . '_logged_in'][$prefix . '_modules'];
				
				foreach($allowed_module as $key => $value){
					$my_module = strtolower($value->module_name);
					
					if (trim($my_module) === trim(strtolower($module_name))){
						$result = true;
					}
				}
			}			
			return $result;
		}
		
		public function module_permission($permission, $data)
		{			
			$result = false;
			
			$check = array_search($permission, array_column($data, "permission"));
			
			if ($check > -1){
				$result = true;
			}			
			return $result;
		}
		
		public function convert_number_to_words($number,$curr_Description)
		{
			$hyphen      = '-';
			$conjunction = ' and ';
			$separator   = ', ';
			$negative    = 'negative ';
			//$decimal     = ' point ';
			$decimal     = ' and ';
			$dictionary  = array(
				0                   => 'zero',
				1                   => 'one',
				2                   => 'two',
				3                   => 'three',
				4                   => 'four',
				5                   => 'five',
				6                   => 'six',
				7                   => 'seven',
				8                   => 'eight',
				9                   => 'nine',
				10                  => 'ten',
				11                  => 'eleven',
				12                  => 'twelve',
				13                  => 'thirteen',
				14                  => 'fourteen',
				15                  => 'fifteen',
				16                  => 'sixteen',
				17                  => 'seventeen',
				18                  => 'eighteen',
				19                  => 'nineteen',
				20                  => 'twenty',
				30                  => 'thirty',
				40                  => 'forty',
				50                  => 'fifty',
				60                  => 'sixty',
				70                  => 'seventy',
				80                  => 'eighty',
				90                  => 'ninety',
				100                 => 'hundred',
				1000                => 'thousand',
				1000000             => 'million',
				1000000000          => 'billion',
				1000000000000       => 'trillion',
				1000000000000000    => 'quadrillion',
				1000000000000000000 => 'quintillion'
			);
		
			if (!is_numeric($number)) {
				return false;
			}
		
			if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
				// overflow
				trigger_error(
					'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
					E_USER_WARNING
				);
				return false;
			}
		
			if ($number < 0) {
				return $negative . $this->convert_number_to_words(abs($number));
			}
		
			$string = $fraction = null;
		
			if (strpos($number, '.') !== false) {
				list($number, $fraction) = explode('.', $number);        
			}
		
			switch (true) {
				case $number < 21:
					$string = $dictionary[$number];
					break;
				case $number < 100:
					$tens   = ((int) ($number / 10)) * 10;
					$units  = $number % 10;
					$string = $dictionary[$tens];
					if ($units) {
						//$string .= $hyphen . $dictionary[$units];
						$string .= ' ' . $dictionary[$units];
					}
					break;
				case $number < 1000:
					$hundreds  = $number / 100;
					$remainder = $number % 100;
					$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
					if ($remainder) {
						//$string .= $conjunction . convert_number_to_words($remainder);
						$string .= ' ' . $this->convert_number_to_words($remainder,$curr_Description);
					}
					break;
				default:
					$baseUnit = pow(1000, floor(log($number, 1000)));
					$numBaseUnits = (int) ($number / $baseUnit);
					$remainder = $number % $baseUnit;
					$string = $this->convert_number_to_words($numBaseUnits,$curr_Description) . ' ' . $dictionary[$baseUnit];
					if ($remainder) {
						//$string .= $remainder < 100 ? $conjunction : $separator;
						$string .= ' ';
						$string .= $this->convert_number_to_words($remainder,$curr_Description);
					}
					
					break;
			}
			
			if (null !== $fraction && is_numeric($fraction)) {
				$string .= " " . $curr_Description . $decimal;
				/*$words = array();
				foreach (str_split((string) $fraction) as $number) {
					$words[] = $dictionary[$number];
				}*/
				//$words = convert_number_to_words((int)($fraction));
				//$string .= implode(' ', $words);
				$string .= "{$fraction}/100";
				//$string .= ' Cents';
			}
		
			return $string;
		}
		public function get_tax_2012($type, $dependant=-1, $period, $gross_amount){
			//computation below was for 2012 and was supersede with the latest 2019
			//type = 1 - Resident(national)  ; 2 - Non Resident(expat)
			/*dependant:
				-1 - Not lodge dependants declaration
				0 - Declared none dependant
				1 - Declared 1 dependant
				2 - Declared 2 dependant
				3 - Declared 3 or more dependant
			*/
			//1 - fortnightly; 2 - monthly; 3 - weekly
				
			$factor = 0;
			$annual = 0;
			$gross_tax = 0;
			$rebate_tax = 0;
			$net_tax = 0;
			$tax = 0;
				
			switch($period){
				case 1: //fortnightly
					$factor = 26;
					break;
				case 2: //monthly
					$factor = 13; //i set as 13 instead of 12 because the based of taxation is originally fornightly so i just devide 26/2  
					break;
				case 3: //weekly
					$factor = 52;
					break;
				
			}			
				
			if ($type == 2){ //NON RESIDENT (EXPAT)
				$annual = $gross_amount * $factor;
						
				switch(true){
					case ($annual >=0 && $annual <= 18000):
						$gross_tax = $annual * 0.22;						
						break;
					
					case ($annual >=18001 && $annual <= 33000):
						$gross_tax = ($annual * 0.30) - 1440;						
						break;
							
					case ($annual >=33001 && $annual <= 70000):
						$gross_tax = ($annual * 0.35) - 3090;						
						break;
							
					case ($annual >=70001 && $annual <= 250000):
						$gross_tax = ($annual * 0.40) - 6590;						
						break;
							
					case ($annual >=250001):
						$gross_tax = ($annual * 0.42) - 11590;						
						break;					
				}				
					
				$net_tax = $gross_tax;
				$tax = $net_tax / $factor;
					
			}else{ //RESIDENT (NATIONAL)
					
				if ($dependant < 0){ //did not lodge a declaration
					$tax = $gross_amount * 0.42;
				}else{
						
					$dependant = $dependant > 3 ? 3 : $dependant;
						
					$annual = ($gross_amount * $factor) - 200;
					
					switch(true){
						case ($annual >=0 && $annual <= 10000):
							$gross_tax = 0;						
							break;
							
						case ($annual >=10001 && $annual <= 18000):
							$gross_tax = ($annual * 0.22) - 2200;						
							break;
							
						case ($annual >=18001 && $annual <= 33000):
							$gross_tax = ($annual * 0.30) - 3640;						
							break;
							
						case ($annual >=33001 && $annual <= 70000):
							$gross_tax = ($annual * 0.35) - 5290;						
							break;
							
						case ($annual >=70001 && $annual <= 250000):
							$gross_tax = ($annual * 0.40) - 8790;						
							break;
							
						case ($annual >=250001):
							$gross_tax = ($annual * 0.42) - 13790;						
							break;					
					}
						
					//rebate
					if ($dependant == 0){ //no dependants
						$net_tax = $gross_tax;						
					}elseif ($dependant > 0){
						switch (true){
							case ($gross_tax <= 300):
								$rebate_tax = 45 + (30 * ($dependant - 1));
								break;
								
							case ($gross_tax > 300 && $gross_tax <= 3000):
								$rebate_tax = $gross_tax * (0.15 + (0.10 * ($dependant - 1)));
								break;
								
							case ($gross_tax > 3000):
								$rebate_tax = 450 + (300 * ($dependant - 1));
								break;
						}						
						$net_tax = $gross_tax - $rebate_tax;
					}
						
					$tax = $net_tax / $factor;				
				}			
			}			
			return ($tax > 0 ? $tax : 0);		
		}
		
		public function get_tax($type, $dependant=-1, $period, $gross_amount){
			//computation below based on 2019 tax scheme from IRC
			//type = 1 - Resident(national)  ; 2 - Non Resident(expat)
			/*dependant:
				-1 - Not lodge dependants declaration
				0 - Declared none dependant
				1 - Declared 1 dependant
				2 - Declared 2 dependant
				3 - Declared 3 or more dependant
			*/
			//1 - fortnightly; 2 - monthly; 3 - weekly
				
			$factor = 0;
			$annual = 0;
			$gross_tax = 0;
			$rebate_tax = 0;
			$net_tax = 0;
			$tax = 0;
				
			switch($period){
				case 1: //fortnightly
					$factor = 26;
					break;
				case 2: //monthly
					$factor = 13; //i set as 13 instead of 12 because the basis of taxation is originally fornightly so i just devide 26/2 
					break;
				case 3: //weekly
					$factor = 52;
					break;
				
			}			
				
			if ($type == 2){ //NON RESIDENT (EXPAT)
				$annual = $gross_amount * $factor;
						
				switch(true){
					case ($annual >=0 && $annual <= 20000):
						$gross_tax = $annual * 0.22;						
						break;
					
					case ($annual >=20001 && $annual <= 33000):
						$gross_tax = ($annual * 0.30) - 1600;						
						break;
							
					case ($annual >=33001 && $annual <= 70000):
						$gross_tax = ($annual * 0.35) - 3250;						
						break;
							
					case ($annual >=70001 && $annual <= 250000):
						$gross_tax = ($annual * 0.40) - 6750;						
						break;
							
					case ($annual >=250001):
						$gross_tax = ($annual * 0.42) - 11750;						
						break;					
				}				
					
				$net_tax = $gross_tax;
				$tax = $net_tax / $factor;
					
			}else{ //RESIDENT (NATIONAL)
					
				if ($dependant < 0){ //did not lodge a declaration
					$tax = $gross_amount * 0.42;
				}else{
						
					$dependant = $dependant > 3 ? 3 : $dependant;					
					$annual = ($gross_amount * $factor) - 200;
					
					switch(true){
						case ($annual >=0 && $annual <= 12500):
							$gross_tax = 0;						
							break;
							
						case ($annual >=12501 && $annual <= 20000):
							$gross_tax = ($annual * 0.22) - 2750;						
							break;
							
						case ($annual >=20001 && $annual <= 33000):
							$gross_tax = ($annual * 0.30) - 4350;						
							break;
							
						case ($annual >=33001 && $annual <= 70000):
							$gross_tax = ($annual * 0.35) - 6000;						
							break;
							
						case ($annual >=70001 && $annual <= 250000):
							$gross_tax = ($annual * 0.40) - 9500;						
							break;
							
						case ($annual >=250001):
							$gross_tax = ($annual * 0.42) - 14500;						
							break;					
					}
						
					//rebate
					switch ($dependant){
						case 0: //no dependant
							$rebate_tax = 0;
							break;
						case 1: // 1 dependant
							//Max of (K45 or Min of (15%*Gross Tax or 450)
							$rebate_tax = max(45, min($gross_tax * 0.15, 450));
							break;
						case 2: // 2 dependants
							//Max of (K75 or Min of (25%*Gross Tax or 750)
							$rebate_tax = max(75, min($gross_tax * 0.25, 750));
							break;
						case 3: // 3 or more dependants
							//Max of (K105 or Min of (35%*Gross Tax or 1050)
							$rebate_tax = max(105, min($gross_tax * 0.35, 1050));
							break;
					}
					
					$net_tax = $gross_tax - $rebate_tax;
					$tax = $net_tax / $factor;				
				}			
			}			
			return ($tax > 0 ? $tax : 0);		
		}
		//end of tax commpute
		
		//coinage analysis
		function coinage($amount, $denomination_list){
			$amount = floatval($amount);
			$arr_counter = array();
			
			//$this->CI->load->model("pay_parameter_model", "ppm");
			//$denomination = $this->CI->ppm->get_denomination();
			
			if ($denomination_list){
				foreach($denomination_list as $key => $val){
					$id = $val->id;					
					$d_amount = floatval($val->amount);					
					$arr_counter[$id] = 0;
					
					while(round($amount,2) >= round($d_amount,2)){						
						$arr_counter[$id]++;						
						$amount = round($amount,2) - round($d_amount,2);						
					}
					
					
					/*					
					$d_count = intval($amount / $d_amount);
					$arr_counter[$id] = $d_count; //intval($amount / floatval($val->amount));
					
					//$amount -= (floatval($val->amount) * floatval($arr_counter[$id]));
					
					$amount_deduct = $d_amount * $d_count;
					$amount -= $amount_deduct;
					*/
					
				}
			}
		
			return $arr_counter;
		} 
		
	}
?>