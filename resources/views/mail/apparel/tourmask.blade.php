@extends('mail.layouts.apparel')

@section('content')
    <x-head-line class="apparel-mail-headline" title="Reusable Face Mask<br/>N95*/ PM2.5 Filter Compatible."/>
    {{-- <h2 style="color: black; text-align: center;"></h2> --}}
    <x-p text="Originally designed for outdoor concerts, festivals and live events, the Arena ‘Tour Mask' is now also helping our critical workers and global citizens in the fight against the COVID-19 pandemic."/>
    <x-p text="Social Masking will be essential over the next several months to prevent second and third waves of group spread. The Tour Mask is best suited for extended travel, public transportation, and the general participation in crowded settings."/>
    <x-p text="Arena operates as one of Phoenix, Arizona's largest Screen Print & Embroidery services. We've converted our sewing room floor to crank out masks for the masses- literally. From our bases in Arizona + Indiana + Texas, we’re capable of producing 50,000 American Made masks per day."/>
@endsection

@section("button")
    <x-button class="apparel-email-button" text="Buy Mask"/>
@endsection
