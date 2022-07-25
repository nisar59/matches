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
<h3 style="text-align:center"><u>Products Detail</u></h3>
<table style="width:100%;border-collapse: collapse;" border="1">
	<tr style="background: #6777ef;">
    <th style="color:white;">Image</th>
    <th style="color:white;">Name</th>
    <th style="color:white;">SKU</th>
    <th style="color:white;">Pricing Unit</th>
    <th style="color:white;">Price</th>
    <th style="color:white;">Category</th>
	</tr>
	<tbody>
		@foreach($data['products'] as $pro)				
		@php
        $path=public_path('img');
        $url=url('img');
        $img=$url.'/images.png';
        if(file_exists($path.'/products/'.$pro->image) AND $pro->image!=null){
        $img=$url.'/products/'.$pro->image;
        }
		@endphp
		<tr>
			<td>
				<img src="{{$img}}" width="50" height="50" style="border-radius: 10px; ">
			</td>
			<td>{{$pro->name}}</td>
            <td>{{$pro->sku}}</td>
			<td>@if($pro->UnitRel!=null)
                   {{$pro->UnitRel->name}}
                @endif
            </td>
            <td>{{$pro->price}}</td>
			<td>@if($pro->CategoryRel!=null)
                   {{$pro->CategoryRel->name}}
                @endif
            </td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
</body>
</html>