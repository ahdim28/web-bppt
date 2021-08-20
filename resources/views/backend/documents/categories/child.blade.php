@foreach ($childs as $child)
<tr>
    <td><i class="lab la-slack"></i></td>
    <td>{!! str_repeat('<i class="las la-minus"></i>',$level) !!} <i>{!! Str::limit($child->fieldLang('name'), 50) !!}</i></td>
    <td class="text-center"><span class="badge badge-info">{{ $child->viewer }}</span></td>
    {{-- <td class="text-center">
        <span class="badge badge-primary">{{ $child->documents->count() }}</span>
    </td> --}}
    <td class="text-center">
        @can ('document_category_update')
        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $child->customConfig()['publish']['color'] }}"
            title="Status">
            {{ __($child->customConfig()['publish']['title']) }}
            <form action="{{ route('document.category.publish', ['id' => $child->id]) }}" method="POST">
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
        @if (auth()->user()->can('document_category_update') && $child->where('parent', $child->parent)->min('position') != $child->position)
        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Up">
            <i class="las la-arrow-up"></i>
            <form action="{{ route('document.category.position', ['id' => $child->id, 'position' => ($child->position - 1), 'parent' => $child->parent]) }}" method="POST">
                @csrf
                @method('PUT')
            </form>
        </a>
        @else
        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
        @endif
        @if (auth()->user()->can('document_category_update') && $child->where('parent', $child->parent)->max('position') != $child->position)
        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Down">
            <i class="las la-arrow-down"></i>
            <form action="{{ route('document.category.position', ['id' => $child->id, 'position' => ($child->position + 1), 'parent' => $child->parent]) }}" method="POST">
                @csrf
                @method('PUT')
            </form>
        </a>
        @else
        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
        @endif
    </td>
    <td class="text-center">
        @can ('documents')
        <a href="{{ route('document.index', ['categoryId' => $child->id]) }}" class="btn btn-sm btn-warning" title="View Document">
            <i class="las la-file"></i> DOCUMENT
        </a>
        @endcan
        <a href="{{ route('document.category.read', ['slugCategory' => $child->slug]) }}" class="btn icon-btn btn-sm btn-info" title="View Detail" target="_blank">
            <i class="las la-external-link-alt"></i>
        </a>
        @can ('document_category_create')
        <a href="{{ route('document.category.create', ['parent' => $child->id]) }}" class="btn icon-btn btn-sm btn-success" title="Add New Child Category">
            <i class="las la-plus"></i>
        </a>
        @endcan
        @can('document_category_update')
        <a href="{{ route('document.category.edit', ['id' => $child->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Category">
            <i class="las la-pen"></i>
        </a>
        @endcan
        @can('document_category_delete')
        <a href="javascript:;" data-id="{{ $child->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Category">
            <i class="las la-trash"></i>
        </a>
        @endcan
    </td>
</tr>
@if (count($child->childs))
    @include('backend.documents.categories.child', ['childs' => $child->childs, 'level' => ($level+1)])
@endif
@endforeach