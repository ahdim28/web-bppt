<?php

namespace App\Http\Controllers;

use App\Services\Catalog\CatalogCategoryService;
use App\Services\Catalog\CatalogTypeService;
use App\Services\Catalog\Product\CatalogProductService;
use App\Services\ConfigurationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class CatalogViewController extends Controller
{
    private $serviceType, $serviceCategory, $serviceProduct, $config;

    public function __construct(
        CatalogTypeService $serviceType,
        CatalogCategoryService $serviceCategory,
        CatalogProductService $serviceProduct,
        ConfigurationService $config
    )
    {
        $this->serviceType = $serviceType;
        $this->serviceCategory = $serviceCategory;
        $this->serviceProduct = $serviceProduct;
        $this->config = $config;
    }

    public function list(Request $request)
    {
        return redirect()->route('home');

        //data
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['categories'] = $this->serviceCategory->getCatalogCategory($request, 'paginate', $limit);
        $data['products'] = $this->serviceProduct->getCatalogProduct($request, 'paginate', $limit);

        return view('frontend.catalog.list', compact('data'), [
            'title' => 'Catalogue',
            'breadcrumbs' => [
                'Catalogue' => '',
            ]
        ]);
    }

     /**
     * category
     */
    public function listCategory(Request $request)
    {
        return redirect()->route('home');

        //data
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['categories'] = $this->serviceCategory->getCatalogCategory($request, 'paginate', $limit);

        return view('frontend.catalog.categories.list', compact('data'), [
            'title' => 'Catalogue - Categories',
            'breadcrumbs' => [
                'Catalogue' => '',
                'Categories' => ''
            ]
        ]);
    }

    public function readCategory(Request $request)
    {
        $slug = $request->route('slugCategory');

        $data['read'] = $this->serviceCategory->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if (empty($data['read']) || $data['read']->is_detail == 0) {
            return redirect()->route('home');
        }

        if ($slug != $data['read']->slug) {
            return redirect()->route('catalog.category.read', ['slugCategory' => $data['read']->slug]);
        }

        $this->serviceCategory->recordViewer($data['read']->id);

        //data
        $limit = $this->config->getValue('content_limit');
        if (!empty($data['read']->product_limit)) {
            $limit = $data['read']->product_limit;
        }
        $data['field'] = $data['read']->custom_field;
        $data['products'] = $this->serviceProduct->getCatalogProduct($request, 'paginate', $limit, 'category', $data['read']->id);

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        if (!empty($data['read']->meta_data['title'])) {
            $data['meta_title'] = Str::limit(strip_tags($data['read']->meta_data['title']), 69);
        }

        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->meta_data['description'])) {
            $data['meta_description'] = $data['read']->meta_data['description'];
        } elseif (empty($data['read']->meta_data['description']) && !empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        $data['meta_keywords'] = $this->config->getValue('meta_keywords');
        if (!empty($data['read']->meta_data['keywords'])) {
            $data['meta_keywords'] = $data['read']->meta_data['keywords'];
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        if (!empty($data['read']->cover['file_path'])) {
            $data['cover'] = $data['read']->coverSrc($data['read']);
        }
        $data['banner'] = $data['read']->bannerSrc($data['read']);

        $blade = 'detail';
        if (!empty($data['read']->custom_view_id)) {
            $blade = config('custom.templates.path.catalog_categories.custom').'.'.
                collect(explode("/", $data['read']->customView->file_path))->last();
        }

        return view('frontend.catalog.categories.'.$blade, compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                $data['read']->fieldLang('name') => ''
            ],
        ]);
    }

    /**
     * product
     */
    public function listProduct(Request $request)
    {
        return redirect()->route('home');

        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        $data['products'] = $this->serviceProduct->getCatalogProduct($request, 'paginate', $limit);

        return view('frontend.catalog.products.list', compact('data'), [
            'title' => 'Catalogue - Products',
            'breadcrumbs' => [
                'Catalogue' => '',
                'Products' => ''
            ]
        ]);
    }

    public function readProduct(Request $request)
    {
        $slug = $request->route('slugProduct');

        $data['read'] = $this->serviceProduct->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read']) || $data['read']->is_detail == 0) {
            return redirect()->route('home');
        }

        if ($slug != $data['read']->slug) {
            return redirect()->route('catalog.product.read', ['slugProduct' => $data['read']->slug]);
        }

        if ($data['read']->public == 0 && auth()->guard()->check() == false) {
            return redirect()->route('home')->with('warning', 'You must login first');
        }

        $this->serviceProduct->recordViewer($data['read']->id);

        //data
        $data['field'] = $data['read']->custom_field;
        $data['medias'] = $data['read']->medias()->orderBy('position', 'ASC')->get();
        $data['latest_product'] = $this->serviceProduct->latestCatalogProduct($data['read']->id, 3);
        $data['prev_product'] = $this->serviceProduct->catalogProductPrevNext($data['read']->id, 1, 'prev');
        $data['next_product'] = $this->serviceProduct->catalogProductPrevNext($data['read']->id, 1, 'next');

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('title');
        if (!empty($data['read']->meta_data['title'])) {
            $data['meta_title'] = Str::limit(strip_tags($data['read']->meta_data['title']), 69);
        }

        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->meta_data['description'])) {
            $data['meta_description'] = $data['read']->meta_data['description'];
        } elseif (empty($data['read']->meta_data['description']) && !empty($data['read']->fieldLang('intro'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('intro')), 155);
        } elseif (empty($data['read']->meta_data['description']) && empty($data['read']->fieldLang('intro')) 
            && !empty($data['read']->fieldLang('content'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('content')), 155);
        }

        $data['meta_keywords'] = $this->config->getValue('meta_keywords');
        if (!empty($data['read']->meta_data['keywords'])) {
            $data['meta_keywords'] = $data['read']->meta_data['keywords'];
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        if (!empty($data['read']->cover['file_path'])) {
            $data['cover'] = $data['read']->coverSrc($data['read']);
        }
        $data['banner'] = $data['read']->bannerSrc($data['read']);

        //share
        $data['share_facebook'] = "https://www.facebook.com/share.php?u=".URL::full()
            ."&title=".$data['read']->fieldLang('title')."";
        $data['share_twitter'] = "https://twitter.com/intent/tweet?text=".
            $data['read']->fieldLang('title')."&amp;url=".URL::full()."";
        $data['share_whatsapp'] = "whatsapp://send?text=".$data['read']->fieldLang('title')." 
            ".URL::full()."";
        $data['share_linkedin'] = "https://www.linkedin.com/shareArticle?mini=true&url=".
            URL::full()."&title=".$data['read']->fieldLang('title')."&source=".request()->root()."";
        $data['share_pinterest'] = "https://pinterest.com/pin/create/bookmarklet/?media=".
            $data['read']->coverSrc($data['read'])."&url=".URL::full()."&is_video=false&description=".
            $data['read']->fieldLang('title')."";

        $blade = 'detail';
        if (!empty($data['read']->custom_view_id)) {
            $blade = config('custom.templates.path.catalog_products.custom').'.'.
                collect(explode("/", $data['read']->customView->file_path))->last();
        }

        return view('frontend.catalog.products.'.$blade, compact('data'), [
            'title' => $data['read']->fieldLang('title'),
            'breadcrumbs' => [
                $data['read']->fieldLang('title') => ''
            ],
        ]);
    }
}
