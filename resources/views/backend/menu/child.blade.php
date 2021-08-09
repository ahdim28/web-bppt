@foreach ($childs as $child)
<div class="card mb-2" style="margin-left: {{ (15+$level) }}px;">
    <div class="card-header">
      <a class="collapsed d-flex justify-content-between text-body" data-toggle="collapse" href="#child-{{ $child->id }}">
        <i><i class="las la-minus"></i>{!! $child->modMenu()['title'] !!}</i> 
        <div class="collapse-icon"></div>
      </a>
    </div>
    <div id="child-{{ $child->id }}" class="collapse" data-parent="#accordion2">
      <div class="table-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">ID</th>
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
                    <td>#{{ $child->id }}</td>
                    <td class="text-center">
                        @can ('menu_update')
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $child->customConfig()['publish']['color'] }}"
                            title="@lang('lang.change_status')">
                            {{ __($child->customConfig()['publish']['title']) }}
                            <form action="{{ route('menu.publish', ['categoryId' => $child->menu_category_id, 'id' => $child->id]) }}" method="POST">
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
                        @if (auth()->user()->can('menu_update') && $child->where('menu_category_id', $child->menu_category_id)->where('parent', $child->parent)->min('position') != $child->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" title="@lang('lang.change_position')">
                            <i class="las la-arrow-up"></i>
                            <form action="{{ route('menu.position', ['categoryId' => $data['category']->id, 'id' => $child->id, 'position' => ($child->position - 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                        @endif
                        @if (auth()->user()->can('page_update') && $child->where('menu_category_id', $child->menu_category_id)->where('parent', $child->parent)->max('position') != $child->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" title="@lang('lang.change_position')">
                            <i class="las la-arrow-down"></i>
                            <form action="{{ route('menu.position', ['categoryId' => $data['category']->id, 'id' => $child->id, 'position' => ($child->position + 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="@lang('alert.access_denied')" disabled><i class="las la-arrow-down"></i></button>
                        @endif
                    </td>
                    <td class="text-center">
                        @can ('menu_create')
                        <a href="{{ route('menu.create', ['categoryId' => $data['category']->id, 'parent' => $child->id]) }}" class="btn icon-btn btn-sm btn-success" title="@lang('lang.add_attr', [
                            'attribute' => __('mod/menu.title')
                        ])">
                            <i class="las la-plus"></i>
                        </a>
                        @endcan
                        @can ('menu_update')
                        @if (auth()->user()->hasRole('super') || !auth()->user()->hasRole('super') && $child->edit_public_menu == 1)
                        <a href="{{ route('menu.edit', ['categoryId' => $data['category']->id, 'id' => $child->id]) }}" class="btn icon-btn btn-sm btn-primary" title="@lang('lang.edit_attr', [
                            'attribute' => __('mod/menu.title')
                        ])">
                            <i class="las la-pen"></i>
                        </a>
                        @endif
                        @endcan
                        @can ('menu_delete')
                        <a href="javascript:;" data-categoryid="{{ $child->menu_category_id }}" data-id="{{ $child->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="@lang('lang.delete_attr', [
                            'attribute' => __('mod/menu.title')
                        ])">
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
    @include('backend.menu.child', ['childs' => $child->childs, 'level' => ($level+15)])
@endif
@endforeach