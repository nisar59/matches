<?php
use Modules\Settings\Entities\Settings;
use Modules\Products\Entities\Products;
use Modules\Purchases\Entities\Purchases;
use Modules\Purchases\Entities\PurchasedProducts;
use Modules\Contacts\Entities\Contacts;
use App\Models\User;
use Modules\StockTransfer\Entities\StockTransfer;
use Modules\WarehousesAndShops\Entities\WarehousesAndShops;
use Modules\Expenses\Entities\Expenses;


function AllPermissions()
{
	$role=[];
	$role['users']=['view','add','edit','delete'];
	$role['permissions']=['view','add','edit','delete'];
	$role['contacts']=['view','add','edit','delete'];
	$role['category']=['view','add','edit','delete'];
	$role['units']=['view','add','edit','delete'];
	$role['warehousesandshops']=['view','add','edit','delete'];
	$role['products']=['view','add','edit','delete'];
	$role['purchases']=['view','add','edit','delete'];
	$role['stocktransfer']=['view','add','edit','delete'];
	$role['expenses']=['view','add','edit','delete'];
	$role['settings']=['view','add','edit','delete'];


return $role;

}

function FileUpload($img, $path){
	if($img==null){return null;}
	 $imgname=$img->getClientOriginalName();
	  if($img->move($path,$imgname)){
	  	return $imgname;
	  }
	  else{
	  	return null;
	  }
}

function Settings()
{
	return Settings::first();
}

function PaymentMethods()
{
	$payment_methods=[];

	$payment_methods=[

		'cash'=>[
			'title'=>'Cash',
			'fields'=>[],
		],
		'advance'=>[
			'title'=>'Advance',
			'fields'=>[],
		],

		'card'=>[
			'title'=>'Card',
			'fields'=>[
				'input'=>[
					'label'=>'Card holder name',
					'name'=>'card_holder_name',
				],
				'select'=>[
					'label'=>'Card Type',
					'name'=>'card_type',
					'options'=>[
						'Credit Card',
						'Debit Card',
						'Visa Card',
						'Master Card',
					],
				],
			],
		],

		'cheque'=>[
			'title'=>'Cheque',
			'fields'=>[
				'input'=>[
					'label'=>'Cheque No',
					'name'=>'cheque_no',
				],
			],
		],
		'bank_account'=>[
			'title'=>'Bank Transfer',
			'fields'=>[
				'input'=>[
					'label'=>'Bank Account No',
					'name'=>'bank_account_no',
				],
			],
		],
		'other'=>[
			'title'=>'Other',
			'fields'=>[
				'input'=>[
					'label'=>'Transcation No',
					'name'=>'transcation_no',
				],
			],
		]

	];

return $payment_methods;

}

function ShippingStatus()
{
	$ship=[
			"processing"=>"Processing",
			"pending"=>"Pending",
			"delivered"=>"Delivered",

	];

	return $ship;
}

function SKU()
{
	$sku=\Str::random(10);
	$pro=Products::where('sku',$sku)->count();
	if($pro){
	SKU();
	}
	else{
	return strtoupper($sku);
	}

}

function ReferenceNO()
{
	$rfno=\Str::random(10);
	$pro=Purchases::where('reference_no',$rfno)->count();
	if($pro){
	ReferenceNO();
	}
	else{
	return strtoupper($rfno);
	}
}

function TransferReferenceNO()
{
	$rfno=\Str::random(10);
	$pro=StockTransfer::where('transfer_reference_no',$rfno)->count();
	if($pro){
	TransferReferenceNO();
	}
	else{
	return strtoupper($rfno);
	}
}

function ExpenseReferenceNO()
{
	$rfno=\Str::random(10);
	$pro=Expenses::where('reference_no',$rfno)->count();
	if($pro){
	ExpenseReferenceNO();
	}
	else{
	return strtoupper($rfno);
	}
}


function Contact($id)
{
	$cont=Contacts::find($id);
	if($cont!=null){
		return $cont->name;
	}
}

function User($id)
{
	$user=User::find($id);
	if($user!=null){
		return $user->name;
	}
}

function ProductName($id)
{
	$pro=Products::find($id);
	if($pro!=null){
		return $pro->name;
	}

}


function PaymentStatus($total,$paid)
{
	if($paid<1){
		return 'due';
	}
	elseif($total==$paid){
		return 'paid';
	}
	else{
		return 'partial';
	}
}

function WarehousesAndShopsName($id)
{
	$wap=WarehousesAndShops::find($id);
	if($wap!=null){
		return $wap->name;
	}
}

function ExpensesCategories()
{
	
	$ec=[
	"Salary",
	"Rent",
	"Bill",
	"Tea/Coffee/Food",
	"Freight/Fare",
	"Other",
];
	return $ec;
}

