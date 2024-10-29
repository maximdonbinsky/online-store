@extends('layouts/master')

@section('title')

    @section('content')
        <h1>{{ $product->name }}</h1>
        <p>Цена: <b>{{ $product->price }} руб.</b></p>
        <img src="{{ Storage::url($product->image) }}">
        <p>{{ $product->description }}</p>
        <form action="{{ route('basket-add', $product->id) }}" method="POST">
            @if($product->isAvailable())
                <button type="submit" class="btn btn-primary" role="button">В корзину</button>
            @else
                Нет в наличии
            @endif
            @csrf
        </form>
    @endsection
