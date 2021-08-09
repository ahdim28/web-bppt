@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="bg-breadcrumb"> 
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="box-breadcrumb">
                    <div class="title-heading text-center">
                        <h1>{!! $data['read']->fieldLang('name') !!}</h1>
                    </div>
                    <a href="{{ route('home') }}" class="btn-back" title="@lang('common.back_home')">
                        <i class="las la-home"></i><span>@lang('common.back_home')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box-wrap">
    <div class="container">
        <div class="row justify-content-end mb-3">
            <div class="col-md-4">
                <div class="form-group d-flex align-items-center">
                    <!-- <label class="mb-0 mr-2" for="select-display">Kategori</label> -->
                    <select id="select-display" class="form-control">
                        <option>All</option>
                        <option>Layanan Info Publik</option>
                        <option>Kebijakan Teknologi</option>
                        <option>Teknologi Sumberdaya Alam dan Kebencanaan</option>
                        <option>Teknologi Agroindustri dan Bioteknologi</option>
                        <option>Teknologi Informasi, Energi dan Material</option>
                        <option>Teknologi Hankam,Transportasi & Manufakturing </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">08</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images/inovasi-presiden.jpeg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Layanan Info Publik
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">08</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images//inovasi-tech.jpg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Kebijakan Teknologi
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">08</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images//tsunami.jpg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Teknologi Sumberdaya Alam &amp; Kebencanaan
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">09</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images/luhut.jpg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Teknologi Agroindustri dan Bioteknologi
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">Menko Luhut Ajak Tingkatkan Nilai Tambah Serta Penggunaan Produksi Dalam Negeri </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">08</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images/inovasi-presiden.jpeg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Layanan Info Publik
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">08</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images//inovasi-tech.jpg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Kebijakan Teknologi
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">08</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images/inovasi-presiden.jpeg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Layanan Info Publik
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">08</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images//inovasi-tech.jpg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Kebijakan Teknologi
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">08</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images//tsunami.jpg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Teknologi Sumberdaya Alam &amp; Kebencanaan
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">09</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images/luhut.jpg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Teknologi Agroindustri dan Bioteknologi
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">Menko Luhut Ajak Tingkatkan Nilai Tambah Serta Penggunaan Produksi Dalam Negeri </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">08</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images/inovasi-presiden.jpeg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Layanan Info Publik
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="detail-news.html" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">08</span>
                            <span class="mmyy">Mar 2021</span>
                        </div>
                        <div class="thumb-img">
                            <img src="images//inovasi-tech.jpg" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="" class="post-info_2">
                            Kebijakan Teknologi
                        </a>
                        <a href="detail-news.html">
                            <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                        </a>
                    </div>
                </div>
            </div>
            
            
        </div>
        <div class="box-btn d-flex justify-content-end">
            <ul class="pagination">
                <li><a href="#!" class="active">1</a></li>
                <li><a href="#!">2</a></li>
                <li><a href="#!">3</a></li>
                <li><a href="#!">...</a></li>
                <li><a href="#!">60</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
