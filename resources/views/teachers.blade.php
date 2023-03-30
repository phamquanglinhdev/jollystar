@extends("layouts.client")
@section("content")
    <div class="container my-5">
        <div class="row">
            <div class="col-md-3 col-12 sticky-top">
                <div class="shadow p-3 rounded text-uppercase">
                    <form action="{{route("teachers")}}" method="post" id="filter">
                        @csrf
                        <input id="current-page" type="hidden" name="page" value="{{$page}}">
                        <div class="h4 text-primary">Lọc giáo viên</div>
                        <hr>
                        <div class="h5 mb-3">Theo nhu cầu học</div>
                        <div class="form-group">
                            @foreach($skills as $skill)
                                <div class="form-check">
                                    <input
                                        @if(in_array($skill->id,$select_skills))
                                            checked
                                        @endif
                                        class="form-check-input" name="skills[]" id="skill-{{$skill->id}}"
                                        type="checkbox"
                                        value="{{$skill->id}}"/>
                                    <label class="form-check-label" for="skill-{{$skill->id}}">{{$skill->name}}</label>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="h5 mb-3">Giáo viên</div>
                        <div class="form-group">
                            <div class="form-check">
                                <input
                                    @if(in_array(1,$select_origin))
                                        checked
                                    @endif
                                    class="form-check-input" name="origin[]" id="origin-1"
                                    type="checkbox"
                                    value="1"/>
                                <label class="form-check-label" for="origin-1">Giáo viên Việt Nam</label>
                            </div>
                            <div class="form-check">
                                <input
                                    @if(in_array(2,$select_origin))
                                        checked
                                    @endif
                                    class="form-check-input" name="origin[]" id="origin-2"
                                    type="checkbox"
                                    value="2"/>
                                <label class="form-check-label" for="origin-2">Giáo viên Nước ngoài</label>
                            </div>
                        </div>
                        <hr>
                        <div class="h5 mb-3">Mức học phí</div>
                        <label id="price-label" for="price" class="form-label">Từ 0
                            đến {{number_format($price*1000)}} đ / Giờ</label>
                        <div class="range mt-3">
                            <input value="{{$price}}" name="price" type="range" class="form-range" min="100"
                                   max="2000" step="10" id="price"/>
                        </div>
                        <hr>
                        <button class="w-100 btn btn-primary">Lọc giáo viên</button>
                    </form>
                </div>

            </div>
            <div class="col-md-9 col-12">
                <div class="p-3 text-center">
                    <nav aria-label="...">
                        <ul class="pagination">
                            @if($page>1)
                                <li class="page-item">
                                    <a class="page-link" onclick="pagination(1)">
                                        <i class="fas fa-step-backward"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" onclick="pagination({{$page-1}})">
                                        {{ $page-1 }}</a>
                                </li>
                            @endif
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="#">{{$page}} <span
                                        class="visually-hidden">(current)</span></a>
                            </li>
                            @if($page<$max_page)
                                <li class="page-item">
                                    <a class="page-link" onclick="pagination({{$page+1}})">
                                        {{ $page+1 }}</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" onclick="pagination({{$max_page}})">
                                        <i class="fas fa-step-forward"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <div class="p-2">
                    @if($teachers->count()>0)
                        @foreach($teachers as $teacher)
                            <div class="shadow mb-4 rounded">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="">
                                            <img src="{{$teacher->avatar}}" class="w-100 rounded-circle p-3">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="p-2">
                                            <div class="h3 text-primary mb-1">{{$teacher->name}}</div>
                                            <div class="mb-1">Kỹ năng dạy:
                                                @foreach($teacher->skills as $skill)
                                                    <span class="badge badge-primary">{{$skill->name}}</span>
                                                @endforeach
                                            </div>
                                            <div class="mb-1">Mức học phí:
                                                <span class="badge badge-primary">
                                                @if($teacher->price!=null && $teacher->price!=0)
                                                        {{number_format($teacher->price)}} đ / Giờ
                                                    @else
                                                        Liên hệ
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="mb-1">
                                            <span>Giáo viên :
                                                @if($teacher->origin==1)
                                                    Việt Nam
                                                    <img
                                                        class="rounded-circle"
                                                        style="width: 1em;height: 1em"
                                                        src="https://vectorflags.s3.amazonaws.com/flags/vn-button-01.png"
                                                    />
                                                @else
                                                    Nước ngoài
                                                @endif
                                            </span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        @if($teacher->video!=null)
                                            <div class="p-2">
                                                <div class="h3 text-primary">Video dạy mẫu</div>
                                                <a href="{{$teacher->video["url"]}}" target="_blank">
                                                    <img src="{{$teacher->video["image"]}}" class="w-100 rounded-3">
                                                </a>
                                                {{--                                        <div class="ratio ratio-16x9 rounded">--}}
                                                {{--                                            <iframe--}}
                                                {{--                                                class="rounded"--}}
                                                {{--                                                src="https://www.youtube.com/embed/{{$teacher->video["id"]}}"--}}
                                                {{--                                                title="{{$teacher->video["title"]}}"--}}
                                                {{--                                                allowfullscreen--}}
                                                {{--                                            ></iframe>--}}
                                                {{--                                        </div>--}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @include("components.empty")
                    @endif
                </div>
                <div class="p-3 text-center">
                    <nav aria-label="...">
                        <ul class="pagination">
                            @if($page>1)
                                <li class="page-item">
                                    <a class="page-link" onclick="pagination(1)">
                                        <i class="fas fa-step-backward"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" onclick="pagination({{$page-1}})">
                                        {{ $page-1 }}</a>
                                </li>
                            @endif
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="#">{{$page}} <span
                                        class="visually-hidden">(current)</span></a>
                            </li>
                            @if($page<$max_page)
                                <li class="page-item">
                                    <a class="page-link" onclick="pagination({{$page+1}})">
                                        {{ $page+1 }}</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" onclick="pagination({{$max_page}})">
                                        <i class="fas fa-step-forward"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("after_scripts")
    <script>
        $("#price").change((e) => {
            let price = "Từ 0 đến " + new Intl.NumberFormat().format(e.target.value) + ".000 đ/ Giờ"
            console.log(price)
            $("#price-label").text(price)
        })
        const pagination = (page) => {
            $("#current-page").val(page);
            $("#filter").submit();
        }
    </script>
@endsection
