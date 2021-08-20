@if (!empty($data['inovation']))  
<div class="box-wrap bg-grey">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="title-heading text-center">
                    <h1>{!! $data['inovation']->fieldLang('name') !!}</h1>
                </div>
                <article class="summary-text text-center">
                    {!! $data['inovation']->fieldLang('description') !!}
                </article>
            </div>
        </div>
        <div class="box-list">
            <div class="row justify-content-center">
                @foreach ($data['inovation']->posts()->publish()->orderBy('created_at', 'DESC')->limit(8)->get() as $inov)
                <div class="col-md-6 col-xl-3">
                    <a href="{{ route('post.read.'.$inov->section->slug, ['slugPost' => $inov->slug]) }}" class="item-innovation" title="{!! $inov->fieldLang('title') !!}">
                        <div class="box-img">
                            <div class="thumb-img">
                                <img src="{{ $inov->coverSrc() }}" alt="{{ $inov->cover['alt'] }}" title="{{ $inov->cover['title'] }}">
                            </div>
                        </div>
                        <div class="innovation-desc">
                            <div class="title-innovation">
                                <h6>{!! $inov->fieldLang('title') !!}</h6>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="box-btn d-flex justify-content-center mt-5">
                <a href="{{ route('section.read.'.$data['inovation']->slug) }}" class="btn btn-main" title="@lang('common.view_more')"><span>@lang('common.view_more')</span></a>
            </div>
        </div>
    </div>
</div>
@endif