<li class="task ui-state-default list-group-item border-0 shadow-lg mb-3 rounded"
    id="task-{{$task->id}}"
    style="cursor: pointer">
    <div class="d-flex justify-content-between align-items-center">
        <i class="las la-arrows-alt-v p-2"></i>
        <div class="text-left w-100">
            <div>{{$task->title}}</div>
            <div class="text-muted small">
                <div>
                    <span class="la la-clock"></span>
                    <span>{{\Illuminate\Support\Carbon::parse($task->deadline)->isoFormat("DD/MM/YYYY HH:mm")}}</span>
                </div>
                @if($task->staffs()->count()>0)
                    <div>
                        <span class="la la-user"></span>
                        <span>{{\Illuminate\Support\Str::limit(implode(",",$task->staffs->pluck("name")->toArray()),40)}}</span>
                    </div>
                @endif
            </div>
        </div>
        @if($task->status=="waiting")
            <div>
                <i class="la la-check-circle bg-success p-1 rounded-circle m-1" type="done"></i>
            </div>
            <div>
                <i class="la la-trash bg-danger p-1 rounded-circle m-1" type="cancel"></i>
            </div>

        @endif
        @if($task->status=="done")
            <div>
                <i class="la la-history bg-primary p-1 rounded-circle m-1" type="waiting"></i>
            </div>
        @endif
        @if($task->status=="cancel")
            <div>
                <i class="la la-history bg-primary p-1 rounded-circle m-1" type="waiting"></i>
            </div>
        @endif
        @if(backpack_user()->role!="staff")
            <a href="{{backpack_url("task/$task->id/edit")}}" type="edit">
                <i class="la la-pencil bg-secondary p-1 rounded-circle m-1" type="edit"></i>
            </a>
        @endif
    </div>
</li>

