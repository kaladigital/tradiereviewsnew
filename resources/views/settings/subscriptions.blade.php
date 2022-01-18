@extends('layouts.master')
@section('content')
    @include('dashboard.left_sidebar_full_menu',['active_page' => 'settings'])
    <div class="col-md-auto col-12 content-wrap review-settings">
        <div class="content-inner">
            <div>
                <h2 class="page-title">Settings</h2>
                <div class="content-widget row no-gutters">
                    @include('settings.settings_menu',['active_page' => 'subscriptions', 'user_onboarding' => $user_onboarding])
                    <div class="col-md-auto col-12 contents">
                        <div class="content-body">
                            <h3>Subscriptions</h3>
                            <div class="visual-section">
                                <div class="inner-container d-flex align-items-center">
                                    <div class="note-wrap order-md-2 order-lg-1 d-flex">
                                        <div class="icon">
                                            <img src="/images/info-icon.svg" alt="Info icon">
                                        </div>
                                        <p class="info">
                                            You current subscription details.
                                        </p>
                                    </div>
                                    <div class="graphics-figure ml-auto order-md-1 order-lg-2">
                                        <img src="/images/subscriptions-visual-figure.svg" alt="Subscriptions visual figure">
                                    </div>
                                </div>
                            </div>
                            <h6>Subscriptions</h6>
                            <p>Here you will be able to handle your TradieReviews subscription.</p>
                            <div class="card subscription-card pro-plan inner-container">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div class="info-wrap">
                                        <div class="logo"><img src="/images/tradiereviews.svg" alt="Tradieflow logo"></div>
                                        @if($current_subscription)
                                            <strong>
                                                {{ $current_subscription->subscription_plan_name }}
                                                @if($upcoming_subscription)
                                                    ("{{ $upcoming_subscription->subscription_plan_name }}" starts on {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current_subscription->expiry_date_time)->format('M j, Y H:i') }})
                                                @endif
                                            </strong>
                                            @if($current_subscription->subscription_plan_code == 'trial')
                                                <p class="card-text">{{ \App\Helpers\Helper::calculateEstimateTime($current_subscription->expiry_date_time) }}</p>
                                            @endif
                                        @elseif($old_subscription)
                                            <span class="warning-text">Expired {{ $old_subscription->subscription_plan_name }} Subscription</span>
                                        @endif
                                    </div>
                                    <div class="action-wrap d-flex align-items-center">
                                        @if(
                                            !$current_subscription || ($current_subscription && $current_subscription->subscription_plan_code == 'trial') ||
                                            ($upcoming_subscription && !$upcoming_subscription->is_extendable) || ($current_subscription && (!$current_subscription->is_extendable || $current_subscription->subscription_plan_code  == 'pro'))
                                        )
                                            <button class="btn btn--sqr btn-primary" id="upgrade_plan_btn">Upgrade Your Plan</button>
                                        @endif
                                        @if($current_subscription && $current_subscription->is_extendable && $current_subscription->subscription_plan_code == 'yearly' && !$upcoming_subscription)
                                            <button class="btn btn--sqr btn-primary" id="downgrade_plan_btn">Downgrade Your Plan</button>
                                        @endif
                                        @if(($upcoming_subscription && $upcoming_subscription->is_extendable) || ($current_subscription && $current_subscription->subscription_plan_code !== 'trial' && $current_subscription->is_extendable))
                                            <button class="btn btn--sqr btn-secondary cancel-renewal" id="cancel_renewal_btn">Cancel Renewal</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @if($upcoming_subscription)
                                        @if($upcoming_subscription->is_extendable)
                                            <p>
                                                Your next payment costs <strong>{{ $upcoming_subscription->price }} {{ $upcoming_subscription->currency == 'usd' ? 'USD' : 'AUD' }}</strong>, to be charged on <strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$upcoming_subscription->expiry_date_time)->format('M j, Y') }}.</strong>
                                            </p>
                                            <p class="small-text">
                                                Your subscription "{{ $upcoming_subscription->subscription_plan_name }}" will be automatically renewed each {{ ($upcoming_subscription->subscription_plan_code == 'pro') ? 'month.' : 'year.' }}
                                            </p>
                                        @else
                                            <p class="small-text">
                                                Your subscription "{{ $upcoming_subscription->subscription_plan_name }}" will expire on {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$upcoming_subscription->expiry_date_time)->format('M j, Y H:i') }}
                                            </p>
                                        @endif
                                    @elseif($current_subscription)
                                        @if($current_subscription->is_extendable)
                                            <p>
                                                Your next payment costs <strong>{{ $current_subscription->price }} {{ $current_subscription->currency == 'usd' ? 'USD' : 'AUD' }}</strong>, to be charged on <strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current_subscription->expiry_date_time)->format('M j, Y') }}.</strong>
                                            </p>
                                            <p class="small-text">
                                                Your subscription "{{ $current_subscription->subscription_plan_name }}" will be automatically renewed each {{ ($current_subscription->subscription_plan_code == 'pro') ? 'month.' : 'year.' }}
                                            </p>
                                        @else
                                            <p class="small-text">
                                                Your subscription "{{ $current_subscription->subscription_plan_name }}" will expire on {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current_subscription->expiry_date_time)->format('M j, Y H:i') }}
                                            </p>
                                        @endif
                                    @elseif($old_subscription)
                                        <p class="small-text">
                                            Your subscription expired on <strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$old_subscription->expiry_date_time)->format('M j, Y') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            @if($tradieflow_current_subscription || $tradieflow_old_subscription)
                                <div class="card subscription-card sub free-trial inner-container">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="info-wrap">
                                            <div class="logo">
                                                <img src="/images/main-logo.svg" alt="TradieReviews logo">
                                            </div>
                                            @if($tradieflow_current_subscription)
                                                <strong>{{ $tradieflow_current_subscription->subscription_plan_name }}</strong>
                                                @if($tradieflow_current_subscription->subscription_plan_code == 'trial')
                                                    <p class="gray-text">{{ \App\Helpers\Helper::calculateEstimateTime($tradieflow_current_subscription->expiry_date_time) }}</p>
                                                @else
                                                    <p class="gray-text">Expires on: {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$tradieflow_current_subscription->expiry_date_time)->format('j F, Y') }}</p>
                                                @endif
                                            @elseif($tradieflow_old_subscription)
                                                <strong>{{ $tradieflow_old_subscription->subscription_plan_name }}</strong>
                                                <?php
                                                    $expiry_date_time = $tradieflow_old_subscription->final_expiry_date_time ? $tradieflow_old_subscription->final_expiry_date_time : $tradieflow_old_subscription->expiry_date_time;
                                                ?>
                                                <p class="gray-text">Expired on: {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$expiry_date_time)->format('j F, Y') }}</p>
                                            @endif
                                        </div>
                                        @if($tradieflow_current_subscription)
                                            @if($tradieflow_current_subscription->subscription_plan_code !== 'trial')
                                                <div class="badge-wrap">
                                                    <span class="badge green">Paid {{ $tradieflow_current_subscription->subscription_plan_code == 'pro' ? 'Monthly' : 'Yearly' }}</span>
                                                </div>
                                            @endif
                                        @elseif($tradieflow_old_subscription)
                                            @if($tradieflow_old_subscription->subscription_plan_code !== 'trial')
                                                <div class="badge-wrap">
                                                    <span class="badge green">Paid {{ $tradieflow_old_subscription->subscription_plan_code == 'pro' ? 'Monthly' : 'Yearly' }}</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="choose-plan-inner inner-container">
                                <div class="row select-plan-row" id="plans_container" style="display:none;">
                                    <div class="col-12">
                                        <h6>Upgrade Your Plan</h6>
                                    </div>
                                    <div class="col-12 col-xl-6 plan_item" data-type="pro" data-title="Monthly Starter" data-price="{{ $auth_user->currency == 'usd' ? $subscription_plans['pro']['price_usd'] : $subscription_plans['pro']['price_aud'] }}">
                                        <div class="plan-item active d-flex align-items-center">
                                            <figure>
                                                <img src="/images/star-icon-white-bg.svg" alt="Monthly figure image">
                                            </figure>
                                            <div class="plan-info">
                                                <h6>Monthly Starter</h6>
                                                <p><span class="price">{{ $auth_user->currency == 'usd' ? '$'.$subscription_plans['pro']['price_usd'] : 'AUD '.$subscription_plans['pro']['price_aud'] }}</span> / month</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3 mt-xl-0 col-xl-6 plan_item" data-type="yearly" data-title="Yearly Professional" data-price="{{ $auth_user->currency == 'usd' ? $subscription_plans['yearly']['price_usd'] : $subscription_plans['yearly']['price_aud'] }}">
                                        <div class="plan-item d-flex align-items-center">
                                            <figure>
                                                <img src="/images/prof-icon.svg" alt="Monthly figure image">
                                            </figure>
                                            <div class="plan-info">
                                                <h6>Yearly Professional</h6>
                                                <p><span class="price">{{ $auth_user->currency == 'usd' ? '$'.$subscription_plans['yearly']['price_usd'] : 'AUD '.$subscription_plans['yearly']['price_aud'] }}</span> / yearly</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row discount-section" id="discount_box_container" style="display:none;">
                                    <div class="col-12">
                                        <h6>Discount Code</h6>
                                        <p>Please enter your discount code below.</p>
                                        <div class="field-wrap d-flex align-items-center">
                                            <div class="form-group">
                                                {!! Form::text('discount_code',null,['class' => 'form-control', 'placeholder' => 'Discount Code', 'id' => 'discount_code', 'autocomplete' => 'off']) !!}
                                                {!! Form::label('discount_code','Discount Code') !!}
                                            </div>
                                            <button type="button" class="btn btn-primary btn--sqr" id="apply_discount_code">Apply</button>
                                        </div>
                                        <div class="notification-row widget-box d-flex align-items-center success display-hidden" id="discount_applied_container" style="display:none;">
                                            <div class="icon">
                                                <img class="success-avatar" src="/images/discount-success-avatar.png" alt="Avatar">
                                            </div>
                                            <h6>
                                                <span>Success!</span> You have successfully added your discount code.
                                            </h6>
                                            <button type="button" class="btn btn-close ml-auto close_discount_alert">
                                                <img src="/images/close-gray.svg" alt="Close icon">
                                            </button>
                                        </div>
                                        <div class="notification-row widget-box d-flex align-items-center error display-hidden" id="discount_error_container">
                                            <div class="icon">
                                                <img class="error-avatar" src="/images/discount-error-avatar.png" alt="Avatar">
                                            </div>
                                            <h6>
                                                <span>Oooops,</span> this discount code is not valid. Please try another one!
                                            </h6>
                                            <button type="button" class="btn btn-close ml-auto close_discount_alert">
                                                <img src="/images/close-gray.svg" alt="Close icon">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row total-payable-row" id="total_price_container" style="display:none;">
                                    <div class="col-12">
                                        <h6>Total to be payed:</h6>
                                        <ul>
                                            <li class="d-flex align-items-center">
                                                <span>Yearly Professional:</span>
                                                <div class="price" id="current_plan_price"></div>
                                            </li>
                                            <li class="d-flex align-items-center display-hidden" id="discount_container">
                                                <span>Discount Value:</span>
                                                <div class="price" id="total_discount_price"></div>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <span>GST(10%):</span>
                                                <div class="price" id="gst_price"></div>
                                            </li>
                                            <li class="d-flex align-items-center estotal">
                                                <span>ESTIMATED TOTAL:</span>
                                                <div class="price" id="total_subscription_price"></div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="card_checkout_container" class="mt-4" style="display:none;">
                                    <div class="card_checkout_loader" style="display:none;">
                                        <img src="/images/loader.gif" width="24px" class="float-left">
                                        <span class="float-left ml-1 loader-text">Processing</span>
                                    </div>
                                    <button id="card_checkout_btn" class="btn btn--sqr btn-primary">Checkout</button>
                                </div>
                                <div class="row payment-method">
                                    <div class="col-12">
                                        <div id="payment_container" style="display:none;">
                                            <h6>Payment Method</h6>
                                            <p>Here you can customize what you would prefer to pay with.</p>
                                            <div class="payment-method-form-wrap form-shown card-container">
                                                <form id="subscription_form" data-type="">
                                                    <div class="form-group">
                                                        <div id="card_number" class="form-control"></div>
                                                        <label for="card_number">Credit Card Number</label>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-lg-6">
                                                            <div id="expiry_date" class="form-control"></div>
                                                            <label for="expiry_date">Expiry Date</label>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <div id="cvv_code" class="form-control"></div>
                                                            <label for="cvv_code">CVC (Security Code)</label>
                                                        </div>
                                                    </div>
                                                    <div id="stripe_error"></div>
                                                    <div class="subscription_loader" style="display:none;">
                                                        <img src="/images/loader.gif" width="24px" class="float-left">
                                                        <span class="float-left ml-1 loader-text">Processing</span>
                                                    </div>
                                                    <button type="submit" class="btn btn--sqr btn-primary" id="default_checkout_btn">Checkout</button>
                                                </form>
                                            </div>
                                        </div>
                                        @if($has_payment_method)
                                            <div class="card-info-wrap row align-items-center" id="update_card_container">
                                                <div class="col-12 col-sm-6 col-md-auto card-figure">
                                                    <div class="card">
                                                        <img src="/images/card-bgr.jpg" alt="Card image">
                                                        <div class="card-info">
                                                            <div class="blank">&nbsp;</div>
                                                            <div class="card-number row no-gutters">
                                                                <div class="col-3">....</div>
                                                                <div class="col-3">....</div>
                                                                <div class="col-3">....</div>
                                                                <div class="col-3 last-digit">{{ $card_details['last_digits'] }}</div>
                                                            </div>
                                                            <div class="card-icon master-card">
                                                                @switch($card_details['card_type'])
                                                                    @case('mastercard')
                                                                        <img class="master-card" src="/images/ic-mastercard.png" alt="Master card">
                                                                    @break
                                                                    @case('visa')
                                                                        <img class="visa-card" src="/images/ic-visa.png" alt="Visa card">
                                                                    @break
                                                                    @case('jcb')
                                                                        <img class="jcb-card" src="/images/ic-jcb.png" alt="JCB card">
                                                                    @break
                                                                    @case('amex')
                                                                        <img class="american-express-card" src="/images/ic-american-express.png" alt="American express club card">
                                                                    @break
                                                                    @case('diners_club')
                                                                        <img class="diners-club-card" src="/images/ic-Diners-club.png" alt="Diners club card">
                                                                    @break
                                                                    @case('discover')
                                                                        <img class="discover-card" src="/images/ic-Discover.png" alt="Discover card">
                                                                    @break
                                                                    @default
                                                                        <img class="unknown-card" src="/images/ic-unknown.png" alt="Unknown card">
                                                                    @break
                                                                @endswitch
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-auto mt-3 mt-sm-0 mt-md-3 mt-lg-0 card-action-col" id="card_update_options">
                                                    <button class="btn btn-primary btn--sqr" id="change_user_card">Change Card</button>
                                                    <button class="btn btn-secondary btn--sqr" id="remove_user_card">Remove Card</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tradie-spacer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($actual_subscription)
        <div class="modal fade downgrade-plan-popup" id="cancel_subscription_modal" tabindex="-1" role="dialog" aria-labelledby="downgradePlanModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header">
                        <span class="modal-title ml-auto" id="downgradePlanModalLabel">Cancel Your Plan</span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <img src="/images/in-call-close-icon.svg" alt="Close icon gray">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="figure text-center">
                            <img src="/images/tradie-icon.svg" alt="Tradie icon">
                        </div>
                        <h2>Do you want to keep being a {{ $actual_subscription->subscription_plan_name  }}</h2>
                        <h6>You will be able to use the {{ $actual_subscription->subscription_plan_name }} Account until {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$actual_subscription->expiry_date_time)->format('F j, Y') }}.</h6>
                        <div class="btn-row d-flex align-items-center">
                            <button type="button" id="confirm_cancel_subscription" class="btn btn--sqr btn-primary cancel_subscription_actions">
                                I don’t want to be a {{ $actual_subscription->subscription_plan_name }}
                            </button>
                            <button type="button" class="btn btn--sqr btn-secondary cancel_subscription_actions" data-dismiss="modal" aria-label="Close">
                                Cancel
                            </button>
                        </div>
                        <h6 id="cancel_renewal_loader" class="w118" style="display:none;">
                            <img src="/images/loader.gif" width="24px" class="float-left">
                            <span class="float-left ml-1 loader-text">Processing</span>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($current_subscription && $current_subscription->is_extendable && $current_subscription->subscription_plan_code == 'yearly' && !$upcoming_subscription)
        <div class="modal fade downgrade-plan-popup" id="downgrade_subscription_modal" tabindex="-1" role="dialog" aria-labelledby="downgradePlanModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header">
                        <span class="modal-title ml-auto" id="downgradePlanModalLabel">Downgrade Your Plan</span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <img src="/images/in-call-close-icon.svg" alt="Close icon gray">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="figure text-center">
                            <img src="/images/tradie-icon.svg" alt="Tradie icon">
                        </div>
                        <h2>Downgrade to {{ $subscription_plans['pro']['name']  }}?</h2>
                        <h6>You will be able to use the {{ $current_subscription->subscription_plan_name }} Account until {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current_subscription->expiry_date_time)->format('F j, Y') }}.</h6>
                        <div class="btn-row d-flex align-items-center">
                            <button type="button" id="confirm_downgrade_subscription" class="btn btn--sqr btn-primary downgrade_subscription_actions">
                                I don’t want to be a {{ $current_subscription->subscription_plan_name }}
                            </button>
                            <button type="button" class="btn btn--sqr btn-secondary downgrade_subscription_actions" data-dismiss="modal" aria-label="Close">
                                Cancel
                            </button>
                        </div>
                        <h6 id="downgrade_subscription_loader" class="w118" style="display:none;">
                            <img src="/images/loader.gif" width="24px" class="float-left">
                            <span class="float-left ml-1 loader-text">Processing</span>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('view_script')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    $(document).ready(function(){
        window.stripe_form_token = null;
        window.discount_code_obj = {
            code: null,
            discount_percentage: null
        }
        window.subscription_plans = <?php echo json_encode($subscription_plans); ?>;

        /**Handle Discount Change*/
        $(document).on('click','#apply_discount_code',function(){
            var discount_code = $.trim($('#discount_code').val());
            if (discount_code.length) {
                $.post('/settings/subscriptions/discount',{ code: discount_code },function(data){
                    if (data.status) {
                        $('#discount_error_container').addClass('display-hidden');
                        $('#discount_applied_container').removeClass('display-hidden');
                        discount_code_obj.code = discount_code;
                        discount_code_obj.discount_percentage = data.percentage;
                        $('.plan-item.active').trigger('click');
                    }
                    else{
                        $('#discount_applied_container').addClass('display-hidden');
                        $('#discount_error_container').removeClass('display-hidden');
                        discount_code_obj.code = null;
                        discount_code_obj.discount_percentage = null;
                        $('.plan-item.active').trigger('click');
                    }
                },'json');
            }
            else{
                $('#discount_applied_container,#discount_error_container').addClass('display-hidden');
                discount_code_obj.code = null;
                discount_code_obj.discount_percentage = null;
                $('#discount_code').focus();
            }

            return false;
        });

        $(document).on('click','.close_discount_alert',function(){
            $(this).closest('.widget-box').addClass('display-hidden');
            return false;
        });

        $(document).on('click','#upgrade_plan_btn',function(){
            show_subscription_upgrade_box(true);
            return false;
        });

        $(document).on('click','#cancel_renewal_btn',function(){
            $('#cancel_subscription_modal').modal('show');
            return false;
        });

        $(document).on('click','#confirm_cancel_subscription',function(){
            $('.cancel_subscription_actions').removeClass('d-flex').hide();
            $('#cancel_renewal_loader').show();
            $.post('/settings/cancel/renewal',{},function(data){
                App.render_message('success','Renewal cancelled successfully');
                setTimeout(function(){
                    location.reload();
                },1000);
            },'json');
        });

        $(document).on('click','#downgrade_plan_btn',function(){
            $('#downgrade_subscription_modal').modal('show');
            return false;
        });

        $(document).on('click','#confirm_downgrade_subscription',function(){
            $('.downgrade_subscription_actions').hide();
            $('#downgrade_subscription_loader').show();

            $.post('/settings/update/subscription',{ token: null, subscription: 'pro', discount_code: null },function(data){
                $('#downgrade_subscription_modal').modal('hide');
                if (data.status) {
                    if (data.open_notifications) {
                        App.notifications.items = data.notifications;
                        App.notifications.has_more_items = data.has_more_items;
                        $('#notification_icon').trigger('click');
                        $("html, body").animate({ scrollTop: 0 }, 'slow');
                    }
                    else{
                        App.render_message('success','Subscription downgraded successfully');
                    }

                    setTimeout(function(){
                        location.reload();
                    },1500);
                }
                else{
                    $('#downgrade_subscription_loader').hide();
                    $('.downgrade_subscription_actions').show();

                    if (data.open_notifications) {
                        App.notifications.items = data.notifications;
                        App.notifications.has_more_items = data.has_more_items;
                        $('#notification_icon').trigger('click');
                        $("html, body").animate({ scrollTop: 0 }, 'slow');
                    }
                    else{
                        App.render_message('error','Something went wrong, please make sure credit card details are correct');
                    }
                }
            },'json');

            return false;
        });

        $(document).on('click','#change_user_card',function(){
            $('#update_card_container').hide();
            $('#subscription_form').attr('data-type','card');
            $('#default_checkout_btn').text('Update Card');
            $('#plans_container,#total_price_container,#card_checkout_container').hide();
            $('#payment_container').fadeIn();
            return false;
        });

        $(document).on('click','#remove_user_card',function(){
            $('#update_card_container').remove();
            $.post('/settings/remove/user/card',{},function(data){
                App.render_message('success','Card removed successfully');
                setTimeout(function(){
                    location.reload();
                },1000)
            },'json');
            return false;
        });

        $(document).on('click','.plan_item',function(){
            $('.plan-item').not($(this)).removeClass('active');
            $(this).find('.plan-item').addClass('active');
            var price_text = $(this).attr('data-price');
            var price = parseFloat($(this).attr('data-price'));
            var discount_price = 0;
                discount_price = price * discount_code_obj.discount_percentage / 100;
                price -= discount_price;
            var gst_price = price / 10;
            $('.total_subscription_price').first().hide();
            $('#current_plan_title').text($(this).attr('data-title') + ':');
            $('#current_plan_price').text('{{ $auth_user->currency == 'usd' ? '$' : 'AUD ' }}' + price_text);
            $('#total_discount_price').text((discount_price ? '- ' : '') + '{{ $auth_user->currency == 'usd' ? '$' : 'AUD ' }}' + format_number(discount_price));

            $('#gst_price').text('{{ $auth_user->currency == 'usd' ? '$' : 'AUD ' }}' + format_number(gst_price));

            if (discount_code_obj.discount_percentage) {
                $('#discount_container').removeClass('display-hidden');
            }
            else{
                $('#discount_container').addClass('display-hidden');
            }

            $('#total_subscription_price').text('{{ $auth_user->currency == 'usd' ? '$' : 'AUD ' }}' + format_number(price + gst_price));
            return false;
        });

        $(document).on('submit','#subscription_form',function(){
            var form_type = $(this).attr('data-type');
            if (form_type == 'upgrade') {
                if ($('#update_card_container').length) {
                    update_subscription(null);
                }
                else{
                    $('#default_checkout_btn').hide();
                    $('.subscription_loader').show();
                    stripe.createToken(cardNumber).then(function(result) {
                        if (result.error) {
                            $('#stripe_error').text(result.error.message);
                            $('#default_checkout_btn').show();
                            $('.subscription_loader').hide();
                        }
                        else {
                            $('#stripe_error').empty();
                            stripe_form_token = result.token.id;
                            update_subscription(stripe_form_token);
                        }
                    });
                }
            }
            else{
                $('.subscription_loader').show();
                $('#default_checkout_btn').hide();
                stripe.createToken(cardNumber).then(function(result) {
                    if (result.error) {
                        $('#stripe_error').text(result.error.message);
                    }
                    else {
                        $('#stripe_error').empty();
                        update_card(result.token.id);
                    }
                });
            }

            return false;
        });

        $(document).on('click','#card_checkout_btn',function(){
            stripe_form_token = false;
            $(this).hide();
            $('.card_checkout_loader').show();
            update_subscription(null);
            return false;
        });

        @if(!$current_subscription || ($current_subscription && $current_subscription->subscription_plan_code == 'trial'))
            show_subscription_upgrade_box();
        @endif

        var update_subscription = function(stripe_token) {
            var subscription_type = ($('#subscription_form').attr('data-type') == 'upgrade') ? $('.plan-item.active').closest('.plan_item').attr('data-type') : '';
            $('.card_update_loader').show();
            $.post('/settings/update/subscription',{ token: stripe_token, subscription: subscription_type, discount_code: discount_code_obj.code },function(data){
                if (data.status) {
                    if (data.open_notifications) {
                        App.notifications.items = data.notifications;
                        App.notifications.has_more_items = data.has_more_items;
                        $('#notification_icon').trigger('click');
                        $("html, body").animate({ scrollTop: 0 }, 'slow');
                    }
                    else{
                        App.render_message('success','Subscription upgraded successfully');
                    }

                    @if(env('APP_ENV') != 'local' && $current_subscription && $current_subscription->subscription_plan_code == 'trial')
                        dataLayer.push({'event': 'first_paid'});
                    @endif
                    setTimeout(function(){
                        location.reload();
                    },1500);
                }
                else{
                    $('.subscription_loader').hide();
                    $('.card_checkout_loader').hide();
                    $('#card_checkout_btn').show();
                    $('#default_checkout_btn').show();
                    $('.subscription_loader').hide();

                    if (data.open_notifications) {
                        App.notifications.items = data.notifications;
                        App.notifications.has_more_items = data.has_more_items;
                        $('#notification_icon').trigger('click');
                        $("html, body").animate({ scrollTop: 0 }, 'slow');
                    }
                    else{
                        App.render_message('error','Something went wrong, please make sure credit card details are correct');
                    }
                }
            },'json');
        }

        var update_card = function(stripe_token) {
            $('.subscription_loader').show();
            $.post('/settings/update/card',{ token: stripe_token },function(data){
                $('.card_update_loader').hide();
                if (data.status) {
                    App.render_message('success','Card updated successfully');
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }
                else{
                    $('.subscription_loader').hide();
                    $('#default_checkout_btn').show();
                    App.render_message('error','Something went wrong, pleae make sure card credentials are correct');
                }
            },'json');
        }

        var stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY') }}');
        var elementStyles = {
            base: {
                iconColor: '#20283e',
                color: '#000000',
                fontWeight: 400,
                fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
                fontSize: '16px',
                fontSmoothing: 'antialiased',
                ':-webkit-autofill': {
                    color: '#fce883',
                },
                '::placeholder': {
                    opacity: 0,
                    color: '#86969E',
                },
                '.CardBrandIcon-container': {
                    left: 'auto',
                    right: 20
                }
            },
            invalid: {
                iconColor: '#4cb5f5',
                color: '#4cb5f5',
            },
        };

        var elements = stripe.elements({
            fonts: [
                {
                    cssSrc: 'https://fonts.googleapis.com/css?family=Poppins',
                },
            ]
        });

        var elementClasses = {
            focus: 'focused',
            empty: 'empty',
            invalid: 'invalid',
        };

        var cardNumber = elements.create('cardNumber', {
            showIcon: false,
            style: elementStyles,
            classes: elementClasses,
            placeholder: '',
        });

        cardNumber.mount('#card_number');
        cardNumber.on('change', function(event) {
            var displayError = document.getElementById('card_errors');
            if (event.error) {
                $('.error .message').text(event.error.message);
            } else {
                $('.error .message').text('');
            }
        });

        var cardExpiry = elements.create('cardExpiry', {
            style: elementStyles,
            classes: elementClasses,
            placeholder: ' ',
        });

        cardExpiry.mount('#expiry_date');

        var cardCvc = elements.create('cardCvc', {
            style: elementStyles,
            classes: elementClasses,
            placeholder: ' ',
        });
        cardCvc.mount('#cvv_code');
        registerElements([cardNumber, cardExpiry, cardCvc], 'card-container','default');

        function registerElements(elements, exampleName) {
            var formClass = '.' + exampleName;
            var example = document.querySelector(formClass);

            var form = example.querySelector('form');
            var error = document.getElementById('stripe_error');

            function enableInputs() {
                Array.prototype.forEach.call(
                    form.querySelectorAll(
                        "input[type='text'], input[type='email'], input[type='tel']"
                    ),
                    function(input) {
                        input.removeAttribute('disabled');
                    }
                );
            }

            function disableInputs() {
                Array.prototype.forEach.call(
                    form.querySelectorAll(
                        "input[type='text'], input[type='email'], input[type='tel']"
                    ),
                    function(input) {
                        input.setAttribute('disabled', 'true');
                    }
                );
            }

            function triggerBrowserValidation() {
                var submit = document.createElement('input');
                submit.type = 'submit';
                submit.style.display = 'none';
                form.appendChild(submit);
                submit.click();
                submit.remove();
            }

            // Listen for errors from each Element, and show error messages in the UI.
            var savedErrors = {};
            elements.forEach(function(element, idx) {
                element.on('change', function(event) {
                    if (event.error) {
                        error.classList.add('visible');
                        savedErrors[idx] = event.error.message;
                        error.innerText = event.error.message;
                    } else {
                        savedErrors[idx] = null;
                        error.innerText = '';
                        var nextError = Object.keys(savedErrors)
                            .sort()
                            .reduce(function(maybeFoundError, key) {
                                return maybeFoundError || savedErrors[key];
                            }, null);

                        if (nextError) {
                            error.innerText = nextError;
                        } else {
                            error.classList.remove('visible');
                        }
                    }
                });
            });
        }
    });

    var show_subscription_upgrade_box = function(scroll){
        @if($upcoming_subscription)
            @if($upcoming_subscription->subscription_plan_code == 'yearly' && $upcoming_subscription->is_extendable)
                $('.plan_item[data-type="pro"]').remove();
            @endif
        @else
            @if($current_subscription && $current_subscription->subscription_plan_code == 'pro' && $current_subscription->is_extendable)
                $('.plan_item[data-type="pro"]').remove();
                $('#plans_container').hide();
            @endif
        @endif

        @if(!$upcoming_subscription && $current_subscription && $current_subscription->subscription_plan_code == 'pro' && $current_subscription->is_extendable)
            $('#plans_container').hide();
            $('#card_checkout_btn').text('Upgrade & Checkout');
            $('#total_to_be_paid_text').addClass('gray-text').text('Total to be payed for the yearly plan:');
        @else
            $('#plans_container').show();
        @endif

        $('.plan_item').first().trigger('click');
        $('#total_price_container,#discount_box_container').show();
        @if($has_payment_method)
            $('#payment_container').hide();
            $('#card_checkout_container').show();
        @else
            $('#payment_container').show();
            $('#card_checkout_container').hide();
        @endif

        $('#subscription_form').attr('data-type','upgrade');
        $('#default_checkout_btn').text('Checkout');
        if ($('#update_card_container').length) {
            $('#update_card_container').show();
        }

        if (scroll) {
            $('body,html').animate({ scrollTop: $('#discount_box_container').offset().top - 200 }, { duration: 900 });
        }
    }

    var format_number = function(price){
        return price.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
</script>
@endsection
