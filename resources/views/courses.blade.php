@extends("layouts.client")
@section("content")
    <div class="text-center p-5">
        <div class="h3">Danh sách khóa học của ZE Education</div>
    </div>
{{--    <div class="container pb-5 text-center">--}}
{{--        @if(empty($curentCategory))--}}
{{--            <a href="{{route("courses")}}" class="btn-primary btn">Tất cả</a>--}}
{{--        @else--}}
{{--            <a href="{{route("courses")}}" class="btn-secondary btn">Tất cả</a>--}}
{{--        @endif--}}
{{--        @foreach($categories as $category)--}}
{{--            @if($category==$curentCategory)--}}
{{--                <a href="{{route("courses",["category"=>$category->id])}}"--}}
{{--                   class="btn-primary btn">{{$category->name}}</a>--}}
{{--            @else--}}
{{--                <a href="{{route("courses",["category"=>$category->id])}}"--}}
{{--                   class="btn-secondary btn">{{$category->name}}</a>--}}
{{--            @endif--}}
{{--        @endforeach--}}
{{--    </div>--}}
    <div class="container mb-5">
        @if($courses->count()!=0)
            <div class="row">
                @foreach($courses as $course)
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="{{route("course",["id"=>$course->id])}}" class="text-reset">
                            <div class="card">
                                <img src="{{$course->thumbnail??"https://i.wpimg.pl/660x440/i.wp.pl/a/f/jpeg/32547/pinterest-logo-mat-pras-660x440.jpeg"}}" class="card-img-top"
                                     alt="{{$course->name}}"/>
                                <div class="card-body">
                                    <div
                                        class="h5 text-primary">{{\Illuminate\Support\Str::limit($course->name,20)}}</div>
{{--                                    <p class="card-text">--}}
{{--                                        {{\Illuminate\Support\Str::limit($course->description,125)}}--}}
{{--                                    </p>--}}
{{--                                    <div>--}}
{{--                                        <span>Danh mục :</span>--}}
{{--                                        <a href="#"><span class="text-primary small">{{$course->category->name}}</span></a>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <span>Nhãn :</span>--}}
{{--                                        @forelse($course->tags as $tag)--}}
{{--                                            <a href="#"><span class="text-primary small">{{$tag->name}}</span></a>--}}
{{--                                        @empty--}}
{{--                                            <span>Không có</span>--}}
{{--                                        @endforelse--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
{{--            @include("components.empty")--}}
        @endif
    </div>
@endsection
