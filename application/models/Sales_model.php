<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sales_model extends CI_Model
{
	function __construct() {
		parent::__construct();
		
	}
	/* 
		return all sales details to display list 
	*/
	public function getSales(){
		$this->db->select('s.*,b.*,c.*,i.*')
		         ->from('sales s')
		         ->join('biller b','s.biller_id=b.biller_id')
		         ->join('customer c','s.customer_id=c.customer_id')
		         ->join('invoice i ','s.sales_id=i.sales_id');
		return $this->db->get()->result();
	}
	/* 
		return warehouse detail use drop down 
	*/
	public function getWarehouse(){
		if($this->session->userdata('type') == "admin"){
			return $this->db->get('warehouse')->result();
		}
		else{
			$this->db->select('w.*')
					 ->from('warehouse w')
					 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
					 ->where('wm.user_id',$this->session->userdata('user_id'));
			return $this->db->get()->result();
		}
	}
	/* 
		return warehouse details available in warehouse products 
	*/
	public function getWarehouseProducts(){
		$this->db->select('warehouse.warehouse_id,warehouses_products.product_id,quantity')
		         ->from('warehouse')
		         ->join('warehouses_products','warehouse.warehouse_id = warehouses_products.warehouse_id');
		return $this->db->get()->result();
	}
	/* 
		return biller detail use drop down 
	*/
	public function getBiller(){
		return $this->db->get('biller')->result();
	}
	/* 
		return customer detail use drop down 
	*/
	public function getCustomer(){
		return $this->db->get('customer')->result();
	}
	/* 
		return discount detail use drop down 
	*/
	public function getDiscount(){
		return $this->db->get('discount')->result();
	}
	/* 
		return tax detail use dynamic table
	*/
	public function getTax(){
		return $this->db->get_where('tax',array('delete_status'=>0))->result();
	}
	/*
		generate invoive no
	*/
	public function generateInvoiceNo(){
		$query = $this->db->query("SELECT * FROM invoice ORDER BY id DESC LIMIT 1");
		$result = $query->result();
		if($result==null){
            $no = sprintf('%06d',intval(1));
        }
        else{
          foreach ($result as $value) {
            $no = sprintf('%06d',intval($value->id)+1); 
          }
        }
		return "INV-".$no;
	}
	/*	
		generate payment reference no
	*/
	public function generateReferenceNo(){
		$query = $this->db->query("SELECT * FROM payment ORDER BY id DESC LIMIT 1");
		$result = $query->result();
		return $result;
	}
	/* 
		return last purchase id 
	*/
	public function createReferenceNo(){
		$query = $this->db->query("SELECT * FROM sales ORDER BY sales_id DESC LIMIT 1");
		$result = $query->result();
		return $result;
	}
	/* 
		return sales record 
	*/
	public function getRecord($id){
		$sql = "select * from sales where sales_id = ?";
		if($query = $this->db->query($sql,array($id))){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* 
		add new sales record in database 
	*/
	public function addModel($data,$invoice){
		/*$sql = "insert into sales (date,reference_no,warehouse_id,customer_id,biller_id,total,discount_value,tax_value,note,shipping_city_id,shipping_state_id,shipping_country_id,shipping_address,shipping_charge,internal_note,user) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){*/
		if($this->db->insert('sales',$data)){
			$insert_id = $this->db->insert_id(); 
			$invoice['sales_id'] = $insert_id;
			$this->db->insert('invoice',$invoice);
			return $insert_id;
		}
		else{
			return FALSE;
		}
	}
	/* 
		return discount detail use drop down when discount change
	*/
	public function getDiscountAjax($id){
		$sql = "select * from discount where discount_id = ?";
		return $this->db->query($sql,array($id))->result();
	}
	/* 
		check product available in sales or not 
	*/
	public function checkProductInSales($sales_id,$product_id){
		$sql = "select * from sales_items where sales_id = ? AND product_id = ?";
		if($quantity = $this->db->query($sql,array($sales_id,$product_id))->num_rows() > 0){

			$sql = "select * from sales_items where sales_id = ? AND product_id = ?";
			$quantity = $this->db->query($sql,array($sales_id,$product_id));
			return $quantity->row()->quantity;
		}
		else{
			return false;
		}
		
	}
	/* 
		update quantity in product table 
	*/
	public function updateQuantity($sales_id,$product_id,$warehouse_id,$quantity,$old_quantity,$data){
		/*$sql = "update sales_items set quantity=?,price =?,gross_total=?,discount=?,tax=? where sales_id = ? AND product_id = ?";
		$this->db->query($sql,array($quantity,$data['price'],$data['gross_total'],$data['discount'],$data['tax'],$sales_id,$product_id));*/
		$where = "sales_id = $sales_id AND product_id = $product_id";
		$this->db->where($where);
		$this->db->update('sales_items',$data);
		
		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($warehouse_id,$product_id))->row()->quantity;
		
		$wquantity = $warehouse_quantity - $quantity + $old_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$warehouse_id,$product_id));
		

		$sql = "select * from products where product_id = ?";
		$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
		
		$pquantity = $product_quantity - $quantity + $old_quantity;
		$sql = "update products set quantity = ? where product_id = ?";
		$this->db->query($sql,array($pquantity,$product_id));
		
	}
	/* 
		check product available in warehouse or not 
	*/
	public function checkProductInWarehouse($product_id,$quantity,$warehouse_id){
		$sql = "select * from warehouses_products where product_id = ? AND warehouse_id = ?";
		$query = $this->db->query($sql,array($product_id,$warehouse_id));
		
		if($query->num_rows()>0){
			$warehouse_quantity = $query->row()->quantity;
			if($warehouse_quantity >= $quantity){
				$wquantity = $warehouse_quantity - $quantity;
				$sql = "update warehouses_products set quantity = ? where product_id = ? AND warehouse_id = ?";
				$this->db->query($sql,array($wquantity,$product_id,$warehouse_id));
				
				$sql = "select * from products where product_id = ?";
				$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
				
				$pquantity = $product_quantity - $quantity ;	
				$sql = "update products set quantity = ? where product_id = ?";
				$this->db->query($sql,array($pquantity,$product_id));
			}
		}
	}
	/*  
		add newly sales items record in database 
	*/
	public function addSalesItem($data,$product_id,$warehouse_id,$quantity){
		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($warehouse_id,$product_id))->row()->quantity;
		
		$wquantity = $warehouse_quantity - $quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$warehouse_id,$product_id));
		
		$sql = "select * from products where product_id = ?";
		$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
		
		$pquantity = $product_quantity - $quantity ;	
		$sql = "update products set quantity = ? where product_id = ?";
		$this->db->query($sql,array($pquantity,$product_id));

	  	$sql = "insert into sales_items (product_id,quantity,price,gross_total,discount_id,discount_value,discount,tax_id,tax_value,tax,sales_id) values (?,?,?,?,?,?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		return sales item data when edited 
	*/
	public function getSalesItems($sales_id,$warehouse_id){
		$this->db->select('si.*,wp.quantity as warehouses_quantity,p.product_id,p.code,p.name,p.unit,p.price,p.cost,p.hsn_sac_code')
				 ->from('sales_items si')
				 ->join('products p','si.product_id = p.product_id')
				 ->join('warehouses_products wp','wp.product_id = p.product_id')
				 ->where('si.sales_id',$sales_id)
				 ->where('wp.warehouse_id',$warehouse_id);
		if($query = $this->db->get()){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* 
		return  single product to add dynamic table 
	*/
	public function getProduct($product_id,$warehouse_id){
		return $this->db->select('p.product_id,p.code,p.hsn_sac_code,p.unit,p.name,p.size,p.cost,p.price,p.alert_quantity,p.image,p.category_id,p.subcategory_id,p.tax_id,wp.quantity,wp.warehouse_id,t.tax_value')
			 ->from('products p')
			 ->join('warehouses_products wp','p.product_id = wp.product_id')
			 ->join('tax t','p.tax_id = t.tax_id','left')
			 ->where('wp.warehouse_id',$warehouse_id)
			 ->where('wp.product_id',$product_id)
		     ->get()
		     ->result();
	}
	/* 
		return  product list to add product 
	*/
	public function getProducts($warehouse_id){
		return  $this->db->select('p.*')
					 ->from('products p')
					 ->join('warehouses_products wp','p.product_id = wp.product_id')
					 ->where('wp.warehouse_id',$warehouse_id)
					 ->where('wp.quantity > 0')
				     ->get()
				     ->result();
	}
	/* 
		save edited record in database 
	*/
	public function editModel($id,$data){
		/*$data['sales_id'] = $id;
		$sql = "update sales set date = ?,reference_no = ?,warehouse_id = ?,customer_id = ?,biller_id = ?,total = ?,discount_value=?,tax_value=?,note = ?,shipping_city_id = ?,shipping_state_id= ?,shipping_country_id =?,shipping_address =?,shipping_charge =?,internal_note = ?,mode_of_transport=?,transporter_name=?,transporter_code=?,vehicle_regn_no=?,user = ? where sales_id = ?";
		if($this->db->query($sql,$data)){*/
		$this->db->where('sales_id',$id);
		if($this->db->update('sales',$data)){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		delete old purchase item when edit purchse  
	*/
	public function deleteSalesItems($sales_id,$product_id,$warehouse_id,$old_warehouse_id){
		
		$sql = "select * from sales_items where sales_id = ? AND product_id = ?";
		$delete_quantity = $this->db->query($sql,array($sales_id,$product_id))->row()->quantity;

		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($warehouse_id,$product_id))->row()->quantity;
		
		$wquantity = $warehouse_quantity + $delete_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$warehouse_id,$product_id));
	

		$sql = "select * from products where product_id = ?";
		$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
		
		$pquantity = $product_quantity + $delete_quantity;
		$sql = "update products set quantity = ? where product_id = ?";
		$this->db->query($sql,array($pquantity,$product_id));
		
		$sql = "delete from sales_items where sales_id = ? AND product_id = ?";
		if($this->db->query($sql,array($sales_id,$product_id))){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		when warehouse change selected items is delete this function  
	*/
	public function changeWarehouseDeleteSalesItems($sales_id,$product_id,$warehouse_id,$old_warehouse_id){

		$sql = "select * from sales_items where sales_id = ? AND product_id = ?";
		$delete_quantity = $this->db->query($sql,array($sales_id,$product_id))->row()->quantity;

		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($old_warehouse_id,$product_id))->row()->quantity;
		
		$wquantity = $warehouse_quantity + $delete_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$old_warehouse_id,$product_id));

		$sql = "select * from products where product_id = ?";
		$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
		
		$pquantity = $product_quantity + $delete_quantity;
		$sql = "update products set quantity = ? where product_id = ?";
		$this->db->query($sql,array($pquantity,$product_id));
		
		$sql = "delete from sales_items where sales_id = ? AND product_id = ?";
		if($this->db->query($sql,array($sales_id,$product_id))){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		delete sales record in database 
	*/
	public function deleteModel($id){
		$sql = "delete from sales where sales_id = ?";
		if($this->db->query($sql,array($id))){
			$sql = "delete from sales_items where sales_id = ?";
			if($this->db->query($sql,array($id))){
				return TRUE;
			}
			
		}
		else{
			return FALSE;
		}
	}
	/* 
		return all details of sales 
	*/
	public function getSalesData(){
		return $this->db->get('sales')->result();
	}
	/*
		return all details of purchase
	*/
	public function getPurchaseData(){		
		return $this->db->get('purchases')->result();
	}
	/* 
		return sales data for calendar
	*/
	public function getCalendarData(){
		return $this->db->get('sales')->result();
	}
	/*
		return sales details
	*/
	public function getDetails($id){

		return  $this->db->select('s.*,
								   i.invoice_no,
								   i.invoice_date,
								   i.paid_amount,
								   c.customer_name,
								   c.address as customer_address,
								   c.mobile as customer_mobile,
								   c.email as customer_email,
								   c.company_name as customer_company,
								   c.postal_code as customer_postal_code,
								   c.gstid as customer_gstid,
								   c.state_id as customer_state_id,
								   c.tan_no as tan_no,
								   c.cst_reg_no as cst_reg_no,
								   c.excise_reg_no as excise_reg_no,
								   c.lbt_reg_no as lbt_reg_no,
								   c.servicetax_reg_no as servicetax_reg_no,
								   ct.name as customer_city,
								   c.country_id as customer_country,
								   b.biller_name,
								   b.address as biller_address,
								   cb.name as biller_city,
								   co.name as biller_country,
								   b.mobile as biller_mobile,
								   b.email as biller_email,
								   b.company_name as biller_company,
								   b.fax as biller_fax,
								   b.telephone as biller_telephone,
								   b.gstid as biller_gstid,
								   b.state_id as biller_state_id,
								   w.warehouse_name,
								   br.address as branch_address,
								   br.city as branch_city,
								   u.first_name,
								   u.last_name')
						 ->from('sales s')
						 ->join('invoice i','i.sales_id = s.sales_id')
						 ->join('customer c','s.customer_id = c.customer_id')
						 ->join('cities ct','c.city_id = ct.id')
						 ->join('states cs','c.state_id = cs.id')
						 ->join('biller b','s.biller_id = b.biller_id')
						 ->join('cities cb','b.city_id = cb.id')
						 ->join('states bs','b.state_id = bs.id')
						 ->join('countries co','b.country_id = co.id')
						 ->join('warehouse w','s.warehouse_id = w.warehouse_id')
						 ->join('branch br','w.branch_id = br.branch_id')
						 ->join('users u','s.user = u.id')
						 ->where('s.sales_id',$id)
						 ->get()
						 ->result();
	}
	/*
		return details for payment
	*/
	public function getDetailsPayment($id){
		return  $this->db->select('s.*,
								   c.customer_name,
								   c.address as customer_address,
								   c.mobile as customer_mobile,
								   c.email as customer_email,
								   c.gstid as customer_gstid,
								   ct.name as customer_city,
								   cco.name as customer_country,
								   b.biller_name,
								   b.address as biller_address,
								   cb.name as biller_city,
								   co.name as biller_country,
								   b.mobile as biller_mobile,
								   b.email as biller_email,
								   b.gstid as biller_gstid,
								   w.warehouse_name,
								   br.address as branch_address,
								   br.city as branch_city,
								   u.first_name,
								   u.last_name')
						 ->from('sales s')
						 ->join('customer c','s.customer_id = c.customer_id')
						 ->join('cities ct','c.city_id = ct.id')
						 ->join('countries cco','c.country_id = cco.id')
						 ->join('biller b','s.biller_id = b.biller_id')
						 ->join('cities cb','b.city_id = cb.id')
						 ->join('countries co','b.country_id = co.id')
						 ->join('warehouse w','s.warehouse_id = w.warehouse_id')
						 ->join('branch br','w.branch_id = br.branch_id')
						 ->join('users u','s.user = u.id')
						 ->where('s.sales_id',$id)
						 ->get()
						 ->result();
	}
	/*
		return sales item details
	*/
	public function getItems($id){
		return  $this->db->select('si.*,pr.name,pr.code,pr.hsn_sac_code,pr.unit,pr.size')
						 ->from('sales_items si')
						 ->join('sales s','si.sales_id = s.sales_id')
						 ->join('products pr','si.product_id = pr.product_id')
						 ->where('si.sales_id',$id)
						 ->get()
						 ->result();
	}
	/*
		return supplier details
	*/
	public function getCustomerEmail($id){

		return $this->db->select('*')
						 ->from('sales s')
						 ->join('customer c','c.customer_id = s.customer_id')
						 ->where('s.sales_id',$id)
						 ->get()
						 ->result();
	}
	/*
		add payment details
	*/
	public function addPayment($data){

		$sql = "INSERT INTO payment (sales_id,date,reference_no,amount,paying_by,bank_name,cheque_no,description) VALUES (?,?,?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){
		/*if($this->db->insert('payment',$data)){*/

			$this->db->where('sales_id',$data['sales_id']);
			$this->db->update('invoice',array("paid_amount"=>$data['amount']));
			return true;
		}else{
			return false;
		}
	}
	/*

	*/
	public function invoice(){
		return $this->db->select('*')
					    ->from('invoice i')
					    ->join('sales s','s.sales_id = i.sales_id')
					    ->get()
					    ->result();
	}
	/*
		return SMTP server Data
	*/
	public function getSmtpSetup(){
		return $this->db->get('email_setup')->row();
	} 
	/*
		return customer data for shipping address
	*/
	public function getCustomerData($id){
		$this->db->where('customer_id',$id);
		return $this->db->get_where('customer')->row();
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
}
?>