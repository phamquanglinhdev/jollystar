<div class="from d-flex p-2 justify-content-end">
    <div class="p-1 d-flex justify-content-end">
        <div class="bg-primary p-2 rounded w-75 d-flex flex-column">
            <div class="mb-2">
               {{$chat->text}}
            </div>
            <div class="small align-self-start">
{{--                {{\Carbon\Carbon::parse($chat->created_at)->isoFormat("HH:mm")}}--}}
            </div>
        </div>
        <img
            src="{{$chat->user->avatar??"https://files.catbox.moe/mt8vsg.png"}}"
            style="width: 2em;height: 2em"
            class="border rounded-circle ml-1"
        >
    </div>
</div>
