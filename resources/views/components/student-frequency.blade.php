<div class="container-fluid">
    @php
        $invoice = $user->CurrentInvoice();
        if(isset($invoice->id)){
            $logs = $invoice->Grade()->first()->Logs()->get();
        }
    @endphp
    <hr>
    @if(isset($invoice->id))
        <div class="my-2 h5">Lớp đang học: "{{$invoice->grade->name}}"</div>
    @endif
    <hr>
    @if(isset($invoice->id))
        @foreach($logs as $log)
            <a
                data-toggle="tooltip" data-placement="top" title="{{$log->lesson}}"
                href="{{route("log.show",$log->id)}}"
                class="btn {{$log->isPresent($user->id)?"btn-primary":"btn-secondary"}}">{{$log->no<10?"0".$log->no:$log->no}}</a>
        @endforeach
    @endif
    <hr>

</div>
