@extends('layouts.email-layout')

@section('content')

Hello <b>{{ $invoice->user->name }}</b>,

<br>

<h5>We've received your order #{{ $invoice->reference }}</h5>

<p>Our team is working on it and would contact you shortly.</p>
<p class="btn btn-primary">
    <a class="" href="{{ url('/orders') }}">Track my Order</a>
    <a class="" href="{{ url('/shop') }}">Visit Shop</a>
</p>
<p>Here are the details:</p>
<ul>
    <li>Order Total: {{ $invoice->grand_total }}</li>
    <li>Address: {{ $invoice->address->street_address }}</li>
</ul>

<p>Kindly note delivery is free in Nairobi CBD. Other regions in Nairobi would incur additional charges which would be communicated to you. <br>
</p>

<p>Pay Cash/Mpesa on Delivery within Nairobi CBD and close estates. Shipments made using external services require payment before delivery.</p>

<p>Thank you for choosing us</p>

<p>Cheers</p>


@endsection