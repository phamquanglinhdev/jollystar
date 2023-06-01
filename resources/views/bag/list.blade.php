@extends(backpack_view("blank"))
@section("content")
    <div class="my-3">
        <span class="h2">{{trans("backpack::crud.books")}}</span>
        <a href="#" onclick="{history.back()}" class="d-print-none font-sm"><i class="la la-angle-double-left"></i> Quay về  <span>trang trước</span></a>
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
                <div class="border px-3 py-5 rounded text-center bg-white">
                    <a href="{{url("admin/book/".$sub->id)}}" class="nav-link text-dark ">
                        <span class="h5 font-weight-bold text-center "> {{$sub->name}}</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        @foreach($bags->books as $book)
            <div class="col-md-2 col-sm-6 col-12 mb-3">
                <div class="shadow-lg">
                    <a href="{{$book->url}}" target="_blank" class="nav-link p-0 text-dark">
                        <div class="img-fluid">
                            <img src="{{$book->thumbnail}}" class="w-100 rounded">
                        </div>
                        <div class="p-3 rounded">
                            <div class="text-center h5">{{$book->name}}</div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

@endsection
