<?php
require_once('dompdf/pdf.php');
require_once('appcode/db_connection.php');

$restaurant = $conn->prepare("select * from restaurant_table where restaurant_id = ?");
$restaurant->execute(array($_GET["id"]));
$restaurant_data = $restaurant->fetchAll();

$order = $conn->prepare("select * from order_item_table where order_id = ?");
$order->execute(array(ltrim($_GET["order_table"],"Table ")));
$order_data = $order->fetchAll();

$order_table = $conn->prepare("select * from order_table where order_table = ?");
$order_table->execute(array($_GET["order_table"]));
$getOrder = $order_table->fetchAll();


$filename = '';

if(isset($_POST["print"]))
{

	

	$output = '
	<table width="100%" border="0" cellpadding="5" cellspacing="5" style="font-family:Arial, san-sarif">';

	foreach($restaurant_data as $row)
	{

		$output .= '
		<tr>
			<td align="center">
				<b style="font-size:32px">'.$row["restaurant_name"].'</b>
				<br />
				<span style="font-size:20px;">'.$row["restaurant_tag_line"].'</span>
				<br /><br />
				<span style="font-size:16px;">'.$row["restaurant_address"].'</span>
				<br />
				<span style="font-size:16px;"><b>Contact No. - </b>'.$row["restaurant_contact_no"].'</span>
				<br />
				<span style="font-size:16px;"><b>Email - </b>'.$row["restaurant_email"].'</span>
				<br /><br />
			</td>
		</tr>
		';

	}

	foreach($getOrder as $order)
	{
		$filename = $order["order_number"].'.pdf';

		$sql = $conn->prepare("update order_table set order_cashier = ? , order_status = ? where order_number = ?");
		$sql->execute(array($_GET['order_cashier'],'Completed',$order['order_number']));

	$output .= ' <tr>
	<td>
		<table width="100%" border="0" cellpadding="5" cellspacing="5">
			<tr>
				<td width="30%"><b>Bill No:- </b>'.$order["order_number"].'</td>
				<td width="30%"><b>Table No:- </b>'.$order["order_table"].'</td>
				<td width="20%" align="right"><b>Date:- </b>'.$order["order_date"].'</td>
				<td width="20%" align="right"><b>Time:- </b>'.$order["order_time"].'</td>
			</tr>
		</table>
	</td>
</tr>';

		$output .= '
			<tr>
				<td>
					<table width="100%" border="1" cellpadding="10" cellspacing="0">
						<tr>
							<th width="10%">Sr#</th>
							<th width="45%">Item</th>
							<th width="10%">Qty.</th>
							<th width="20%">Price</th>
							<th width="15%">Amount</th>
						</tr>';


		$count = 0;
		foreach($order_data as $item)
		{
			$count++;
			$output .= '
						<tr>
						 <td>'.$count.'</td>
							<td>'.$item["product_name"].'</td>
							<td>'.$item["product_quantity"].'</td>
							<td>'.$item["product_rate"].'</td>
							<td>'.$item["product_amount"].'</td>
						</tr>
						
			';
		}

		$order_id = ltrim($_GET["order_table"],"Table ");

		$sql = $conn->prepare("select * from order_tax_table where order_id = '".$order_id."'");

		$tax_result = $sql->execute();

		$total_tax_row = $sql->fetchColumn();

		$rowspan = 2 + $total_tax_row;

		$tax_result = $sql->fetchAll();

		$output .= '
						<tr>
							<td rowspan="'.$rowspan.'" colspan="3">
							<b>Cashier : </b>'.$_GET['order_cashier'].'
							</td>
							<td align="right"><b>Gross Total</b></td>
							<td>'.$order["order_gross_amount"].'</td>
						</tr>
		';

		foreach($tax_result as $tax)
		{
			$output .= '
						<tr>
							<td align="right"><b>'.$tax["order_tax_name"].' ('.$tax["order_tax_percentage"].'%)</b></td>
							<td>'.$tax["order_tax_amount"].'</td>
						</tr>
			';
		}

		$output .= '
						<tr>
							<td align="right"><b>Net Amount</b></td>
							<td>'.$order["order_net_amount"].'</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center">Thank you, Please come again</td>
			</tr>
			';


	

}


	$output .= "</table>";

	$pdf = new Pdf();

	$pdf->loadHtml($output, 'UTF-8');
	$pdf->render();
	$pdf->stream($filename, array( 'Attachment'=>0 ));
	exit(0);

}

?>
