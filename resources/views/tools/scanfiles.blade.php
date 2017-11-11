@extends('tools.base')
@section('title', __('cmdline.title_scan'))

@section('command')
    @php
        Artisan::call('photogallery:scan');
    @endphp
@endsection
