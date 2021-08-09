<div id="layout-sidenav" class="{{ isset($layout_sidenav_horizontal) ? 'layout-sidenav-horizontal sidenav-horizontal container-p-x flex-grow-0' : 'layout-sidenav sidenav-vertical' }} sidenav bg-sidenav-theme">

    <!-- Brand demo (see assets/css/demo/demo.css) -->
    <div class="app-brand demo">
        <span class="app-brand-logo demo">
            <img src="{{ $config['logo_2'] }}" alt="{{ $config['website_name'] }} Logo">
        </span>
        <a href="javascript:void(0)" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
          <i class="las la-thumbtack"></i>
        </a>
    </div>

    <div class="sidenav-divider mt-0"></div>

    <!-- Inner -->
    <ul class="sidenav-inner{{ empty($layout_sidenav_horizontal) ? ' py-1' : '' }}">

        @php
            $userManagementOpen = (Request::is('admin/acl*') || Request::is('admin/user*') || Request::is('admin/log*'));
            $masterOpen = (Request::is('admin/template*') || Request::is('admin/field*') || Request::is('admin/tag*') || Request::is('admin/comment*'));
        @endphp

        <!-- Dashboard -->
        <li class="sidenav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="sidenav-link" title="@lang('menu.backend.title1')">
              <i class="sidenav-icon las la-tachometer-alt"></i><div>@lang('menu.backend.title1')</div>
            </a>
        </li>

        @if (Auth::user()->can('users'))
        <!-- Management User -->
        <li class="sidenav-item {{ $userManagementOpen ? 'open active' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('menu.backend.title2')">
              <i class="sidenav-icon ion las la-users"></i>
              <div>@lang('menu.backend.title2')</div>
            </a>
            <ul class="sidenav-menu">
              @role('super')
              <li class="sidenav-item {{ Request::is('admin/acl*') ? 'open active' : '' }}">
                <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('menu.backend.title3')">
                    <div>@lang('menu.backend.title3')</div>
                </a>

                <ul class="sidenav-menu">
                    <li class="sidenav-item {{ Request::is('admin/acl/role*') ? 'active' : '' }}">
                        <a href="{{ route('role.index') }}" class="sidenav-link" title="@lang('menu.backend.title4')">
                          <div>@lang('menu.backend.title4')</div>
                        </a>
                    </li>
                    <li class="sidenav-item {{ Request::is('admin/acl/permission*') ? 'active' : '' }}">
                        <a href="{{ route('permission.index') }}" class="sidenav-link" title="@lang('menu.backend.title5')">
                          <div>@lang('menu.backend.title5')</div>
                        </a>
                    </li>
                </ul>
              </li>
              @endrole
              @can('users')
              <li class="sidenav-item {{ Request::is('admin/user*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="sidenav-link" title="@lang('menu.backend.title6')">
                  <div>@lang('menu.backend.title6')</div>
                </a>
              </li>
              <li class="sidenav-item {{ Request::is('admin/log*') ? 'active' : '' }}">
                <a href="{{ route('log') }}" class="sidenav-link" title="@lang('menu.backend.title7')">
                    <div>@lang('menu.backend.title7')</div>
                </a>
              </li>
              @endcan
              
            </ul>
        </li>
        @endif

        @if (Auth::user()->can('fields') || Auth::user()->can('tags') || Auth::user()->can('comments'))
        <!-- Data Master -->
        <li class="sidenav-item {{ $masterOpen ? 'open active' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('menu.backend.title8')">
              <i class="sidenav-icon ion las la-database"></i> <div>@lang('menu.backend.title8')</div>
            </a>
            <ul class="sidenav-menu">
              @role('super')
              <li class="sidenav-item {{ Request::is('admin/template*') ? 'active' : '' }}">
                <a href="{{ route('template.index') }}" class="sidenav-link" title="@lang('menu.backend.title9')">
                    <div>@lang('menu.backend.title9')</div>
                </a>
              </li>
              @endrole
              @can('fields')
              <li class="sidenav-item {{ Request::is('admin/field*') ? 'active' : '' }}">
                <a href="{{ route('field.category') }}" class="sidenav-link" title="@lang('menu.backend.title10')">
                    <div>@lang('menu.backend.title10')</div>
                </a>
              </li>
              @endcan
              @can('tags')
              <li class="sidenav-item {{ Request::is('admin/tag*') ? 'active' : '' }}">
                <a href="{{ route('tag.index') }}" class="sidenav-link" title="@lang('menu.backend.title11')">
                    <div>@lang('menu.backend.title11')</div>
                </a>
              </li>
              @endcan
              @can('comments')
              <li class="sidenav-item {{ Request::is('admin/comment*') ? 'active' : '' }}">
                <a href="{{ route('comment.index') }}" class="sidenav-link" title="@lang('menu.backend.title12')">
                    <div>@lang('menu.backend.title12')</div>
                </a>
              </li>
              @endcan
              
            </ul>
        </li>
        @endif

        @if (Auth::user()->can('pages') || Auth::user()->can('content_sections') || Auth::user()->can('banner_categories') || 
          Auth::user()->can('catalog_types') || Auth::user()->can('catalog_categories') || Auth::user()->can('catalog_products') ||
          Auth::user()->can('albums') || Auth::user()->can('playlists') || Auth::user()->can('links') || Auth::user()->can('inquiries'))
        <!-- Module -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">@lang('menu.backend.sub1')</li>
        @endif

        @can ('pages')
        <!-- Page -->
        <li class="sidenav-item {{ (Request::is('admin/page*') || Request::segment(4) == 'page') ? 'active' : '' }}">
          <a href="{{ route('page.index') }}" class="sidenav-link" title="@lang('menu.backend.title13')">
            <i class="sidenav-icon las la-bars"></i><div>@lang('menu.backend.title13')</div>
          </a>
        </li>
        @endcan

        @can ('content_sections')
        <!-- Content -->
        <li class="sidenav-item {{ (Request::is('admin/section*') || Request::segment(4) == 'post') ? 'active' : '' }}">
          <a href="{{ route('section.index') }}" class="sidenav-link" title="@lang('menu.backend.title14')">
            <i class="sidenav-icon las la-pen-square"></i><div>@lang('menu.backend.title14')</div>
          </a>
        </li>
        @endcan

        @can ('banner_categories')
        <!-- Banner -->
        <li class="sidenav-item {{ Request::is('admin/banner*') ? 'active' : '' }}">
          <a href="{{ route('banner.category.index') }}" class="sidenav-link" title="@lang('menu.backend.title15')">
            <i class="sidenav-icon las la-image"></i><div>@lang('menu.backend.title15')</div>
          </a>
        </li>
        @endcan

        @if (Auth::user()->can('catalog_types') || Auth::user()->can('catalog_categories') || Auth::user()->can('catalog_products'))
        <!-- Catalogue -->
        <li class="sidenav-item {{ Request::is('admin/catalog*') ? 'open active' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('menu.backend.title16')">
            <i class="sidenav-icon las la-store-alt "></i> <div>@lang('menu.backend.title16')</div>
          </a>

          <ul class="sidenav-menu">
              @can('catalog_types')
              <li class="sidenav-item {{ Request::is('admin/catalog/type*') ? 'active' : '' }}">
                  <a href="{{ route('catalog.type.index') }}" class="sidenav-link" title="@lang('menu.backend.title17')">
                      <div>@lang('menu.backend.title17')</div>
                  </a>
              </li>
              @endcan
              @can('catalog_categories')
              <li class="sidenav-item {{ Request::is('admin/catalog/category*') ? 'active' : '' }}">
                  <a href="{{ route('catalog.category.index') }}" class="sidenav-link" title="@lang('menu.backend.title18')">
                      <div>@lang('menu.backend.title18')</div>
                  </a>
              </li>
              @endcan
              @can('catalog_products')
              <li class="sidenav-item {{ Request::is('admin/catalog/product*') ? 'active' : '' }}">
                <a href="{{ route('catalog.product.index') }}" class="sidenav-link" title="@lang('menu.backend.title19')">
                    <div>@lang('menu.backend.title19')</div>
                </a>
              </li>
              @endcan
          </ul>
        </li>
        @endif

        @if (Auth::user()->can('albums') || Auth::user()->can('playlists'))
        <!-- Gallery -->
        <li class="sidenav-item {{ Request::is('admin/gallery*') ? 'open active' : '' }}">
          <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('menu.backend.title20')">
            <i class="sidenav-icon las la-photo-video"></i> <div>@lang('menu.backend.title20')</div>
          </a>

          <ul class="sidenav-menu">
              @can('albums')
              <li class="sidenav-item {{ Request::is('admin/gallery/album*') ? 'active' : '' }}">
                  <a href="{{ route('gallery.album.index') }}" class="sidenav-link" title="@lang('menu.backend.title21')">
                      <div>@lang('menu.backend.title21')</div>
                  </a>
              </li>
              @endcan
              @can('playlists')
              <li class="sidenav-item {{ Request::is('admin/gallery/playlist*') ? 'active' : '' }}">
                  <a href="{{ route('gallery.playlist.index') }}" class="sidenav-link" title="@lang('menu.backend.title22')">
                      <div>@lang('menu.backend.title22')</div>
                  </a>
              </li>
              @endcan
          </ul>
        </li>
        @endif

        @can('links')
        <!-- Links -->
        <li class="sidenav-item {{ Request::is('admin/link*') ? 'active' : '' }}">
          <a href="{{ route('link.index') }}" class="sidenav-link" title="@lang('menu.backend.title23')">
            <i class="sidenav-icon las la-link"></i> <div>@lang('menu.backend.title23')</div>
          </a>
        </li>
        @endcan

        @can('inquiries')
        <!-- Inquiry -->
        <li class="sidenav-item {{ Request::is('admin/inquiry*') ? 'active' : '' }}">
          <a href="{{ route('inquiry.index') }}" class="sidenav-link" title="@lang('menu.backend.title24')">
            <i class="sidenav-icon las la-envelope"></i> <div>@lang('menu.backend.title24')</div>
            @if ($counter['inquiry_form'] > 0)    
            <div class="pl-1 ml-auto">
              <div class="badge badge-danger">{{ $counter['inquiry_form'] }}</div>
            </div>
            @endif
          </a>
        </li>
        @endcan

        @if (Auth::user()->can('menu_categories') || Auth::user()->can('visitor') || Auth::user()->can('filemanager') || Auth::user()->can('backup'))
        <!-- Extra -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">@lang('menu.backend.sub2')</li>
        @endif

        @can('menu_categories')
        <!-- Menu -->
        <li class="sidenav-item {{ Request::is('admin/menu*') ? 'active' : '' }}">
            <a href="{{ route('menu.category.index') }}" class="sidenav-link" title="@lang('menu.backend.title25')">
              <i class="sidenav-icon las la-list"></i><div>@lang('menu.backend.title25')</div>
            </a>
        </li>
        @endcan
        
        @can('visitor')
        <!-- Visitor -->
        <li class="sidenav-item {{ Request::is('admin/visitor') ? 'active' : '' }}">
            <a href="{{ route('visitor') }}" class="sidenav-link" title="@lang('menu.backend.title26')">
              <i class="sidenav-icon las la-user-plus"></i><div>@lang('menu.backend.title26')</div>
            </a>
        </li>
        @endcan

        @can('filemanager')
        <!-- Filemanager -->
        <li class="sidenav-item {{ Request::is('admin/filemanager') ? 'active' : '' }}">
            <a href="{{ route('filemanager') }}" class="sidenav-link" title="@lang('menu.backend.title27')">
              <i class="sidenav-icon las la-folder"></i><div>@lang('menu.backend.title27')</div>
            </a>
        </li>
        @endcan

        @can('backup')
        <!-- Backup -->
        <li class="sidenav-item {{ Request::is('admin/backup') ? 'active' : '' }}">
            <a href="{{ route('backup') }}" class="sidenav-link" title="@lang('menu.backend.title28')">
              <i class="sidenav-icon las la-trash-restore-alt"></i><div>@lang('menu.backend.title28')</div>
            </a>
        </li>
        @endcan

        @if (Auth::user()->can('configurations') || Auth::user()->can('commons'))
         <!-- Setting -->
         <li class="sidenav-divider mb-1"></li>
         <li class="sidenav-header small font-weight-semibold">@lang('menu.backend.sub3')</li>
         
         <!-- Configuration -->
         <li class="sidenav-item {{ Request::is('admin/configuration*') ? 'open active' : '' }}">
             <a href="javascript:void(0)" class="sidenav-link sidenav-toggle" title="@lang('menu.backend.title29')">
               <i class="sidenav-icon las la-cogs"></i> <div>@lang('menu.backend.title29')</div>
             </a>
 
             <ul class="sidenav-menu">
                @can('configurations')  
                 <li class="sidenav-item {{ Request::is('admin/configuration/website') ? 'active' : '' }}">
                     <a href="{{ route('configuration.website') }}" class="sidenav-link" title="@lang('menu.backend.title30')">
                         <div>@lang('menu.backend.title30')</div>
                     </a>
                 </li>
                 @endcan  
                 @can('commons')  
                 <li class="sidenav-item {{ Request::is('admin/configuration/common*') ? 'active' : '' }}">
                     <a href="{{ route('configuration.common', ['lang' => config('custom.language.default')]) }}" class="sidenav-link" title="@lang('menu.backend.title31')">
                         <div>@lang('menu.backend.title31')</div>
                     </a>
                 </li>
                 @endcan
             </ul>
         </li>
        @endif

        @role ('super')
        <!-- Language -->
        <li class="sidenav-item {{ Request::is('admin/language*') ? 'active' : '' }}">
            <a href="{{ route('language.index') }}" class="sidenav-link" title="@lang('menu.backend.title32')">
              <i class="sidenav-icon las la-language"></i><div>@lang('menu.backend.title32')</div>
            </a>
        </li>
        <!-- Maintenance -->
        <li class="sidenav-item {{ Request::is('admin/maintenance') ? 'active' : '' }}">
            <a href="{{ route('maintenance') }}" class="sidenav-link" title="@lang('menu.backend.title33')">
              <i class="sidenav-icon las la-tools"></i> <div>@lang('menu.backend.title33')</div>
            </a>
        </li>
        @endrole
        
    </ul>
</div>
