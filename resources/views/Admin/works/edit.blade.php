@php
    $title = "Edit Work Experience"
@endphp

@extends('Admin.layouts.page')

@section('section')

<section class="breadcrumb-nav">
    <div class="container">
        <h4>
            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('works.show') }}">{{ __('Work Experiences') }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ __('Edit Work Experience') }}</span>
        </h4>
    </div>
</section>

<section class="createForm">
    <div class="col-xl-9">
        <div class="row">
            <div class="section-content create">
                <div class="row">
                    <div class="col-8 head info-head">
                        <h5><i class="fa-solid fa-diagram-project"></i> <span>{{ __('Edit Work Experience') }}</span></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="form">
                        <form action="{{ route('works.update', ['id' => $work->id]) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" name="companyName" id="companyName" class="form-control" value="{{ $work->companyName }}" placeholder="Company Name" required>
                                        <label for="companyName">{{ __('Company Name') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" name="title" id="title" class="form-control" value="{{ $work->title }}" placeholder="Title" required>
                                        <label for="title">{{ __('Title') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" name="caption" id="caption" class="form-control" value="{{ $work->caption }}" placeholder="Caption" required>
                                        <label for="caption">{{ __('Caption') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" name="environment" id="environment" class="form-control" value="{{ $work->environment }}" placeholder="Environment" required>
                                        <label for="environment">{{ __('Environment') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="input-group">
                                        <input type="date" name="startDate" id="startDate" class="form-control" value="{{ $work->startDate }}" placeholder="Start Date" required>
                                        <label for="startDate">{{ __('Start Date') }}</label>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="input-group">
                                        <small>
                                            <input type="checkbox" onchange="Disable()" style="width: 10%;" value="present" name="Present" id="present"
                                            @if ($work->current != null)
                                                checked
                                            @endif
                                            >
                                            <label for="present">{{__('Still Work there?')}}</label>
                                        </small>
                                        <input type="date" name="endDate" id="endDate" class="form-control" placeholder="End Date" required
                                        value="@if ($work->current == null){{ $work->endDate }}@endif"
                                        >
                                        <label for="endDate">{{ __('End Date') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-primary">{{ __('Update Work Experience') }}</button>
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

<script>

    let endDate = $('#endDate');
    let present = $('#present');
    function Disable() {

        if (present.prop('checked') === true) {
            endDate.prop('disabled', true);
            endDate.val(null);
        } else {
            endDate.prop('disabled', false);
        }
    }

    if (present.prop('checked') === true) {
        endDate.prop('disabled', true);
        endDate.val(null);
    }
</script>

@endsection
