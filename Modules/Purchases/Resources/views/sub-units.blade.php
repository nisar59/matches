      <div class="row col-md-12">
        <div class="col-md-7">
          <label>Unit</label>
          <select class="form-control" name="subunits[{{$data['proid']}}][]">
            @foreach($data['units'] as $unit)
            <option value="{{$unit->id}}">{{$unit->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label>Sub Unit Quantity</label>
          <input type="number" min="0" class="form-control" name="subunitsquantity[{{$data['proid']}}][]">
        </div>
        <div class="col-md-1 pt-4">
          <a href="javascript:void(0)" onclick="$(this).parent().parent().remove()" class="btn btn-danger mt-2"><i class="fas fa-expand-arrows-alt"></i></a>
        </div>
      </div>