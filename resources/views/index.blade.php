@extends('layouts/master')

@section('title', 'Главная')

@section('content')
    @if(session()->has('warning')) 
        <p class="alert alert-warning">{{ session()->get('warning') }}</p>
    @endif
    <h1>Все товары</h1>

    <div class="row">
        @foreach($products as $product)
            @include('layouts/card', compact('product'))
        @endforeach
    </div>
@endsection