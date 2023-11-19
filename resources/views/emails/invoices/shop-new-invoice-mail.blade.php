@extends('layouts.email-layout')

@section('content')

<p>Hey again :)</p>

<h5>New Order Requested</h5>

<p>You've received a new order from <b>{{ $invoice->user->name }}</b></p>

<p>Their contacts are <a href="mailto:{{ $invoice->user->email }}">{{ $invoice->user->email }}</a> and <a href="tel:+{{ $invoice->user->phone_number }}">{{ $invoice->user->phone_number }}</a></p>

<p>Shopping Cart:</p>
<ul>
    @foreach( $invoice->cart as $item) 
        <li>x{{ $item['quantity'] }} {{ $item['product_variant']['name'] }}</li>
    @endforeach
</ul>

<div class="btn btn-primary">
    <p><a href="{{ url('/orders') }}">Process Order</a></p>
</div>

<p>Created: {{ $invoice->created_at->diffForHumans() }}</p>

<p>Kindly contact customer and process this order</p>


@endsection