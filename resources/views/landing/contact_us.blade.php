@extends('layouts.login')
@section('content')
<main class="main not-logedin">
    @include('auth.header',['auth_user' => $auth_user])
    <div class="container contents-wrapper contact-us">
        <div class="row no-gutters">
            <div class="col-12 col-md-6 content-col">
                <div class="inner-container">
                    <h1>We’d Love To <span class="blue-text">Hear From You</span>!</h1>
                    <div class="form-wrap form-style2">
                        {!! Form::open(['url' => 'contact-us', 'id' => 'contact_us_form']) !!}
                            <div class="form-group">
                                {!! Form::text('name',null,['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Your Name', 'required' => 'required']) !!}
                                {!! Form::label('name','Your Name') !!}
                            </div>
                            <div class="form-group">
                                {!! Form::email('email',null,['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Your Email', 'required' => 'required']) !!}
                                {!! Form::label('email','Your Email') !!}
                            </div>
                            <div class="form-group">
                                {!! Form::textarea('message',null,['class' => 'form-control', 'id' => 'message', 'placeholder' => 'Start typing...', 'required' => 'required', 'required' => 'required']) !!}
                                {!! Form::label('message','Your Message') !!}
                            </div>
                            <div class="form-group">
                                <div class="g-recaptcha mb-3 mt-3" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                            </div>
                            <div id="loading_container" style="display:none;">
                                <img src="/images/loader.gif" width="24px" class="float-left">
                                <span class="float-left ml-1 loader-text">Processing</span>
                            </div>
                            <button type="submit" id="submit_btn" class="btn btn-primary btn--sqr">Get in Touch</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 figure-col">
                <div class="inner-container ml-md-auto">
                    <figure class="figure">
                        <img src="/images/contact-us-figure.png" alt="Contact us figure">
                    </figure>
                    <h2>Or Conact Us via Email:</h2>
                    <div class="mail-info-cart cart d-flex align-items-center">
                        <figure class="cart-figure">
                            <img src="/images/envelope-icon.svg" alt="">
                        </figure>
                        <div class="info">
                            <p>Send us an email:</p>
                            <a href="mailto:info@tradiereviews.co">info@tradiereviews.co</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('view_script')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('submit','#contact_us_form',function(){
            var recaptcha_token = $('#g-recaptcha-response').val();
            $('#submit_btn').hide();
            $('#loading_container').show();
            $.post('/contact-us',{ name: $('#name').val(), email: $('#email').val(), message: $('#message').val(), recaptcha_token: recaptcha_token },function(data){
                $('#loading_container').hide();
                $('#submit_btn').show();
                grecaptcha.reset();
                if (data.status) {
                    new Noty({
                        type: 'success',
                        theme: 'metroui',
                        layout: 'topRight',
                        text: "<b>Thank you!</b> <br>We've received your message and will get back to you within 24 hours.",
                        timeout: 4000,
                        progressBar: false
                    }).show();
                    @if(env('APP_ENV') != 'local')
                        dataLayer.push({'event': 'contact_us_request'});
                    @endif
                    $('#contact_us_form')['0'].reset();
                }
                else{
                    new Noty({
                        type: 'error',
                        theme: 'metroui',
                        layout: 'topRight',
                        text: data.error,
                        timeout: 4000,
                        progressBar: false
                    }).show();
                }
            },'json');
            return false;
        });
    });
</script>
@endsection
