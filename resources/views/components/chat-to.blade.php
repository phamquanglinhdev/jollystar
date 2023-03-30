<div class="to d-flex p-2 justify-content-start">
    <div class="p-1 d-flex justify-content-start">
        <img
            src="{{$chat->user->avatar??"https://files.catbox.moe/mt8vsg.png"}}"
            style="width: 2em;height: 2em"
            class="border rounded-circle mr-1"
        >
        <div>
            <div class="small text-muted">{{$chat->user->name}}</div>
            <div class="bg-secondary p-2 rounded w-75 d-flex flex-column">

                <div>
                    {{$chat->text}}
                </div>
                <div class="small float-right align-self-end text-muted">
                    {{--                {{\Carbon\Carbon::parse($chat->created_at)->isoFormat("HH:mm")}}--}}
                </div>
            </div>
        </div>
    </div>
</div>
