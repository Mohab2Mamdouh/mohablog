@php
    $title = "Personal Info"
@endphp

@extends('Admin.layouts.page')

@section('section')

<section class="breadcrumb-nav">
    <div class="container">
        <h4>
            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('info.show') }}">{{ __('Personal Info') }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ __('Edit Personal Info') }}</span>
        </h4>
    </div>
</section>


<section class="content">
    <div class="row">
        <div class="col-xl-4 profilePic">
            <div class="section-content profile-pic">
                <div class="row">
                    <div class="head pic-head">
                        <h5>{{ __('Update Profile Picture') }}</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="picture">
                        <img src="{{ asset('storage/users/'.$user->profileImage) }}" alt="{{ $user->username }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form">
                        <form action="{{ route('info.image') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <input type="file" class="form-control" style="width: 85% !important" id="profile_pic" name="profile_pic">
                                <input type="hidden" name="oldPic" value="{{ $user->profileImage }}">
                            </div>
                            <div class="row">
                                <button type="submit" class="btn btn-block btn-primary" style="width: 85%;margin: auto 24px;">{{ __('Update Picture') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">
                <div class="section-content profile-info">
                    <div class="row">
                        <div class="col-8 head info-head">
                            <h5><i class="fa-solid fa-id-card"></i> <span>{{ __('Edit User Profile') }}</span></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form">
                            <form action="{{ route('info.update') }}" method="post">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <div class="col-xl-6 " style="">
                                        <div class="input-group">
                                            <input type="text" name="FullName" id="FullName" class="form-control" value="{{ $user->fullName }}">
                                            <label for="FullName">{{ __('Full Name') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" style="">
                                        <div class="input-group">
                                            <input type="text" name="Username" id="Username" class="form-control" value="{{ $user->username }}">
                                            <label for="Username">{{ __('Username') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="input-group">
                                            <input type="text" name="Title" id="Title" class="form-control" value="{{ $user->title }}">
                                            <label for="Title">{{ __('Title') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="input-group">
                                            <input type="email" name="Email" id="Email" class="form-control" value="{{ $user->email }}">
                                            <label for="Email">{{ __('Email') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="input-group">
                                            <input type="text" name="Address" id="Address" class="form-control" value="{{ $user->address }}">
                                            <label for="Address">{{ __('Address') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="input-group">
                                            <input type="tel" name="Phone" id="Phone" class="form-control" value="{{ $user->phone }}">
                                            <label for="Phone">{{ __('Phone') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="input-group">
                                            <input type="number" name="ExpYear" id="ExpYear" class="form-control" value="{{ $user->expYear }}">
                                            <label for="ExpYear">{{ __('Exp Year') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <label class="form-label fw-bold mb-3">{{ __('Choose Layout') }}</label>

                                        <div class="d-flex gap-3">

                                            <!-- Layout 1 -->
                                            <input type="radio"
                                                   class="btn-check"
                                                   name="layout"
                                                   id="layout1"
                                                   value="pdf1"
                                                   autocomplete="off"
                                                {{ $user->layout == 'pdf1' ? 'checked' : '' }}>

                                            <label class="btn btn-outline-primary w-100 py-3 text-center" for="layout1">
                                                <div class="fw-semibold">{{ __('Layout 1') }}</div>
                                                <small>{{ __('Simple & clean design') }}</small>
                                            </label>

                                            <!-- Layout 2 -->
                                            <input type="radio"
                                                   class="btn-check"
                                                   name="layout"
                                                   id="layout2"
                                                   value="pdf"
                                                   autocomplete="off"
                                                {{ $user->layout == 'pdf' ? 'checked' : '' }}>

                                            <label class="btn btn-outline-primary w-100 py-3 text-center" for="layout2">
                                                <div class="fw-semibold">{{ __('Layout 2') }}</div>
                                                <small>{{ __('Detailed & structured') }}</small>
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="input-group">
                                            <input type="text" name="my_site" id="mySite" class="form-control" value="{{ $user->my_site }}">
                                            <label for="mySite">{{ __('mySite') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="input-group">
                                            <input type="text" name="behance" id="behance" class="form-control" value="{{ $user->behance }}">
                                            <label for="behance">{{ __('Behance') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="input-group">
                                            <input type="text" name="github" id="github" class="form-control" value="{{ $user->github }}">
                                            <label for="github">{{ __('Github') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="input-group">
                                            <input type="text" name="linked_in" id="linked_in" class="form-control" value="{{ $user->linked_in }}">
                                            <label for="linked_in">{{ __('Linked In') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="input-group">
                                            <textarea name="profile" class="form-control" id="profile" cols="10" rows="2">
                                                {{ $user->profile }}
                                            </textarea>
                                            <label for="profile">{{ __('Profile') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-primary">{{ __('Update Info') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
