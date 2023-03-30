@extends("layouts.client")
@section("content")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.2/sweetalert2.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.2/sweetalert2.min.js"></script>
    @if ($errors->any())
        @php
            $data = "";
            foreach ($errors->all() as $error){
                $data .= "<div>$error</div>";
            }

        @endphp
        <script>
            Swal.fire({
                title: 'Thiếu thông tin',
                html: '{!! $data !!}',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500,
            })
        </script>
        {{--        <div class="alert alert-danger">--}}
        {{--            <ul>--}}
        {{--                @foreach ($errors->all() as $error)--}}
        {{--                    <li>{{ $error }}</li>--}}
        {{--                @endforeach--}}
        {{--            </ul>--}}
        {{--        </div>--}}
    @endif
    @if(session("success"))
        <script>
            Swal.fire({
                title: 'Gửi thành công',
                text: 'Nhân viên JollyStar sẽ sớm liên hệ với bạn',
                icon: 'success',
                // confirmButtonText: 'Cool'
            })
        </script>
    @endif
    <div id="carouselExampleCrossfade" class="carousel slide carousel-fade" data-mdb-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{$_SERVER["BANNER"]??asset("img/carousel.png")}}"
                     class="d-block w-75 m-auto" alt="Wild Landscape"/>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleCrossfade"
                data-mdb-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleCrossfade"
                data-mdb-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- End your project here-->
    <div class="container my-5">
        <div class="text-center p-5">
            <div class="h3">
                Jolly Star
            </div>
            <div class="h4">
                Chuyên đào tạo tiếng Anh mọi levels
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-12">
                <img src="{{asset("img/intro-1.jpg")}}" class="card-img-top"
                     alt="Sunset Over the Sea"/>
                <div class="card">

                    <div class="card-body text-center">
                        <div class="h5 card-title text-center my-3 my-lg-4 text-uppercase">
                            Nhiều khung giờ học trong ngày
                        </div>
                        <p class="card-text">
                            Học sinh có thể chọn lựa lớp khung giờ phù hợp một cách linh hoạt, dễ dàng sắp xếp khung
                            thời gian để học tập.<br><br>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <img src="{{asset("img/intro-2.jpg")}}" class="card-img-top"
                     alt="Sunset Over the Sea"/>
                <div class="card">

                    <div class="card-body text-center">
                        <div class="h5 card-title text-center my-3 my-lg-4">
                            LỘ TRÌNH CÁ NHÂN HÓA
                        </div>
                        <p class="card-text">
                            Học 1 kèm 1 nên giáo viên có thể hiểu rõ trình độ bạn và dạy bạn theo lộ trình được cá nhân
                            hóa
                            phù hợp nhất với bạn – đảm bảo hiệu quả gấp nhiều lần so với đi học tại trung tâm.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <img src="{{asset("img/intro-3.jpg")}}" class="card-img-top"
                     alt="Sunset Over the Sea"/>
                <div class="card">

                    <div class="card-body text-center">
                        <div class="h5 card-title text-center my-3 my-lg-4">
                            CHI PHÍ THẤP
                        </div>
                        <p class="card-text">
                            Học 1 kèm 1 nhưng chi phí cho mỗi buổi học thấp hơn so với học lớp 10 – 12 người tại trung
                            tâm.
                            Đảm bảo bạn có thể học tiếng Anh lâu dài mà không còn lo lắng về vấn đề tài chính.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-primary text-white">
        <div class="container">
            <div class="text-center p-5">
                <div class="h3">
                    BẠN CÓ THỂ HỌC GÌ VỚI Jolly Star?
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-12 mb-4">
                    <img src="{{asset("img/pad_1.jpg")}}" class="card-img-top rounded"
                         alt="Sunset Over the Sea"/>
                </div>
                <div class="col-sm-3 col-12 mb-4">
                    <img src="{{asset("img/pad_2.jpg")}}" class="card-img-top rounded"
                         alt="Sunset Over the Sea"/>
                </div>
                <div class="col-sm-3 col-12 mb-4">
                    <img src="{{asset("img/pad_3.jpg")}}" class="card-img-top rounded"
                         alt="Sunset Over the Sea"/>
                </div>
                <div class="col-sm-3 col-12 mb-4">
                    <img src="{{asset("img/pad_4.jpg")}}" class="card-img-top rounded"
                         alt="Sunset Over the Sea"/>
                </div>
            </div>
            <div class="text-center p-3 pb-5">
                <button class="btn btn-primary">
                    Xem chi tiết các khóa học
                </button>
            </div>
        </div>
    </div>
    <div class="bg-primary text-white pb-5">
        <div class="text-center p-lg-5 p-2">
            <div class="h3">ĐÀO TẠO TIẾNG ANH CHO DOANH NGHIỆP</div>
        </div>
        <div class="container">
            <div class="row py-5 align-items-center" style="border: 2px white dashed">
                <div class="col-md-5 col-12">
                    <div class="h5">
                        Jolly Star đào tạo tiếng Anh Online cho nhân viên các doanh nghiệp theo yêu cầu.
                    </div>
                    <hr>
                    <ul>
                        <li>Chương trình học được thiết kế riêng theo yêu cầu của từng doanh nghiệp.</li>
                        <li>Nâng cao hiệu quả học tập</li>
                        <li>Tiết kiệm chi phí lên tới 50% – 70%.</li>
                    </ul>
                </div>
                <div class="col-md-7 col-12 w-50 m-auto d-lg-block d-none">
                    <img src="https://files.catbox.moe/gvnv74.jpg" class="w-100 rounded shadow-lg"/>
                </div>
                <div class="col-md-7 col-12 w-100 m-auto d-lg-none d-block">
                    <img src="https://files.catbox.moe/gvnv74.jpg" class="w-100 rounded shadow-lg"/>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="">--}}
{{--        <div class="text-center p-5">--}}
{{--            <div class="h3 pb-5">GIÁO VIÊN CỦA CHÚNG TÔI</div>--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="card">--}}
{{--                            <div class="ratio ratio-16x9 rounded">--}}
{{--                                <iframe--}}
{{--                                    class="rounded"--}}
{{--                                    src="https://www.youtube.com/embed/{{json_decode($_SERVER["LEFT_VIDEO"])->id??""}}"--}}
{{--                                    title="YouTube video"--}}
{{--                                    allowfullscreen--}}
{{--                                ></iframe>--}}
{{--                            </div>--}}
{{--                            <div class="card-body px-5">--}}
{{--                                <div class="h5 text-primary">GIÁO VIÊN VIỆT NAM</div>--}}
{{--                                <p class="card-text">Giáo viên Việt Nam với chứng chỉ IELTS 6.5 – 8.0 hoặc du học sinh--}}
{{--                                    tại--}}
{{--                                    Mỹ - Châu Âu.</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="card">--}}
{{--                            <div class="ratio ratio-16x9 rounded">--}}
{{--                                <iframe--}}
{{--                                    class="rounded"--}}
{{--                                    src="https://www.youtube.com/embed/{{json_decode($_SERVER["RIGHT_VIDEO"])->id??""}}"--}}
{{--                                    title="YouTube video"--}}
{{--                                    allowfullscreen--}}
{{--                                ></iframe>--}}
{{--                            </div>--}}
{{--                            <div class="card-body px-5">--}}
{{--                                <div class="h5 text-primary">GIÁO VIÊN PHILIPPINES</div>--}}
{{--                                <p class="card-text">Giáo viên Philippines nổi tiếng là những người chuyên dạy tiếng Anh--}}
{{--                                    cho--}}
{{--                                    trẻ em trên toàn thế giới.</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="py-2">
        <div class="text-center p-5">
            <h3>HỌC VIÊN CỦA CHÚNG TÔI NÓI GÌ ?</h3>
        </div>
        <div class="container">
            <div class="owl-carousel py-5">
                @if($reviews!=null)
                    @foreach($reviews as $review)
                        <div class=" p-2 reviews">
                            <img src="{{$review->avatar}}"
                                 class="card-img-top rounded-circle w-50 m-auto" alt="Sunset Over the Sea"/>
                            <div class="text-warning text-center mt-2">
                                <span class="fas fa-star"></span>
                                <span class="fas fa-star"></span>
                                <span class="fas fa-star"></span>
                                <span class="fas fa-star"></span>
                                <span class="fas fa-star"></span>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    {{$review->review_content}}
                                </p>
                                <div class="h5">- {{$review->name}} -</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
{{--    <div class="py-2 container">--}}
{{--        <div class="text-center pb-5 text-uppercase">--}}
{{--            <h3>Chứng chỉ của học viên</h3>--}}
{{--        </div>--}}
{{--        <div class="owl-carousel">--}}
{{--            @php--}}
{{--                $certificates  = \App\Models\Certificate::limit(10)->get();--}}
{{--            @endphp--}}
{{--            @foreach($certificates as $certificate)--}}
{{--                <div class="bg-image bg-dark rounded">--}}
{{--                    <img src="{{$certificate->image}}" class="w-100 bgd rounded">--}}
{{--                    <div class="middle text-white">--}}
{{--                        <div class="text">{{$certificate->name}}</div>--}}
{{--                        <div class="text">{{$certificate->certificate_name}}</div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="bg-primary" id="lien-he">
        <div class="container">
            <div class="row my-5 py-5">
                <div class="col-md-6 bg-white d-none d-lg-block rounded-start">
                    <div class="my-5">
                        <img src="https://files.catbox.moe/ji9qzc.png" class="w-100">
                    </div>
                </div>
                <div class="col-md-6 bg-white rounded-end">
                    <div class=" my-5 p-3 pt-4 rounded">
                        <form action="{{route("contact.save")}}" method="post">
                            @csrf
                            <div class="p-2 h4 mb-5 text-center text-primary">Chia sẻ nhu cầu học tập của bạn</div>
                            <!-- Name input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="name" name="name" class="form-control"/>
                                <label class="form-label" for="name">Tên của bạn</label>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control"/>
                                <label class="form-label" for="email">Địa chỉ email</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="tel" id="phone" name="phone" class="form-control"/>
                                <label class="form-label" for="phone">Số điện thoại</label>
                            </div>
                            <!-- Message input -->
                            <div class="form-outline mb-4">
                                <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                                <label class="form-label" for="message">Nhu cầu học tập của bạn</label>
                            </div>

                            <!-- Checkbox -->

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">Gửi ngay</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("after_scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $(".owl-carousel").owlCarousel({
                    loop: true,
                    margin: 10,
                    responsive: {
                        0: {
                            items: 1,
                            mergeFit: true
                        },
                        600: {
                            items: 2,
                            mergeFit: true
                        },
                        1000: {
                            items: 4,
                            mergeFit: true
                        },

                    },
                    autoHeight: true,
                    autoplay: true,
                    autoplayTimeout: 2000,
                    autoplayHoverPause: true
                }
            );
        });
    </script>
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
