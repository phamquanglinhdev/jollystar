<div class="container border py-2 rounded">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="my-1 mb-3 h4 bg-success text-white p-2  rounded-3">
                Chia sẻ
            </div>
            <div>
                @foreach($share as $new)
                    <a class="nav-link text-success" href="{{route("post",["id"=>$new->id])}}">
                        <i class="fab fa-pinterest"></i>
                        {{$new->title}}
                    </a>
                @endforeach
                <hr>
                <a class="text-center smail text-success font-italic" href="{{route("posts")}}">Xem thêm</a>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="my-1 mb-3 h4 bg-success text-white p-2  rounded-3">
                Tin tức , sự kiện
            </div>
            <div>
                @foreach($events as $new)
                    <a class="nav-link text-success" href="{{route("post",["id"=>$new->id])}}">
                        <i class="fab fa-pinterest"></i>
                        {{$new->title}}
                    </a>
                @endforeach
                <hr>
                <a class="text-center smail text-success font-italic" href="{{route("posts")}}">Xem thêm</a>
            </div>
        </div>
    </div>
</div>
