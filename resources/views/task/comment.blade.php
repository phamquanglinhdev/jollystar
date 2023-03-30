<div class=" p-2 rounded mb-1 border">
    <div class="font-weight-bold">
        <span>
            <i class="la la-user"></i>
        </span>
        <span>
            {{$answer->user->name}}
        </span>
    </div>
    <div class="">{{$answer->text}}</div>
    <div class="small">{{\Illuminate\Support\Carbon::parse($answer->created_at)->isoFormat("DD/MM/YYYY HH:mm")}}</div>
</div>
