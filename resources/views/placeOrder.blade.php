<@extends('layouts/master')

@section('title', 'Оформление заказа')

@section('content')
    <h1>@lang('place_order.confirm_order')</h1>
    <div class="container">
        <div class="row justify-content-center">
            <p>@lang('place_order.total_cost_order') <b>{{ $order->calculateFullPrice() }} руб</b></p>
            <form action="{{ route('basket-confirm') }}" method="POST">
                <div>
                    <p>@lang('place_order.please_provide')</p>

                    <div class="container">
                        <div class="form-group">
                            <label for="name" class="control-label col-lg-offset-3 col-lg-2">@lang('place_order.name') </label>
                            <div class="col-lg-4">
                                <input type="text" name="name" id="name" value="" class="form-control">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="phone" class="control-label col-lg-offset-3 col-lg-2">@lang('place_order.phone_number') </label>
                            <div class="col-lg-4">
                                <input type="text" name="phone" id="phone" value="" class="form-control">
                            </div>
                        </div>
                        <br>
                        <br>
                        @guest
                            <div class="form-group">
                                <label for="email" class="control-label col-lg-offset-3 col-lg-2">@lang('place_order.email') </label>
                                <div class="col-lg-4">
                                    <input type="text" name="email" id="email" value="" class="form-control">
                                </div>
                            </div>
                        @endguest
                    </div>
                    <br>
                    <input type="hidden" name="_token" value="qhk4riitc1MAjlRcro8dvWchDTGkFDQ9Iacyyrkj">
                    <br>
                    @csrf
                    <input type="submit" class="btn btn-success" value="@lang('place_order.confirm_order')">
                </div>
            </form>
        </div>
    </div>
@endsection
