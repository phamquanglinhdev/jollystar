@extends(backpack_view("blank"))
@php
    use App\Models\Finance;
@endphp
@section('content')
    <div class="h5">Quản lý thu chi tháng {{\Carbon\Carbon::now()->isoFormat("MM-YYYY")}}</div>
    <div class="row">
        <div class="col-md-6 col-12">
            <canvas id="income"></canvas>
            <hr>
            <div>
                Thu học phí : {{number_format(Finance::TotalInvoice())}} đ
            </div>
            <div>
                Thu khác : {{number_format(Finance::TotalIncome())}} đ
            </div>
            <hr>
            <div>
                Tổng thu : {{number_format(Finance::TotalInvoice()+Finance::TotalIncome())}} đ
            </div>
        </div>
        <div class="col-md-6 col-12">
            <canvas id="outcome"></canvas>
            <hr>
            <div>
                Chi lương giáo viên : {{number_format(Finance::TotalTeacherSalary())}} đ
            </div>
            <div>
                Chi khác : {{number_format(Finance::TotalPayment())}} đ
            </div>
            <hr>
            <div>
                Tổng chi : {{number_format(Finance::TotalPayment()+Finance::TotalTeacherSalary())}} đ
            </div>
        </div>

    </div>
    <hr>
    <div>
        <span class="font-weight-bold">Tổng</span> : {{number_format(Finance::Sum())}} đ
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('income');
        new Chart(ctx, {
            type: 'line',
            data: {

                labels: [{{Finance::MonthInvoice()["dates"]}}],
                datasets: [
                    {
                        label: 'Thu học phí',
                        data: [{{Finance::MonthInvoice()["invoices"]}}],
                        borderWidth: 1
                    },
                    {
                        label: 'Thu khác',
                        data: [{{Finance::MonthInvoice()["incomes"]}}],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        const outcome = document.getElementById('outcome');
        new Chart(outcome, {
            type: 'line',
            data: {

                labels: [{{Finance::MonthInvoice()["dates"]}}],
                datasets: [
                    {
                        label: 'Chi lương giáo viên',
                        data: [{{Finance::MonthInvoice()["salary"]}}],
                        borderWidth: 1
                    },
                    {
                        label: 'Chi khác',
                        data: [{{Finance::MonthInvoice()["payments"]}}],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@stop

