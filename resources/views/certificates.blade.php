@extends("layouts.client")
@section("content")
    <div class="container">
        <div class="p-lg-5 p-2 text-center h3 text-uppercase">
            Chứng chỉ của học sinh
        </div>
        <div class="row mt-3">
            @forelse($certificates as $certificate)
                <div class="col-md-3 col-sm-6 col-12 mb-3">
                    <div class="bg-image bg-dark rounded">
                        <img src="{{$certificate->image}}" class="w-100 bgd rounded">
                        <div class="middle text-white">
                            <div class="text">{{$certificate->name}}</div>
                            <div class="text">{{$certificate->certificate_name}}</div>
                        </div>
                    </div>
                </div>
            @empty
                @include("components.empty")
            @endforelse
        </div>
    </div>
    <style>
        .bg-image{
            cursor: pointer;
        }
        .middle {
            width: 100%;
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            bottom: 20%;
            left: 50%;
            transform: translate(-50%, 50%);
            text-align: center;

        }
        .bgd{
            transition: .5s ease;
        }
        .bg-image:hover .bgd{
            opacity: 0.05;
        }
        .bg-image:hover .middle{
            opacity: 1;
        }
    </style>
@endsection
