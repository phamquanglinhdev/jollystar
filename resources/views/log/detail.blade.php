@extends(backpack_view("blank"))

@section('content')
    <div class="container-fluid">
        <ul class="list-group">
            <li class="list-group-item">
                <div>
                    <span class="font-weight-bold">Giáo viên</span>
                    : {{$log->teacher->name}}</div>
            </li>
            <li class="list-group-item">
                <div><span class="font-weight-bold">Buổi {{$log->no}}</span> : {{$log->lesson}}</div>
            </li>
            <li class="list-group-item">
                <span class="font-weight-bold">Thời gian </span> :
                Ngày <span
                    class="font-weight-bold">{{\Carbon\Carbon::parse($log->date)->isoFormat("DD-MM-YYYY")}}</span>
                từ <span class="font-weight-bold">{{\Carbon\Carbon::parse($log->start)->isoFormat("HH:mm")}}</span>
                đến <span class="font-weight-bold">{{\Carbon\Carbon::parse($log->end)->isoFormat("HH:mm")}}</span>
            </li>
            <li class="list-group-item">
                <div class="font-weight-bold mb-2">Điểm danh:</div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">Học sinh</th>
                        <th scope="col" class="text-center">Tham gia học</th>
                        <th scope="col" class="text-center">Nhận xét</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($log->students??[] as $item)
                        <tr>
                            <td>{{$item["name"]}}</td>
                            <td class="text-center">
                                @if($item["present"]==1)
                                    <img
                                        src="{{asset("images/check.ico")}}"
                                        style="width: 2em;height: 2em">
                                @else
                                    <img
                                        src="{{asset("images/cancel.png")}}"
                                        style="width: 2em;height: 2em">
                                @endif

                            </td>
                            <td>{{$item["comment"]}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </li>
            @if(backpack_user()->role!="student")
                <li class="list-group-item">
                    <span class="font-weight-bold">Lương theo giờ: </span>
                    {{number_format($log->salary_per_hour)}} đ
                </li>
            @endif
            @if($log->video!=null)
                <li class="list-group-item">
                    <div class="font-weight-bold mb-2">Video buổi học:</div>
                    <div class="col-md-6">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item rounded"
                                    src="https://www.youtube.com/embed/{{json_decode($log->video)->id}}"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                </li>
            @endif
            <li class="list-group-item">
                <span class="font-weight-bold">Nhận xét của giáo viên: </span>
                {{$log->teacher_comment}}
            </li>
            <li class="list-group-item">
                <span class="font-weight-bold">Bài tập: </span>
                {{$log->question}}
            </li>
            @if($log->attachments!=null)
                <li class="list-group-item">
                    <span class="font-weight-bold">Đính kèm: </span>
                    <a href="{{$log->attachments}}" class="nav-link d-inline"><i class="las la-cloud-download-alt"></i> Tải xuống</a>
                </li>
            @endif
        </ul>
    </div>
@stop
