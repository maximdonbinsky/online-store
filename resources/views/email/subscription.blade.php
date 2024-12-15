@lang('email.dear_customer') {{ $product->__('name') }} @lang('email.appeared_product')
<a href="{{ route('product', [$product->category->code, $product->code]) }}">@lang('email.details')</a>
