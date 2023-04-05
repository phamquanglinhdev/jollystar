@extends("layouts.client")
@section("content")
    <div class="container">
        <div class="text-center h3 text-primary p-lg-5 p-2">SỰ KIỆN</div>
        <div class="row">
            @forelse($posts as $post)
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{\Illuminate\Support\Str::limit($post->title,45)}}</h5>
                            <div class="card-text">Ngày đăng
                                : {{\Carbon\Carbon::make($post->updated_at)->isoFormat("DD-MM-YYYY")}}</div>
                            <div class="card-text mb-2">Giờ đăng
                                : {{\Carbon\Carbon::make($post->updated_at)->isoFormat("HH:mm:ss")}}</div>
                            <a href="{{route("post",["id"=>$post->id])}}" class="btn btn-primary w-100">Xem ngay</a>
                        </div>
                    </div>
                </div>
            @empty
                @include("components.empty")
            @endforelse
        </div>
    </div>
@endsection
