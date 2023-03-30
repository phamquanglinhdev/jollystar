<div class="container-fluid mt-5">
    <div class="h3">
        Lộ trình học
    </div>

    <div class="container-fluid mt-3">
        @foreach($invoices as $item)
            <div class="d-flex align-items-center item mb-2">
                <div class="bg-success rounded-circle" style="width: 1em;height: 1em"></div>
                <div class="ml-2">
                    <span class="font-weight-bold">
                       Lớp  "{{$item->grade->name}}"
                    </span>
                    <span class="font-italic ml-2">
                         Ngày bắt đầu : {{\Carbon\Carbon::parse($item->start)->isoFormat("DD/MM/YYYY")}}
                    </span>
                </div>
            </div>
        @endforeach
    </div>



</div>
