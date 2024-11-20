@extends('layouts/master')

@section('title')

    @section('content')
        <h1>{{ $product->name }}</h1>
        <p>Цена: <b>{{ $product->price }} руб.</b></p>
        <img src="{{ Storage::url($product->image) }}">
        <p>{{ $product->description }}</p>
            @if($product->isAvailable())
                <form action="{{ route('basket-add', $product->id) }}" method="POST">
                    <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                    @csrf
                </form>
            @else
                <span><b>Нет в наличии</b></span>
                <br>
                <span>Сообщить мне о поступлении товара:</span>
                <div class="warning">
                    @if($errors->get('email'))
                        {!! $errors->get('email')[0] !!}
                    @endif
                </div>
                <form method="POST" action="{{ route('subscription', $product) }}">
                    <input type="text" name="email" value="Укажите email"></input>
                    <button type="submit">Отправить</button>
                    @csrf
                </form>
            @endif
    @endsection
