<tr>
	<td width="50%"><input type="hidden" class="products_ids" name="product_id[]" value="{{$data->id}}">{{$data->productRel->name}}</td>
	<td width="10%"><input type="number" class="form-control text-center unit_quantity" value="1" min="1" name="quantity[]"></td>
	<td width="10%"><input type="number" readonly class="form-control readonly border-0 unit_cost" value="{{$data->unit_cost}}"></td>
	<td width="20%"><input type="number" readonly class="form-control readonly border-0 net_cost" value="0.00"></td>
	<td width="10%" align="center"><a href="javascript:void(0)" onclick="$(this).parent().parent().remove();"><i class="fas fa-trash-alt"></i></a></td>
</tr>