@extends('layouts.frontend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper.min.css') }}">
@endsection

@section('content')
<div class="box-intro">
  <div class="sg-intro">
      <img src="{{ asset('assets/frontend/images/sg-sm.svg') }}" alt="">
  </div>
  <!-- <div class="bidang-dropdown d-lg-none">
      <div class="container-fluid">
          <div class="bidang-nav">
              <span>8 Bidang Teknologi</span>
              <i class="las la-angle-down"></i>
          </div>
          <div class="bidang-content" style="display: none;">
              <ul>
                  <li class="btk"><a href="">Bidang Teknologi Kebencanaan</a></li>
                  <li class="brk"><a href="">Bidang Rekayasa Keteknikan</a></li>
                  <li class="bk"><a href="">Bidang Kemaritiman</a></li>
                  <li class="bt"><a href="">Bidang Transportasi</a></li>
                  <li class="bkp"><a href="">Bidang Kesehatan & Pangan</a></li>
                  <li class="be"><a href="">Bidang Energi</a></li>
                  <li class="bpk"><a href="">Bidang Pertahanan & Keamanan</a></li>
                  <li class="btie"><a href="">Bidang Teknologi Informasi & Elektronik</a></li>
              </ul>
          </div>
      </div>
  </div> -->
  <div class="intro-flex">
      <div class="container">
          <div class="intro-content">
              <div class="swiper-container intro-content-slide">
                  <div class="swiper-wrapper">
                      <div class="swiper-slide">
                          <div class="box-intro-content">
                              <a href="">
                                  <div class="title-heading" >
                                      <h1>BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h1>
                                  </div>
                              </a>
                              <artilce class="summary-text">
                                 <p>Inovasi dalam bidang pertahanan ini dihadirkan melalui pengembangan Pesawat Udara Nir Awak (PUNA) atau Drone, tipe Medium Altitude Long Endurance (MALE) atau disebut PUNA MALE.</p>
                              </artilce>
                              <div class="box-btn">
                                  <a href="" class="btn btn-main"><span>Selengkapnya</span></a>
                              </div>
                          </div>
                      </div>
                      <div class="swiper-slide">
                          <div class="box-intro-content">
                              <a href="">
                                  <div class="title-heading" >
                                      <h1>BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h1>
                                  </div>
                              </a>
                              <artilce class="summary-text">
                                  <p>Badan Pengkajian dan Penerapan Teknologi (BPPT) kembali berhasil memasang satu sistem Buoy Tsunami di Selatan Bali (Buoy DPS) pada 12 April 2021 pukul 20:30.</p>
                              </artilce>
                              <div class="box-btn">
                                  <a href="" class="btn btn-main"><span>Selengkapnya</span></a>
                              </div>
                          </div>
                      </div>
                      <div class="swiper-slide">
                          <div class="box-intro-content">
                              <a href="">
                                  <div class="title-heading" >
                                      <h1>Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC</h1>
                                  </div>
                              </a>
                              <artilce class="summary-text">
                                  <p>Menghadapi potensi cuaca ekstrem, Badan Pengkajian dan Penerapan Teknologi (BPPT) terus laksanakan Operasi Teknologi Modifikasi Cuaca (TMC) guna mereduksi curah hujan di wilayah Jabodetabek.</p>
                              </artilce>
                              <div class="box-btn">
                                  <a href="" class="btn btn-main"><span>Selengkapnya</span></a>
                              </div>
                          </div>
                      </div>
                      <div class="swiper-slide">
                          <div class="box-intro-content">
                              <a href="">
                                  <div class="title-heading" >
                                      <h1>Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h1>
                                  </div>
                              </a>
                              <artilce class="summary-text">
                                  <p>Dalam pidatonya Presiden mendorong penerapan perekonomian yang dilaksanakan dengan berbasiskan inovasi dan teknologi. Pertama, Presiden menekankan BPPT harus aktif berburu inovasi dan teknologi untuk dikembangkan dan diterapkan.</p>
                              </artilce>
                              <div class="box-btn">
                                  <a href="" class="btn btn-main"><span>Selengkapnya</span></a>
                              </div>
                          </div>
                      </div>
                      
                  </div>
              </div>
              
          </div>
      </div>
      <div class="intro-img">
          <div class="box-intro-img">
              <div class="swiper-container intro-img-slide">
                  <div class="swiper-wrapper">
                      <div class="swiper-slide">
                          <div class="box-intro-img-slide img-overlay">
                              <div class="thumb-img">
                                  <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                              </div>
                          </div>
                      </div>
                      <div class="swiper-slide">
                          <div class="box-intro-img-slide img-overlay">
                              <div class="thumb-img">
                                  <img src="{{ asset('assets/frontend/images/tsunami.jpg') }}" alt="">
                              </div>
                          </div>
                      </div>
                      <div class="swiper-slide">
                          <div class="box-intro-img-slide img-overlay">
                              <div class="thumb-img">
                                  <img src="{{ asset('assets/frontend/images/cuaca.jpg') }}" alt="">
                              </div>
                          </div>
                      </div>
                      <div class="swiper-slide">
                          <div class="box-intro-img-slide img-overlay">
                              <div class="thumb-img">
                                  <img src="{{ asset('assets/frontend/images/inovasi-presiden.jpeg') }}" alt="">
                              </div>
                          </div>
                      </div>
                      
                  </div>
              </div>
          </div>
          <div class="swiper-button-wrapper">
              <div class="swiper-button-prev swiper-btn skew sbp-1"><i class="las la-arrow-left"></i></div>
              <div class="swiper-button-next swiper-btn skew sbn-1"><i class="las la-arrow-right"></i></div>
          </div>
      </div>
      <div class="box-scroll-down">
          <div class="container">
              <a href="#next-scroll" class="scroll-down page-scroll" id="btn-scroll">
                  <i class="las la-mouse"></i>
                  <span>@lang('common.scroll')</span>
              </a>
          </div>
      </div>
  </div>
  
  
 
</div>
<div class="box-wrap" id="next-scroll">
  <div class="container">
      <div class="row justify-content-between">
          <div class="col-lg-6">
              <div class="box-lead">
                  <div class="sg-white">
                      <img src="{{ asset('assets/frontend/images/sg-white.svg') }}" alt="">
                  </div>
                  <div class="content-lead">
                      <span>Kepala BPPT</span>
                      <h6>Dr. Ir. Hammam Riza, M.sc.</h6>
                  </div>
                  <img src="{{ asset('assets/frontend/images/hammam-riza.png') }}" alt="">
              </div>
          </div>
          <div class="col-lg-6">
              <div class="speak-lead">
                  <div class="title-heading">
                      <h5>Selamat datang di website </h5>
                      <h1>Badan Pengkajian dan Penerapan Teknologi</h1>
                      <h3>"Solid Smart Speed"</h3>
                  </div>
                  <article class="summary-text">
                      <p>Assalamualaikum warahmatullahi wabarakatuh</p>
                      <p>Puji dan syukur patutlah dipanjatkan kepada Tuhan Yang Maha Kuasa atas karunia Nya hingga kami dapat menyapa anda pungunjung Website BPPT dengan tampilan serta fitur yang lebih komprehensif dan menarik.</p>
                      <p>Dengan hadirnya tampilan baru website bppt.go.id ini, diharapkan akan semakin terjalin hubungan yang baik antara BPPT dengan stakeholdernya, baik mitra kerja maupun masyarakat pada umumnya. [...]</p>
                  </article>
                  <div class="box-btn mt-5">
                      <a href="" class="btn btn-main"><span>Selengkapnya</span></a>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<div class="box-wrap bg-grey">
  <div class="container-fluid">
      <div class="row justify-content-center">
          <div class="col-lg-8">
              <div class="title-heading text-center">
                  <h5>BPPT Indonesia</h5>
                  <h1>Delapan Bidang Fokus BPPT</h1>
              </div>
              <article class="summary-text text-center">
                  <p>Badan Pengkajian dan Penerapan Teknologi (BPPT) adalah Lembaga Pemerintah Non-Kementerian yang berada dibawah koordinasi Badan Riset Inovasi Nasional yang bertanggung jawab langsung ke Presiden dalam menjalankan tugas pemerintahan di bidang pengkajian dan penerapan teknologi.</p>
              </article>
          </div>
      </div>
      <div class="box-list">
          <div class="row justify-content-center">
              <div class="col-md-6 col-lg-3">
                  <a href="" class="item-bidang img-overlay btk" title="Bidang Teknologi Kebencanaan">
                      <div class="title-bidang">
                          <div class="no-bidang">
                              <span>01</span>
                              <span><i class="las la-arrow-right"></i></span>
                          </div>
                          <h6>Bidang Teknologi Kebencanaan</h6>
                      </div>
                      <div class="thumb-img">
                          <img src="{{ asset('assets/frontend/images/bid-1.jpeg') }}" alt="">
                      </div>
                  </a>
              </div>
              <div class="col-md-6 col-lg-3">
                  <a href="" class="item-bidang img-overlay brk" title="Bidang Rekayasa Keteknikan">
                      <div class="title-bidang">
                          <div class="no-bidang">
                              <span>02</span>
                              <span>
                                  <i class="las la-arrow-right"></i>
                              </span>
                          </div>
                          <h6>Bidang Rekayasa Keteknikan</h6>
                      </div>
                      <div class="thumb-img">
                          <img src="{{ asset('assets/frontend/images/bid-2.jpg') }}" alt="">
                      </div>
                  </a>
              </div>
              <div class="col-md-6 col-lg-3">
                  <a href="" class="item-bidang img-overlay bk" title="Bidang Kemaritiman">
                      <div class="title-bidang">
                          <div class="no-bidang">
                              <span>03</span>
                              <span>
                                  <i class="las la-arrow-right"></i>
                              </span>
                          </div>
                          <h6>Bidang Kemaritiman</h6>
                      </div>
                      <div class="thumb-img">
                          <img src="{{ asset('assets/frontend/images/bid-3.jpg') }}" alt="">
                      </div>
                  </a>
              </div>
              <div class="col-md-6 col-lg-3">
                  <a href="" class="item-bidang img-overlay bt" title="Bidang Transportasi">
                      <div class="title-bidang">
                          <div class="no-bidang">
                              <span>04</span>
                              <span>
                                  <i class="las la-arrow-right"></i>
                              </span>
                          </div>
                          <h6>Bidang Transportasi</h6>
                      </div>
                      <div class="thumb-img">
                          <img src="{{ asset('assets/frontend/images/bid-4.jpg') }}" alt="">
                      </div>
                  </a>
              </div>
              <div class="col-md-6 col-lg-3">
                  <a href="" class="item-bidang img-overlay bkp" title="Bidang Kesehatan & Pangan">
                      <div class="title-bidang">
                          <div class="no-bidang">
                              <span>05</span>
                              <span>
                                  <i class="las la-arrow-right"></i>
                              </span>
                          </div>
                          <h6>Bidang Kesehatan & Pangan</h6>
                      </div>
                      <div class="thumb-img">
                          <img src="{{ asset('assets/frontend/images/bid-5.jpg') }}" alt="">
                      </div>
                  </a>
              </div>
              <div class="col-md-6 col-lg-3">
                  <a href="" class="item-bidang img-overlay be" title="Bidang Energi">
                      <div class="title-bidang">
                          <div class="no-bidang">
                              <span>06</span>
                              <span>
                                  <i class="las la-arrow-right"></i>
                              </span>
                          </div>
                          <h6>Bidang Energi</h6>
                      </div>
                      <div class="thumb-img">
                          <img src="{{ asset('assets/frontend/images/bid-6.jpg') }}" alt="">
                      </div>
                  </a>
              </div>
              <div class="col-md-6 col-lg-3">
                  <a href="" class="item-bidang img-overlay bpk" title="Bidang Pertahanan & Keamanan">
                      <div class="title-bidang">
                          <div class="no-bidang">
                              <span>07</span>
                              <span>
                                  <i class="las la-arrow-right"></i>
                              </span>
                          </div>
                          <h6>Bidang Pertahanan & Keamanan</h6>
                      </div>
                      <div class="thumb-img">
                          <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                      </div>
                  </a>
              </div>
              <div class="col-md-6 col-lg-3">
                  <a href="" class="item-bidang img-overlay btie" title="Bidang Teknologi Informasi & Elektronik">
                      <div class="title-bidang">
                          <div class="no-bidang">
                              <span>08</span>
                              <span>
                                  <i class="las la-arrow-right"></i>
                              </span>
                          </div>
                          <h6>Bidang Teknologi Informasi & Elektronik</h6>
                      </div>
                      <div class="thumb-img">
                          <img src="{{ asset('assets/frontend/images/bid-8.jpg') }}" alt="">
                      </div>
                  </a>
              </div>
          </div>
      </div>
  </div>
</div>
<div class="box-wrap p-0 bg-dark">
  <div class="container">
      <div class="row align-items-center justify-content-between">
          
          <div class="col-lg-4">
              <div class="box-content-ai">
                  <div class="title-heading text-white">
                      <h5>BPPT Indonesia</h5>
                      <h1>Artificial Intelligence (AI)</h1>
                  </div>
                  <article class="summary-text text-white">
                      <p>Badan Pengkajian dan Penerapan Teknologi (BPPT) adalah Lembaga Pemerintah Non-Kementerian yang berada dibawah koordinasi Badan Riset Inovasi Nasional yang bertanggung jawab langsung ke Presiden dalam menjalankan tugas pemerintahan di bidang pengkajian dan penerapan teknologi.</p>
                  </article>
                  <div class="box-btn mt-5">
                      <a href="" class="btn btn-main"><span>Selengkapnya</span></a>
                  </div>
              </div>
          </div>
          <div class="col-lg-6">
              <div class="box-img-ai">
                  <img src="{{ asset('assets/frontend/images/ai.png') }}" alt="">
              </div>
          </div>
      </div>
  </div>
</div>
<div class="box-wrap">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-8">
              <div class="title-heading text-center">
                  <h5>BPPT Indonesia</h5>
                  <h1>Berita Terbaru</h1>
              </div>
              <article class="summary-text text-center">
              </article>
          </div>
      </div>
      <ul class="nav nav-tabs mt-3 mb-4" id="myTab" role="tablist">
          <li class="nav-item">
              <a class="nav-link active" id="hot-news-tab" data-toggle="tab" href="#hot-news" role="tab" aria-controls="hot-news" aria-selected="true">BPPT Hot News</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="berita-tab" data-toggle="tab" href="#berita" role="tab" aria-controls="berita" aria-selected="false">Berita BPPT</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="inovasi-tab" data-toggle="tab" href="#inovasi" role="tab" aria-controls="inovasi" aria-selected="false">Inovasi & Layanan</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="opini-tab" data-toggle="tab" href="#opini" role="tab" aria-controls="opini" aria-selected="false">Opini</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="agenda-tab" data-toggle="tab" href="#agenda" role="tab" aria-controls="agenda" aria-selected="false">Agenda Kegiatan</a>
          </li>
      </ul>
      <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="hot-news" role="tabpanel" aria-labelledby="hot-news-tab">
              <div class="row justify-content-around">
                  <div class="col-lg-8">
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/inovasi-presiden.jpeg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Layanan Info Publik
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images//inovasi-tech.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Kebijakan Teknologi
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images//tsunami.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Teknologi Sumberdaya Alam & Kebencanaan
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">09</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/luhut.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Teknologi Agroindustri dan Bioteknologi
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Menko Luhut Ajak Tingkatkan Nilai Tambah Serta Penggunaan Produksi Dalam Negeri </h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                      
                  </div>
                  <div class="col-lg-4">
                      <div class="box-list mt-0">
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/elang.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">18 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Wujudkan Pertumbuhan Ekonomi dan Kemandirian Industri Pertahanan Melalui Inovasi Teknologi </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images//cuaca.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">16 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/inovasi-presiden.jpeg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">15 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">13 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/tsunami.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">26 Juni 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images//cuaca.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">18 Mei 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                                  </a>
                              </div>
                          </div>
                      </div>
                      <div class="box-btn d-flex justify-content-end">
                          <a href="" class="btn btn-text"><span>Artikel Lainnya</span></a>
                      </div>
                  </div>
              </div>
              
          </div>
          <div class="tab-pane fade" id="berita" role="tabpanel" aria-labelledby="berita-tab">
              <div class="row justify-content-around">
                  <div class="col-lg-8">
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">09</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/luhut.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Teknologi Agroindustri dan Bioteknologi
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Menko Luhut Ajak Tingkatkan Nilai Tambah Serta Penggunaan Produksi Dalam Negeri </h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/inovasi-presiden.jpeg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Layanan Info Publik
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Kebijakan Teknologi
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images//tsunami.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Teknologi Sumberdaya Alam & Kebencanaan
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                         
                      </div>
                  </div>
                  <div class="col-lg-4">
                      <div class="box-list mt-0">
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/elang.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">18 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Wujudkan Pertumbuhan Ekonomi dan Kemandirian Industri Pertahanan Melalui Inovasi Teknologi </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/cuaca.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">16 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/inovasi-presiden.jpeg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">15 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">13 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/tsunami.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">26 Juni 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/cuaca.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">18 Mei 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                                  </a>
                              </div>
                          </div>
                      </div>
                      <div class="box-btn d-flex justify-content-end">
                          <a href="" class="btn btn-text"><span>Artikel Lainnya</span></a>
                      </div>
                  </div>
              </div>
          </div>
          <div class="tab-pane fade" id="inovasi" role="tabpanel" aria-labelledby="inovasi-tab">
              <div class="row justify-content-around">
                  <div class="col-lg-8">
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/tsunami.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Teknologi Sumberdaya Alam & Kebencanaan
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">09</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/luhut.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Teknologi Agroindustri dan Bioteknologi
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Menko Luhut Ajak Tingkatkan Nilai Tambah Serta Penggunaan Produksi Dalam Negeri </h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/inovasi-presiden.jpeg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Layanan Info Publik
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Kebijakan Teknologi
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4">
                      <div class="box-list mt-0">
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/elang.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">18 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Wujudkan Pertumbuhan Ekonomi dan Kemandirian Industri Pertahanan Melalui Inovasi Teknologi </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/cuaca.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">16 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/inovasi-presiden.jpeg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">15 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">13 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images//tsunami.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">26 Juni 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/cuaca.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">18 Mei 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                                  </a>
                              </div>
                          </div>
                      </div>
                      <div class="box-btn d-flex justify-content-end">
                          <a href="" class="btn btn-text"><span>Artikel Lainnya</span></a>
                      </div>
                  </div>
              </div>
          </div>
          <div class="tab-pane fade" id="opini" role="tabpanel" aria-labelledby="opini-tab">
              <div class="row justify-content-around">
                  <div class="col-lg-8">
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Kebijakan Teknologi
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/tsunami.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Teknologi Sumberdaya Alam & Kebencanaan
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">09</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/luhut.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Teknologi Agroindustri dan Bioteknologi
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Menko Luhut Ajak Tingkatkan Nilai Tambah Serta Penggunaan Produksi Dalam Negeri </h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/inovasi-presiden.jpeg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Layanan Info Publik
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4">
                      <div class="box-list mt-0">
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/elang.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">18 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Wujudkan Pertumbuhan Ekonomi dan Kemandirian Industri Pertahanan Melalui Inovasi Teknologi </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/cuaca.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">16 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/inovasi-presiden.jpeg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">15 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">13 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/tsunami.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">26 Juni 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/cuaca.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">18 Mei 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                                  </a>
                              </div>
                          </div>
                      </div>
                      <div class="box-btn d-flex justify-content-end">
                          <a href="" class="btn btn-text"><span>Artikel Lainnya</span></a>
                      </div>
                  </div>
              </div>
          </div>
          <div class="tab-pane fade" id="agenda" role="tabpanel" aria-labelledby="agenda-tab">
              <div class="row justify-content-around">
                  <div class="col-lg-8">
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/inovasi-presiden.jpeg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Layanan Info Publik
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Kebijakan Teknologi
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">08</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/tsunami.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Teknologi Sumberdaya Alam & Kebencanaan
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="item-post">
                                  <a href="" class="box-img img-overlay">
                                      <div class="box-date">
                                          <span class="dd">09</span>
                                          <span class="mmyy">Mar 2021</span>
                                      </div>
                                      <div class="thumb-img">
                                          <img src="{{ asset('assets/frontend/images/luhut.jpg') }}" alt="">
                                      </div>
                                  </a>
                                  <div class="box-info">
                                      <a href="" class="post-info_2">
                                          Teknologi Agroindustri dan Bioteknologi
                                      </a>
                                      <a href="">
                                          <h6 class="post-title">Menko Luhut Ajak Tingkatkan Nilai Tambah Serta Penggunaan Produksi Dalam Negeri </h6>
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4">
                      <div class="box-list mt-0">
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/elang.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">18 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Wujudkan Pertumbuhan Ekonomi dan Kemandirian Industri Pertahanan Melalui Inovasi Teknologi </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/cuaca.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">16 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/inovasi-presiden.jpeg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">15 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Melalui Inovasi, Presiden Jokowi Dorong BPPT Dalam Pertumbuhan Ekonomi Nasional</h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">13 Juli 20201</div>
                                  <a href="">
                                      <h6 class="post-title">BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images/tsunami.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">26 Juni 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Bangun Sistem Mitigasi Bencana Terintegrasi, BPPT Berhasil Pasang Buoy Tsunami di Selatan Bali </h6>
                                  </a>
                              </div>
                          </div>
                          <div class="item-post sm">
                              <a href="" class="box-img img-overlay">
                                  <div class="thumb-img">
                                      <img src="{{ asset('assets/frontend/images//cuaca.jpg') }}" alt="">
                                  </div>
                              </a>
                              <div class="box-info">
                                  <div class="post-info_2">18 Mei 20201</div>
                                  <a href="">
                                      <h6 class="post-title">Hadapi Potensi Cuaca Ekstrem, BPPT Terus Lakukan Operasi TMC </h6>
                                  </a>
                              </div>
                          </div>
                      </div>
                      <div class="box-btn d-flex justify-content-end">
                          <a href="" class="btn btn-text"><span>Artikel Lainnya</span></a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="box-list m-md-0">
          <ul class="list-hastag">
              <li class="item-hastag"><a href=""><span>Teknologi</span></a></li>
              <li class="item-hastag"><a href=""><span>AI</span></a></li>
              <li class="item-hastag"><a href=""><span>Indonesia</span></a></li>
              <li class="item-hastag"><a href=""><span>Smart</span></a></li>
              <li class="item-hastag"><a href=""><span>BPPTIndonesia</span></a></li>
          </ul>
      </div>
  </div>
  <div class="container">
      <div class="box-list">
          <h5 class="mb-4">Publikasi BPPT</h5>
          <div class="row">
              <div class="col-sm-6 col-md-4">
                  <div class="item-post">
                      <a href="" class="box-img img-overlay">
                          <div class="box-date">
                              <span class="dd">19</span>
                              <span class="mmyy">Apr 2021</span>
                          </div>
                          <div class="thumb-img">
                              <img src="{{ asset('assets/frontend/images/detik.jpg') }}" alt="">
                          </div>
                      </a>
                      <div class="box-info">
                          <div class="logo-info">
                             <img src="{{ asset('assets/frontend/images/logo-detikcom.png') }}" alt="">
                          </div>
                          <a href="">
                              <h6 class="post-title">Keren! Ini Penampakan Desain Kapal Selam Mini Buatan BPPT</h6>
                          </a>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6 col-md-4">
                  <div class="item-post">
                      <a href="" class="box-img img-overlay">
                          <div class="box-date">
                              <span class="dd">08</span>
                              <span class="mmyy">Mar 2021</span>
                          </div>
                          <div class="thumb-img">
                              <img src="{{ asset('assets/frontend/images/detik-jokowi.jpeg') }}" alt="">
                          </div>
                      </a>
                      <div class="box-info">
                          <div class="logo-info">
                              <img src="{{ asset('assets/frontend/images/logo-detikcom.png') }}" alt="">
                          </div>
                          <a href="">
                              <h6 class="post-title">Jokowi Pede BPPT Jadi Otak Pemulihan Ekonomi, Beri 3 Catatan Ini </h6>
                          </a>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6 col-md-4">
                  <div class="item-post">
                      <a href="" class="box-img img-overlay">
                          <div class="box-date">
                              <span class="dd">24</span>
                              <span class="mmyy">Sep 2020</span>
                          </div>
                          <div class="thumb-img">
                              <img src="{{ asset('assets/frontend/images/kompas-1.jpeg') }}" alt="">
                          </div>
                      </a>
                      <div class="box-info">
                          <div class="logo-info">
                              <img src="{{ asset('assets/frontend/images/logo-kompascom.png') }}" alt="">
                          </div>
                          <a href="">
                              <h6 class="post-title">Bersama China, BMKG Kembangkan 3 Sistem Baru Deteksi Gempa dan Tsunami</h6>
                          </a>
                      </div>
                  </div>
              </div>
              
          </div>
          <div class="box-btn d-flex justify-content-center">
              <a href="" class="btn btn-text"><span>Berita Lainnya</span></a>
          </div>
      </div>
  </div>
</div>
<div class="box-wrap bg-blue">
  <div class="container">
      <div class="row justify-content-between align-items-center">
          <div class="col-lg-3">
              <div class="title-heading text-white">
                  <h5>BPPT Indonesia</h5>
                  <h1>BPPT Links</h1>
              </div>
              <article class="text-summmary text-white">
              </article>
          </div>
          <div class="col-lg-8">
              <div class="row align-items-center justify-content-around">
                  <div class="col-6 col-lg-3">
                      <a href="" class="item-partner">
                          <img src="{{ asset('assets/frontend/images/bppt_tv.png') }}" alt="">
                      </a>
                  </div>
                  <div class="col-6 col-lg-3">
                      <a href="" class="item-partner">
                          <img src="{{ asset('assets/frontend/images/lhkpn.png') }}" alt="">
                      </a>
                  </div>
                  <div class="col-6 col-lg-3">
                      <a href="" class="item-partner">
                          <img src="{{ asset('assets/frontend/images/lapor.png') }}" alt="">
                      </a>
                  </div>
                  <div class="col-6 col-lg-3">
                      <a href="" class="item-partner">
                          <img src="{{ asset('assets/frontend/images/jdih.png') }}" alt="">
                      </a>
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
    var introContent = new Swiper('.intro-content-slide', {
        spaceBetween: 10,
        touchRatio: 0.2,
        slideToClickedSlide: true,
        loop: true,
        speed: 1000,
        parallax: true,
        
    });

    var introImage = new Swiper('.intro-img-slide', {
        spaceBetween: 0,
        slidesPerView: 1,
        navigation: {
            nextEl: '.sbn-1',
            prevEl: '.sbp-1',
        },
        loop: true,
        parallax: true,
        effect: 'fade',
        autoplay: {
            delay: 5000,
        },
        speed: 1000,
        breakpoints: {
            // when window width is <= 575.98px
            991.98: {
                draggable: true,
                simulateTouch: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                
            }
            
        }
    });
    
    introContent.controller.control = introImage;
    introImage.controller.control = introContent;
</script>
@endsection
