<div class="row">
    <div class="col-sm-6 col-lg-3 mb-2">
        <div class="border text-white bg-primary rounded shadow-lg">
            <div class="card-body">
                <div class="text-value">{{\App\Models\Dashboard::students()}}</div>
                <div>Học sinh</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-2">
        <div class="border text-white bg-success rounded shadow-lg">
            <div class="card-body">
                <div class="text-value">{{\App\Models\Dashboard::teachers()}}</div>
                <div>Giáo viên</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-2">
        <div class="border text-white bg-warning rounded shadow-lg">
            <div class="card-body">
                <div class="text-value">{{\App\Models\Dashboard::grades()}}</div>
                <div>Lớp học</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-2">
        <div class="border text-white bg-cyan rounded shadow-lg">
            <div class="card-body">
                <div class="text-value">{{\App\Models\Dashboard::logs()}}</div>
                <div>Buổi học</div>
            </div>
        </div>
    </div>
</div>
