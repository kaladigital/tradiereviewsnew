@extends('layouts.master')
@section('content')
    @include('dashboard.left_sidebar_menu',['active_page' => 'settings'])
    <div class="col-md-auto col-12 content-wrap onboarding">
        <div class="content-inner text-center">
            <h1>Select your <span class="green-text">Onboarding</span>!</h1>
            <h3>How would you like to onboard?</h3>
            <div class="select-items-container">
                <div class="row">
                    <div class="col-md-6 select-item">
                        <div class="select-item-inner">
                            <h3>Self-Onboarding</h3>
                            <p>Try and get started with TradieFlow
                                right away!</p>
                            <a href="/settings/account" class="btn btn--round green-outline">Select</a>
                            <figure class="figure">
                                <img src="/images/self-onboarding-figure.png" alt="Self onboarding">
                            </figure>
                        </div>
                    </div>
                    <div class="col-md-6 select-item demo">
                        <div class="select-item-inner">
                            <h3>Demo</h3>
                            <p>Please select a day and a time slot to consult with one of our specialists!</p>
                            <a href="/onboarding-demo" class="btn btn--round green-outline">Select</a>
                            <figure class="figure">
                                <img src="/images/demo-onboarding-figure.png" alt="Demo onboarding">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
