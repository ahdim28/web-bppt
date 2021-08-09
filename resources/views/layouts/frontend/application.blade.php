<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>

    <meta charset="utf-8">
    <meta name="theme-color" content="#086ad8"/>
    <meta name="title" content="{!! isset($data['meta_title']) ? strip_tags($data['meta_title']) : strip_tags($config['meta_title']) !!}">
    <meta name="description" content="{!! isset($data['meta_description']) ? strip_tags($data['meta_description']) : strip_tags($config['meta_description']) !!}">
    <meta name="keywords" content="{!! isset($data['meta_keywords']) ? strip_tags($data['meta_keywords']) : strip_tags($config['meta_keywords']) !!}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title.' | ' : '' }} @yield('title') {{ strip_tags($config['meta_title']) }}</title>

    <meta name="robots" content="index,follow" />
    <meta name="googlebot" content="index,follow" />
    <meta name="revisit-after" content="2 days" />
    <meta name="author" content="4 Vision Media">
    <meta name="expires" content="never" />

    <meta name="google-site-verification" content="{!! $config['google_verification'] !!}" />
    <meta name="p:domain_verify" content="{!! $config['domain_verification'] !!}"/>

    <meta property="og:locale" content="{{ App::getlocale().'_'.strtoupper(App::getlocale()) }}" />
    <meta property="og:site_name" content="{{ route('home') }}">
    <meta property="og:title" content="{!! isset($data['meta_title']) ? strip_tags($data['meta_title']) : strip_tags($config['meta_title']) !!}"/>
    <meta property="og:url" name="url" content="{{ url()->full() }}">
    <meta property="og:description" content="{!! isset($data['meta_description']) ? $data['meta_description'] : $config['meta_description'] !!}"/>
    <meta property="og:image" content="{!! isset($data['cover']) ? asset($data['cover']) : $config['open_graph'] !!}"/>
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{!! isset($data['meta_title']) ? strip_tags($data['meta_title']) : strip_tags($config['meta_title']) !!}">
    <meta name="twitter:site" content="{{ url()->full() }}">
    <meta name="twitter:creator" content="{!! isset($data['creator']) ? $data['creator'] : 'Administrator Web' !!}">
    <meta name="twitter:description" content="{!! isset($data['meta_description']) ? strip_tags($data['meta_description']) : strip_tags($config['meta_description']) !!}">
    <meta name="twitter:image" content="{!! isset($data['cover']) ? asset($data['cover']) : $config['open_graph'] !!}">

    <link rel="canonical" href="{{ url()->full() }}" />

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('assets/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#086ad8">
    <meta name="msapplication-TileImage" content="{{ asset('assets/favicon/ms-icon-144x144.png') }}">

    <!-- Fonts -->

    <!-- Css Global -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/line-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/lightgallery.css') }}">
    
    <!-- Css Additional -->
    @yield('styles')
    
    <!-- jQuery header -->
    @yield('jshead')


    {!! $config['google_analytics'] !!}
</head>
    <body @yield('body-attr')>

        @yield('layout-content')
        
        <div class="float-bidang">
            <div class="close-toggle-bidang">
                <i class="las la-times"></i>
            </div>
            <div class="item-float-bidang">
                <a href="" class="item-bidang img-overlay btk" title="Teknologi Kebencanaan">
                    <div class="title-bidang">
                        <div class="no-bidang">
                            <span>01</span>
                            <span><i class="las la-arrow-right"></i></span>
                        </div>
                        <h6>Teknologi Kebencanaan</h6>
                    </div>
                    <div class="thumb-img">
                        <img src="{{ asset('assets/frontend/images/bid-1.jpeg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item-float-bidang">
                <a href="" class="item-bidang img-overlay brk" title="Rekayasa Keteknikan">
                    <div class="title-bidang">
                        <div class="no-bidang">
                            <span>02</span>
                            <span>
                                <i class="las la-arrow-right"></i>
                            </span>
                        </div>
                        <h6>Rekayasa Keteknikan</h6>
                    </div>
                    <div class="thumb-img">
                        <img src="{{ asset('assets/frontend/images/bid-2.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item-float-bidang">
                <a href="" class="item-bidang img-overlay bk" title="Kemaritiman">
                    <div class="title-bidang">
                        <div class="no-bidang">
                            <span>03</span>
                            <span>
                                <i class="las la-arrow-right"></i>
                            </span>
                        </div>
                        <h6>Kemaritiman</h6>
                    </div>
                    <div class="thumb-img">
                        <img src="{{ asset('assets/frontend/images/bid-3.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item-float-bidang">
                <a href="" class="item-bidang img-overlay bt" title="Transportasi">
                    <div class="title-bidang">
                        <div class="no-bidang">
                            <span>04</span>
                            <span>
                                <i class="las la-arrow-right"></i>
                            </span>
                        </div>
                        <h6>Transportasi</h6>
                    </div>
                    <div class="thumb-img">
                        <img src="{{ asset('assets/frontend/images/bid-4.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item-float-bidang">
                <a href="" class="item-bidang img-overlay bkp" title="Kesehatan & Pangan">
                    <div class="title-bidang">
                        <div class="no-bidang">
                            <span>05</span>
                            <span>
                                <i class="las la-arrow-right"></i>
                            </span>
                        </div>
                        <h6>Kesehatan & Pangan</h6>
                    </div>
                    <div class="thumb-img">
                        <img src="{{ asset('assets/frontend/images/bid-5.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item-float-bidang">
                <a href="" class="item-bidang img-overlay be" title="Energi">
                    <div class="title-bidang">
                        <div class="no-bidang">
                            <span>06</span>
                            <span>
                                <i class="las la-arrow-right"></i>
                            </span>
                        </div>
                        <h6>Energi</h6>
                    </div>
                    <div class="thumb-img">
                        <img src="{{ asset('assets/frontend/images/bid-6.jpg') }}" alt="">
                    </div>
                </a>
            </div>
            <div class="item-float-bidang">
                <a href="" class="item-bidang img-overlay bpk" title="Pertahanan & Keamanan">
                    <div class="title-bidang">
                        <div class="no-bidang">
                            <span>07</span>
                            <span>
                                <i class="las la-arrow-right"></i>
                            </span>
                        </div>
                        <h6>Pertahanan & Keamanan</h6>
                    </div>
                    <div class="thumb-img">
                        <img src="images/inovasi-tech.jpg" alt="">
                    </div>
                </a>
            </div>
            <div class="item-float-bidang">
                <a href="" class="item-bidang img-overlay btie" title="Teknologi Informasi & Elektronik">
                    <div class="title-bidang">
                        <div class="no-bidang">
                            <span>08</span>
                            <span>
                                <i class="las la-arrow-right"></i>
                            </span>
                        </div>
                        <h6>Teknologi Informasi & Elektronik</h6>
                    </div>
                    <div class="thumb-img">
                        <img src="{{ asset('assets/frontend/images/bid-8.jpg') }}" alt="">
                    </div>
                </a>
            </div>
        </div>

        <a id="button-top"><i class="las la-arrow-up"></i></a>
        <!-- jQuery Global-->
        <script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>

        <!-- jQuery addtional-->
        <script src="{{ asset('assets/frontend/js/jquery.easing.min.js') }}"></script>   
        <script src="{{ asset('assets/frontend/js/scrolling-nav.js') }}"></script>
        <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/frontend/js/lightgallery.js') }}"></script>
        <script src="{{ asset('assets/frontend/js/main.js') }}"></script>   
        @yield('scripts')

        <!-- jsbody-->
        @yield('jsbody')

    </body>
</html>
