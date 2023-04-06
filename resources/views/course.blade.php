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
            @foreach($course->lessons as $key => $lesson)
                <div class="mb-3">
                    <a
                        class="p-2 text-white text-left btn-primary w-100"
                        type="button"
                        data-mdb-toggle="collapse"
                        data-mdb-target="#lesson-{{$key}}"
                        aria-expanded="false"
                        aria-controls="collapseExample"
                    >
                        <i class="fa fa-list"></i>
                        {{$lesson['unit']}}
                    </a>

                    <!-- Collapsed content -->
                    <div class="collapse  border p-2" id="lesson-{{$key}}">
                        <div class="d-flex justify-content-between">
                            <div>
                                {{$lesson['doc']}}
                            </div>
                            <a target="_blank" href="{{url($lesson['video'])}}">
                                <i class="fa fa-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
