<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customer_model extends CI_Model
{
	function __construct() {
		parent::__construct();
		
	}
	/*
		return country
	*/
	public function getCountry(){
		return $this->db->get('countries')->result();
	}
	/*
		return state
	*/
	public function getState($id){	
		return $this->db->select('s.*')
		                 ->from('states s')
		                 ->join('countries c','c.id = s.country_id')
		                 ->where('s.country_id',$id)
		                 ->get()
		                 ->result();
	}
	/*
		return city 
	*/
	public function getCity($id){
		return $this->db->select('c.*')
		                 ->from('cities c')
		                 ->join('states s','s.id = c.state_id')
		                 ->where('c.state_id',$id)
		                 ->get()
		                 ->result();
	} 
	/* 
		return all customer details to dispaly list 
	*/
	public function getCustomer(){
		$data = $this->db->select('b.*,c.name as cname,ct.name as ctname')
		                 ->from('customer b')
		                 ->join('countries c','c.id = b.country_id')
		                 ->join('cities ct','ct.id = b.city_id')
		                 ->get()
		                 ->result();
		return $data;
	}
	/* 
		insert new customer record in databse 
	*/
	public function addModel($data){
		$sql = "insert into customer (customer_name,company_name,address,city_id,country_id,state_id,mobile,email,postal_code,gstid,vat_no,pan_no,tan_no,cst_reg_no,excise_reg_no,lbt_reg_no,servicetax_reg_no,gst_registration_type) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){
		/*if($this->db->insert('customer',$data)){*/
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/* 
		return specific customer record  
	*/
	public function getRecord($id){
		$sql = "select * from customer where customer_id = ?";
		if($query = $this->db->query($sql,array($id))){
		/*$this->db->where('customer_id',$data);
		if($query = $this->db->get('customer')){*/
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* 
		save edited customer record in databse 
	*/
	public function editModel($data,$id){
		/*$sql = "update customer set customer_name = ?,company_name = ?,address = ?,city_id = ?,country_id = ?,state_id = ?,mobile = ?,email = ?,postal_code = ?,gstid=?,vat_no=?,pan_no=?,tan_no=?,cst_reg_no=?,excise_reg_no=?,lbt_reg_no,servicetax_reg_no=?,gst_registration_type=? where customer_id = ?";*/
		//if($this->db->query($sql,$data)){
		$this->db->where('customer_id',$id);
		if($this->db->update('customer',$data)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/* 
		delete customer record in databse 
	*/
	public function deleteModel($id){
		$sql = "delete from customer where customer_id = ?";
		if($this->db->query($sql,array($id))){
		/*$this->db->where('customer_id',$id);
		if($this->db->delete('customer')){*/
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>