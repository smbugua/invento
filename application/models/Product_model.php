<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model
{
	function __construct() {
		parent::__construct();
		
	}
	public function index(){
		
	}
	/* 
		return category id and name to use drop down manu 
	*/
	public function getCategory(){
		$this->db->select('category_id,category_name');
		$data =	$this->db->get('category');
		return $data->result();
	}
	/* 
		return brand name to use drop down manu 
	*/
	public function getBrand(){
		$this->db->select('brand_name');
		$data =	$this->db->get('brand');
		return $data->result();
	}
	/* 
		return subcategory id and name to use drop down manu 
	*/
	public function getSubcategory($id){
		$sql = "SELECT s.* FROM sub_category s INNER JOIN products p ON s.category_id = p.category_id where p.product_id = ?";
		$data = $this->db->query($sql,array($id));
		/*$this->db->select('sub_category_id,sub_category_name');
		$data =	$this->db->get('sub_category');*/
		return $data->result();
	}
	/* 
		return tax id and name to use drop down manu 
	*/
	public function getTax(){
		$this->db->select('tax_id,tax_name');
		$data =	$this->db->get('tax');
		return $data->result();
	}
	/*
		return sac data
	*/
	public function getSac(){
		
		return $this->db->get('sac')->result();
	}
	/*
		return hsn chapter
	*/
	public function getHsnChapter(){
		return $this->db->get('hsn_chapter')->result();
	}
	/*
		return hsn data
	*/
	public function getHsn(){
		return $this->db->get_where('hsn',array('chapter'=>1))->result();
	}
	/*

	*/
	public function getHsnData($id){
		return $this->db->get_where('hsn',array('chapter'=>$id))->result();
	}
	/* 
		return subcategory details when category change 
	*/
	public function selectSubcategory($id){
		$sql = "select * from sub_category where category_id = ?";
		$data = $this->db->query($sql,array($id));
		/*$this->db->where('category_id',$id);
		$data = $this->db->get('sub_category');*/
		return $data->result();
	}
	/* 
		return all product details to display list 
	*/
	public function getProducts(){
		$this->db->select('p.*,c.category_name')
				 ->from('products p')
				 ->join('category c','c.category_id = p.category_id');
		return $this->db->get()->result();
	}
	/* 
		ckech product code already exist or not 
	*/
	function codeExist($key)
	{
		$sql = "select * from products where code = ?";
		$query = $this->db->query($sql,array("code" => $key));
	    /*$this->db->where('code',$key);
	    $query = $this->db->get('products');*/
	    if ($query->num_rows() > 0){
	        return true;
	    }
	    else{
	        return false;
	    }
	}
	/* 
		add new product record in database 
	*/
	public function addModel($data){
		log_message('debug', print_r($data, true));
		$sql = "insert into products (name,category_id,subcategory_id,price,tax_id,image,date,details) values(?,?,?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){
		/*if($this->db->insert('products',$data)){*/
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/* 
		return all product details when product edit 
	*/
	public function getRecord($data){
		//$this->db->where('product_id',$data);
		$this->db->select('products.*, category.category_id,category.category_name, sub_category.sub_category_id, sub_category.sub_category_name')
				 ->from('products')
				 ->join('category','products.category_id = category.category_id')
				 ->join('sub_category','products.subcategory_id = sub_category.sub_category_id')
				 ->where('products.product_id',$data);
		$query = $this->db->get();
		if($query){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* 
		save edited product record in database  
	*/
	public function editModel($data,$id){
		$sql = "update products set  name = ?,category_id = ?,subcategory_id = ?,price = ?,alert_quantity = ?,tax_id = ?,image = ?,date = ?,details = ? where product_id = ?";
		if($this->db->query($sql,$data)){
		/*$this->db->where('product_id',$id);
		if($this->db->update('products',$data)){*/
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/* 
		delete product record from database 
	*/
	public function deleteModel($id){
		$sql = "delete from products where product_id = ?";
		if($this->db->query($sql,array($id))){
		/*$this->db->where('product_id',$id);
		if($this->db->delete('products')){*/
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*

	*/
	public function addCsvData($data){

	}
}
?>