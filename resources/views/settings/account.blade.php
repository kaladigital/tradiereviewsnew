@extends('layouts.master')
@section('content')
    @include('dashboard.left_sidebar_full_menu',['active_page' => 'settings'])
    <div class="col-md-auto col-12 content-wrap review-settings">
        <div class="content-inner">
            <div>
                <h2 class="page-title">Settings</h2>
                <div class="content-widget row no-gutters">
                    @include('settings.settings_menu',['active_page' => 'account', 'user_onboaridng' => $user_onboarding])
                    <div class="col-md-auto col-12 contents">
                        {!! Form::model($auth_user,['action' => ['SettingsController@updateAccount'], 'method' => 'patch', 'autocomplete' => 'off', 'id' => 'account_form']) !!}
                        <div class="content-body account-info">
                            <h3>Account</h3>
                            <div class="visual-section">
                                <div class="inner-container d-flex align-items-center">
                                    <div class="note-wrap order-md-2 order-lg-1 d-flex">
                                        <div class="icon">
                                            <img src="/images/info-icon.svg" alt="Info icon">
                                        </div>
                                        <p class="info">
                                            Welcome to TradieReviews, where you can quickly generate 100’s of online reviews from authentic customers.
                                        </p>
                                    </div>
                                    <div class="graphics-figure ml-auto order-md-1 order-lg-2">
                                        <img src="/images/account-visual-figure.svg" alt="Account visual figure">
                                    </div>
                                </div>
                            </div>
                            <h6>Personal Information</h6>
                            <p>This information will be displayed for your clients.</p>
                            <div class="inner-container">
                                <div class="form-wrap">
                                    @include('elements.alerts')
                                    <div class="form-group-row form-row">
                                        <div class="form-group col-12 col-lg-6">
                                            {!! Form::text('name',null,['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Full Name', 'id' => 'name']) !!}
                                            {!! Form::label('name','Full Name') !!}
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            {!! Form::text('email',null,['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Email', 'id' => 'email']) !!}
                                            {!! Form::label('email','Email') !!}
                                        </div>
                                    </div>
                                    <div class="form-group-row form-row">
                                        <div class="form-group select-group col-12 col-lg-6">
                                            {!! Form::select('country_id',$countries,null,['class' => 'form-control', 'required' => 'required', 'id' => 'country_id']) !!}
                                            {!! Form::label('country_id','Country') !!}
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            {!! Form::text('zip_code',null,['class' => 'form-control', 'placeholder' => 'Area/ZIP Code', 'id' => 'zip_code']) !!}
                                            {!! Form::label('zip_code','Zip') !!}
                                        </div>
                                    </div>
                                    <div class="checkbox-row d-flex">
                                        <div class="custom-control custom-checkbox form-group">
                                            {!! Form::checkbox('is_reviews_display_name','1',$auth_user->is_reviews_display_name ? true : false,['class' => 'custom-control-input', 'id' => 'is_reviews_display_name']) !!}
                                            {!! Form::label('is_reviews_display_name','I want to display my full name on review requests.',['class' => 'custom-control-label']) !!}
                                        </div>
                                    </div>
                                    <h6>Business Information</h6>
                                    <p>Your company details will be presented on the review requests sent to your clients.</p>
                                    <div class="inner-container">
                                        <div class="form-wrap">
                                            <div class="form-group-row form-row">
                                                <div class="form-group col-12 col-lg-6">
                                                    {!! Form::text('reviews_company_name',null,['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Company Name', 'id' => 'reviews_company_name']) !!}
                                                    {!! Form::label('reviews_company_name','Company Name') !!}
                                                </div>
                                                <div class="form-group col-12 col-lg-6">
                                                    {!! Form::url('website_url',null,['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Email', 'id' => 'website_url']) !!}
                                                    {!! Form::label('website_url','URL of Your Website') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="action-row">
                            @if($user_onboarding->status == 'pending')
                                <a href="/settings/skip/account" class="btn btn--round btn-secondary">Skip</a>
                                <button type="submit" class="btn btn--round btn-primary">Continue</button>
                            @else
                                <button type="submit" class="btn btn--round btn-primary">Save</button>
                            @endif
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
