@php
    use App\Models\Post;
    if(in_array(backpack_user()->role,["admin","super"])){
        $posts = Post::orderBy("pin","DESC")->get();
    }else{
        $posts = Post::where("roles","like","%".backpack_user()->role."%")->orderBy("pin","DESC")->get();
    }
@endphp
@extends(backpack_view('blank'))
@section('content')
    @if(\Illuminate\Support\Facades\Cookie::get("origin")!=backpack_user()->origin)
        @if(backpack_user()->role!="super")
            <script>
                window.location.reload()
            </script>
        @endif
    @endif
    {{--    @include("components.profile",['user'=>backpack_user()])--}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="border rounded p-3 bg-white">
                    @if(backpack_user()->role=="teacher")
                        @include("components.profile",["user"=>backpack_user()])
                        @include("components.calendar",["user"=>App\Models\Teacher::find(backpack_user()->id)])
                    @endif
                    @if(backpack_user()->role=="student")
                        @include("components.profile",["user"=>backpack_user()])
                        @include("components.student-frequency",["user"=>App\Models\Student::find(backpack_user()->id)])
                        <div class="h5 container-fluid">Lịch học</div>
                        @include("components.calendar",["user"=>App\Models\Student::find(backpack_user()->id)])
                            <div class="p-1 my-2">
                                @include("components.single-log",["user"=>App\Models\Student::find(backpack_user()->id)])
                            </div>
                    @endif
                    @if(in_array(backpack_user()->role,["admin","super"]))
                        @include("components.admin-dashboard")
                    @endif
                    @include("components.posts_dashboard",['posts'=>$posts])

                </div>
            </div>
        </div>
    </div>
@endsection
