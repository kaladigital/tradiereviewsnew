@extends('layouts.login')
@section('content')
<main class="main login-page tradie-reviews">
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-12 col-lg-auto form-section">
                <div class="inner-container">
                    <a href="/" class="main-logo">
                        <img src="/images/tradiereviews.svg" alt="TradieReviews logo">
                    </a>
                    <div class="login-content-wrapper">
                        <h1>
                            Log
                            <span class="blue-text">In</span>.
                        </h1>
                        <h6>
                            New to TradieFlow? <a href="/free-trial">Register Now</a>
                        </h6>
                        <div class="form-wrap login-form form-style2">
                            @include('elements.alerts')
                            {!! Form::open(['action' => 'Auth\AuthController@postLogin', 'method' => 'post', 'id' => 'login_form']) !!}
                                <div class="form-group">
                                    {!! Form::email('email', null, ['required' => 'required', 'class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email']) !!}
                                    {!! Form::label('email','Email') !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::password('password', ['required' => 'required', 'class' => 'form-control', 'placeholder' => 'Password', 'id' => 'password']) !!}
                                    {!! Form::label('password','Password') !!}
                                    <button type="button" class="btn position-absolute showPassword" id="show_password">
                                        <img src="/images/eye-icon.svg" class="eye_icon" data-type="gray" alt="Eye icon">
                                        <img src="/images/eye-icon-blue.svg" class="eye_icon" data-type="green" alt="Eye icon" style="display:none;">
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-primary btn--sqr">Log In</button>
                            {!! Form::close() !!}
                            <p>
                                <a href="/auth/forgot-password">Forgot password?</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-auto thumb-section">
                <figure class="figure">
                    <img src="/images/login-page-figure.png" alt="Login background image" class="figure-image">
                </figure>
            </div>
        </div>
    </div>
</main>
@endsection
@section('view_script')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','#show_password',function(e){
            if ($('#password').attr('type') == 'password') {
                $('#password').attr('type','text');
                $(this).find('.eye_icon[data-type="gray"]').hide();
                $(this).find('.eye_icon[data-type="green"]').show();
            }
            else{
                $('#password').attr('type','password');
                $(this).find('.eye_icon[data-type="green"]').hide();
                $(this).find('.eye_icon[data-type="gray"]').show();
            }
            return false;
        });
    });
</script>
@endsection
