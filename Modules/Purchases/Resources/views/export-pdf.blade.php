<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<style type="text/css">
	th, td{
		padding: 5px;
		border:1px solid silver;
	}
</style>
<body>
<div style="text-align:center">
<img src="{{url('public/img/settings/'.Settings()->portal_logo)}}" style="width: 80px;">
<h1 style="text-align:center; margin: 0px;">{{Settings()->portal_name}}</h1>
<p style="margin:0px;">Email: {{Settings()->portal_email}}</p><hr>
<h3 style="text-align:center"><u>Purchases Detail</u></h3>
<table style="width:100%;border-collapse: collapse;" border="1">
	<tr style="background: #6777ef;">
    <th style="color:white;">Vendor</th>
    <th style="color:white;">Date</th>
    <th style="color:white;">Reference No</th>
    <th style="color:white;">Total Items</th>
    <th style="color:white;">Gross Total</th>
    <th style="color:white;">Net Discount</th>
    <th style="color:white;">Shipping Charges</th>
    <th style="color:white;">Purchase Total</th>
    <th style="color:white;">Payment Amount</th>
    <th style="color:white;">Due</th>
    <th style="color:white;">Payment Status</th>
    <th style="color:white;">Shipping Status</th>
    <th style="color:white;">Added By</th>
	</tr>
	<tbody>
		@php
		$items=0;
		$gtotal=0;
		$discount=0;
		$shipping=0;
		$purchase=0;
		$payment=0;
		$due=0;
		@endphp
		@foreach($data['purchases'] as $purch)
		@php
		$items+=$purch->total_items;
		$gtotal+=$purch->gross_total;
		$discount+=$purch->net_discount;
		$shipping+=$purch->shipping_charges;
		$purchase+=$purch->purchase_total;
		$payment+=$purch->payment_amount;
		$due+=$purch->due;
		@endphp				
		<tr>
			<td>{{Contact($purch->vendor)}}</td>
            <td>{{$purch->order_date}}</td>
            <td>{{$purch->reference_no}}</td>
            <td>{{$purch->total_items}}</td>
            <td>{{$purch->gross_total}}</td>
            <td>{{$purch->net_discount}}</td>
            <td>{{$purch->shipping_charges}}</td>
            <td>{{$purch->purchase_total}}</td>
            <td>{{$purch->payment_amount}}</td>
            <td>{{$purch->due}}</td>
            <td>{{ucfirst($purch->payment_status)}}</td>
            <td>{{ucfirst($purch->shipping_status)}}</td>
            <td>{{User($purch->added_by)}}</td>
		</tr>
		@endforeach
		<tr style="background:#6777ef">
			<th style="color:white;" colspan="3">Total</th>
			<td style="color:white;">{{$items}}</td>
			<td style="color:white;">{{$gtotal}}</td>
			<td style="color:white;">{{$discount}}</td>
			<td style="color:white;">{{$shipping}}</td>
			<td style="color:white;">{{$purchase}}</td>
			<td style="color:white;">{{$payment}}</td>
			<td style="color:white;" colspan="4">{{$due}}</td>
		</tr>
	</tbody>
</table>
</div>
</body>
</html>