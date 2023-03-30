<div>
    <div class="mb-1 font-weight-bold">Mô tả ngắn:</div>
    <div class="text-muted font-italic">{{$task->short}}</div>
    <hr>
    <div class="mb-2 font-weight-bold">Mô tả chi tiết:</div>
    <div>{!! $task->long !!}</div>
    <hr>
    <div class="mb-2 font-weight-bold">Deadline:</div>
    <div>{!! \Illuminate\Support\Carbon::parse($task->deadline)->isoFormat("DD/MM/YYYY HH:mm:ss") !!}</div>
    <hr>
    @if($task->staffs()->count()>0)
        <div class="mb-2 font-weight-bold">Nhân viên:</div>
        @foreach($task->staffs as $staff)
            <div>
                <span class="la la-user"></span> {{$staff->name}}
            </div>
        @endforeach
    @endif
    <hr>
    @include("task.comments",['task'=>$task])
</div>
