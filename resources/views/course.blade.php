@extends("layouts.client")
@section("content")
    <style>
        .bg-poster {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url({{$course->thumbnail}});
        }
    </style>
    <div class="bg-poster p-lg-5 py-3 px-1">
        <div class="text-center text-white text-uppercase ">
            <div class="h4 text-primary mb-5">Khóa học</div>
            <div class="h1 ">{{$course->name}}</div>
            <div class="pt-2 pt-lg-4 w-50 m-auto">{!! $course->description !!}</div>
            <button class="btn btn-primary mt-5">NHẬN TƯ VẤN NGAY</button>
        </div>
    </div>
    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url("/")}}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{route("courses",['category'=>$course->category->id])}}">
                        {{$course->category->name}}
                    </a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$course->name}}</li>
            </ol>
        </nav>
    </div>
    <div class="py-5 border-top border-bottom container">
        <div class="mb-5">
            <div class="text-center h3 mb-3 text-uppercase">
                Nội dung chính
            </div>
            <div class="p-3 rounded shadow">
                {!! $course->main_content !!}
            </div>
        </div>
        <div class="mb-5">
            <div class="text-center h3 mb-3 text-uppercase">
                Phương pháp học
            </div>
            <div class="p-3 rounded shadow">
                {!! $course->learn_method !!}
            </div>
        </div>
    </div>
@endsection
