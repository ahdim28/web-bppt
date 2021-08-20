
<div class="search-wrap">
    <div class="flex-search">
        <form action="{{ route('home.search') }}" method="GET">
            <div class="form-group mb-0">
                <input id="search-box" type="search" class="form-control" placeholder="What do you need ?" name="keyword" value="{{ Request::get('keyword') }}" required>
                <button type="submit" class="btn-submit">
                    <span><i class="las la-search"></i></span>
                    <span><i class="las la-arrow-right"></i></span>
                </button>
            </div>
        </form>
        <div class="cancel-toggle">
            <span>Cancel</span>
        </div>
    </div>
</div>