@extends('layouts/master')

@section('title')

    @section('content')
        <h1>{{ $product->__('name') }}</h1>
        <p>@lang('product.price') <b>{{ $product->price }} руб.</b></p>
        <img src="{{ Storage::url($product->image) }}">
        <p>{{ $product->__('description') }}</p>
            @if($product->isAvailable())
                <form action="{{ route('basket-add', $product->id) }}" method="POST">
                    <button type="submit" class="btn btn-primary" role="button">@lang('main.in_the_basket')</button>
                    @csrf
                </form>
            @else
                <span><b>@lang('main.out_of_stock')</b></span>
                <br>
                <span>@lang('product.inform_me')</span>
                <div class="warning">
                    @if($errors->get('email'))
                        {!! $errors->get('email')[0] !!}
                    @endif
                </div>
                <form method="POST" action="{{ route('subscription', $product) }}">
                    <input type="text" name="email" value=@lang('product.enter_email')></input>
                    <button type="submit">@lang('product.send')</button>
                    @csrf
                </form>
            @endif
    @endsection
