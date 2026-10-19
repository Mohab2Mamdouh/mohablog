@php
    $title = "Add Project"
@endphp

@extends('Admin.layouts.page')

@section('section')

<section class="breadcrumb-nav">
    <div class="container">
        <h4>
            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('projects.show') }}">{{ __('Projects') }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ __('Add Project') }}</span>
        </h4>
    </div>
</section>

@include('Admin.Projects._form', [
    'action'      => route('projects.store'),
    'submitLabel' => __('Add Project'),
])

@endsection
