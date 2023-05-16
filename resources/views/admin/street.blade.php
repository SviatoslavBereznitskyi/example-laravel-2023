<form action="{{route('admin.street.import')}}" method="POST">
    @csrf
    <h3>Street</h3>
    <div class="form-group">
        <label class="control-label"  for="type">City</label>
        <select class="form-control"  name="cityId" id="cityId" required>
            @foreach($cities as $city)
                <option value="{{$city->id}}">{{$city->name}}</option>
            @endforeach
        </select>
    </div>
    <input type="submit">
</form>
