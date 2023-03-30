@extends(backpack_view("blank"))

@section('content')
    <div class="container-fluid">
        <div class="h2">Chi tiết lớp học</div>
    </div>
    <hr>
    @include("components.profile",["user"=>$entry])
    <hr>
@stop
