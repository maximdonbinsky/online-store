@extends('layouts/master')

@section('title', __('categories.categories'))

@section('content')
    @foreach($categories as $category)
        <div class="panel">
            <a href="{{ route('category', $category->code) }}">
                <img src="{{ Storage::url($category->image) }}">
                <h2>{{ $category->__('name') }}</h2>
            </a>
            <h3>@lang('categories.total') {{$category->products->count()}}</h3>
            <p>{{$category->__('description')}}</p>
        </div>
    @endforeach
@endsection
