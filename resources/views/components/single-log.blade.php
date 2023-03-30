@php
    $invoice = $user->CurrentInvoice();
    if(isset($invoice->id)){
        $logs = $invoice->Grade()->first()->Logs()->get();
    }
@endphp
<hr>
<div style="overflow: scroll">
    <div style="min-width: 1000px;max-height:300px ">
        <table class="table table-bordered">
            <thead>
            <tr class="text-center">
                <th scope="col">Buổi</th>
                <th scope="col">Ngày</th>
                <th scope="col">Bài học</th>
                <th scope="col">Giáo viên</th>
                <th scope="col">Tình trạng</th>
                <th scope="col">Đánh giá của giáo viên</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($invoice->id))
                @foreach($logs as $log)
                    <tr class="text-center">
                        <td class="text-center">{{$log->no}}</td>
                        <td>{{\Carbon\Carbon::parse($log->date)->isoFormat("DD-MM-YYYY")}}</td>
                        <td>{{$log->lesson}}</td>
                        <td>{{$log->Teacher->name}}</td>
                        <td class="text-center">
                            @if($log->isPresent($user->id))
                                <img
                                    src="{{asset("images/check.ico")}}"
                                    style="width: 2em;height: 2em">
                            @else
                                <img
                                    src="{{asset("images/cancel.png")}}"
                                    style="width: 2em;height: 2em">
                            @endif
                        </td>
                        <td class="text-left">
                            @foreach($log->students as  $student)
                                @if($student["name"]==$user->name)
                                    {{$student["comment"]}}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
            <tfoot>
            <tr class="text-center">
                <th scope="col">Buổi</th>
                <th scope="col">Ngày</th>
                <th scope="col">Bài học</th>
                <th scope="col">Giáo viên</th>
                <th scope="col">Tình trạng</th>
                <th scope="col">Đánh giá của giáo viên</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

