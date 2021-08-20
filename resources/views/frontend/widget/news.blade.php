<div class="box-wrap" style="padding-top: 2em;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="title-heading text-center">
                    <h1>@lang('common.latest_news_caption')</h1>
                </div>
                <article class="summary-text text-center">
                </article>
            </div>
        </div>
        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="berita-tab" data-toggle="tab" href="#berita" role="tab" aria-controls="berita" aria-selected="true" title="{!! $data['news']->first()->section->fieldLang('name') !!}">{!! $data['news']->first()->section->fieldLang('name') !!}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="inovasi-tab" data-toggle="tab" href="#inovasi" role="tab" aria-controls="inovasi" aria-selected="false" title="{!! $data['inovations']->first()->section->fieldLang('name') !!}">{!! $data['inovations']->first()->section->fieldLang('name') !!}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="opini-tab" data-toggle="tab" href="#opini" role="tab" aria-controls="opini" aria-selected="false" title="{!! $data['opini']->first()->section->fieldLang('name') !!}">{!! $data['opini']->first()->section->fieldLang('name') !!}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="hot-news-tab" data-toggle="tab" href="#hot-news" role="tab" aria-controls="hot-news" aria-selected="false" title="@lang('common.hot_news_caption')">@lang('common.hot_news_caption')</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="hot-news" role="tabpanel" aria-labelledby="hot-news-tab">
                <div class="row justify-content-around">
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach ($data['hot_news']->take(4) as $hot)
                            <div class="col-sm-6">
                                <div class="item-post">
                                    <a href="{{ route('post.read.'.$hot->section->slug, ['slugPost' => $hot->slug]) }}" class="box-img img-overlay" title="{!! $hot->fieldLang('title') !!}">
                                        <div class="box-date">
                                            <span class="dd">{{ $hot->created_at->format('d') }}</span>
                                            <span class="mmyy">{{ $hot->created_at->format('M Y') }}</span>
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
                            @foreach ($data['hot_news']->take(6) as $hot)
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
                            <a href="{{ route('section.read.'.$data['news']->first()->section->slug) }}" class="btn btn-text" title="@lang('common.view_more')"><span>@lang('common.view_more')</span></a>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="tab-pane fade show active" id="berita" role="tabpanel" aria-labelledby="berita-tab">
                <div class="row justify-content-around">
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach ($data['news']->take(4) as $news)
                            <div class="col-sm-6">
                                <div class="item-post">
                                    <a href="{{ route('post.read.'.$news->section->slug, ['slugPost' => $news->slug]) }}" class="box-img img-overlay" title="{!! $news->fieldLang('title') !!}">
                                        <div class="box-date">
                                            <span class="dd">{{ $news->created_at->format('d') }}</span>
                                            <span class="mmyy">{{ $news->created_at->format('M Y') }}</span>
                                        </div>
                                        <div class="thumb-img">
                                            <img src="{{ $news->coverSrc() }}" alt="{{ $news->cover['alt'] }}" title="{{ $news->cover['title'] }}">
                                        </div>
                                    </a>
                                    <div class="box-info">
                                        <a href="{{ route('category.read.'.$news->section->slug, ['slugCategory' => $news->category->slug]) }}" class="post-info_2" title="{!! $news->category->fieldLang('name') !!}">
                                            {!! $news->category->fieldLang('name') !!}
                                        </a>
                                        <a href="{{ route('post.read.'.$news->section->slug, ['slugPost' => $news->slug]) }}" title="{!! $news->fieldLang('title') !!}">
                                            <h6 class="post-title">{!! $news->fieldLang('title') !!}</h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="box-list mt-0">
                            @foreach ($data['news']->take(6) as $news)
                            <div class="item-post sm">
                                <a href="{{ route('post.read.'.$news->section->slug, ['slugPost' => $news->slug]) }}" class="box-img img-overlay" title="{!! $news->fieldLang('title') !!}">
                                    <div class="thumb-img">
                                        <img src="{{ $news->coverSrc() }}" alt="{{ $news->cover['alt'] }}" title="{{ $news->cover['title'] }}">
                                    </div>
                                </a>
                                <div class="box-info">
                                    <div class="post-info_2">{{ $news->created_at->format('d F Y') }}</div>
                                    <a href="{{ route('post.read.'.$news->section->slug, ['slugPost' => $news->slug]) }}" title="{!! $news->fieldLang('title') !!}">
                                        <h6 class="post-title">{!! $news->fieldLang('title') !!}</h6>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="box-btn d-flex justify-content-end">
                            <a href="{{ route('section.read.'.$data['news']->first()->section->slug) }}" class="btn btn-text" title="@lang('common.view_more')"><span>@lang('common.view_more')</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="inovasi" role="tabpanel" aria-labelledby="inovasi-tab">
                <div class="row justify-content-around">
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach ($data['inovations']->take(4) as $inov)
                            <div class="col-sm-6">
                                <div class="item-post">
                                    <a href="{{ route('post.read.'.$inov->section->slug, ['slugPost' => $inov->slug]) }}" class="box-img img-overlay" title="{!! $inov->fieldLang('title') !!}">
                                        <div class="box-date">
                                            <span class="dd">{{ $inov->created_at->format('d') }}</span>
                                            <span class="mmyy">{{ $inov->created_at->format('M Y') }}</span>
                                        </div>
                                        <div class="thumb-img">
                                            <img src="{{ $inov->coverSrc() }}" alt="{{ $inov->cover['alt'] }}" title="{{ $inov->cover['title'] }}">
                                        </div>
                                    </a>
                                    <div class="box-info">
                                        <a href="{{ route('category.read.'.$inov->section->slug, ['slugCategory' => $inov->category->slug]) }}" class="post-info_2" title="{!! $inov->category->fieldLang('name') !!}">
                                            {!! $inov->category->fieldLang('name') !!}
                                        </a>
                                        <a href="{{ route('post.read.'.$inov->section->slug, ['slugPost' => $inov->slug]) }}" title="{!! $inov->fieldLang('title') !!}">
                                            <h6 class="post-title">{!! $inov->fieldLang('title') !!}</h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="box-list mt-0">
                            @foreach ($data['inovations']->take(6) as $inov)
                            <div class="item-post sm">
                                <a href="{{ route('post.read.'.$inov->section->slug, ['slugPost' => $inov->slug]) }}" class="box-img img-overlay" title="{!! $inov->fieldLang('title') !!}">
                                    <div class="thumb-img">
                                        <img src="{{ $inov->coverSrc() }}" alt="{{ $inov->cover['alt'] }}" title="{{ $inov->cover['title'] }}">
                                    </div>
                                </a>
                                <div class="box-info">
                                    <div class="post-info_2">{{ $inov->created_at->format('d F Y') }}</div>
                                    <a href="{{ route('post.read.'.$inov->section->slug, ['slugPost' => $inov->slug]) }}" title="{!! $inov->fieldLang('title') !!}">
                                        <h6 class="post-title">{!! $inov->fieldLang('title') !!}</h6>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="box-btn d-flex justify-content-end">
                            <a href="{{ route('section.read.'.$data['inovations']->first()->section->slug) }}" class="btn btn-text" title="@lang('common.view_more')"><span>@lang('common.view_more')</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="opini" role="tabpanel" aria-labelledby="opini-tab">
                <div class="row justify-content-around">
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach ($data['opini']->take(4) as $opini)
                            <div class="col-sm-6">
                                <div class="item-post">
                                    <a href="{{ route('post.read.'.$opini->section->slug, ['slugPost' => $opini->slug]) }}" class="box-img img-overlay" title="{!! $opini->fieldLang('title') !!}">
                                        <div class="box-date">
                                            <span class="dd">{{ $opini->created_at->format('d') }}</span>
                                            <span class="mmyy">{{ $opini->created_at->format('M Y') }}</span>
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
                            @foreach ($data['opini']->take(6) as $opini)
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
                            <a href="{{ route('section.read.'.$data['opini']->first()->section->slug) }}" class="btn btn-text" title="@lang('common.view_more')"><span>@lang('common.view_more')</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-list my-4">
            <ul class="list-hastag">
                @foreach ($data['tags']->take(5) as $tag)
                <li class="item-hastag">
                    <a href="{{ route('home.search', ['tags' => $tag->name]) }}" title="{!! $tag->name !!}"><span>{!! $tag->name !!}</span></a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>