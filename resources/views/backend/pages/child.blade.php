@foreach ($childs as $child)
<div class="card mb-2" style="margin-left: {{ (15+$level) }}px;">
    <div class="card-header">
      <a class="collapsed d-flex justify-content-between text-body" data-toggle="collapse" href="#page-{{ $child->id }}">
        <i><i class="las la-minus"></i> {!! Str::limit($child->fieldLang('title'), 60) !!}</i> 
        <div class="collapse-icon"></div>
      </a>
    </div>
    <div id="page-{{ $child->id }}" class="collapse" data-parent="#accordion2">
      <div class="table-responsive">
          <table id="user-list" class="table card-table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 80px;">@lang('lang.viewer')</th>
                  <th class="text-center" style="width: 100px;">@lang('lang.status')</th>
                  <th class="text-center" style="width: 80px;">@lang('lang.public')</th>
                  <th style="width: 230px;">@lang('lang.created')</th>
                  <th style="width: 230px;">@lang('lang.updated')</th>
                  <th class="text-center" style="width: 110px;">@lang('lang.position')</th>
                  <th class="text-center" style="width: 215px;">@lang('lang.action')</th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                      <td class="text-center"><span class="badge badge-info">{{ $child->viewer }}</span></td>
                      <td class="text-center">
                        @can ('page_update')
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $child->customConfig()['publish']['color'] }}"
                            title="@lang('lang.status')">
                            {{ __($child->customConfig()['publish']['title']) }}
                            <form action="{{ route('page.publish', ['id' => $child->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <span class="badge badge-{{ $child->customConfig()['publish']['color'] }}">{{ __($child->customConfig()['publish']['title']) }}</span>
                        @endcan
                      </td>
                      <td class="text-center">
                        <span class="badge badge-{{ $child->customConfig()['public']['color'] }}">{{ __($child->customConfig()['public']['title']) }}</span>
                      </td>
                      <td>
                          {{ $child->created_at->format('d F Y (H:i A)') }}
                          @if (!empty($child->created_by))
                          <br>
                              <span class="text-muted">@lang('lang.by') : {{ $child->createBy->name }}</span>
                          @endif
                      </td>
                      <td>
                          {{ $child->updated_at->format('d F Y (H:i A)') }}
                          @if (!empty($child->updated_by))
                          <br>
                              <span class="text-muted">@lang('lang.by') : {{ $child->updateBy->name }}</span>
                          @endif
                      </td>
                      <td class="text-center">
                        @if (auth()->user()->can('page_update') && $child->where('parent', $child->parent)->min('position') != $child->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Up">
                            <i class="las la-arrow-up"></i>
                            <form action="{{ route('page.position', ['id' => $child->id, 'position' => ($child->position - 1), 'parent' => $child->parent]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                        @endif
                        @if (auth()->user()->can('page_update') && $child->where('parent', $child->parent)->max('position') != $child->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Down">
                            <i class="las la-arrow-down"></i>
                            <form action="{{ route('page.position', ['id' => $child->id, 'position' => ($child->position + 1), 'parent' => $child->parent]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                        @endif
                      </td>
                      <td class="text-center">
                        <a href="{{ route('page.read.'.$child->slug) }}" class="btn icon-btn btn-sm btn-info" title="View Detail" target="_blank">
                            <i class="las la-external-link-alt"></i>
                        </a>
                        @can('page_create')
                        <a href="{{ route('page.create', ['parent' => $child->id]) }}" class="btn icon-btn btn-sm btn-success" title="Add New Child Page">
                            <i class="las la-plus"></i>
                        </a>
                        @endcan
                        @can('medias')
                        <a href="{{ route('media.index', ['moduleId' => $child->id, 'moduleName' => 'page']) }}" class="btn icon-btn btn-sm btn-info" title="Media">
                            <i class="las la-folder"></i>
                        </a>
                        @endcan
                        @can('page_update')
                        <a href="{{ route('page.edit', ['id' => $child->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Page">
                            <i class="las la-pen"></i>
                        </a>
                        @endcan
                        @can('page_delete')
                        <a href="javascript:;" data-id="{{ $child->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Page">
                            <i class="las la-trash"></i>
                        </a>
                        @endcan
                    </td>
                  </tr>
              </tbody>
          </table>
      </div>
    </div>
</div>
@if (count($child->childs))
    @include('backend.pages.child', ['childs' => $child->childs, 'level' => ($level+15)])
@endif
@endforeach