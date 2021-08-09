@extends('layouts.frontend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper.min.css') }}">
@endsection

@section('content')
<div class="box-wrap single-post">
    <div class="container">
        <div class="box-breadcrumb">
            <ul class="list-breadcrumb">
                <li class="item-breadcrumb">
                    <a href="index.html">
                        <i class="las la-home"></i><span>Home</span>
                    </a>
                </li>
                <li class="item-breadcrumb">
                    <a href="list-news.html">
                        <span>Berita</span>
                    </a>
                </li>
                <li class="item-breadcrumb">
                    <span>Secara Daring, BPPT Luncuran InaTEWS Buoy di Perairan Gunung Anak Krakatau </span>
                </li>
            </ul>
        </div>
        <div class="box-post">
           <div class="post-hits">
                <div class="box-hits">146</div>
                <span>Hits</span>
            </div>
            <div class="post-title">
                <div class="title-heading">
                    <h2>Secara Daring, BPPT Luncuran InaTEWS Buoy di Perairan Gunung Anak Krakatau </h2>
                </div>
                <div class="box-info">
                    <div class="item-info">
                        <i class="las la-user"></i>
                        <span>Admin</span>
                    </div>
                    <a href="" class="item-info">
                        <i class="las la-tag"></i>
                        <span>Berita Layanan Info Publik</span>
                    </a>
                    <div class="item-info">
                        <i class="las la-print"></i>
                        <a href="#!"><span>print<span></a>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="box-content pt-4">
            <div class="box-post-img">
                <img src="images/tsunami.jpg" alt="">
            </div>
            <article>
                <p>Sebagaimana diketahui bahwa BPPT, BMKG, BIG, PVMBG-Badan Geologi, Kementerian ESDM mendapat penugasan nasional melalui Perpres No. 93 Tahun 2019 untuk Memperkuat dan Mengembangkan Sistem Informasi Gempa Bumi dan Tsunami di Indonesia.</p>
                <p>Secara sejak tahun 2019-2024 dengan target kinerja yaitu terpasang dan beroperasinya: Inabuoy di 13 lokasi, InaCBT di 7 lokasi, InaCAT/Tomografi di tiga lokasi dan satu Kecerdasan Artifical (AI-Tsunami) di Indonesia, kata Kepala BPPT Hammam Riza di acara Peluncuran Ina TEWS Gunung Anak Krakatau (GAK) secara daring (28/07).</p>
                <p>Ditambahkan Hammam, peluncuran InaTEWS Buoy ini merupakan inovasi kegiatan BPPT yang dimulai dari proses desain, konstruksi, pengujian, pemasangan, dan operasional. Keunggulan dari INATEWS Buoy hasil inovasi BPPT ini adalah sistem Inabuoy dapat beroperasi di laut dalam yang menjadi pusat gempa dan tsunami sehingga early detection atau deteksi dini oleh Buoy sebagai konfirmasi model/prediksi di BMKG akan terjadinya tsunami dapat dilakukan.</p>
                <p>Tidak hanya itu, menurutnya, teknologi Buoy terdiri dari 3 komponen utama yakni OBU, Buoy dan Manajemen Data di InaTOC. Secara keseluruhan terdiri dari sensor tekanan, sistem komunikasi akustik, mooring line, komunikasi data via satelit Iridium dan aplikasi software untuk manajemen data di InaTOC.</p>
                
                <img " src="images/tsunami-2.jpg">
                <p>Hammam berharap melalui kegiatan ini dapat menjadi wadah untuk menyampaikan secara terbuka capaian-capaian super program InaTEWS BPPT sehingga dapat saling berbagi ilmu pengetahuan dan teknologi, pengalaman serta menjadi ajang untuk membangun sinergi antar BPPT dan Pemerintah Daerah, Institusi riset dari dalam dan luar negeri, asosiasi, lembaga sosial masyarakat, industri/swasta dan media. Sehingga program Nasional ini dapat terlaksana dengan Konsep Pentahelix, pungkasnya.</p>
                <p>Sementara, Deputi Bidang Teknologi Pengembangan Sumberdaya Alam (TPSA) Yudi Anantasena menyampaikan, program InaTEWS ini menerapkan konsep Pentahelix selain melibatkan akademisi, masyarakat serta sektor bisnis untuk pembuatan buoy tahun lalu di BPPT.</p>
                <p>Menurutnya, sampai saat ini BPPT sudah melakukan pemasangan di Selatan Bali, Selatan  Kabupaten Malang, Selat Sunda dan Selatan Cilacap, datanya sudah beberapa diterima di InaToc seperti data dari Buoy di Selatan Malang yang masuk lagi dengan baik.</p>
                <p>Semoga yang dilakukan didalam  ini dapat mencapai output atau produk target InaTEWS BPPT bisa dilaksanakan dengan baik serta menunjukan sebagai bangsa khususnya BPPT serta para mitra-mitra semua bisa melakukan semua produk inovasi anak bangsa, jelasnya. (Humas BPPT)</p>
            </article>
            <div class="list-photo">
                <div class="swiper-container gallery-news">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="item-photo" data-src="images/tsunami.jpg" data-sub-html="<h4>Title</h4><span>Description</span>">
                                <div class="thumb-img">
                                    <img src="images/tsunami.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item-photo" data-src="images/tsunami-2.jpg" data-sub-html="<h4>Title</h4><span>Description</span>">
                                <div class="thumb-img">
                                    <img src="images/tsunami-2.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item-photo" data-src="images/tsunami-3.jpg" data-sub-html="<h4>Title</h4><span>Description</span>">
                                <div class="thumb-img">
                                    <img src="images/tsunami-3.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item-photo" data-src="images/tsunami-4.jpeg" data-sub-html="<h4>Title</h4><span>Description</span>">
                                <div class="thumb-img">
                                    <img src="images/tsunami-4.jpeg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item-photo" data-src="images/tsunami-5.jpg" data-sub-html="<h4>Title</h4><span>Description</span>">
                                <div class="thumb-img">
                                    <img src="images/tsunami-5.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h6>Tags :</h6>
                    <ul class="list-hastag">
                        <li class="item-hastag"><a href=""><span>Teknologi</span></a></li>
                        <li class="item-hastag"><a href=""><span>Indonesia</span></a></li>
                        <li class="item-hastag"><a href=""><span>Smart</span></a></li>
                        <li class="item-hastag"><a href=""><span>BPPTIndonesia</span></a></li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="share-box mt-0">
                        <h6>share :</h6>
                        <ul>
                            <li>
                                <a href="">
                                    <div class="share-icon">
                                        <i class="lab la-facebook-f"></i>
                                    </div>
                                    <span>Facebook</span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <div class="share-icon">
                                        <i class="lab la-twitter"></i>
                                    </div>
                                    <span>Twitter</span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <div class="share-icon">
                                        <i class="lab la-linkedin-in"></i>
                                    </div>
                                    <span>linkedin</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="box-list">
            <h5 class="mb-4">Berita Terkait</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="item-post sm">
                        <a href="detail-news.html" class="box-img img-overlay">
                            <div class="thumb-img">
                                <img src="images/elang.jpg" alt="">
                            </div>
                        </a>
                        <div class="box-info">
                            <div class="post-info_2">18 Juli 20201</div>
                            <a href="detail-news.html">
                                <h6 class="post-title">Wujudkan Pertumbuhan Ekonomi dan Kemandirian Industri Pertahanan Melalui Inovasi Teknologi </h6>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="item-post sm">
                        <a href="detail-news.html" class="box-img img-overlay">
                            <div class="thumb-img">
                                <img src="images//cuaca.jpg" alt="">
                            </div>
                        </a>
                        <div class="box-info">
                            <div class="post-info_2">16 Juli 20201</div>
                            <a href="detail-news.html">
                                <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="item-post sm">
                        <a href="detail-news.html" class="box-img img-overlay">
                            <div class="thumb-img">
                                <img src="images/inovasi-presiden.jpeg" alt="">
                            </div>
                        </a>
                        <div class="box-info">
                            <div class="post-info_2">15 Juli 20201</div>
                            <a href="detail-news.html">
                                <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="item-post sm">
                        <a href="detail-news.html" class="box-img img-overlay">
                            <div class="thumb-img">
                                <img src="images//inovasi-tech.jpg" alt="">
                            </div>
                        </a>
                        <div class="box-info">
                            <div class="post-info_2">13 Juli 20201</div>
                            <a href="detail-news.html">
                                <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="item-post sm">
                        <a href="detail-news.html" class="box-img img-overlay">
                            <div class="thumb-img">
                                <img src="images//tsunami.jpg" alt="">
                            </div>
                        </a>
                        <div class="box-info">
                            <div class="post-info_2">26 Juni 20201</div>
                            <a href="detail-news.html">
                                <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="item-post sm">
                        <a href="detail-news.html" class="box-img img-overlay">
                            <div class="thumb-img">
                                <img src="images//cuaca.jpg" alt="">
                            </div>
                        </a>
                        <div class="box-info">
                            <div class="post-info_2">18 Mei 20201</div>
                            <a href="detail-news.html">
                                <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/frontend/js/swiper.min.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //COLLECTION-SLIDER
        var swiper = new Swiper('.gallery-news', {
            slidesPerView: 5,
            spaceBetween: 2,
            speed: 1000,
            autoplay: {
                delay: 2000,
            },
            loop: true,
            breakpoints: {
                // when window width is <= 575.98px
                575.98: {
                    slidesPerView: 3,
                }
            }

        });
</script>
@endsection
