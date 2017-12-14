<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('purchase_model');
		$this->load->model('log_model');
	}
		
	public function index(){
		// get all purchase record and display list
		$data['data'] = $this->purchase_model->getPurchase();
		$this->load->view('purchase/list',$data);
	} 
	/*
		call add purchase view to add purchase
	*/
	public function add(){
		$data['product'] = $this->purchase_model->getProduct();
		$data['warehouse'] = $this->purchase_model->getWarehouse(); 
		$data['supplier'] = $this->purchase_model->getSupplier();
		$data['reference_no'] = $this->purchase_model->createReferenceNo();
		$this->load->view('purchase/add',$data);

	}
	/* 
		this function is used when product add in purchase table 
	*/
	public function getProductAjax($id){
		$data = $this->purchase_model->getProductAjax($id);
		$data['discount'] = $this->purchase_model->getDiscount();
		$data['tax'] = $this->purchase_model->getTax();
	    echo json_encode($data);
		//print_r($data);
	}
	/* 
		This function is used to search product code / name in database 
	*/
	public function getAutoCodeName($code,$search_option){
          //$code = strtolower($code);
		  $p_code = $this->input->post('p_code');
		  $p_search_option = $this->input->post('p_search_option');
          $data = $this->purchase_model->getProductCodeName($p_code,$p_search_option);
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
          //print_r($list);
	}
	/* 
		This function is used to add purchase in database 
	*/
	public function addPurchase(){
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		//$this->form_validation->set_rules('supplier_id','Supplier ID','trim|required');
		//$this->form_validation->set_rules('warehouse_id','Warehouse ID','trim|required');
		if($this->form_validation->run()==false){

			$this->add();
		}
		else
		{
			$warehouse_id = $this->input->post('warehouse');
			$data = array(
						"date" 			=> 	$this->input->post('date'),
						"reference_no"	=>	$this->input->post('reference_no'),
						"supplier_id" 	=>	$this->input->post('supplier'),
						"warehouse_id"	=> 	$warehouse_id,
						"total" 		=>	$this->input->post('grand_total'),
						"discount_value"=>  $this->input->post('total_discount'),
						"tax_value" 	=>  $this->input->post('total_tax'),
						"note" 			=> 	$this->input->post('note'),
						"user"			=>	$this->session->userdata('user_id')
					);	
			$invoice = array(
				"invoice_no" => $this->purchase_model->generateInvoiceNo(),
				"receipt_amount" => $this->input->post('grand_total'),
				"receipt_voucher_date" => date('Y-m-d')
			);
			if($purchase_id = $this->purchase_model->addModel($data,$invoice)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $purchase_id,
						'message'  => 'Purchase Inserted'
					);
				$this->log_model->insert_log($log_data);
				$purchase_item_data = $this->input->post('table_data');
				$js_data = json_decode($purchase_item_data);
				
				foreach ($js_data as $key => $value) {
					if($value==null){
					}
					else{
						$product_id = $value->product_id;
						$quantity = $value->quantity;
						$data = array(
							"product_id" => $value->product_id,
							"quantity" => $value->quantity,
							"gross_total" => $value->total,
							"discount_id" => $value->discount_id,
							"discount_value" => $value->discount_value,
							"discount" => $value->discount,
							"tax_id" => $value->tax_id,
							"tax_value" => $value->tax_value,
							"tax" => $value->tax,
							"cost" => $value->cost,
							"purchase_id" => $purchase_id
							);
						$warehouse_data = array(
							"product_id" => $value->product_id,
							"warehouse_id" => $warehouse_id,
							"quantity" => $value->quantity
							);
						$this->purchase_model->addProductInWarehouse($product_id,$quantity,$warehouse_id,$warehouse_data);
						if($this->purchase_model->addPurchaseItem($data)){
						}
						else{

						}
					}
				}
				redirect('purchase','refresh');
			}
			else{
				
			}
		}
	}
	/* 
		This function is used to call view  edit purchase 
	*/
	public function edit($id){
		$data['product'] = $this->purchase_model->getProduct();
		$data['warehouse'] = $this->purchase_model->getWarehouse(); 
		$data['supplier'] = $this->purchase_model->getSupplier();
		$data['data'] = $this->purchase_model->getRecord($id);
		$data['discount'] = $this->purchase_model->getDiscount();
		$data['tax'] = $this->purchase_model->getTax();
		foreach ($data['data'] as $key) {
			$purchase_id = $key->purchase_id;
			$warehouse_id = $key->warehouse_id;
			$data['items'] = $this->purchase_model->getPurchaseItems($purchase_id,$warehouse_id);	
		}
		/*echo "<pre>";
		print_r($data);
		exit();*/
		$this->load->view('purchase/edit',$data);
	}
	/* 
		This function is used to delete discount record in databse 
	*/
	public function delete($id){
		if($this->purchase_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Purchase Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('purchase','refresh');
		}
		else{
			redirect('purchase','refresh');
		}
	}
	/* 
		This function is to edit purchase record in database 
	*/
	public function editPurchase(){
		$id = $this->input->post('purchase_id');
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		//$this->form_validation->set_rules('supplier_id','Supplier ID','trim|required');
		//$this->form_validation->set_rules('warehouse_id','Warehouse ID','trim|required');
		if($this->form_validation->run()==false){

			$this->edit($id);
		}
		else
		{
			$warehouse_id = $this->input->post('warehouse');
			$data = array(
						"date" 			=> $this->input->post('date'),
						"reference_no" 	=> $this->input->post('reference_no'),
						"supplier_id" 	=> $this->input->post('supplier'),
						"warehouse_id" 	=> $this->input->post('warehouse'),
						"total"			=> $this->input->post('grand_total'),
						"discount_value"=>  $this->input->post('total_discount'),
						"tax_value" 	=>  $this->input->post('total_tax'),
						"note" 			=> $this->input->post('note'),
						"user"			=> $this->session->userdata('user_id'),
						//"table_data"=>$this->input->post('table_data'),
						//"table_data1"=>$this->input->post('table_data1')
					);
			
			$js_data = json_decode($this->input->post('table_data1'));
			$php_data = json_decode($this->input->post('table_data'));
			if($this->purchase_model->editModel($id,$data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Purchase Updated'
					);
				$this->log_model->insert_log($log_data);	
				foreach ($js_data as $key => $value) {
					if($value=='delete'){
						//echo " delete".$key;
						$product_id =  $php_data[$key];
						if($this->purchase_model->deletePurchaseItems($id,$product_id,$warehouse_id)){
							//echo " 1.Dsuccess";
						}
					}
					else if($value==null){
						//echo " Null".$key;
					}
					else{
						//echo " array";
						$product_id = $value->product_id;
						$quantity = $value->quantity;
						$data = array(
								"product_id" => $value->product_id,
								"quantity" => $value->quantity,
								"gross_total" => $value->total,
								"discount_id" => $value->discount_id,
								"discount_value" => $value->discount_value,
								"discount" => $value->discount,
								"tax_id" => $value->tax_id,
								"tax_value" => $value->tax_value,
								"tax" => $value->tax,
								"cost" => $value->cost,
								"purchase_id" => $id
							);
						$warehouse_data = array(
							"product_id" => $value->product_id,
							"warehouse_id" => $warehouse_id,
							"quantity" => $value->quantity
							);

						if($this->purchase_model->addUpdatePurchaseItem($id,$product_id,$warehouse_id,$quantity,$data,$warehouse_data)){
							//echo " 1 Asuccess add";
						}
						else{

						}
					}
				}
				redirect('purchase');
			}
		}
	}
	/*
		view purchase details
	*/
	public function view($id){
		$data['data'] = $this->purchase_model->getDetails($id);
		$data['items'] = $this->purchase_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();

		$this->load->view('purchase/view',$data);
	}
	/*
		generate pdf 
	*/
	public function pdf($id){

		ob_start();
		$html = ob_get_clean();
		$html = utf8_encode($html);

		$data['data'] = $this->purchase_model->getDetails($id);
		$data['items'] = $this->purchase_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$html = $this->load->view('purchase/pdf',$data,true);

		include(APPPATH.'third_party/mpdf/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'UTF-8';
        $mpdf->WriteHTML($html);
        $mpdf->Output($data['data'][0]->reference_no.'pdf','I');
	}
	/*
		send email
	*/
	public function email($id){
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => 0,
				'message'  => 'Purchase Receipt Email Send'
			);
		$this->log_model->insert_log($log_data);
		$data = $this->purchase_model->getSupplierEmail($id);
		$company = $this->purchase_model->getCompany();
		$email = $this->purchase_model->getSmtpSetup();
		$this->load->view('class.phpmailer.php');

		$mail = new PHPMailer();

		$mail->IsSMTP();
		$mail->Host = $email->smtp_host;

		$mail->SMTPAuth = true;
		//$mail->SMTPSecure = "ssl";
		$mail->Port = $email->port;
		$mail->Username = $email->smtp_username;
		$mail->Password = $email->smtp_password;

		$mail->From = $email->from_address;
		$mail->FromName = $email->form_name;
		$mail->AddAddress($data[0]->email);
		//$mail->AddReplyTo("mail@mail.com");

		$mail->IsHTML(true);

		$mail->Subject = "Purchase order No : ".$data[0]->reference_no." From ".$company[0]->name;
		$mail->Body = "Date : ".$data[0]->date."<br>Total : ".$data[0]->total;
		//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

		if(!$mail->Send())
		{
			$message =  "Email could not be sent";
		}
		else{
			$message =  "Email has been sent";
		}
		$this->session->set_flashdata('message', $message);
		redirect('purchase','refresh');
	}
	/*
		view payment
	*/
	public function payment($id){
		$data['data'] = $this->purchase_model->getDetails($id);
		$data['items'] = $this->purchase_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$data['ledger'] = $this->purchase_model->getLedger();
		$data['p_reference_no'] = $this->purchase_model->generateReferenceNo();
		$this->load->view('purchase/payment',$data);
	}
	/*
		add payment
	*/
	public function paymentAdd($id){
		$data['data'] = $this->purchase_model->getDetails($id);
		$data['items'] = $this->purchase_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$data['p_reference_no'] = $this->purchase_model->generateReferenceNo();
		$this->load->view('purchase/payment/add',$data);
	}
	/*
		get Discount value for AJAX 
	*/
	public function getDiscountValue($id){
		$data = $this->purchase_model->getDiscountValue($id);
		echo json_encode($data);
	}
	/*
		get Tax value for AJAX 
	*/
	public function getTaxValue($id){
		$data = $this->purchase_model->getTaxValue($id);
		echo json_encode($data);
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
			$this->form_validation->set_rules('bank_name','Bank Name','trim|required');
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
					"purchase_id"     => $id,
					"payment_voucher_date"         => $this->input->post('date'),
					"invoice_no" => $this->input->post('reference_no'),
					"payment_ledger" => $this->input->post('ledger'),
					"payment_amount"       => $this->input->post('amount'),
					"mode_of_payment"    => $this->input->post('paying_by'),
					"bank_name"    => $bank_name,
					"cheque_no"    => $cheque_no,
					"description"  => $this->input->post('note')
				);

			if($this->purchase_model->addPayment($data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Purchase Payable'
					);
				$this->log_model->insert_log($log_data);
				redirect('purchase','refresh');
			}
			else{
				redirect("purchase",'refresh');
			}
		}
	}
}
?>