@php
    $title = "Edit Project"
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
            <span>{{ __('Edit Project') }}</span>
        </h4>
    </div>
</section>

<section class="createForm">
    <div class="col-xl-9">
        <div class="row">
            <div class="section-content create">
                <div class="row">
                    <div class="col-8 head info-head">
                        <h5><i class="fa-solid fa-diagram-project"></i> <span>{{ __('Update Project') }}</span></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="form">
                        <form action="{{ route('projects.update', ['id' => $project->id]) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" name="name" id="projectName" class="form-control" value="{{ $project->name }}" placeholder="Project Name" required>
                                        <label for="projectName">{{ __('Project Name') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" name="appURL" id="appURL" value="{{ $project->appURL }}" class="form-control" placeholder="App URL">
                                        <label for="appURL">{{ __('App URL') }}</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" name="URL" id="URL" class="form-control" value="{{ $project->url }}" placeholder="Github URL" required>
                                        <label for="URL">{{ __('Github URL') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" name="caption" id="caption" class="form-control" value="{{ $project->caption }}" placeholder="Caption" required>
                                        <label for="caption">{{ __('Caption') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <textarea name="description" class="form-control" placeholder="Description" id="description" cols="30" rows="3">{{ $project->description }}</textarea>
                                        <label for="description">{{ __('Description') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" name="link" id="link" class="form-control" value="{{ $project->link }}" placeholder="Project Link (Live Demo)">
                                        <label for="link">{{ __('Project Link') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <textarea name="TechnologyStack" class="form-control" placeholder="Technology Stack" id="TechnologyStack" cols="30" rows="2">
                                            {{ $project->techmologyStack }}
                                        </textarea>
                                        <label for="TechnologyStack">{{ __('Technology Stack') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="date" name="endDate" id="endDate" class="form-control" value="{{ $project->endDate?->format('Y-m-d') }}" placeholder="End Date">
                                        <label for="endDate">{{ __('End Date') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-success">{{ __('Update Project') }}</button>
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
