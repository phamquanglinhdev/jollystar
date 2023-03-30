@extends(backpack_view("blank"))

@section('content')
    <style>
        .animated {
            height: 100%;
        }

        .container-fluid {
            padding: 0.2em !important;
        }
    </style>
    <div class="container-fluid p-0 h-100 message-board">
        <div class="row py-2 h-100">
            <div class="col-lg-3 col-md-4 col-sm-6 d-lg-block d-none border-right border-left h-100">
                <div class="">
                    @if($conversations!=null)
                        @foreach($conversations as $conversation)
                            <a href="{{route("message.index",["conversation"=>$conversation->id])}}"
                               class="nav-link p-0 text-dark">
                                <div class="p-lg-2 p-0 bg-white mb-2">
                                    <div class="font-weight-bold text-capitalize">{{$conversation->name}}</div>
                                    <div class="text-muted font-italic small">
                                        {{$conversation->chats->last()->user->name??"Hãy nhắn gì đó..."}}
                                        :
                                        {{$conversation->chats->last()!=null?\Illuminate\Support\Str::limit($conversation->chats->last()->text,20):""}}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
            @if(isset($current->name))
                <div class="col-lg-9 col-md-12 col-12 h-100">
                    <div class="bg-white h-100 d-flex flex-column p-lg-3 p-0">
                        <div class="px-2 pt-2 rounded-top bg-primary">
                            <div class="h4">{{$current->name}}</div>
                        </div>
                        <div class="flex-grow-1 border mb-2 rounded d-flex justify-content-end flex-column"
                             style="height: 100px!important;">
                            {{--                        Chat--}}
                            <div id="bottom" class="chat-scroll" style="overflow-y:scroll ">
                                @foreach($current->Chats()->get() as $chat)
                                    @if($chat->user_id!=backpack_user()->id)
                                        @include("components.chat-to",["chat"=>$chat])
                                    @else
                                        @include("components.chat-from",["chat"=>$chat])
                                    @endif
                                @endforeach
                            </div>
                            {{--                        Chat--}}
                        </div>
                        <form name="send-message" action="{{route("message.send")}}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input id="text" type="text" class="form-control" placeholder="Nhắn gì đó nào">
                                <div type="submit" class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="las la-paper-plane"></i>
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop
@section("after_scripts")
    @if(isset($current->name))
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

        <script>
            function scrollToBot() {
                $("#bottom").animate({scrollTop: $('#bottom').prop("scrollHeight")}, 1000);
            }

            let conversation_id = {{$current->id}}
            $(document).ready(function () {
                scrollToBot()
                const pusher = new Pusher("1135ea099ddcaccb13e0", {
                    cluster: "ap1",
                });
                const channel = pusher.subscribe('conversation-' + conversation_id);
                channel.bind('App\\Events\\SendMessage', function (data) {
                    if (data.chat.user_id != {{backpack_user()->id}}) {
                        $(".chat-scroll").append(data.view)
                        scrollToBot()
                    }
                });
                $("form").submit(function (event) {
                    let formData = {
                        conversation_id: conversation_id,
                        text: $("#text").val(),
                        _token: "{!! csrf_token() !!}",
                    };

                    $.ajax({
                        type: "POST",
                        url: "{{route("message.send")}}",
                        data: formData,
                        dataType: "html",
                        encode: true,
                    }).done(function (data) {
                        console.log(data)
                        $(".chat-scroll").append(data)
                        scrollToBot()
                    })
                    $("#text").val("")
                    event.preventDefault();
                });
            });
        </script>
    @endif
@endsection
