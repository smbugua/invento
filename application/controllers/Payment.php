<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('payment_model');
		$this->load->model('log_model');
	}
	public function index(){
		$data['data'] = $this->payment_model->getPayment();
		$this->load->view('payment/list',$data);
	} 
	public function edit($id){
		$data['data'] = $this->payment_model->getDetails($id);
		$this->load->view('payment/edit',$data);
	}
	public function editPayment(){
		$id = $this->input->post('id');
		$paying_by = $this->input->post('paying_by');
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('paying_by','Paying By','trim|required');
		if($paying_by == "Cheque"){
			$this->form_validation->set_rules('bank_name','Bank Name','trim|required|callback_alpha_dash_space');
			$this->form_validation->set_rules('cheque_no','Cheque No','trim|required|numeric');
		}
		if($this->form_validation->run()==false){
			$this->edit($id);
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
					"date"         => $this->input->post('date'),
					"paying_by"    => $this->input->post('paying_by'),
					"bank_name"    => $bank_name,
					"cheque_no"    => $cheque_no,
					"description"  => $this->input->post('note')
				);
			if($this->payment_model->editPayment($id,$data)){ 
				$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Payment Updated'
				);
				$this->log_model->insert_log($log_data);
				redirect('payment','refresh');
			}
			else{
				$this->session->set_flashdata('message', 'Error in Payment.');
				redirect("payment",'refresh');
			}
		}
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
	}/*

	*/
	public function delete($id){
		if($this->payment_model->delete($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Payment Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('payment','refresh');
		}
		else{
			$this->session->set_flashdata('message', 'Error in Delete.');
			redirect("payment",'refresh');
		}
	}
}