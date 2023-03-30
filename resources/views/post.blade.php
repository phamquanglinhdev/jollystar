@extends("layouts.client")
@section("content")
    <style>
        .bg-poster {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url({{$post->thumbnail}});
        }
    </style>
    <div class="bg-poster p-lg-5 py-3 px-1">
        <div class="text-center text-white text-uppercase ">
            <div class="h1">{{$post->title}}</div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="p-3 mt-5 border rounded">
                    {!! $post->main_content !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 mt-5 border rounded">
                    <div class="text-primary h3 text-uppercase">Bài viết mới nhất</div>
                    <div class="mt-3">
                        @foreach($posts as $post)
                            <div class="mb-2">
                                <i class="fas fa-file-alt p-1"></i>
                                <a class="text-reset" href="{{route("post",["id"=>$post->id])}}">{{$post->title}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
