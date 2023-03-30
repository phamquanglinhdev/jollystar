{{-- This file is used to store topbar (left) items--}}

<li class="nav-item px-3"><a class="nav-link" href="#">Xin chào, {{backpack_user()->name}}</a></li>

@if(backpack_user()->id==1)
    <li class="nav-item px-3"><a class="nav-link" href="#">Phân quyền:Super Admin
            <small class="text-danger">Khi thêm dữ liệu cần lưu ý chi nhánh hiện tại (chi nhánh {{backpack_user()->origin}})</small>
        </a></li>
    <form action="{{route("super.switch")}}">
        @csrf
        @php
            $admin = \App\Models\Admin::all();
        @endphp
        <div class="input-group">
            <select name='origin' class="form-control">
                <option>-</option>
                @foreach($admin as $branch)
                    <option value="{{$branch->origin}}"
                            @if(backpack_user()->origin==$branch->origin)
                                selected
                        @endif
                    >
                        Chi nhánh {{$branch->origin}}
                    </option>
                @endforeach
            </select>
            <div class="input-append">
                <button class="btn btn-success rounded-0">Chuyển</button>
            </div>
        </div>
    </form>

@else
    <li class="nav-item px-3"><a class="nav-link" href="#">Phân quyền:{{backpack_user()->role}}</li>
@endif
