<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">
            @if($product->isNew())
                <span class="badge badge-success">@lang('main.labels.new')</span>
            @endif
            @if($product->isHit())
                <span class="badge badge-warning">@lang('main.labels.hit')</span>
            @endif
            @if($product->isRecommend())
                <span class="badge badge-danger">@lang('main.labels.recommend')</span>
            @endif
        </div>
        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->__('name') }}">
        <div class="caption">
            <h3>{{ $product->__('name') }}</h3>
            <p>{{ $product->price }}</p>
            <p>
                <form action="{{ route('basket-add', $product->id) }}" method="POST">
                    @if($product->isAvailable())
                        <button type="submit" class="btn btn-primary" role="button">@lang('main.in_the_basket')</button>
                    @else
                        @lang('main.out_of_stock')
                    @endif
                    <a href="{{ route('product', [isset($category) ? $category->code : $product->category->code, $product->code]) }}" class="btn btn-default"
                       role="button">@lang('main.detailed')</a>
                    @csrf
                </form>
            </p>
        </div>
    </div>
</div>
