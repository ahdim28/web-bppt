<?php

namespace App\Services\Catalog\Product;

use App\Models\Catalog\Product\CatalogProduct;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TagService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogProductService
{
    private $model, $lang, $tag, $field;

    public function __construct(
        CatalogProduct $model,
        LanguageService $lang,
        TagService $tag,
        FieldCategoryService $field
    )
    {
        $this->model = $model;
        $this->lang = $lang;
        $this->tag = $tag;
        $this->field = $field;
    }

    public function getCatalogProductList($request)
    {
        $query = $this->model->query();

        $query->when($request, function ($query, $req) {
            if ($req->t != '') {
                $query->where('catalog_type_id', $req->t);
            }
        })->when($request, function ($query, $req) {
            if ($req->c != '') {
                $query->where('catalog_category_id', $req->c);
            }
        })->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('publish', $req->s);
            }
        })->when($request, function ($query, $req) {
            if ($req->p != '') {
                $query->where('public', $req->p);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('title->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getCatalogProduct($request = null, $withPaginate = null, 
        $limit = null, $type = null, $typeId = null)
    {
        $query = $this->model->query();

        if ($type == 'type') {
            $query->where('catalog_type_id', $typeId);
        }

        if ($type == 'category') {
            $query->where('catalog_category_id', $typeId);
        }

        $query->publish();
        if (Auth::guard()->check() == false) {
            $query->public();
        }

        if (!empty($request)) {
            $this->search($query, $request);
        }

        $query->orderBy('position', 'ASC');
        if (!empty($withPaginate)) {
            $result = $query->paginate($limit);
        } else {
            if (!empty($limit)) {
                $result = $query->limit($limit)->get();
            } else {
                $result = $query->get();
            }
        }

        return $result;
    }

    public function latestCatalogProduct(int $id, $limit = 8, $content = null)
    {
        $find = $this->find($id);

        $query = $this->model->query();

        $query->publish();
        if (Auth::guard()->check() == false) {
            $query->public();
        }

        if ($content == 'type') {
            $query->where('catalog_type_id', $find->catalog_type_id);
        }

        if ($content == 'category') {
            $query->where('catalog_category_id', $find->catalog_category_id);
        }

        $query->whereNotIn('id', [$id]);

        $result = $query->inRandomOrder()->limit($limit)->get();

        return $result;
    }

    public function catalogProductPrevNext(int $id, $limit = 1, $type, $isType = null)
    {
        $find = $this->find($id);

        $query = $this->model->query();

        $query->publish();
        if (Auth::guard()->check() == false) {
            $query->public();
        }

        if ($isType == 'type') {
            $query->where('catalog_type_id', $find->catalog_type_id);
        }

        if ($isType == 'category') {
            $query->where('catalog_category_id', $find->catalog_category_id);
        }

        if ($type == 'prev') {
            $query->where('id', '<', $id);
        }

        if ($type == 'next') {
            $query->where('id', '>', $id);
        }

        $query->whereNotIn('id', [$id]);

        $result = $query->inRandomOrder()->limit($limit)->get();

        return $result;
    }

    public function search($query, $request)
    {
        $query->when($request->keyword, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('title->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('intro->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('content->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('meta_data->title', 'like', '%'.$q.'%')
                    ->orWhere('meta_data->description', 'like', '%'.$q.'%')
                    ->orWhere('meta_data->keywords', 'like', '%'.$q.'%');
            });
        });
    }

    public function countCatalogProduct()
    {
        $query = $this->model->query();

        $query->publish();

        $result = $query->count();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findBySlug($slug)
    {
        $query = $this->model->query();

        $query->where('slug', $slug);

        $result = $query->first();

        return $result;
    }

    public function store($request)
    {
        $product = new CatalogProduct;
        $this->setField($request, $product);
        $product->position = $this->model->where('catalog_category_id', $request->category_id)
            ->max('position') + 1;
        $product->created_by = Auth::user()->id;
        $product->save();

        if (!empty($request->tags)) {
            $this->tag->wipeStore($request, $product);
        }

        return $product;
    }

    public function update($request, int $id)
    {
        $product = $this->find($id);
        $this->setField($request, $product);
        $product->updated_by = Auth::user()->id;
        $product->save();

        if (!empty($request->tags)) {
            $this->tag->wipeStore($request, $product);
        }

        if (!empty($request->old_tags) && empty($request->tags)) {
            $product->tags()->delete();
        }

        return $product;
    }

    public function setField($request, $product)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $title[$value->iso_codes] = ($request->input('title_'.$value->iso_codes) == null) ?
                $request->input('title_'.config('custom.language.default')) : $request->input('title_'.$value->iso_codes);
            $intro[$value->iso_codes] = ($request->input('intro_'.$value->iso_codes) == null) ?
                $request->input('intro_'.config('custom.language.default')) : $request->input('intro_'.$value->iso_codes);
            $content[$value->iso_codes] = ($request->input('content_'.$value->iso_codes) == null) ?
                $request->input('content_'.config('custom.language.default')) : $request->input('content_'.$value->iso_codes);
        }

        $product->catalog_type_id = $request->type_id ?? null;
        $product->catalog_category_id = $request->category_id ?? null;
        $product->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $product->title = $title;
        $product->intro = $intro;
        $product->content = $content;
        $product->price = $request->price ?? null;
        $product->quantity = $request->quantity ?? null;
        $product->is_discount = (bool)$request->is_discount;
        if ((bool)$request->is_discount == 1) {
            $product->discount = $request->discount ?? null;
        } else {
            $product->discount = null;
        }
        $product->cover = [
            'file_path' => Str::replace(url('/storage'), '', $request->cover_file) ?? null,
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];
        $product->banner = [
            'file_path' => Str::replace(url('/storage'), '', $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
        ];
        $product->publish = (bool)$request->publish;
        $product->public = (bool)$request->public;
        $product->is_detail = (bool)$request->is_detail;
        $product->custom_view_id = $request->custom_view_id ?? null;
        $product->meta_data = [
            'title' => $request->meta_title ?? null,
            'description' => $request->meta_description ?? null,
            'keywords' => $request->meta_keywords ?? null,
        ];

        $product->field_category_id = $request->field_category_id ?? null;
        if (!empty($request->field_category_id)) {

            $field = $this->field->find($request->field_category_id);
            foreach ($field->fields as $key => $value) {
                $custom_field[$key] = [
                    $value->name => $request->input('field_'.$value->name) ?? null
                ];
            }

            $product->custom_field = $custom_field;

        } else {
            $product->custom_field = null;
        }

        $product->created_at = $request->created_at;

        return $product;
    }

    public function publish(int $id)
    {
        $product = $this->find($id);
        $product->publish = !$product->publish;
        $product->updated_by = Auth::user()->id;
        $product->save();

        return $product;
    }

    public function selection(int $id)
    {
        $product = $this->find($id);
        $total = $this->model->where('catalog_category_id', $product->catalog_category_id)
            ->selection()->count();
        $select = $product->category->product_selection;

        if ($product->selection == 0) {
            $check = (empty($select) || !empty($select) && $total < $select);
        } else {
            $check = (empty($select) || !empty($select));
        }

        if ($check) {
            $product->selection = !$product->selection;
            $product->updated_by = Auth::user()->id;
            $product->save();

            return true;
        } else {
            return false;
        }
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $product = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $product->position,
            ]);
            $product->position = $position;
            $product->updated_by = Auth::user()->id;
            $product->save();

            return $product;
        }
    }

    public function recordViewer(int $id)
    {
        $product = $this->find($id);
        $product->viewer = ($product->viewer+1);
        $product->save();

        return $product;
    }

    public function delete(int $id)
    {
        $product = $this->find($id);

        if ($product->menu()->count() == 0) {

            if ($product->medias->count() > 0) {
                
                foreach ($product->medias as $key => $value) {
    
                    if (empty($value->youtube_id)) {
                        Storage::delete(config('custom.files.product.path').$id.
                            '/'.$value->file);
            
                        if ($value->is_video == 1) {
                            Storage::delete(config('custom.files.product.thumbnail.path').$id.
                            '/'.$value->thumbnail);
                        }
                    }
    
                }
    
            }
            $product->tags()->delete();
            $product->delete();
    
            return true;

        } else {
            return false;
        }

    }
}