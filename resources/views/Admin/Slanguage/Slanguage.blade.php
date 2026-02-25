@php
    $title = "Speaking Language"
@endphp

@extends('Admin.layouts.page')

@section('section')

<section class="breadcrumb-nav">
    <div class="container">
        <h4>
            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ __('Speaking Language') }}</span>
        </h4>
    </div>
</section>

<div class="buttons">
    <div class="row">
        <div class="col">
            <a href="{{ route('langs.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> {{ __('Add Speaking Language') }}</a>
        </div>
    </div>
</div>


<section class="content" style="padding-bottom: 84px">
    <div class="container">
        <div class="card-deck row">
            <div class="col-xl-6">
                @for ($i = 0; $i < count($langs); $i++)
                    @if ($i == round(count($langs) / 2))
                        </div>
                        <div class="col-xl-6">
                    @endif

                    <div class="card col-xl-12" style="width: 100% !important; margin-bottom: 25px;">
                        <div class="card-body">
                            <div class="row">
                                <h5 class="card-title col font-weight-bold text-uppercase">{{ $langs[$i]->languageName }}</h5>
                                <div class="col-1 text-end update">
                                    <a class="text-success editLang" href="#" title="Update Language"><i class="fa-solid fa-edit"></i></a>
                                </div>
                                <div class="col-1 text-end remove">
                                    <a class="text-danger open-button" onclick="openForm{{ $i }}()" id="delete-2" href="#" title="Delete Skill"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </div>
                            <div class="row confirm confirmation-update d-none">
                                <div class="card col" style="padding: 0;margin-bottom: 15px;">
                                    <h5 class="card-header alert alert-success alert-dismissible fade show" style="color: rgb(62, 185, 62);font-weight: bold;">{{ __('Update Skill') }}</h5>
                                    <div class="card-body" style="margin: 0;" role="alert">
                                        <h5 class="card-title" style="color: #888">{{ __('Update ') . $langs[$i]->languageName }}</h5>
                                        <p class="card-text">
                                            <form action="{{ route('langs.update', ['id' => $langs[$i]->id]) }}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="input-group">
                                                            <input type="text" name="languageName" id="languageName" class="form-control" value="{{ $langs[$i]->languageName }}" required>
                                                            <label for="languageName">{{ __('Language Name') }}</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <div class="input-group">
                                                            <select class="form-control" name="level" id="level" required>
                                                                <option class="text-uppercase text-center" selected="selected" disabled="disabled">{{ __('- Chooce Your Level -') }}</option>
                                                                @for ($x = 0; $x < 6; $x++)
                                                                    <option value="Level {{ $x }}"
                                                                    @if ($langs[$i]->level == "Level ".$x)
                                                                        selected="selected"
                                                                    @endif
                                                                    >{{ __('Level ') . $x }}</option>
                                                                @endfor
                                                            </select>
                                                            <label for="level">{{ __('Level') }}</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-8">
                                                        <button type="submit" class="btn btn-primary text-uppercase">{{ __('Update Speaking Language') }}</button>
                                                    </div>
                                                    <div class="col">
                                                        <span class="btn btn-outline-danger text-uppercase cancel">{{ __('cancel') }}</span>
                                                    </div>
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            </div>
                            <p class="card-text"><b>{{ __('Level: ') }}</b>{{ $langs[$i]->level }}</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                {{ __('Created at ') . date("F Y", strtotime($langs[$i]->created_at)) }}
                            </small>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</section>

<div class="overlay"></div>

@for ($i = 0; $i < count($langs); $i++)
    <div class="form-popup" id="myForm_{{ $i }}">
        <div class="card border-danger mb-3" style="max-width: 60rem;">
            <div class="card-header">{{ $langs[$i]->languageName }}</div>
            <div class="card-body text-danger">
                <h5 class="card-title">{{ __('Delete the Language "') . $langs[$i]->languageName . '"?' }}</h5>
                <p class="card-text">
                    <a href="{{ route('langs.delete', ['id' => $langs[$i]->id]) }}" class="card-link">{{ __('Delete') }}</a>
                    <a href="#" class="card-link cancel" onclick="closeForm{{ $i }}()">{{ __('Cancel') }}</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        let overlay = $('.overlay');
        overlay.css('height', $('body').css('height'));
        function openForm{{ $i }}() {
            for (let index = 0; index < {{count($langs)}}; index++) {
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
