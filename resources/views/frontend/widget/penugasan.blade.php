@if (!empty($data['penugasan']))
<div class="box-wrap bg-grey">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-8">
                <div class="title-heading">
                    <h5>{!! $config['website_name'] !!}</h5>
                    <h1>{!! $data['penugasan']->fieldLang('title') !!}</h1>
                </div>
                <article class="summary-text">
                    <p>Badan Pengkajian dan Penerapan Teknologi (BPPT) adalah Lembaga Pemerintah Non-Kementerian yang berada dibawah koordinasi Badan Riset Inovasi Nasional yang bertanggung jawab langsung ke Presiden dalam menjalankan tugas pemerintahan di bidang pengkajian dan penerapan teknologi.</p>
                </article>
                
            </div>
            <div class="col-lg-4">
                <div class="swiper-button-wrapper d-none d-lg-flex justify-content-end align-items-center">
                    <div class="swiper-button-prev swiper-btn sbp-2"><i class="las la-arrow-left"></i></div>
                    <div class="swiper-button-next swiper-btn sbn-2"><i class="las la-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <div class="assignment-slide swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="" class="item-assignment">
                        <div class="box-img img-overlay">
                            <div class="title-assignment">
                                <div class="no-bidang">
                                    <span><i class="las la-arrow-right"></i></span>
                                    <span><i class="las la-arrow-right"></i></span>
                                </div>
                                <h6>Sistem Informasi zoonosisi (SIZE)</h6>
                            </div>
                            <div class="thumb-img">
                                <img src="{{ asset('assets/frontend/images/zoonosisi.jpeg') }}" alt="">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="" class="item-assignment">
                        <div class="box-img img-overlay">
                             <div class="title-assignment">
                                <div class="no-bidang">
                                    <span><i class="las la-arrow-right"></i></span>
                                    <span><i class="las la-arrow-right"></i></span>
                                </div>
                                <h6>Kendaraan Listrik Berbasis Baterai</h6>
                            </div>
                            <div class="thumb-img">
                                <img src="{{ asset('assets/frontend/images/kendaraan-listrik.jpg') }}" alt="">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="" class="item-assignment">
                        <div class="box-img img-overlay">
                             <div class="title-assignment">
                                <div class="no-bidang">
                                    <span><i class="las la-arrow-right"></i></span>
                                    <span><i class="las la-arrow-right"></i></span>
                                </div>
                                <h6>SPBE</h6>
                            </div>
                            <div class="thumb-img">
                                <img src="{{ asset('assets/frontend/images/spbe.jpeg') }}" alt="">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="" class="item-assignment">
                        <div class="box-img img-overlay">
                             <div class="title-assignment">
                                <div class="no-bidang">
                                    <span><i class="las la-arrow-right"></i></span>
                                    <span><i class="las la-arrow-right"></i></span>
                                </div>
                                <h6>Penghapusan Emas Merkuri</h6>
                            </div>
                            <div class="thumb-img">
                                <img src="{{ asset('assets/frontend/images/merkuri.jpeg') }}" alt="">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="swiper-pagination d-block d-lg-none"></div>
        </div>
    </div>
</div>
@endif