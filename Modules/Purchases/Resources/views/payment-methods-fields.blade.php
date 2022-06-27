
@foreach($data['method']['fields'] as $key=> $fields)
@if($key=='input')
<div class="form-group">
<label>{{$fields['label']}}</label>
<input type="text" name="{{$fields['name']}}" class="form-control" placeholder="{{$fields['label']}}">
</div>
@elseif($key=='select')
<div class="form-group">
<label>{{$fields['label']}}</label>
<select name="{{$fields['name']}}" class="form-control">
@foreach($fields['options'] as $optn)
<option value="{{$optn}}">{{$optn}}</option>
@endforeach
</select>
</div>
@endif
@endforeach