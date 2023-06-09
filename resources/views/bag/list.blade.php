@extends(backpack_view("blank"))
@section("content")
    <div class="my-3">
        <span class="h2">{{trans("backpack::crud.books")}}</span>
        <a href="#" onclick="{history.back()}" class="d-print-none font-sm"><i class="la la-angle-double-left"></i> Quay
            về <span>trang trước</span></a>
    </div>
    <hr>
    @if(backpack_user()->type<=0)
        <a href="{{backpack_url("book/create")}}" class="btn btn-primary text-white">
            <i class="las la-plus"></i>
            {{trans("backpack::crud.add")." ".trans("backpack::crud.book")}}
        </a>
    @endif
    <hr>
    <div class="h3 text-primary font-weight-bold">{{$bags->name}}</div>
    <hr>
    <div class="row">
        @foreach($bags->children as $sub)
            <div class="col-md-3 col-sm-6 col-12 mb-3">
                <div class="border px-3 py-5 rounded text-center  card-overlay h-100"
                     style="background: linear-gradient(rgba(0, 0, 0, {{$sub->opacity}}), rgba(0, 0, 0, {{$sub->opacity}})), url('{{$sub->thumbnail??"https://png.pngtree.com/thumb_back/fh260/background/20200809/pngtree-doodles-on-green-chalkboard-background-back-to-school-background-image_389839.jpg"}}')
                       ;background-size: cover;background-position:center;

                    "
                >
                    <a href="{{url("admin/book/".$sub->id)}}" class="nav-link text-white ">
                        <span class="h5 font-weight-bold text-center "> {{$sub->name}}

                        </span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        @foreach($bags->books as $book)
            <div class="col-md-2 col-sm-6 col-12 mb-3 ">
                <div class="shadow-lg h-100">
                    <a href="{{$book->url}}" target="_blank" class="nav-link p-0 text-dark">
                        <div class="img-fluid" style="position: relative">
                            <div style="position: absolute; z-index: 9999;right: 0;top:1%"
                                 class="d-flex flex-column">
                                <a class="p-1 bg-success " href="{{url($book->url)}}">
                                    <i class="la la-play la-2x shadow-lg text-white"></i>
                                </a>
                                @if(in_array(backpack_user()->role,["admin","staff","super"]))
                                    <a class="p-1 bg-primary " href="{{url("admin/book/$book->id/edit")}}">
                                        <i class="la la-pencil la-2x shadow-lg text-white"></i>
                                    </a>

                                    <form action="{{route("book.destroy",$book->id)}}" method="post">
                                        @method("DELETE")
                                        @csrf
                                        <button type="submit" class="btn p-1 bg-danger rounded-0">
                                            <i class="la la-trash la-2x shadow-lg text-white"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>


                            <img src="{{$book->thumbnail}}" class="w-100 rounded">
                        </div>
                        <div class="p-3 rounded">
                            <div class="text-center h5">
                                <span>
                                    {{$book->name}}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

@endsection
