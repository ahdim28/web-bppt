@if (!empty($data['agenda']))    
<div class="box-wrap bg-grey">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="title-heading text-center">
                    <h5>{!! $config['website_name'] !!}</h5>
                    <h1>{!! $data['agenda']->fieldLang('name') !!}</h1>
                </div>
                <article class="summary-text text-center">
                </article>
            </div>
        </div>
        <div class="box-list">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row">
                        @foreach ($data['agenda']->posts()->publish()->orderBy('created_at', 'DESC')->limit(4)->get() as $agenda)
                        <div class="col-lg-6">
                            <a href="{{ route('post.read.'.$agenda->section->slug, ['slugPost' => $agenda->slug]) }}" class="item-event" title="{!! $agenda->fieldLang('title') !!}">
                                <div class="event-date">
                                    <div class="event-dd">{!! $agenda->created_at->format('d') !!}</div>
                                    <div class="event-mm">{!! $agenda->created_at->format('M') !!}</div>
                                </div>
                                <div class="event-info">
                                    <h6 class="event-title">{!! $agenda->fieldLang('title') !!}</h6>
                                    <div class="event-schedule">
                                        <div class="item-schedule">
                                            <span>Mulai</span>
                                            <div class="point-schedule">
                                                <i class="las la-calendar"></i>
                                                <div class="data-schedule">
                                                    <span>{{ $agenda->event->start_date->format('d.m.Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="point-schedule">
                                                <i class="las la-clock"></i>
                                                <div class="data-schedule">
                                                    <span>{{ $agenda->event->start_date->format('H:i A') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-schedule">
                                            <span>Selesai</span>
                                            <div class="point-schedule">
                                                <i class="las la-calendar"></i>
                                                <div class="data-schedule">
                                                    <span>{{ $agenda->event->end_date->format('d.m.Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="point-schedule">
                                                <i class="las la-clock"></i>
                                                <div class="data-schedule">
                                                    <span>{{ $agenda->event->end_date->format('H:i A') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif