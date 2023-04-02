{{-- This file is used to store topbar (left) items--}}

<li class="nav-item px-3"><a class="nav-link" href="#">Xin chào, {{backpack_user()->name}}</a></li>
<li class="nav-item px-3"><a class="nav-link" href="#">Mã chi nhánh : {{backpack_user()->origin}}</a></li>

@if(backpack_user()->role=="super")
    <li class="nav-item px-3"><a class="nav-link" href="#">Phân quyền:Super Admin
            <small class="text-danger">Khi thêm dữ liệu cần lưu ý chi nhánh hiện tại (chi
                nhánh {{backpack_user()->origin}})</small>
        </a></li>
    <form action="{{route("super.switch")}}">
        @csrf
        @php
            $branches = \App\Models\Branch::all();
        @endphp
        <div class="input-group">
            <select name='origin' class="form-control">
                <option disabled>-</option>
                @foreach($branches as $branch)
                    <option value="{{$branch->code}}"
                            @if(\Illuminate\Support\Facades\Cookie::get("origin")==$branch->code)
                                selected
                        @endif
                    >
                        {{$branch->name}}
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
