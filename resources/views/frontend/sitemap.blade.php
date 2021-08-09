<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@if (config('custom.setting.module.page') == true)    
    <sitemap>
        <loc>{{ route('page.list') }}</loc>
    </sitemap>
    @foreach ($data['pages'] as $page)
    <sitemap>
        <loc>{{ route('page.read.'.$page->slug) }}</loc>
        <lastmod>{{ $page->updated_at }}</lastmod>
    </sitemap>
    @endforeach
@endif
@if (config('custom.setting.module.section') == true) 
    <sitemap>
        <loc>{{ route('section.list') }}</loc>
    </sitemap>
    @foreach ($data['sections'] as $section)
    <sitemap>
        <loc>{{ route('section.read.'.$section->slug) }}</loc>
        <lastmod>{{ $section->updated_at }}</lastmod>
    </sitemap>
    @endforeach
@endif
@if (config('custom.setting.module.category') == true) 
    <sitemap>
        <loc>{{ route('category.list') }}</loc>
    </sitemap>
    @foreach ($data['categories'] as $category)
    <sitemap>
        <loc>{{ route('category.read.'.$category->section->slug, ['slugCategory' => $category->slug]) }}</loc>
        <lastmod>{{ $category->updated_at }}</lastmod>
    </sitemap>
    @endforeach
@endif
@if (config('custom.setting.module.post') == true) 
    <sitemap>
        <loc>{{ route('post.list') }}</loc>
    </sitemap>
    @foreach ($data['posts'] as $post)
    <sitemap>
        <loc>{{ route('post.read.'.$post->section->slug, ['slugPost' => $post->slug]) }}</loc>
        <lastmod>{{ $post->updated_at }}</lastmod>
    </sitemap>
    @endforeach
@endif
@if (config('custom.setting.module.catalog') == true) 
    <sitemap>
        <loc>{{ route('catalog.view') }}</loc>
    </sitemap>
    <sitemap>
        <loc>{{ route('catalog.category.list') }}</loc>
    </sitemap>
    @foreach ($data['catalog_categories'] as $catCategory)
    <sitemap>
        <loc>{{ route('catalog.category.read', ['slugCategory' => $catCategory->slug]) }}</loc>
        <lastmod>{{ $catCategory->updated_at }}</lastmod>
    </sitemap>
    @endforeach
    <sitemap>
        <loc>{{ route('catalog.product.list') }}</loc>
    </sitemap>
    @foreach ($data['catalog_products'] as $catProduct)
    <sitemap>
        <loc>{{ route('catalog.product.read', ['slugProduct' => $catProduct->slug]) }}</loc>
        <lastmod>{{ $catProduct->updated_at }}</lastmod>
    </sitemap>
    @endforeach
@endif
@if (config('custom.setting.module.album') == true) 
    <sitemap>
        <loc>{{ route('gallery.album.list') }}</loc>
    </sitemap>
    @foreach ($data['albums'] as $album)
    <sitemap>
        <loc>{{ route('gallery.album.read', ['slugAlbum' => $album->slug]) }}</loc>
        <lastmod>{{ $album->updated_at }}</lastmod>
    </sitemap>
    @endforeach
@endif
@if (config('custom.setting.module.playlist') == true) 
    <sitemap>
        <loc>{{ route('gallery.playlist.list') }}</loc>
    </sitemap>
    @foreach ($data['playlists'] as $playlist)
    <sitemap>
        <loc>{{ route('gallery.playlist.read', ['slugPlaylist' => $playlist->slug]) }}</loc>
        <lastmod>{{ $playlist->updated_at }}</lastmod>
    </sitemap>
    @endforeach
@endif
@if (config('custom.setting.module.link') == true) 
    <sitemap>
        <loc>{{ route('link.list') }}</loc>
    </sitemap>
    @foreach ($data['links'] as $link)
    <sitemap>
        <loc>{{ route('link.read.'.$link->slug) }}</loc>
        <lastmod>{{ $link->updated_at }}</lastmod>
    </sitemap>
    @endforeach
@endif
@if (config('custom.setting.module.inquiry') == true) 
    <sitemap>
        <loc>{{ route('inquiry.list') }}</loc>
    </sitemap>
    @foreach ($data['inquiries'] as $inquiry)
    <sitemap>
        <loc>{{ route('inquiry.read.'.$inquiry->slug) }}</loc>
        <lastmod>{{ $inquiry->updated_at }}</lastmod>
    </sitemap>
    @endforeach
@endif
</sitemapindex>

