@extends("layouts.client")
@section("content")
    <div class="container my-5">
        <div class="text-center h3 text-uppercase my-5 text-primary">Thư viện sách ze education</div>
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="text-left shadow-lg p-2 mt-3">
                    <div class="py-2 text-uppercase h5 mb-3 rounded text-primary text-center">Danh mục sách</div>
                    @foreach($baskets as $basket)
                        <a
                            class="p-1 px-2  bg-primary text-white w-100 rounded mb-2"
                            type="button"
                            data-mdb-toggle="collapse"
                            data-mdb-target="#basket-{{$basket->id}}"
                            aria-expanded="false"
                            aria-controls="collapseExample"
                        >
                            <i class="fas fa-align-justify"></i>
                            {{$basket->name}}
                        </a>

                        <!-- Collapsed content -->
                        <div class="collapse mb-4 show" id="basket-{{$basket->id}}" style="padding-left: 20px">
                            @foreach($basket->Children as $child)
                                <div>
                                    <a href="{{route("library",["id"=>$child->id])}}" class="text-dark">
                                        <i class="fas fa-angle-double-right"></i>
                                        {{$child->name}} ({{$child->books->count()}})
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-9 col-12">
                <div class="p-2 my-2">
                    <div class="row">
                        @foreach($books as $book)
                            <div class="col-md-3 col-sm-6">
                                <div class="card mb-3">
                                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                        <img src="{{$book->thumbnail}}"
                                             class="img-fluid"/>
                                    </div>
                                    <div class="card-body p-2">
                                        {{--                                        <div class="card-title text-center">{{$book->name}}</div>--}}
                                        <a target="_blank" href="{{$book->url}}" data-mdb-toggle="tooltip"
                                           title="{{$book->name}}" class="w-100 btn btn-primary">Đọc</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
