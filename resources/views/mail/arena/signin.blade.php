@extends('mail.layouts.arena')

@section('content')
    <x-head-line class="arena-email-headline" title="Welcome to Arena Apparel"/>
    <x-p text="We seek out the best factories in each product specialty and may interview up to fifty factories before selecting one to make our products."/>
    <x-p text="A factory visit is mandatory, during which expectations of our Code of Conduct are discussed including our requirement to cascade this through their supply chain. We do not at this early stage in the relationship expect the company to name all of their suppliers, but through raising the subject, we aim to gauge their level of future cooperation."/>
    <x-p text="Available capacity is also key to this conversation. It is important that we gain insight into their production planning for us to understand how they can accommodate any new business without the need for overtime and subcontracting."/>
@endsection

@section('button')
    <x-button class="arena-email-button" text="Sign In"/>
@endsection
