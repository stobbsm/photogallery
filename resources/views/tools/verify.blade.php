@extends('tools.base')
@section('title', __('cmdline.title_verify'))

@section('command')
    @php
        Artisan::call('photogallery:verify');
    @endphp
@endsection
