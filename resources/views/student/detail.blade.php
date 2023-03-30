@extends(backpack_view("blank"))

@section('content')
    @include("components.profile",["user"=>$entry])
    <div class="bg-white mx-4 p-2 mt-5 rounded shadow-lg pb-5">
        @include("components.student-frequency",["user"=>$entry])
        <div class="row">
            <div class="col-md-6">
                @include("components.invoices",["invoices"=>$entry->Invoices()->get()])
            </div>
            <div class="col-md-6">
                @include("components.grade",["grade"=>$entry->CurrentInvoice()->grade,'invoice'=>$entry->CurrentInvoice()])
            </div>
        </div>
        <div class="p-1 my-2">
            @include("components.single-log",["user"=>$entry])
        </div>
        <hr>
        @include("components.caring",["caring"=>$entry->Carings()->orderBy("date")->get(),'student'=>$entry])
    </div>
@stop
