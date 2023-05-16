<form action="{{route('admin.metro.import')}}" method="POST">
    @csrf
    <h3>Metro</h3>
    <div class="form-group">
        <label class="control-label"  for="type">City</label>
        <select class="form-control"  name="cityId" id="cityId" required>
            @foreach($cities as $city)
                <option value="{{$city->id}}">{{$city->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="control-label"  for="type">Data</label>
        <textarea class="form-control"  name="data" id="data" required style="width:700px; height: 200px"></textarea>
    </div>
    <input type="submit">
</form>
