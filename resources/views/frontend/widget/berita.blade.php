<div class="box-wrap" style="padding-top: 2em;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="title-heading text-center">
                    <h5>{!! $config['website_name'] !!}</h5>
                    <h1>@lang('common.news_new_caption')</h1>
                </div>
                <article class="summary-text text-center">
                </article>
            </div>
        </div>
        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            @if (!empty($data['berita']))  
            <li class="nav-item">
                <a class="nav-link active" id="hot-news-tab" data-toggle="tab" href="#hot-news" role="tab" aria-controls="hot-news" aria-selected="true" title="@lang('common.hot_news_caption')">@lang('common.hot_news_caption')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="berita-tab" data-toggle="tab" href="#berita" role="tab" aria-controls="berita" aria-selected="false" title="{!! $data['berita']->fieldLang('name') !!}">{!! $data['berita']->fieldLang('name') !!}</a>
            </li>
            @endif
            @if (!empty($data['inovasi']))  
            <li class="nav-item">
                <a class="nav-link" id="inovasi-tab" data-toggle="tab" href="#inovasi" role="tab" aria-controls="inovasi" aria-selected="false" title="@lang('common.inovation_caption')">@lang('common.inovation_caption')</a>
            </li>
            @endif
            @if (!empty($data['opini']))  
            <li class="nav-item">
                <a class="nav-link" id="opini-tab" data-toggle="tab" href="#opini" role="tab" aria-controls="opini" aria-selected="false" title="{!! $data['opini']->fieldLang('name') !!}">{!! $data['opini']->fieldLang('name') !!}</a>
            </li>
            @endif
        </ul>
        <div class="tab-content" id="myTabContent">
            @if (!empty($data['berita']))  
            <div class="tab-pane fade show active" id="hot-news" role="tabpanel" aria-labelledby="hot-news-tab">
                <div class="row justify-content-around">
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach ($data['berita']->posts()->publish()->orderBy('viewer', 'DESC')->limit(4)->get() as $hot)
                            <div class="col-sm-6">
                                <div class="item-post">
                                    <a href="{{ route('post.read.'.$hot->section->slug, ['slugPost' => $hot->slug]) }}" class="box-img img-overlay" title="{!! $hot->fieldLang('title') !!}">
                                        <div class="box-date">
                                            <span class="dd">{{ $hot->created_at->format('d') }}</span>
                                            <span class="mmyy">{{ $hot->created_at->format('F Y') }}</span>
                                        </div>
                                        <div class="thumb-img">
                                            <img src="{{ $hot->coverSrc() }}" alt="{{ $hot->cover['alt'] }}" title="{{ $hot->cover['title'] }}">
                                        </div>
                                    </a>
                                    <div class="box-info">
                                        <a href="{{ route('category.read.'.$hot->section->slug, ['slugCategory' => $hot->category->slug]) }}" class="post-info_2" title="{!! $hot->category->fieldLang('name') !!}">
                                            {!! $hot->category->fieldLang('name') !!}
                                        </a>
                                        <a href="{{ route('post.read.'.$hot->section->slug, ['slugPost' => $hot->slug]) }}" title="{!! $hot->fieldLang('title') !!}">
                                            <h6 class="post-title">{!! $hot->fieldLang('title') !!}</h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                    </div>
                    <div class="col-lg-4">
                        <div class="box-list mt-0">
                            @foreach ($data['berita']->posts()->publish()->orderBy('viewer', 'DESC')->limit(6)->get() as $hot)
                            <div class="item-post sm">
                                <a href="{{ route('post.read.'.$hot->section->slug, ['slugPost' => $hot->slug]) }}" class="box-img img-overlay" title="{!! $hot->fieldLang('title') !!}">
                                    <div class="thumb-img">
                                        <img src="{{ $hot->coverSrc() }}" alt="{{ $hot->cover['alt'] }}" title="{{ $hot->cover['title'] }}">
                                    </div>
                                </a>
                                <div class="box-info">
                                    <div class="post-info_2">{{ $hot->created_at->format('d F Y') }}</div>
                                    <a href="{{ route('post.read.'.$hot->section->slug, ['slugPost' => $hot->slug]) }}" title="{!! $hot->fieldLang('title') !!}">
                                        <h6 class="post-title">{!! $hot->fieldLang('title') !!}</h6>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="box-btn d-flex justify-content-end">
                            <a href="{{ route('section.read.'.$data['berita']->slug) }}" class="btn btn-text" title="@lang('common.other')"><span>@lang('common.other')</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="berita" role="tabpanel" aria-labelledby="berita-tab">
                <div class="row justify-content-around">
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach ($data['berita']->posts()->publish()->orderBy('created_at', 'DESC')->limit(4)->get() as $berita)
                            <div class="col-sm-6">
                                <div class="item-post">
                                    <a href="{{ route('post.read.'.$berita->section->slug, ['slugPost' => $berita->slug]) }}" class="box-img img-overlay" title="{!! $berita->fieldLang('title') !!}">
                                        <div class="box-date">
                                            <span class="dd">{{ $berita->created_at->format('d') }}</span>
                                            <span class="mmyy">{{ $berita->created_at->format('F Y') }}</span>
                                        </div>
                                        <div class="thumb-img">
                                            <img src="{{ $berita->coverSrc() }}" alt="{{ $berita->cover['alt'] }}" title="{{ $berita->cover['title'] }}">
                                        </div>
                                    </a>
                                    <div class="box-info">
                                        <a href="{{ route('category.read.'.$berita->section->slug, ['slugCategory' => $berita->category->slug]) }}" class="post-info_2" title="{!! $berita->category->fieldLang('name') !!}">
                                            {!! $berita->category->fieldLang('name') !!}
                                        </a>
                                        <a href="{{ route('post.read.'.$berita->section->slug, ['slugPost' => $berita->slug]) }}" title="{!! $berita->fieldLang('title') !!}">
                                            <h6 class="post-title">{!! $berita->fieldLang('title') !!}</h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                    </div>
                    <div class="col-lg-4">
                        <div class="box-list mt-0">
                            @foreach ($data['berita']->posts()->publish()->orderBy('created_at', 'DESC')->limit(6)->get() as $berita)
                            <div class="item-post sm">
                                <a href="{{ route('post.read.'.$berita->section->slug, ['slugPost' => $berita->slug]) }}" class="box-img img-overlay" title="{!! $berita->fieldLang('title') !!}">
                                    <div class="thumb-img">
                                        <img src="{{ $berita->coverSrc() }}" alt="{{ $berita->cover['alt'] }}" title="{{ $berita->cover['title'] }}">
                                    </div>
                                </a>
                                <div class="box-info">
                                    <div class="post-info_2">{{ $berita->created_at->format('d F Y') }}</div>
                                    <a href="{{ route('post.read.'.$berita->section->slug, ['slugPost' => $berita->slug]) }}" title="{!! $berita->fieldLang('title') !!}">
                                        <h6 class="post-title">{!! $berita->fieldLang('title') !!}</h6>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="box-btn d-flex justify-content-end">
                            <a href="{{ route('section.read.'.$data['berita']->slug) }}" class="btn btn-text" title="@lang('common.other')"><span>@lang('common.other')</span></a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (!empty($data['inovasi']))  
            <div class="tab-pane fade" id="inovasi" role="tabpanel" aria-labelledby="inovasi-tab">
                <div class="row justify-content-around">
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach ($data['inovasi']->posts()->publish()->orderBy('created_at', 'DESC')->limit(4)->get() as $inovasi)
                            <div class="col-sm-6">
                                <div class="item-post">
                                    <a href="{{ route('post.read.'.$inovasi->section->slug, ['slugPost' => $inovasi->slug]) }}" class="box-img img-overlay" title="{!! $inovasi->fieldLang('title') !!}">
                                        <div class="box-date">
                                            <span class="dd">{{ $inovasi->created_at->format('d') }}</span>
                                            <span class="mmyy">{{ $inovasi->created_at->format('F Y') }}</span>
                                        </div>
                                        <div class="thumb-img">
                                            <img src="{{ $inovasi->coverSrc() }}" alt="{{ $inovasi->cover['alt'] }}" title="{{ $inovasi->cover['title'] }}">
                                        </div>
                                    </a>
                                    <div class="box-info">
                                        <a href="{{ route('category.read.'.$inovasi->section->slug, ['slugCategory' => $inovasi->category->slug]) }}" class="post-info_2" title="{!! $inovasi->category->fieldLang('name') !!}">
                                            {!! $inovasi->category->fieldLang('name') !!}
                                        </a>
                                        <a href="{{ route('post.read.'.$inovasi->section->slug, ['slugPost' => $inovasi->slug]) }}" title="{!! $inovasi->fieldLang('title') !!}">
                                            <h6 class="post-title">{!! $inovasi->fieldLang('title') !!}</h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                    </div>
                    <div class="col-lg-4">
                        <div class="box-list mt-0">
                            @foreach ($data['inovasi']->posts()->publish()->orderBy('created_at', 'DESC')->limit(6)->get() as $inovasi)
                            <div class="item-post sm">
                                <a href="{{ route('post.read.'.$inovasi->section->slug, ['slugPost' => $inovasi->slug]) }}" class="box-img img-overlay" title="{!! $inovasi->fieldLang('title') !!}">
                                    <div class="thumb-img">
                                        <img src="{{ $inovasi->coverSrc() }}" alt="{{ $inovasi->cover['alt'] }}" title="{{ $inovasi->cover['title'] }}">
                                    </div>
                                </a>
                                <div class="box-info">
                                    <div class="post-info_2">{{ $inovasi->created_at->format('d F Y') }}</div>
                                    <a href="{{ route('post.read.'.$inovasi->section->slug, ['slugPost' => $inovasi->slug]) }}" title="{!! $inovasi->fieldLang('title') !!}">
                                        <h6 class="post-title">{!! $inovasi->fieldLang('title') !!}</h6>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="box-btn d-flex justify-content-end">
                            <a href="{{ route('section.read.'.$data['inovasi']->slug) }}" class="btn btn-text" title="@lang('common.other')"><span>@lang('common.other')</span></a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (!empty($data['opini']))  
            <div class="tab-pane fade" id="opini" role="tabpanel" aria-labelledby="opini-tab">
                <div class="row justify-content-around">
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach ($data['opini']->posts()->publish()->orderBy('created_at', 'DESC')->limit(4)->get() as $opini)
                            <div class="col-sm-6">
                                <div class="item-post">
                                    <a href="{{ route('post.read.'.$opini->section->slug, ['slugPost' => $opini->slug]) }}" class="box-img img-overlay" title="{!! $opini->fieldLang('title') !!}">
                                        <div class="box-date">
                                            <span class="dd">{{ $opini->created_at->format('d') }}</span>
                                            <span class="mmyy">{{ $opini->created_at->format('F Y') }}</span>
                                        </div>
                                        <div class="thumb-img">
                                            <img src="{{ $opini->coverSrc() }}" alt="{{ $opini->cover['alt'] }}" title="{{ $opini->cover['title'] }}">
                                        </div>
                                    </a>
                                    <div class="box-info">
                                        <a href="{{ route('category.read.'.$opini->section->slug, ['slugCategory' => $opini->category->slug]) }}" class="post-info_2" title="{!! $opini->category->fieldLang('name') !!}">
                                            {!! $opini->category->fieldLang('name') !!}
                                        </a>
                                        <a href="{{ route('post.read.'.$opini->section->slug, ['slugPost' => $opini->slug]) }}" title="{!! $opini->fieldLang('title') !!}">
                                            <h6 class="post-title">{!! $opini->fieldLang('title') !!}</h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                    </div>
                    <div class="col-lg-4">
                        <div class="box-list mt-0">
                            @foreach ($data['opini']->posts()->publish()->orderBy('created_at', 'DESC')->limit(6)->get() as $opini)
                            <div class="item-post sm">
                                <a href="{{ route('post.read.'.$opini->section->slug, ['slugPost' => $opini->slug]) }}" class="box-img img-overlay" title="{!! $opini->fieldLang('title') !!}">
                                    <div class="thumb-img">
                                        <img src="{{ $opini->coverSrc() }}" alt="{{ $opini->cover['alt'] }}" title="{{ $opini->cover['title'] }}">
                                    </div>
                                </a>
                                <div class="box-info">
                                    <div class="post-info_2">{{ $opini->created_at->format('d F Y') }}</div>
                                    <a href="{{ route('post.read.'.$opini->section->slug, ['slugPost' => $opini->slug]) }}" title="{!! $opini->fieldLang('title') !!}">
                                        <h6 class="post-title">{!! $opini->fieldLang('title') !!}</h6>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="box-btn d-flex justify-content-end">
                            <a href="{{ route('section.read.'.$data['opini']->slug) }}" class="btn btn-text" title="@lang('common.other')"><span>@lang('common.other')</span></a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="box-list my-4">
            <ul class="list-hastag">
                @foreach ($data['tags'] as $tag)
                <li class="item-hastag"><a href="{{ route('home.search', ['tags' => $tag->name]) }}" title="{!! $tag->name !!}"><span>{!! $tag->name !!}</span></a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @if (!empty($data['publikasi'])) 
            <div class="col-lg-8">
                <h5 class="mb-4">@lang('common.publication_caption')</h5>
                <div class="row">
                    @foreach ($data['publikasi']->posts()->publish()->orderBy('created_at', 'DESC')->limit(4)->get() as $publikasi)
                    <div class="col-sm-6">
                        <div class="item-post">
                            <a href="{{ route('post.read.'.$publikasi->section->slug, ['slugPost' => $publikasi->slug]) }}" class="box-img img-overlay" title="{!! $publikasi->fieldLang('title') !!}">
                                <div class="box-date">
                                    <span class="dd">{{ $publikasi->created_at->format('d') }}</span>
                                            <span class="mmyy">{{ $publikasi->created_at->format('F Y') }}</span>
                                </div>
                                <div class="thumb-img">
                                    <img src="{{ $publikasi->coverSrc() }}" alt="{{ $publikasi->cover['alt'] }}" title="{{ $publikasi->cover['title'] }}">
                                </div>
                            </a>
                            <div class="box-info">
                                <div class="logo-info">
                                <img src="{{ $publikasi->category->bannerSrc() }}" alt="">
                                </div>
                                <a href="{{ route('post.read.'.$publikasi->section->slug, ['slugPost' => $publikasi->slug]) }}" title="{!! $publikasi->fieldLang('title') !!}">
                                    <h6 class="post-title">{!! $publikasi->fieldLang('title') !!}</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="box-btn d-flex justify-content-center mt-3">
                    <a href="{{ route('section.read.'.$data['publikasi']->slug) }}" class="btn btn-main" title="{!! $data['publikasi']->fieldLang('name') !!} @lang('common.other')"><span>{!! $data['publikasi']->fieldLang('name') !!} @lang('common.other')</span></a>
                </div>
                
            </div>
            @endif
            <div class="col-lg-4">
                <div class="box-gpr">
                    <h5 class="mb-4">Government Public Relations (GPR)</h5>
                    <div id="gpr-kominfo-widget-container"></div>
                </div>
            </div>
        </div>
        
    </div>
</div>