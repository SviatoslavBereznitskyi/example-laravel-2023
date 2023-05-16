<h5>Images:</h5>
<div style="display: flex; flex-wrap: wrap">
@foreach($model->images as $image)
    <div style="margin: 10px 10px 20px 10px; width: 40%">
        <h6>{{$image->type}}</h6>
        <div style="width: 200px; height: 150px; object-fit:cover">
            <a href="{{Storage::disk('s3-public')->url($image->path)}}}}" target="_blank">
                <img style="width: 100%; height: 100%" src="{{Storage::disk('s3-public')->url($image->path)}}" alt="">
            </a>
        </div>
    </div>
@endforeach
</div>
