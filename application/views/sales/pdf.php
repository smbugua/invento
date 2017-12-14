<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
	<style>
		body{
			font-family: arial;
			font-size: 10px;
		}
      .table, th, td
      {
            border: 1px solid black;
      }
      .table td .table1 td
      {
            border: 1px solid black;
      }
      .table 
      {
          width: 70%;
      }
      .table table td
       {
            border: 0px solid black;
      }
      
  </style>
</head>
<body>
		<table align="center" class="table" style="border: 1px solid black; border-collapse: collapse">
			<tbody>
				<tr>
					<td colspan="6" align="center"><h3><!-- <?php  echo $company[0]->name;?> -->Tax Invoice</h3></td>
					<td colspan="6"></td>
				</tr>
				<tr>
						<td colspan="6" align="left" rowspan="2">
						<table width="330px">
							<tr>
								<td><img src="<?php echo base_url();?><?php echo $company[0]->logo;?>" alt="Company Logo" width="100" height="40"> 
								</td>
								<td><?php echo $data[0]->biller_company; ?><br>
									<?php echo $data[0]->biller_address; ?><br>
									Phone <?php echo $data[0]->biller_telephone; ?><br> 
									Fax <?php echo $data[0]->biller_fax; ?><br> 
									Email: <?php echo $data[0]->biller_email; ?></td>
								<td></td>
							</tr>
						</table>			
							
						<td colspan="6">
							<input type="checkbox" value="Original for Recipient">Original for Recipient<br>
							<input type="checkbox" value="Original for Recipient">Duplicate for Transport<br>
							<input type="checkbox" value="Original for Recipient">Triplicate for Supplier
						</td>
				</tr>
				<tr>
						
						<td colspan="6">GST NO:<?php echo $data[0]->customer_gstid;?><br>
										STATE: <?php echo $company[0]->state_name;?>
						</td>
				</tr>
				<tr>
					<td colspan="4">
						(Bill To)&nbsp;&nbsp;&nbsp;Registered Dealer
					</td>
					<td colspan="7"><!-- Invoice:<br> -->
						Invoice No:
						<?php echo $data[0]->invoice_no; ?>/GST&nbsp;&nbsp;&nbsp;
						Date:<?php echo $data[0]->invoice_date;?>
					</td>

				</tr>	
				<tr>
					
					<td colspan="4" >
						<?php echo $data[0]->biller_company; ?><br>
						<?php echo $data[0]->biller_address; ?><br>
						Phone <?php echo $data[0]->biller_telephone; ?><br> 
						Fax <?php echo $data[0]->biller_fax; ?><br> 
						Email: <?php echo $data[0]->biller_email; ?>
					</td>
					
					<td colspan="7">
					<table class="" width="400px">
						<tr>
							<td>Chalan No: <?php echo $data[0]->chalan_no; ?></td>
							<td>Indent No:<?php echo $data[0]->indent_no; ?></td>
						</tr>
						<tr>
							<td colspan="2">Broker:<?php echo $data[0]->broker; ?></td>
						</tr>
						<tr>
							<td>Credit Days:<?php echo $data[0]->credit_days; ?></td>
							<td>Due Date:<?php echo $data[0]->invoice_date;?></td>
						</tr>
							
					</table>		
					</td>
				</tr>
				
				
				<tr>
					<td colspan="4">
						<?php ?>(Shipped To)&nbsp;&nbsp;&nbsp;(place of Supply)
					</td>
					<td colspan="7" rowspan="2">
					<table border="0" width="400px">
						<tr>
							<td colspan="2">Transport:<?php echo $data[0]->transporter_name; ?></td>
						</tr>
						<tr>
							<td colspan="2">Date of Supply:<?php echo $data[0]->date; ?></td>
						</tr>
						<br><br>
						<tr>
							<td colspan="2">Place of Supply:<?php echo $data[0]->customer_address;?></td>
						</tr>
						<tr>
							<td>Lr.No:<?php echo $data[0]->l_r_no;?></td>
							<td>Date:<?php echo $data[0]->invoice_date;?></td>
						</tr>
						<tr>
							<td colspan="2">Electronic Ref.No:<?php echo $data[0]->electronic_ref_no;?></td>
						</tr>
						
					</table>		
					</td>
					
				</tr>	
				<tr>
					<td colspan="4">
						<?php echo $data[0]->customer_name; ?><br>
						<?php echo $data[0]->customer_address; ?><br>
						Mo. <?php echo $data[0]->customer_mobile; ?><br>  
						Email: <?php echo $data[0]->customer_email; ?>
					</td>

					
				</tr>

				<tr>
					<th style="width:5%">Sr.no</th>
					<th colspan="1">PRODUCT (or) ITEM</th>
					<th colspan="2">HSN/SAC</th>
					<th>UOM</th>
					<th>Size</th>
					<th>Pcs</th>
					<th >Rate</th>
					<th>Disc %</th>
					<th colspan="2">Amount</th>
					
					
				</tr>
				<?php $i = 1;$tot = 0;foreach ($items as $value) { ?>
				<tr>
					
					<td ><?php echo $i?></td>
					<td colspan="1"><?php echo $value->name; ?></td>
					<td colspan="2"><?php echo $value->hsn_sac_code; ?></td>
					<td><?php echo $value->unit;?></td>
					<td><?php echo $value->size;?></td>
					<td align="right"><?php echo $value->quantity;?></td>
					<td align="right" ><?php echo $value->price;?></td>
					
					
					<td align="right"><?php echo $value->discount_value; ?></td>
					<td align="right" colspan="2"><?php echo $value->gross_total; ?></td>
				</tr>
				
				<?php $i++;$tot += $value->gross_total; } ?>
				<tr>
					<td colspan="12" style="height: 50px;"></td>
				</tr>
				<tr>
					<td colspan="5"></td>
					<td colspan="3">Total Amount</td>
					
					<td align="right" colspan="4"> <?php echo $tot; ?></td>
				</tr>
				<tr>
					<td colspan="5"></td>
					<td colspan="3">Discount</td>
					
					<td align="right" colspan="4"> <?php echo $data[0]->discount_value; ?></td>
				</tr>


				<tr>
					<td colspan="5">Sales Remark : </td>
					<td colspan="3">Amount Before Tax</td>
					
					<td align="right" colspan="4"> <?php echo $tot-$data[0]->discount_value; ?></td>
				</tr>
				<tr>
					<td colspan="6" style="padding: : 0px;">
						<table style="border-collapse: collapse; width: 450px;" class="table1">
							<tr>
								<td rowspan="2" width="20%" align="center">HSN/SAC Code</td>
								<td rowspan="2" width="15%" align="center">Taxable Value</td>
								<td colspan="2" align="center">CGST</td>
								<td colspan="2" align="center">SGST</td>
								<td colspan="2" align="center">IGST</td>
							</tr>
							<tr>
								<td align="center">%</td>
								<td align="center">Amt.</td>
								<td align="center">%</td>
								<td align="center">Amt.</td>
								<td align="center">%</td>
								<td align="center">Amt.</td>
							</tr>
							<?php $i = 1;$tot = 0;foreach ($items as $value) { ?>
								<tr>
									<td><?php echo $value->hsn_sac_code; ?></td>
									<td align="right"><?php echo $value->gross_total - $value->discount; ?></td>
									<?php
									 
					            		if($company[0]->state_id == $data[0]->customer_state_id){
					            			echo "<td align='right'>".($value->tax_value/2)."</td>";
					            			echo "<td align='right'>".($value->tax/2)."</td>";
					            		} 
					            		else{
					            			echo "<td></td><td></td>";
					            		}
					            	?>
									<?php 
					            		if($company[0]->state_id == $data[0]->customer_state_id){
					            			echo "<td align='right'>".($value->tax_value/2)."</td>";
					            			echo "<td align='right'>".($value->tax/2)."</td>";
					            		} 
					            		else{
					            			echo "<td></td><td></td>";
					            		}
					            	?>
									<?php 
					            		if($company[0]->state_id != $data[0]->customer_state_id){
					            			echo "<td align='right'>".($value->tax_value)."</td>";
					            			echo "<td align='right'>".($value->tax)."</td>";
					            		} 
					            		else{
					            			echo "<td></td><td></td>";
					            		}
					            	?>
								</tr>
							<?php $i++;$tot += $value->gross_total; } ?>
						</table>
					</td>
					<td colspan="6" style="padding: 0px;">
						<table style="border-collapse: collapse; width:250px;">
							<tr>
								<td style="border-right: 1px solid black;">Add CGST :</td>
								<td align="right">
									<?php 
					            		if($company[0]->state_id == $data[0]->customer_state_id){
					            			echo $data[0]->tax_value/2;
					            		} 
					            		else{
					            			echo "0.00";
					            		}
					            	?>
								</td>
							</tr>
							<tr>
								<td style="border-right: 1px solid black;">Add SGST :</td>
								<td align="right">
									<?php 
					            		if($company[0]->state_id == $data[0]->customer_state_id){
					            			echo $data[0]->tax_value/2;
					            		} 
					            		else{
					            			echo "0.00";
					            		}
					            	?>
								</td>
							</tr>
							<tr>
								<td style="border-right: 1px solid black;">Add IGST :</td>
								<td align="right">
									<?php 
					            		if($company[0]->state_id != $data[0]->customer_state_id){
					            			echo $data[0]->tax_value;
					            		} 
					            		else{
					            			echo "0.00";
					            		}
					            	?>
								</td>
							</tr>
							<tr>
								<td style="border-right: 1px solid black;border-top: 1px solid black;">Tax Amount GST</td>
								<td align="right" style="border-top: 1px solid black;"><?php echo $data[0]->tax_value; ?></td>
							</tr>
							<tr>
								<td style="border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;">Round-off</td>
								<td align="right" style="border-top: 1px solid black;border-bottom: 1px solid black;"></td>
							</tr>
							<tr>
								<td>***Invoice Amount</td>
								<td align="right"><?php echo $data[0]->total; ?></td>
							</tr>
						</table>
					</td>
				</tr>
				
				
				 <tr>
					<td colspan="5">Total Amount(in words)<br><b><!-- INR Thirty Thousands Rupes Only -->
						<?php echo $this->numbertowords->convert_number($data[0]->total); ?>
						</b>
						<!-- Company's:&nbsp;&nbsp;&nbsp;Application --><br>			
					</td>
					<td colspan="7">GST Payable on Reverse Charge:
							<?php if($data[0]->gst_payable!=NULL)
								{
									echo $data[0]->gst_payable;
								}
								else
								{
									echo "No";
								}
							?>

					</td>
				</tr>
				<tr>
					<td colspan="12">Company's Bank Details: 
									Bank Name : <?php echo $company[0]->bank_name;?>
									Account No: <?php echo $company[0]->account_no;?>
									Branch $ IFSC code:<?php echo $company[0]->branch_ifsccode;?>
					</td>
				</tr>
				<tr>
					<td colspan="5" style="font-size: 10px;"><b>Subject To Mumbai Jurisdiction</b>
						<?php echo $company[0]->terms_condition;?><br>
					</td>					
					<td colspan="7">
						<table>
							<tr>
								<td align="center" colspan="2" style="font-size: 10px;">Certified that the particulars are given above are true and correct</td>
							</tr>
							<tr>
								<td align="center" colspan="2" style="font-size: 12px;"><b>For LEEDS</b><br><br><br><br><br></td>
							</tr>
							<tr>
								<td align="center" style="font-size: 12px;"> <b>Authorised Signatory</b></td>
								<td style="font-size: 12px;" align="right"><b>E.& O.E.</b></td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
	</table>		
</body>
</html>
<script>
  window.print();
</script>