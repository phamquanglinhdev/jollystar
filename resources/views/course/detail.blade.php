@extends(backpack_view("blank"))

@section('content')
    <hr>
    <div class="h2 text-success text-uppercase font-weight-bold">{{$course->name}}</div>
    <div>
    </div>
    <div class="p-4 border rounded bg-white">{!! $course->description !!}</div>
    @foreach($course->lessons as $key => $item)
        <div class="mt-3">
            <div>
                <button  class="rounded-0 btn bg-secondary p-2 rounded w-100 text-left" data-toggle="collapse" href="#unit-{{$key}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i class="las la-ellipsis-v"></i> {{$item["unit"]}}
                </button>
                <div class="collapse show" id="unit-{{$key}}">
                    <div class="p-2 card card-body">
                        <div class="font-weight-bold">Nội dung :</div>
                        <div class="my-2">
                            {{$item["doc"]}}
                        </div>
                        <div><span class="font-weight-bold">Video</span>: <a class="nav-link d-inline" href="{{url($item["video"])}}"> <i class="lab la-youtube"></i> Click để mở</a></div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@stop
