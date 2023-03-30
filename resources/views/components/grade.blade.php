<div class="container-fluid mt-5">
    <div class="h3">
        Thông tin lớp đang học
    </div>

    <div class="container-fluid mt-3">
        <div><i class="lab la-first-order-alt"></i> Tên lớp: {{$grade->name}}</div>
        <div><i class="lab la-first-order-alt"></i> Chương trình học: {{$grade->program}}</div>
        <div><i class="la la-clock"></i> Thời lượng học: {{$grade->time}} phút</div>
        <div><i class="la la-user"></i> Giáo viên:
            {{implode(",",$grade->teachers->pluck("name")->toArray())}}
        </div>
        <div><i class="la la-user"></i> Trợ giảng:
            {{implode(",",$grade->supporters->pluck("name")->toArray())}}
        </div>
        <div><i class="la la-user"></i> NV quản lý lớp:
            {{implode(",",$grade->staffs->pluck("name")->toArray())}}
        </div>
        <div><i class="las la-calendar-alt"></i> Lịch học :
            @foreach($grade->times as $time)
                @if($time["day"]!="")
                    <div class="ml-2"><i class="las la-stream"></i> {{\App\Untils\Trans::Week($time["day"])}} : {{$time["start"]}}-{{$time["end"]}}</div>
                @endif
            @endforeach
        </div>
        <div><i class="la la-calendar"></i> Ngày bắt đầu học: {{\Illuminate\Support\Carbon::parse($invoice->start)->isoFormat("DD-MM-YYYY")}}</div>
    </div>


</div>
