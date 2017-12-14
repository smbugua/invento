  <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Invento | Dashboard</title>
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/images/title.png'); ?>" />

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/fullcalendar/fullcalendar.min.css">
  <!-- Graph -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <!-- Close Graph -->
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/fullcalendar/fullcalendar.print.css" media="print">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/datepicker/datepicker3.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/colorpicker/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/select2/select2.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>dist/css/skins/_all-skins.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('assets/');?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/');?>documentation/style.css">

  <script src="<?php echo base_url();?>assets/plugins/jQuery/jquery-3.1.1.js"></script> 
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->

<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url();?>assets/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url();?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url();?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url();?>assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/dist/js/demo.js"></script>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b> <img src="<?php  echo base_url(); ?>assets/images/logo2.png"/></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">          
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown">
              
              <div style="width:70px;">
                <table>
                <tr>
                  <td>
                    <?php
                      if($this->session->userdata('site_lang')!=null){
                    ?>
                        <img src="<?php echo base_url('assets/images/flag/').$this->session->userdata('site_lang').".png";?>" width="110%">
                    <?php
                      }
                      else{
                    ?>
                      <img src="<?php echo base_url('assets/images/flag/');?>english.png" width="110%">
                    <?php
                      }
                    ?>
                    </td>
                  <td>
                    <?php 
                      if($this->session->userdata('site_lang')!=null){
                        echo ucwords($this->session->userdata('site_lang')); 
                      }
                      else{
                        echo " English";
                      }
                    ?>
                  </td>
                </tr>
              </table>
              </div>
            </a>
            <ul class="dropdown-menu">
              <li>
                <ul class="menu">
                  <li>
                    <a href="<?php echo base_url('LanguageSwitcher/switchLang/english'); ?>"><h3><img src="<?php echo base_url('assets/images/flag/english.png');?>" width="9%">English</h3></a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('LanguageSwitcher/switchLang/french'); ?>"><h3><img src="<?php echo base_url('assets/images/flag/french.png');?>" width="9%">French</h3></a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('LanguageSwitcher/switchLang/russian'); ?>"><h3><img src="<?php echo base_url('assets/images/flag/russian.png');?>" width="9%">Russian</h3></a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('LanguageSwitcher/switchLang/hindi'); ?>"><h3><img src="<?php echo base_url('assets/images/flag/hindi.png');?>" width="9%">Hindi</h3></a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('LanguageSwitcher/switchLang/spanish'); ?>"><h3><img src="<?php echo base_url('assets/images/flag/spanish.png');?>" width="9%">Spanish</h3></a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('LanguageSwitcher/switchLang/telugu'); ?>"><h3><img src="<?php echo base_url('assets/images/flag/telugu.png');?>" width="9%">Telugu</h3></a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('LanguageSwitcher/switchLang/arabic'); ?>"><h3><img src="<?php echo base_url('assets/images/flag/arabic.png');?>" width="9%">Arabic</h3></a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('LanguageSwitcher/switchLang/japanese'); ?>"><h3><img src="<?php echo base_url('assets/images/flag/japanese.png');?>" width="9%">Japanese</h3></a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('LanguageSwitcher/switchLang/gujarati'); ?>"><h3><img src="<?php echo base_url('assets/images/flag/gujarati.png');?>" width="9%">Gujarati</h3></a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('LanguageSwitcher/switchLang/portuguese'); ?>"><h3><img src="<?php echo base_url('assets/images/flag/portuguese.png');?>" width="9%">Portuguese</h3></a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('LanguageSwitcher/switchLang/turkish'); ?>"><h3><img src="<?php echo base_url('assets/images/flag/turkish.png');?>" width="9%">Turkish</h3></a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url();?>assets/dist/img/person2.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata('first_name')." ".$this->session->userdata('last_name'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url();?>assets/dist/img/person2.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->session->userdata('first_name')." ".$this->session->userdata('last_name'); ?>
                  <small></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo base_url()?>auth/logout" class="btn btn-default btn-flat"><?php echo $this->lang->line('header_sign_out'); ?></a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url();?>assets/dist/img/person2.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('first_name')." ".$this->session->userdata('last_name'); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $this->lang->line('header_online'); ?></a>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header"><?php echo $this->lang->line('header_main_navidation'); ?></li>
        <li class="active treeview">
          <a href="<?php echo base_url();?>auth/dashboard">
            <i class="fa fa-dashboard"></i> 
            <span><?php echo $this->lang->line('header_dashboard'); ?></span>
            <span class="pull-right-container">
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
            </span>
          </a>
        </li>
        <?php
          if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="purchaser" || $this->session->userdata('type')=="manager"){
        ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cube text-blue"></i>
            <span><?php echo $this->lang->line('header_product') ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right text-blue"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('product');?>"><i class="fa fa-lemon-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
            <li><a href="<?php echo base_url('product/add');?>"><i class="fa  fa-square-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
            <li><a href="<?php echo base_url('product/import');?>"><i class="fa fa-file-o text-maroon"></i>Import Products</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="<?php echo base_url('product_alert');?>">
            <i class="fa  fa-warning text-suffron"></i>
            <span><?php echo $this->lang->line('header_product_alert'); ?></span>
            <span class="pull-right-container">
              <span class="label label-danger pull-right">
                <?php 
                  echo $data = $this->db->select('count(*) as count')
                                                    ->from('products p1')
                                                    ->join('products p2',"p1.product_id = p2.product_id")
                                                    ->where('p1.alert_quantity > p2.quantity')
                                                    ->get()
                                                    ->row()->count;
                ?>
              </span>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-square text-maroon"></i>
            <span><?php echo $this->lang->line('header_purchase'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right text-maroon"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#">
                <i class="fa fa-bullseye text-blue"></i>
                <span><?php echo $this->lang->line('header_purchase'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-blue"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('purchase');?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('purchase/add');?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-soccer-ball-o text-red"></i>
                <span><?php echo $this->lang->line('header_purchase_return'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-red"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('purchase_return');?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('purchase_return/add');?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cube text-blue"></i>
            <span><?php echo $this->lang->line('header_transfers'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right text-blue"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('transfer');?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
            <li><a href="<?php echo base_url('transfer/add');?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
          </ul>
        </li>
        <?php
          }
          if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="sales_person" || $this->session->userdata('type')=="manager"){
        ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart text-aqua"></i>
            <span><?php echo $this->lang->line('header_sales'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right text-aqua"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart text-yellow"></i>
                <span><?php echo $this->lang->line('header_sales'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-yellow"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('sales');?>"><i class="fa fa-lemon-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('sales/add');?>"><i class="fa fa-square-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-star text-green"></i>
                <span><?php echo $this->lang->line('header_sales_return'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-green"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('sales_return');?>"><i class="fa fa-lemon-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('sales_return/add');?>"><i class="fa fa-square-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-star text-green"></i>
                <span>Quotation</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-green"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('quotation');?>"><i class="fa fa-lemon-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('quotation/add');?>"><i class="fa fa-square-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="<?php echo base_url('payment');?>">
                <i class="fa fa-money text-maroon"></i>
                <span><?php echo $this->lang->line('header_payment'); ?></span>
              </a>
            </li>
            <li class="treeview">
              <a href="<?php echo base_url('sales/invoice');?>">
                <i class="fa fa-square-o text-green"></i>
                <span><?php echo $this->lang->line('header_invoice'); ?></span>
              </a>
            </li>
          </ul>
        </li>
        <?php
          }
          if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="accountant" || $this->session->userdata('type')=="manager"){
        ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file text-yellow"></i>
            <span><?php echo $this->lang->line('header_reports'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right text-yellow"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="<?php echo base_url('reports/daily'); ?>">
                <i class="fa fa-circle-thin text-maroon"></i>
                <span><?php echo $this->lang->line('header_daily'); ?></span>
              </a>
            </li>
            <li class="treeview">
              <a href="<?php echo base_url('reports/products'); ?>">
                <i class="fa fa-cube text-red"></i>
                <span><?php echo $this->lang->line('header_product'); ?></span>
              </a>
            </li>

            <li class="treeview">
              <a href="<?php echo base_url('reports/purchase'); ?>">
                <i class="fa fa-square text-green"></i>
                <span><?php echo $this->lang->line('header_purchase'); ?></span>
              </a>
            </li>
            <li class="treeview">
              <a href="<?php echo base_url('reports/purchase_return'); ?>">
                <i class="fa fa-soccer-ball-o text-aqua"></i>
                <span><?php echo $this->lang->line('header_purchase_return'); ?></span>
              </a>
            </li>

            <li class="treeview">
              <a href="<?php echo base_url('reports/sales'); ?>">
                <i class="fa fa-shopping-cart text-gray"></i>
                <span><?php echo $this->lang->line('header_sales'); ?></span>
              </a>
            </li>
            <li class="treeview">
              <a href="<?php echo base_url('reports/sales_return'); ?>">
                <i class="fa fa-star text-suffron"></i>
                <span><?php echo $this->lang->line('header_sales_return'); ?></span>
              </a>
            </li>
            <li class="treeview">
              <a href="<?php echo base_url('reports/tax'); ?>">
                <i class="fa fa-legal text-maroon"></i>
                <span>Tax</span>
              </a>
            </li>
          </ul>
        </li>
        <?php 
          }
          if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="manager" || $this->session->userdata('type')=="sales_person"){
        ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users text-green"></i>
            <span><?php echo $this->lang->line('header_people'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right text-green"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php
              if($this->session->userdata('type')=="admin"){
            ?>
            <li class="treeview">
              <a href="#">
                <i class="fa  fa-user text-blue"></i>
                <span><?php echo $this->lang->line('header_users'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-blue"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('auth');?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('auth/create_user');?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa  fa-user text-red"></i>
                <span><?php echo $this->lang->line('header_billers'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-red"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('biller');?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('biller/add');?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <?php
              }
              if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="sales_person"){
            ?>
            <li class="treeview">
              <a href="#">
                <i class="fa  fa-user text-maroon"></i>
                <span><?php echo $this->lang->line('header_customers'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-maroon"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('customer');?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('customer/add');?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <?php
              }
              if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="manager"){
            ?>
            <li class="treeview">
              <a href="#">
                <i class="fa  fa-user text-yellow"></i>
                <span><?php echo $this->lang->line('header_suppliers'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-yellow"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('supplier');?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('supplier/add');?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <?php
              }
            ?>
          </ul>
        </li>
        <?php 
          }
          if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="manager"){
        ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cog text-red"></i>
            <span><?php echo $this->lang->line('header_setting'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right text-red"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="<?php echo base_url('company_setting') ?>">
                <i class="fa fa-dot-circle-o text-maroon"></i>
                <span><?php echo $this->lang->line('header_company_setting'); ?></span>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-tags text-green"></i>
                <span><?php echo $this->lang->line('header_category'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-green"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url("category");?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url("category/add");?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-qrcode text-blue"></i>
                <span><?php echo $this->lang->line('header_sub_category'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-blue"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url("subcategory");?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url("subcategory/add");?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-suitcase text-yellow"></i>
                <span><?php echo $this->lang->line('header_branch'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-yellow"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url("branch");?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url("branch/add");?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-bold"></i>
                <span><?php echo $this->lang->line('header_brand'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-red"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url("brand");?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url("brand/add");?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-hourglass text-gray"></i>
                <span><?php echo $this->lang->line('header_discount'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-gray"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url("discount");?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url("discount/add");?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-legal text-aqua"></i>
                <span><?php echo $this->lang->line('header_tax'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-aqua"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url("tax");?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url("tax/add");?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-university text-suffron"></i>
                <span><?php echo $this->lang->line('header_warehouse'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-suffron"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url("warehouse");?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url("warehouse/add");?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-th-large text-maroon"></i>
                <span><?php echo $this->lang->line('header_assign_warehouse'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-maroon"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('assign_warehouse');?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('assign_warehouse/add');?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="<?php echo base_url('email_setup');?>">
                <i class="fa fa-envelope-o text-yellow"></i>
                <span>Email Setup</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="<?php echo base_url('log');?>">
            <i class="fa fa-history text-maroon"></i>
            <span>Logs</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th-large text-maroon"></i>
            <span>Account</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right text-maroon"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li class="treeview">
              <a href="#">
                <i class="fa fa-th-large text-maroon"></i>
                <span>Account Group</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-maroon"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('accountgroup');?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('accountgroup/add');?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
            <li class="treeview"><a href="#">
                <i class="fa fa-th-large text-maroon"></i>
                <span>Ledger</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right text-maroon"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('ledger');?>"><i class="fa fa-circle-o text-green"></i><?php echo $this->lang->line('header_list'); ?></a></li>
                <li><a href="<?php echo base_url('ledger/add');?>"><i class="fa fa-circle-o text-yellow"></i><?php echo $this->lang->line('header_add'); ?></a></li>
              </ul>
            </li>
              
          </ul>
        </li>
        <?php
          }
        ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>












































