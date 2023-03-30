<div>
    <div class="font-weight-bold">Bình luận:</div>
    <div class="my-2" id="list-comments">
        @foreach($task->answers as $answer)
            @include("task.comment",['answer'=>$answer])
        @endforeach
    </div>
    <div class="input-group mb-3">
        <input type="hidden" id="selected-task" value="{{$task->id}}">
        <input type="text" id="current-comment" class="form-control" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-secondary" type="button" id="send-comment">
                <i class="la la-comment"></i>
            </button>
        </div>
    </div>
</div>
