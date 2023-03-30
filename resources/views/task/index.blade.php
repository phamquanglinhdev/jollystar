@extends(backpack_view("blank"))
@section("after_styles")
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection
@section('content')
    @if(in_array(backpack_user()->role,["admin","supper"]))
        <div class="container-fluid mt-3">
            <a class="btn btn-primary nav-link d-inline" href="{{route("task.create")}}">Thêm công việc mới</a>
            <hr>
        </div>
    @endif
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="h5 text-center font-weight-bold mb-3">Cần làm</div>
                <ul id="sortable" class="list-group">
                    @foreach($tasks as $task)
                        @include("task.task",["task"=>$task])
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <div class="h5 text-center font-weight-bold mb-3">Đã xong</div>
                <ul id="done" class="list-group">
                    @foreach($done as $task)
                        @include("task.task",["task"=>$task])
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <div class="h5 text-center font-weight-bold mb-3">Đã hủy</div>
                <ul id="cancel" class="list-group">
                    @foreach($cancel as $task)
                        @include("task.task",["task"=>$task])
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@stop
@section("after_scripts")
    <!-- Modal -->
    <div class="modal  fade" id="task-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="task-modal-title">Hoàn thành báo cáo tài chính tháng 12</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="task-modal-detail">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ajaxComplete(
            function () {
                $("#send-comment").click(function (e) {
                    const comment = $("#current-comment").val()
                    const task = $("#selected-task").val()
                    $.ajax({
                        type: "POST",
                        url: "{{route("task.answer")}}",
                        data: {task: task, comment: comment},
                        dataType: "html",
                        encode: true,
                    }).done(function (data) {
                        $("#list-comments").append(data)
                        $("#current-comment").val("")
                    })
                })
            }
        )
        $(function () {
            $("#sortable").sortable({
                update: function (e) {
                    const items = $("#sortable").sortable("toArray")
                    $.ajax({
                        type: "POST",
                        url: "{{route("task.sorted")}}",
                        data: {list: items},
                        dataType: "json",
                        encode: true,
                    }).done(function (data) {
                        console.log(data)
                    })
                }
            });
            $("#done").sortable({
                update: function () {
                    const items = $("#done").sortable("toArray")
                    $.ajax({
                        type: "POST",
                        url: "{{route("task.sorted")}}",
                        data: {list: items},
                        dataType: "json",
                        encode: true,
                    }).done(function (data) {
                        console.log(data)
                    })
                }
            });
            $("#cancel").sortable({
                update: function () {
                    const items = $("#cancel").sortable("toArray")
                    $.ajax({
                        type: "POST",
                        url: "{{route("task.sorted")}}",
                        data: {list: items},
                        dataType: "json",
                        encode: true,
                    }).done(function (data) {
                        console.log(data)
                    })
                }
            });
        });
        $(".task").click(function (e) {
            const method = e.target.attributes.type ? e.target.attributes.type.value : null;
            const taskId = this.id

            if (method == null) {
                $.ajax({
                    type: "POST",
                    url: "{{route("task.detail")}}",
                    data: {id: taskId},
                    dataType: "json",
                    encode: true,
                }).done(function (data) {
                    $("#task-modal-detail").html(data.html)
                    $("#task-modal-title").html(data.title)
                })
                $('#task-detail').modal({
                    show: true
                });
            } else {
                if (method !== "edit")
                    $.ajax({
                        type: "POST",
                        url: "{{route("task.action")}}",
                        data: {action: method, id: taskId},
                        dataType: "json",
                        encode: true,
                    }).done(function (data) {
                        console.log(data)
                        window.location.reload()
                    })
            }
        })
    </script>
@endsection
