@foreach ($childs as $child)
<tr>
    <td><i class="lab la-slack"></i></td>
    <td>{!! str_repeat('<i class="las la-minus"></i>',$level) !!} <i>{!! Str::limit($child->fieldLang('name'), 50) !!}</i></td>
    <td class="text-center"><span class="badge badge-info">{{ $child->viewer }}</span></td>
    <td class="text-center">
        <span class="badge badge-primary">{{ $child->list_limit ?? 'Default Config' }}</span>
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
        @if (auth()->user()->can('content_category_update') && $child->where('parent', $child->parent)->where('section_id', $child->section_id)->min('position') != $child->position)
        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Up">
            <i class="las la-arrow-up"></i>
            <form action="{{ route('category.position', ['sectionId' => $child->section_id, 'id' => $child->id, 'position' => ($child->position - 1), 'parent' => $child->parent]) }}" method="POST">
                @csrf
                @method('PUT')
            </form>
        </a>
        @else
        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
        @endif
        @if (auth()->user()->can('content_category_update') && $child->where('parent', $child->parent)->where('section_id', $child->section_id)->max('position') != $child->position)
        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Down">
            <i class="las la-arrow-down"></i>
            <form action="{{ route('category.position', ['sectionId' => $child->section_id, 'id' => $child->id, 'position' => ($child->position + 1), 'parent' => $child->parent]) }}" method="POST">
                @csrf
                @method('PUT')
            </form>
        </a>
        @else
        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
        @endif
    </td>
    <td class="text-center">
        <a href="{{ route('category.read.'.$child->section->slug, ['slugCategory' => $child->slug]) }}" class="btn icon-btn btn-sm btn-info" title="View Detail" target="_blank">
            <i class="las la-external-link-alt"></i>
        </a>
        @can ('content_category_create')
        <a href="{{ route('category.create', ['sectionId' => $data['section']->id, 'parent' => $child->id]) }}" class="btn icon-btn btn-sm btn-success" title="Add New Child Category">
            <i class="las la-plus"></i>
        </a>
        @endcan
        @can('content_category_update')
        <a href="{{ route('category.edit', ['sectionId' => $child->section_id, 'id' => $child->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Category">
            <i class="las la-pen"></i>
        </a>
        @endcan
        @can('content_category_delete')
        <a href="javascript:;" data-section-id="{{ $child->section_id }}" data-id="{{ $child->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Category">
            <i class="las la-trash"></i>
        </a>
        @endcan
    </td>
</tr>
@if (count($child->childs))
    @include('backend.content.categories.child', ['childs' => $child->childs, 'level' => ($level+1)])
@endif
@endforeach