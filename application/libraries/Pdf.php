<?php
	
	defined('BASEPATH') or die('No direct script access allowed!');

	require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

	class Pdf extends TCPDF{
	
		var $company_name;
		var $company_address;
		var $company_contact;
		var $file_description;
		var $details;
		var $top_margin;
		
		var $footer_msg;
		var $footer_page_text;
		var $footer_margin;
		var $signatory;
		
		function __contruct(){
			parent::__contruct();
		}
		
		public function myHeader($company, $address="", $contact="", $description="", $details="", $top_margin=25){
			$this->company_name = $company;
			$this->company_address = $address;
			$this->company_contact = $contact;
			$this->file_description = $description;
			$this->details = $details;
			$this->top_margin = $top_margin;
		}
		
		public function myFooter($footer_msg="", $footer_page_text="Page", $footer_margin=-35, $signatory=""){
			$this->footer_msg = $footer_msg;
			$this->footer_page_text = $footer_page_text;
			$this->footer_margin = $footer_margin;
			$this->signatory = $signatory;
		}
		
		//Page header
	    public function Header(){			
			
	       	$this->SetTopMargin($this->top_margin);
	        
			$image_file = base_url() . "assets/images/logo.jpg";	        	
	        $this->Image($image_file, 10,6, 14,'', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	       
	        // Set font        
	        $this->SetFont('helvetica', 'B', 12);       
	        //$this->MultiCell(50,10, $company, 0,'L',false,0,30,6,false,0,false,true,0,'T',false);
	        $this->MultiCell(120,10, $this->company_name, 0,'L',false,0,27,6,false,0,false,true,0,'T',false);
	        
			
	        $this->SetFont('helvetica', 'R', 8);       
	        $this->MultiCell(170,10, $this->company_address,0,'L',false,0,27,8,false,0,false,true,0,'T',false);
			$this->MultiCell(80,10, $this->company_contact,0,'L',false,0,27,12,false,0,false,true,0,'T',false);
				        
	        $this->SetFont('helvetica', 'B', 15);
			$this->Cell(0, 26, ucwords($this->file_description),0,1,'R', 0, '', 0, false, 'M', 'B');
			//$this->MultiCell(173,10, ucwords($this->file_description),0,'R',false,0,27,15,false,0,false,true,0,'T',false);
	        //$this->ln(9);
			$this->writeHTML("<hr />",true,false,true,false,'');
			
			//details
			$this->SetFont('helvetica', 'R', 11);  
			$this->writeHTML($this->details,true,true);
	    }

	    // Page footer
	    public function Footer() {
			
			// Position at 15 mm from bottom
			$this->SetY($this->footer_margin);
			// Set font
			$this->SetFont('helvetica', 'I', 8);
			// Page number
			$this->writeHTML($this->signatory,true,true);
			$msg = $this->footer_page_text . $this->getAliasNumPage().'/'.$this->getAliasNbPages() . ' | ' . $this->footer_msg;
			$this->Cell(0, 10, $msg , 0, false, 'C', 0, '', 0, false, 'T', 'M');
			
			//$this->MultiCell(0,10, $msg ,0,'C',false,0,0,0,false,0,false,true,0,'T',false);
			//write1DBarcode( string $code, string $type, [int $x = ''], [int $y = ''], [int $w = ''], [int $h = ''], [float $xres = 0.4], [array $style = ''], [string $align = ''])
			//Cell( float $w, [float $h = 0], [string $txt = ''], [mixed $border = 0], [int $ln = 0], [string $align = ''], [int $fill = 0], [mixed $link = ''], [int $stretch = 0])
			//MultiCell( float $w, float $h, string $txt, [mixed $border = 0], [string $align = 'J'], [int $fill = 0], [int $ln = 1], [int $x = ''], [int $y = ''], [boolean $reseth = true], [int $stretch = 0], [boolean $ishtml = false])			
	    }
	}
?>