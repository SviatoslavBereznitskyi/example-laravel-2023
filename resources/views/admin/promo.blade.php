<form action="{{route('admin.promocodes.generate')}}" method="POST">
    @csrf
    <h3>Generate promo codes </h3>
    <div class="form-group">
        <label class="control-label"  for="value">Value</label>
        <input class="form-control"  type="number" name="value" id="value" required>
    </div>
    <div class="form-group">
        <label class="control-label"  for="qty">Quantity</label>
        <input class="form-control"  type="number" name="qty" id="qty" required>
    </div>
    <div class="form-group">
        <label class="control-label"  for="template">Template for promo</label>
        <input class="form-control" type="text" name="template" id="template" required>
        <small class="form-element-helptext">Use # for number and @ for letters.</small>
        <small class="form-element-helptext">Example: ###@-@##, will generate 111n-j11</small>
    </div>
    <div class="form-group">
        <label class="control-label"  for="type">Type</label>
        <select class="form-control"  name="type" id="type" required>
            @foreach($types as $key => $type)
                <option value="{{$key}}">{{$type}}</option>
            @endforeach
        </select>
    </div>
    <input type="submit">
</form>
