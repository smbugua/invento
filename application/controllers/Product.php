<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('product_model');
		$this->load->model('log_model');
	}
	public function index(){
		//get all product details to display list
		$data['data'] = $this->product_model->getProducts();
		$this->load->view('product/list',$data);
	}
	/* 
		call add view to add product record 
	*/
	public function add(){
		$data['category'] = $this->product_model->getCategory();
		$data['tax']      = $this->product_model->getTax();
	    $data['sac']      = $this->product_model->getSac();
		$data['chapter']  = $this->product_model->getHsnChapter();
		$data['hsn']      = $this->product_model->getHsn();
		$data['brand']	  = $this->product_model->getBrand();	
		
		$this->load->view('product/add',$data);
	}
	/* 
		This function used when category is change subcategory list change  
	*/
	public function getSubcategory($id){
		$data = $this->product_model->selectSubcategory($id);
		echo json_encode($data);
	}
	/*

	*/
	public function getHsnData($id){
		$data = $this->product_model->getHsnData($id);
		echo json_encode($data);
	}
	/* 
		This function is used to add product record in database 
	*/
	public function addProduct(){
		$this->load->helper('security');
		$this->form_validation->set_rules('code', 'Code', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|callback_alpha_dash_space|xss_clean');
		$this->form_validation->set_rules('category', 'Category', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('subcategory', 'Subcategory', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('unit', 'Unit', 'trim|required|alpha|xss_clean');
		//$this->form_validation->set_rules('size', 'Size', 'trim|required|alpha_numeric|xss_clean');
		$this->form_validation->set_rules('cost', 'Cost', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('price', 'Price', 'trim|required|numeric|xss_clean');
		//$this->form_validation->set_rules('alert_quantity', 'Alert Quantity', 'trim|required|numeric|xss_clean');
		//$this->form_validation->set_rules('tax', 'Tax', 'trim|required|numeric|xss_clean');
		//$this->form_validation->set_rules('image', 'Image', 'trim|required');
		//$this->form_validation->set_rules('details', 'Details', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE)
        {
            $this->add();
        }
        else
        {
        	if($_FILES["image"]["name"]){
        		$type = explode('.',$_FILES["image"]["name"]);
				$type = $type[count($type)-1];
				$url = "assets/images/product/".uniqid(rand()).'.'.$type;
						
				if(in_array($type,array("jpg","jpeg","gif","png"))){
							
					if(is_uploaded_file($_FILES["image"]["tmp_name"])){
								
						if(move_uploaded_file($_FILES["image"]["tmp_name"],$url)){
									
						} 
					}	
				}
        	}
        	else{
        		$url = "assets/images/product/no_image.jpg";
        	}
					
		
			$data = array(
					//"code"           => $this->input->post('code'),
					"name"           => $this->input->post('name'),
					//"hsn_sac_code"   => $this->input->post('hsn_sac_code'),
					"category_id"    => $this->input->post('category'),
					"subcategory_id" => $this->input->post('subcategory'),
					//"brand_id"       => $this->input->post('brand'),
					//"unit"           => $this->input->post('unit'),
					//"size"           => $this->input->post('size'),
					//"cost"           => $this->input->post('cost'),
					"price"          => $this->input->post('price'),
					//"alert_quantity" => $this->input->post('alert_quantity'),
					"tax_id"         => $this->input->post('tax'),
					"image"          => base_url().''.$url,
					"date"           => date('Y-m-d'),
					"details"        => $this->input->post('note')
				);

			if($id = $this->product_model->addModel($data)){ 
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Product Inserted'
					);
				$this->log_model->insert_log($log_data);
				redirect('product','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Product can not be Inserted.');
				redirect("product",'refresh');
			}
		}
	}
	/*
		call edit view to edit product record 
	*/
	public function edit($id){
		$data['data']        = $this->product_model->getRecord($id);
		$data['category']    = $this->product_model->getCategory();
		$data['subcategory'] = $this->product_model->getSubcategory($id);
		$data['tax']         = $this->product_model->getTax();
		$data['sac']         = $this->product_model->getSac();
		$data['chapter']     = $this->product_model->getHsnChapter();
		$data['hsn']         = $this->product_model->getHsn();
		$this->load->view('product/edit',$data);
	}
	/* 
		This function is used to edit product in database 
	*/
	public function editProduct(){
		$id = $this->input->post('id');
		$this->form_validation->set_rules('code', 'Code', 'trim|required|numeric');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|callback_alpha_dash_space');
		$this->form_validation->set_rules('category', 'Category', 'trim|required|numeric');
		$this->form_validation->set_rules('subcategory', 'Subcategory', 'trim|required|numeric');
		$this->form_validation->set_rules('unit', 'Unit', 'trim|required|alpha');
		//$this->form_validation->set_rules('size', 'Size', 'trim|required|alpha_numeric');
		$this->form_validation->set_rules('cost', 'Cost', 'trim|required|numeric');
		$this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
		//$this->form_validation->set_rules('alert_quantity', 'Alert Quantity', 'trim|required|numeric');
		//$this->form_validation->set_rules('tax', 'Tax', 'trim|required|numeric');
		//$this->form_validation->set_rules('image', 'Image', 'trim|required');
		//$this->form_validation->set_rules('details', 'Details', 'trim|required');


		if ($this->form_validation->run() == FALSE)
        {
            $this->edit($id);
        }
        else
        {
				
			if($_FILES["image"]["name"] == null){
				$url = $this->input->post('hidden_image');
			}
			else{
				$type = explode('.',$_FILES["image"]["name"]);
				$type = $type[count($type)-1];
				$url = "./assets/images/product/".uniqid(rand()).'.'.$type;
						
				if(in_array($type,array("jpg","jpeg","gif","png"))){
							
					if(is_uploaded_file($_FILES["image"]["tmp_name"])){
								
						if(move_uploaded_file($_FILES["image"]["tmp_name"],$url)){
							$url = base_url().''.$url;	
						}
					}	
				}
			}	

			$data = array(
					"code"           => $this->input->post('code'),
					"name"           => $this->input->post('name'),
					"hsn_sac_code"   => $this->input->post('hsn_sac_code'),
					"category_id"    => $this->input->post('category'),
					"subcategory_id" => $this->input->post('subcategory'),
					"brand_id"       => $this->input->post('brand'),
					"unit"           => $this->input->post('unit'),
					"size"           => $this->input->post('size'),
					"cost"           => $this->input->post('cost'),
					"price"          => $this->input->post('price'),
					"alert_quantity" => $this->input->post('alert_quantity'),
					"tax_id"         => $this->input->post('tax'),
					"image"          => $url,
					"date"           => date('Y-m-d'),
					"details"        => $this->input->post('note'),
					"product_id"     => $this->input->post('id')
				);
			
			if($this->product_model->editModel($data,$id)){ 
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Product Updated'
					);
				$this->log_model->insert_log($log_data);
				redirect('product','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Product can not be Updated.');
				redirect("product",'refresh');
			}
		}
	}
	/* 
		This function is used to delete product record in databse 
	*/
	public function delete($id){
		if($this->product_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Product Deleted'
				);
				$this->log_model->insert_log($log_data);
			redirect('product','refresh');
		}
		else{
			$this->session->set_flashdata('fail', 'Product can not be Deleted.');
			redirect("product",'refresh');
		}
	}
	/*
		this function call CSV file view
	*/
	public function import(){
		$data['category'] = $this->product_model->getCategory();
		$this->load->view('product/import',$data);
	}
	/*
		this  function get csv file data
	*/
	public function import_csv(){
        
        $category_id = $this->input->post('category');
        $subcategory_id = $this->input->post('subcategory');
        $filename=$_FILES["csv"]["tmp_name"];      
    
        if($_FILES["csv"]["size"] > 0)
        {
            $file = fopen($filename, "r");
            
            for ($lines = 0; $data = fgetcsv($file,1000,",",'"'); $lines++) 
            {
                if ($lines == 0) continue;
                
                $sql = "INSERT INTO `products`(`category_id`,`subcategory_id`,`code`, `name`, `hsn_sac_code`, `unit`, `size`, `cost`, `price`, `alert_quantity`, `details`) VALUES ($category_id,$subcategory_id,'".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."')";
                $this->db->query($sql);
            }
            fclose($file); 
        }
        else{
            redirect("product/import",'refresh'); 
        }
        redirect('product','refresh');
	}
	function code_exists($code) {
		if($this->product_model->codeExist($code)){
			$this->form_validation->set_message('code_exists', 'Code Already Exist');
			return false;
		}
		else{
			return true;
		}
	}
	function alpha_dash_space($str) {
		if (! preg_match("/^([-a-zA-Z0-9_ ])+$/i", $str))
	    {
	        $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha-numeric characters, spaces, underscores, and dashes.');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
} 
?>