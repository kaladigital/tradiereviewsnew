@extends('layouts.master')
@section('content')
@include('dashboard.left_sidebar_full_menu',['active_page' => 'settings'])
<div class="col-md-auto col-12 content-wrap settings-security">
    <div class="content-inner">
        <h2 class="page-title">Settings</h2>
        <div class="content-widget row no-gutters">
            @include('settings.settings_menu',['active_page' => 'security'])
            <div class="col-md-auto col-12 contents">
                {!! Form::open(['url' => 'settings/security', 'method' => 'patch', 'class' => 'data-form password-form needs-validation', 'autocomplete' => 'off', 'id' => 'password_change_form']) !!}
                    <div class="content-body account-info">
                        @include('elements.alerts')
                        <h3>Security</h3>
                        <h6>Change Password</h6>
                        <p>You can change your password below.</p>
                        <div class="form-wrap">
                            <div class="form-group">
                                {!! Form::password('current_password',['class' => 'form-control', 'placeholder' => 'Current Password', 'id' => 'current_password']) !!}
                                {!! Form::label('current_password','Current Password') !!}
                                <button type="button" class="btn position-absolute showPassword show_password" id="show_password">
                                    <img src="/images/eye-icon.svg" class="eye_icon" data-type="gray" alt="Eye icon">
                                    <img src="/images/eye-green-icon.svg" class="eye_icon" data-type="green" alt="Eye icon" style="display:none;">
                                </button>
                            </div>
                            <div class="form-group">
                                {!! Form::password('new_password',['class' => 'form-control', 'placeholder' => 'New Password', 'id' => 'new_password']) !!}
                                {!! Form::label('new_password','New Password') !!}
                                <button type="button" class="btn position-absolute showPassword show_password" id="show_password">
                                    <img src="/images/eye-icon.svg" class="eye_icon" data-type="gray" alt="Eye icon">
                                    <img src="/images/eye-green-icon.svg" class="eye_icon" data-type="green" alt="Eye icon" style="display:none;">
                                </button>
                            </div>
                            <div class="form-group">
                                {!! Form::password('new_password_confirm',['class' => 'form-control', 'placeholder' => 'Repeat New Password', 'id' => 'new_password_confirm']) !!}
                                {!! Form::label('new_password_confirm','Repeat New Password') !!}
                                <button type="button" class="btn position-absolute showPassword show_password" id="show_password">
                                    <img src="/images/eye-icon.svg" class="eye_icon" data-type="gray" alt="Eye icon">
                                    <img src="/images/eye-green-icon.svg" class="eye_icon" data-type="green" alt="Eye icon" style="display:none;">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="action-row">
                        <a href="#" class="btn btn--round btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn--round btn-primary">Save</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('view_script')
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','.show_password',function(){
            var input_obj = $(this).closest('.form-group').find('.form-control');
            if (input_obj.attr('type') == 'password') {
                input_obj.attr('type','text');
                $(this).find('.eye_icon[data-type="gray"]').hide();
                $(this).find('.eye_icon[data-type="green"]').show();
            }
            else{
                input_obj.attr('type','password');
                $(this).find('.eye_icon[data-type="green"]').hide();
                $(this).find('.eye_icon[data-type="gray"]').show();
            }

            return false;
        });

        $('#password_change_form').validate({
            rules : {
                current_password: {
                    required: true,
                },
                new_password: {
                    required: true
                },
                new_password_confirm: {
                    required: true,
                    equalTo: '#new_password'
                },
            },
            messages: {
                current_password: {
                    required : 'Please specify current password'
                },
                new_password: {
                    required : 'Please specify new password'
                },
                new_password_confirm: {
                    required : 'Please confirm new password',
                    equalTo: 'Password\'s don\'t match'
                }
            },
        });
    });
</script>
@endsection
