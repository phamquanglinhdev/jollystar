@extends("layouts.client")
@section("content")
    <style>
        .bg-poster {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url({{$course->thumbnail??"https://i.wpimg.pl/660x440/i.wp.pl/a/f/jpeg/32547/pinterest-logo-mat-pras-660x440.jpeg"}});
        }
    </style>
    <div class="bg-poster p-lg-5 py-3 px-1">
        <div class="text-center text-white text-uppercase ">
            <div class="h4 text-primary mb-5">Khóa học</div>
            <div class="h1 ">{{$course->name}}</div>
            {{--            <button class="btn btn-primary mt-5">NHẬN TƯ VẤN NGAY</button>--}}
        </div>
    </div>
    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url("/")}}">Trang chủ</a></li>
{{--                <li class="breadcrumb-item"><a href="{{route("courses",['category'=>$course->category->id])}}">--}}
{{--                        {{$course->category->name}}--}}
{{--                    </a></li>--}}
                <li class="breadcrumb-item active" aria-current="page">{{$course->name}}</li>
            </ol>
        </nav>
    </div>
    <div class="py-5 border-top border-bottom container">
        <div class="mb-5">
            <div class="text-center h3 mb-3 text-uppercase">
                Giới thiệu
            </div>
            <div class="p-3">
                {!! $course->description  !!}
            </div>
        </div>
        <div class="mb-5">
            <div class="text-center h3 mb-3 text-uppercase">
                Nội dung khóa học
            </div>
            <ul class="list-group">
                @foreach($course->lessons as $lesson)
                    <li class="list-group-item">
                        <div class="font-weight-bold">{{$lesson["unit"]}}</div>
                        <div class="text-muted font-italic">{{$lesson["doc"]}}</div>
                        <a href="{{url($lesson["video"])}}" class="nav-link text-success">Xem video</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
