{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i
            class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

@if(backpack_user()->role=="super")
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('branch') }}"><i class="nav-icon la la-building"></i>
            Chi nhánh</a></li>
@endif

@if(in_array(backpack_user()->role,["admin","super","staff"]))
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-group"></i> Người dùng</a>
        <ul class="nav-dropdown-items">
            @if(in_array(backpack_user()->role,["admin","super"]))
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('staff') }}"><i
                            class="nav-icon la la-user-astronaut"></i> Nhân
                        viên</a></li>
            @endif
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('teacher') }}"><i
                        class="nav-icon la la-user-tie"></i>
                    Giáo viên</a></li>
            {{--        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-question"></i> Users</a>--}}
            {{--        </li>--}}
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('customer') }}"><i
                        class="nav-icon la la-users"></i> Khách hàng</a></li>
        </ul>
@endif
@if(in_array(backpack_user()->role,["admin","staff","super","teacher"]))
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-group"></i>Quản lý học sinh</a>
        <ul class="nav-dropdown-items">

            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('student') }}"><i
                        class="nav-icon la la-users"></i>
                    Học sinh</a></li>
            @if(backpack_user()->role!="teacher")
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('invoice') }}"><i
                            class="nav-icon la la-table"></i> Học phí</a></li>
            @endif
        </ul>
    </li>
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-group"></i> Quản lý lớp học</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('grade') }}"><i
                        class="nav-icon la la-chalkboard"></i> Lớp học</a></li>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('log') }}"><i
                        class="nav-icon la la-history"></i>
                    Nhật ký</a>
            </li>
        </ul>
    </li>
@endif
@if(backpack_user()->role=="student")
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('invoice') }}"><i
                class="nav-icon la la-table"></i> Học phí</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('grade') }}"><i
                class="nav-icon la la-chalkboard"></i> Lớp học</a></li>
    </li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('log') }}"><i class="nav-icon la la-history"></i>
            Nhật ký</a>
    </li>
@endif


@if(in_array(backpack_user()->role,["admin","super","staff"]))
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-file-archive"></i>Quản lý tài
            chính</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('finance') }}"><i
                        class="nav-icon la la-pie-chart"></i>Tổng quan</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('invoice') }}"><i
                        class="nav-icon la la-file-invoice"></i> Thu học phí</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('income') }}"><i
                        class="nav-icon la la-file-invoice-dollar"></i> Thu khác</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('teacher-salary') }}"><i
                        class="nav-icon la la-file-invoice-dollar"></i> Chi lương giáo viên</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('payment') }}"><i
                        class="nav-icon la la-file-invoice-dollar"></i> Chi khác</a></li>
        </ul>
    </li>
@endif
@if(in_array(backpack_user()->role,["admin","super"]))
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('post') }}"><i
                class="nav-icon la la-pinterest"></i>
            Bài viết</a>
    </li>
@endif

{{--@if(backpack_user()->role=="super")--}}
{{--    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('backup') }}'><i class='nav-icon la la-hdd-o'></i>--}}
{{--            Backups</a></li>--}}
{{--@endif--}}



<li class="nav-item"><a class="nav-link" href="{{ backpack_url('course') }}"><i class="nav-icon la la-list"></i> Khóa
        học</a></li>
{{--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>--}}
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-file-archive"></i>Tài liệu</a>
    <ul class="nav-dropdown-items">

        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('bag') }}"><i
                    class="nav-icon la la-list"></i> Danh mục sách</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('book') }}"><i
                    class="nav-icon la la-book"></i> Sách</a></li>
    </ul>
</li>
{{--<li class="nav-item nav-dropdown">--}}
{{--    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon lab la-rocketchat"></i>Trò chuyện</a>--}}
{{--    <ul class="nav-dropdown-items">--}}
{{--        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('conversation') }}"><i--}}
{{--                    class="nav-icon la la-comments"></i>Nhóm chat</a></li>--}}
{{--        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('message') }}"><i--}}
{{--                    class="nav-icon lab la-rocketchat"></i>Trò chuyện</a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</li>--}}
@if(in_array(backpack_user()->role,["admin","super","staff"]))
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('task') }}"><i class="nav-icon la la-tasks"></i>Công
            việc</a></li>
@endif


<li class="nav-item"><a class="nav-link" href="{{ backpack_url('review') }}"><i class="nav-icon la la-question"></i> Reviews</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('news') }}"><i class="nav-icon la la-question"></i> News</a></li>