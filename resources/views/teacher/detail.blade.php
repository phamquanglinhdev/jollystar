@extends(backpack_view("blank"))

@section('content')
    @include("components.profile",["user"=>$entry])
    @include("components.teacher-action",["user"=>$entry])
    @include("components.calendar",["user"=>$entry])
@stop
