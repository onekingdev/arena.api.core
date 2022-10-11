@extends("mail.layouts.soundblock")

@section("content")
    <x-head-line class="soundblock-email-headline" title="New Support Ticket."/>
    <x-p text="You have been attached to {{$ticket->ticket_title}} ticket."/>
    <x-p text="You can view this ticket from your Soundblock account by clicking on Support at the top of the page."/>
@endsection