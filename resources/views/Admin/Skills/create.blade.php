@php
    $title = "Add Skill"
@endphp

@extends('Admin.layouts.page')

@section('section')

<section class="breadcrumb-nav">
    <div class="container">
        <h4>
            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('skills.show') }}">{{ __('Skills') }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ __('Add Skill') }}</span>
        </h4>
    </div>
</section>

<section class="createForm">
    <div class="col-xl-9">
        <div class="row">
            <div class="section-content create">
                <div class="row">
                    <div class="col-8 head info-head">
                        <h5><i class="fa-solid fa-fill-drip"></i> <span>{{ __('Create Skill') }}</span></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="form">
                        <form action="{{ route('skills.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" name="languageName" id="languageName" class="form-control" placeholder="language Name" required>
                                        <label for="languageName">{{ __('language Name') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <select class="form-control" name="type" id="type" required>
                                            <option class="text-uppercase text-center" selected="selected" disabled="disabled">{{ __('- Skill Type -') }}</option>
                                            @foreach (\App\Enums\SkillType::cases() as $type)
                                                <option value="{{ $type->value }}">{{ $type->value }}</option>
                                            @endforeach
                                        </select>
                                        <label for="type">{{ __('Skill Type') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <div>
                                            <input style="width: 20% !important" type="checkbox" value="1" name="main" id="main">
                                            <span class="text-muted">{{ __('Primary Language') }}</span>
                                        </div>
                                        <label for="main">{{ __('Main') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-primary">{{ __('Add Skill') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
