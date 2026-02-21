@php
    $title = "Show Work Experience"
@endphp

@extends('Admin.layouts.page')

@section('section')

<section class="breadcrumb-nav">
    <div class="container">
        <h4>
            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ __('Work Experience') }}</span>
        </h4>
    </div>
</section>

<div class="buttons">
    <div class="row">
        <div class="col">
            <a href="{{ route('works.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> {{ __('Add Work Experience') }}</a>
        </div>
    </div>
</div>

<section class="content">
    <div class="container">
        <div class="card-deck row">
            @for ($i = 0; $i < count($works); $i++)
                @if ($i % 2 == 0)
                    </div>
                    <div class="card-deck row">
                @endif

                <div class="card col-xl-6">
                    <div class="card-body">
                        <div class="row">
                            <h5 class="card-title col font-weight-bold text-uppercase">{{ $works[$i]->companyName }}</h5>
                            <div class="col-1 text-end update">
                                <a class="text-success" href="{{ route('works.edit', ['id' => $works[$i]->id]) }}" title="Update Project"><i class="fa-solid fa-edit"></i></a>
                            </div>
                            <div class="col-1 text-end remove">
                                <a class="text-danger open-button" onclick="openForm{{ $i }}()" id="delete-2" href="#" title="Delete Skill"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                        <p class="card-text">{{ $works[$i]->caption }}</p>
                        <p class="card-text"><b>{{ __('Environment: ') }}</b>{{ $works[$i]->environment }}</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            {{ date("F Y", strtotime($works[$i]->startDate)) . " To " }}
                            @if ($works[$i]->current != null)
                                {{ $works[$i]->current }}
                            @else
                                {{ date("F Y", strtotime($works[$i]->endDate)) }}
                            @endif
                        </small>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

<div class="overlay"></div>

@for ($i = 0; $i < count($works); $i++)
    <div class="form-popup" id="myForm_{{ $i }}">
        <div class="card border-danger mb-3" style="max-width: 60rem;">
            <div class="card-header">{{ $works[$i]->companyName }}</div>
            <div class="card-body text-danger">
                <h5 class="card-title">{{ __('Delete the project "') . $works[$i]->companyName . '"?' }}</h5>
                <p class="card-text">
                    <a href="{{ route('works.delete', ['id' => $works[$i]->id]) }}" class="card-link">{{ __('Delete') }}</a>
                    <a href="#" class="card-link cancel" onclick="closeForm{{ $i }}()">{{ __('Cancel') }}</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        let overlay = $('.overlay');
        overlay.css('height', $('body').css('height'));
        function openForm{{ $i }}() {
            for (let index = 0; index < {{count($works)}}; index++) {
                if (index === {{$i}}) {
                    continue;
                }
                console.log(index);
                $('#myForm_' + index).css('display', 'none');
            }
            $('#myForm_' + {{ $i }}).css('display', 'block');
            overlay.css('display', 'block');

        }

        function closeForm{{ $i }}() {
            $('#myForm_' + {{ $i }}).css('display', 'none');
            overlay.css('display', 'none');
        }
    </script>
@endfor



@endsection
