<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sales extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('sales_model');
		$this->load->model('customer_model');
		$this->load->model('purchase_model');
		$this->load->model('log_model');
	}
	public function index(){
		// get all sales to display list
		$data['data'] = $this->sales_model->getSales();
		$this->load->view('sales/list',$data);
	} 
	/* 
		call add view to add sales record 
	*/
	public function add(){
		$data['warehouse'] = $this->sales_model->getWarehouse();
		$data['warehouse_products'] = $this->sales_model->getWarehouseProducts(); 
		$data['biller'] = $this->sales_model->getBiller();
		$data['customer'] = $this->sales_model->getCustomer(); 
		$data['discount'] = $this->sales_model->getDiscount();
		$data['reference_no'] = $this->sales_model->createReferenceNo();
		$this->load->view('sales/add',$data);
	}
	/* 
		this function is used to get discount data when discount is change 
	*/
	public function getDiscountAjax($id){
		$data = $this->sales_model->getDiscountAjax($id);
		echo json_encode($data);
	}
	/* get all product warehouse wise */
	public function getProducts($warehouse_id){
		$data = $this->sales_model->getProducts($warehouse_id);
	    echo json_encode($data);
	}
	/* get single product */
	public function getProduct($product_id,$warehouse_id){
		$data = $this->sales_model->getProduct($product_id,$warehouse_id);
		$data['discount'] = $this->sales_model->getDiscount();
		$data['tax'] = $this->sales_model->getTax();
	    echo json_encode($data);
		//print_r($data);
	}
	/* 
		this function is used to search product name / code in auto complite 
	*/
	public function getAutoCodeName($code,$search_option,$warehouse){
          //$code = strtolower($code);
		  $p_code = $this->input->post('p_code');
		  $p_search_option = $this->input->post('p_search_option');
          $data = $this->sales_model->getProductCodeName($p_code,$p_search_option,$warehouse);
          if($search_option=="Code"){
          	$list = "<ul class='auto-product'>";
          	foreach ($data as $val){
          		$list .= "<li value=".$val->code.">".$val->code."</li>";
          	}
          	$list .= "</ul>";
          }
          else{
          	$list = "<ul class='auto-product'>";
          	foreach ($data as $val){
          		$list .= "<li value=".$val->product_id.">".$val->name."</li>";
          	}
          	$list .= "</ul>";
          }
          
          echo $list;
          //echo json_encode($data);
          //print_r($data);
	}
	/* 
		this fucntion is used to add sales record in database 
	*/
	public function addSales(){
		
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		//$this->form_validation->set_rules('supplier_id','Supplier ID','trim|required');
		//$this->form_validation->set_rules('warehouse_id','Warehouse ID','trim|required');
		//$this->form_validation->set_rules('discount_id','Discount ID','trim|required');
		//$this->form_validation->set_rules('biller_id','Biller ID','trim|required');
		if($this->form_validation->run()==false){

			$this->add();
		}
		else
		{
			$warehouse_id = $this->input->post('warehouse');
			$data = array(
						"date" 				  =>  $this->input->post('date'),
						"reference_no" 		  =>  $this->input->post('reference_no'),
						"warehouse_id" 		  =>  $this->input->post('warehouse'),
						"customer_id" 		  =>  $this->input->post('customer'),
						"biller_id" 		  =>  $this->input->post('biller'),
						"total" 			  =>  $this->input->post('grand_total'),
						"discount_value"	  =>  $this->input->post('total_discount'),
						"tax_value" 		  =>  $this->input->post('total_tax'),
						"note" 				  =>  $this->input->post('note'),
						"shipping_city_id"    =>  $this->input->post('city'),
						"shipping_state_id"   =>  $this->input->post('state'),
						"shipping_country_id" =>  $this->input->post('country'),
						"shipping_address"    =>  $this->input->post('address'),
						"shipping_charge"     =>  $this->input->post('shipping_charge'),
						"internal_note"       =>  $this->input->post('internal_note'),
						"mode_of_transport"   =>  $this->input->post('mode_of_transport'),
						"transporter_name"    =>  $this->input->post('transporter_name'),
						"transporter_code"    =>  $this->input->post('transporter_code'),
						"vehicle_regn_no"     =>  $this->input->post('vehicle_regn_no'),
						"l_r_no"     		  =>  $this->input->post('l_r_no'),
						"chalan_no"           =>  $this->input->post('chalan_no'),
						"indent_no"           =>  $this->input->post('indent_no'),
						"credit_days"         =>  $this->input->post('credit_days'),
						"date_of_supply"      =>  $this->input->post('date_of_supply'),
						"electronic_ref_no"   =>  $this->input->post('electronic_ref_no'),
						"gst_payable"         =>  $this->input->post('gst_payable'),
						"broker"              =>  $this->input->post('broker'),
						"user"			      =>  $this->session->userdata('user_id')
					);

			$invoice = array(
				"invoice_no" => $this->sales_model->generateInvoiceNo(),
				"sales_amount" => $this->input->post('grand_total'),
				"invoice_date" => date('Y-m-d')
			);
			if($sales_id = $this->sales_model->addModel($data,$invoice)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $sales_id,
						'message'  => 'Sales Inserted'
					);
				$this->log_model->insert_log($log_data);
				$sales_item_data = $this->input->post('table_data');
				$js_data = json_decode($sales_item_data);
				foreach ($js_data as $key => $value) {
					if($value==null){
					}
					else{
						$product_id = $value->product_id;
						$quantity = $value->quantity;	
						$data = array(
							"product_id" => $value->product_id,
							"quantity" => $value->quantity,
							"price" => $value->price,
							"gross_total" => $value->total,
							"discount_id" => $value->discount_id,
							"discount_value" => $value->discount_value,
							"discount" => $value->discount,
							"tax_id" => $value->tax_id,
							"tax_value" => $value->tax_value,
							"tax" => $value->tax,
							"sales_id" => $sales_id
							);
						//$this->sales_model->checkProductInWarehouse($product_id,$quantity,$warehouse_id);
						if($this->sales_model->addSalesItem($data,$product_id,$warehouse_id,$quantity)){
							
						}
						else{

						}
					}
				}
				redirect('sales/view/'.$sales_id);
			}
			else{
				redirect('sales','refresh');
			}
		}
	}
	/* 
		call edit view to edit sales record 
	*/
	public function edit($id){
		$data['warehouse'] = $this->sales_model->getWarehouse(); 
		$data['biller'] = $this->sales_model->getBiller();
		$data['customer'] = $this->sales_model->getCustomer(); 
		$data['discount'] = $this->sales_model->getDiscount();
		$data['tax'] = $this->sales_model->getTax();
		$data['data'] = $this->sales_model->getRecord($id);
		$data['country']  = $this->customer_model->getCountry();
		$data['state'] = $this->customer_model->getState($data['data'][0]->shipping_country_id);
		$data['city'] = $this->customer_model->getCity($data['data'][0]->shipping_state_id);
		$data['product'] = $this->sales_model->getProducts($data['data'][0]->warehouse_id);
		$data['items'] = $this->sales_model->getSalesItems($data['data'][0]->sales_id,$data['data'][0]->warehouse_id);
		$this->load->view('sales/edit',$data);
	}
	/*  
		this fucntion is to edit sales record and save in database 
	*/
	public function editSales(){
		$id = $this->input->post('sales_id');
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		//$this->form_validation->set_rules('supplier_id','Supplier ID','trim|required');
		//$this->form_validation->set_rules('warehouse_id','Warehouse ID','trim|required');
		//$this->form_validation->set_rules('discount_id','Discount ID','trim|required');
		//$this->form_validation->set_rules('biller_id','Biller ID','trim|required');
		if($this->form_validation->run()==false){

			$this->edit($id);
		}
		else
		{
			$warehouse_id = $this->input->post('warehouse');
			$old_warehouse_id = $this->input->post('old_warehouse_id');
			$warehouse_change = $this->input->post('warehouse_change');
			$data = array(
						"date" 			      =>  $this->input->post('date'),
						"reference_no" 	      =>  $this->input->post('reference_no'),
						"warehouse_id"	      =>  $this->input->post('warehouse'),
						"customer_id" 	      =>  $this->input->post('customer'),
						"biller_id" 	      =>  $this->input->post('biller'),
						"total" 		      =>  $this->input->post('grand_total'),
						"discount_value"      =>  $this->input->post('total_discount'),
						"tax_value" 	      =>  $this->input->post('total_tax'),
						"note" 			      =>  $this->input->post('note'),
						"shipping_city_id"    =>  $this->input->post('city'),
						"shipping_state_id"   =>  $this->input->post('state'),
						"shipping_country_id" =>  $this->input->post('country'),
						"shipping_address"    =>  $this->input->post('address'),
						"shipping_charge"     =>  $this->input->post('shipping_charge'),
						"internal_note"       =>  $this->input->post('internal_note'),
						"mode_of_transport"   =>  $this->input->post('mode_of_transport'),
						"transporter_name"    =>  $this->input->post('transporter_name'),
						"transporter_code"    =>  $this->input->post('transporter_code'),
						"vehicle_regn_no"     =>  $this->input->post('vehicle_regn_no'),
						"l_r_no"     		  =>  $this->input->post('l_r_no'),
						"chalan_no"           =>  $this->input->post('chalan_no'),
						"indent_no"           =>  $this->input->post('indent_no'),
						"credit_days"         =>  $this->input->post('credit_days'),
						"date_of_supply"      =>  $this->input->post('date_of_supply'),
						"electronic_ref_no"   =>  $this->input->post('electronic_ref_no'),
						"gst_payable"         =>  $this->input->post('gst_payable'),
						"broker"              =>  $this->input->post('broker'),
						"user"			      =>  $this->session->userdata('user_id'),
						"sales_id"		      =>  $this->input->post('sales_id')
					);
			
			$js_data = json_decode($this->input->post('table_data1'));
			$php_data = json_decode($this->input->post('table_data'));
			if($this->sales_model->editModel($id,$data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Sales Updated'
					);
				$this->log_model->insert_log($log_data);	
				foreach ($js_data as $key => $value) {
					if($value=='delete'){
						//echo " delete".$key;
						$product_id =  $php_data[$key];
						if($this->sales_model->deleteSalesItems($id,$product_id,$warehouse_id,$old_warehouse_id)){
							//echo " 1.Dsuccess";
						}
					}
					else if($value==null){
						if($warehouse_id != $old_warehouse_id AND $php_data[$key] !=null){
							$product_id =  $php_data[$key];
							if($this->sales_model->changeWarehouseDeleteSalesItems($id,$product_id,$warehouse_id,$old_warehouse_id)){
								//echo " 1.Dsuccess";
							}
						}
						else if($warehouse_change == "yes"){
							$product_id =  $php_data[$key];
							if($this->sales_model->changeWarehouseDeleteSalesItems($id,$product_id,$warehouse_id,$old_warehouse_id)){
								//echo " 1.Dsuccess";
							}
						}
					}
					else{
						$product_id = $value->product_id;
						$quantity = $value->quantity;
						$data = array(
								"product_id" => $value->product_id,
								"quantity" => $value->quantity,
								"price" => $value->price,
								"gross_total" => $value->total,
								"discount_id" => $value->discount_id,
								"discount_value" => $value->discount_value,
								"discount" => $value->discount,
								"tax_id" => $value->tax_id,
								"tax_value" => $value->tax_value,
								"tax" => $value->tax,
								"sales_id" => $id
							);
						if($old_quantity = $this->sales_model->checkProductInSales($id,$product_id)){
							$this->sales_model->updateQuantity($id,$product_id,$warehouse_id,$quantity,$old_quantity,$data);
						}
						else{
							if($this->sales_model->addSalesItem($data,$product_id,$warehouse_id,$quantity)){
								//echo " 1 Asuccess add";
							}
							else{

							}
						}
					}
				}
				redirect('sales');
			}
		}
	}
	/* 
		this function is used to delete sales record from database 
	*/
	public function delete($id){
		if($this->sales_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Sales Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('sales','refresh');
		}
		else{
			redirect('sales','refresh');
		}
	}
	/*
		display data in dashboard calendar
	*/
	public function calendar(){
		log_message('debug', print_r($this->db->get('category')->result(), true));
		$data = $this->sales_model->getCalendarData();
		$total = 0;
		foreach ($data as $value) {
			$date = Date('Y-m-d');
			if($date == $value->date){
				$total += $value->total;
			}
			$temp = array(
					"title" => $total,
					"start" => "2017-04-05T00:01:00+05:30"
				);
		}
		 echo json_encode($temp);
	}
	/*
		view Sales details
	*/
	public function view($id){
		$data['data'] = $this->sales_model->getDetails($id);
		$data['items'] = $this->sales_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('sales/view',$data);
	}
	/*
		generate pdf
	*/
	public function pdf($id){
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Invoice Generated'
			);
		$this->log_model->insert_log($log_data);
		ob_start();
		$html = ob_get_clean();
		$html = utf8_encode($html);

		$data['data'] = $this->sales_model->getDetails($id);
		$data['items'] = $this->sales_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$html = $this->load->view('sales/pdf',$data,true);

		include(APPPATH.'third_party/mpdf/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'UTF-8';
        $mpdf->WriteHTML($html);
        $mpdf->Output($data['data'][0]->reference_no.'pdf','I');
	}
	public function print1($id){
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Invoice Printed'
			);
		$this->log_model->insert_log($log_data);
		$data['data'] = $this->sales_model->getDetails($id);
		$data['items'] = $this->sales_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('sales/pdf',$data);
	}
	/*
		send email
	*/
	public function email($id){
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => 0,
				'message'  => 'Invoice Email Send'
			);
		$this->log_model->insert_log($log_data);
		$email = $this->sales_model->getSmtpSetup();

		$data = $this->sales_model->getCustomerEmail($id);
		$company = $this->purchase_model->getCompany();
		$this->load->view('class.phpmailer.php');

		$mail = new PHPMailer();

		$mail->IsSMTP();
		$mail->Host = $email->smtp_host;

		$mail->SMTPAuth = true;
		//$mail->SMTPSecure = "ssl";
		$mail->Port = $email->smtp_port;
		$mail->Username = $email->smtp_username;
		$mail->Password = $email->smtp_password;

		$mail->From = $email->from_address;
		$mail->FromName = $email->from_name;
		$mail->AddAddress($data[0]->email);
		//$mail->AddReplyTo("mail@mail.com");

		/*$mail->IsHTML(true);

		$mail->Subject = "Purchase order No : ".$data[0]->reference_no." From ".$company[0]->name;
		$mail->Body = "Date : ".$data[0]->date."<br>Total : ".$data[0]->total;
		//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

		if(!$mail->Send())
		{
			$message =  "Email could not be sent";
		}
		else{
			$message =  "Email has been sent";
		}*/
		$total = $data[0]->total+$data[0]->shipping_charge;
         $this->load->library('email'); 
   
         $this->email->from($email->from_address ,$email->from_name); 
         $this->email->to($data[0]->email);
         $this->email->subject("Sales order No : ".$data[0]->reference_no." From ".$company[0]->name); 
         $this->email->message("Date : ".$data[0]->date."   \nTotal : ".$total." \n\n\nComapany Name : ".$company[0]->name."\nAddress : ".$company[0]->street." ".$company[0]->country_name."\nMobile No :".$company[0]->phone); 
         //Send mail 
         if($this->email->send()) 
         $message = "Email sent successfully.";
         else 
         $message = "Error in sending Email."; 

		$this->session->set_flashdata('message', $message);
		redirect('sales','refresh');
	}
	/*
		payment	 view
	*/
	public function payment($id){
		$data['data'] = $this->sales_model->getDetailsPayment($id);
		$data['company'] = $this->purchase_model->getCompany();
		$data['p_reference_no'] = $this->sales_model->generateReferenceNo();

		$this->load->view('sales/payment',$data);
	}
	/*
		get payment details to view and send to model
	*/
	public function addPayment(){
		$id = $this->input->post('id');
		$paying_by = $this->input->post('paying_by');
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('paying_by','Paying By','trim|required');
		if($paying_by == "Cheque"){
			$this->form_validation->set_rules('bank_name','Bank Name','trim|required|callback_alpha_dash_space');
			$this->form_validation->set_rules('cheque_no','Cheque No','trim|required|numeric');
		}
		if($this->form_validation->run()==false){
			$this->payment($id);
		}
		else
		{
			if($paying_by == "Cheque"){
				$bank_name = $this->input->post('bank_name');
				$cheque_no = $this->input->post('cheque_no');
			}
			else{
				$bank_name = "";
				$cheque_no = "";
			}
			$data = array(
					"sales_id"     => $id,
					"date"         => $this->input->post('date'),
					"reference_no" => $this->input->post('reference_no'),
					"amount"       => $this->input->post('amount'),
					"paying_by"    => $this->input->post('paying_by'),
					"bank_name"    => $bank_name,
					"cheque_no"    => $cheque_no,
					"description"  => $this->input->post('note')
				);

			if($this->sales_model->addPayment($data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Sales Payable'
					);
				$this->log_model->insert_log($log_data);
				redirect('sales','refresh');
			}
			else{
				redirect("sales",'refresh');
			}
		}
	}
	/*
		generate invoice
	*/
	public function invoice(){
		$data['data'] = $this->sales_model->invoice();
		$this->load->view('sales/invoice',$data);
	}
	/*

	*/
	public function getCustomerData($id){
		$data['data'] = $this->customer_model->getRecord($id);
		$data['country']  = $this->customer_model->getCountry();
		$data['state'] = $this->customer_model->getState($data['data'][0]->country_id);
		$data['city'] = $this->customer_model->getCity($data['data'][0]->state_id);
		echo json_encode($data);
	}
	/*
		check character and space validation 
	*/
	function alpha_dash_space($str) {
		if (! preg_match("/^([a-zA-Z ])+$/i", $str))
	    {
	        $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha and spaces');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
}
?>