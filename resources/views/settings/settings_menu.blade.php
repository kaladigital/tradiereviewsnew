<div class="col-md-auto col-12 content-nav-col {{ $user_onboarding->status == 'completed' ? 'setup-completed' : '' }}">
    @if($user_onboarding->status == 'pending')
        <div class="setup-progress-widget d-flex align-items-center">
            <div class="circle-progress" data-progress="{{ $auth_user->onboarding_state }}">
                <svg>
                    <circle cx="22.5" cy="22.5" r="22.5" fill="none" stroke="#eff2f9" stroke-width="2">
                    </circle>
                    <circle cx="22.5" cy="22.5" r="22.5" fill="none" stroke="#3962FA" stroke-width="2">
                    </circle>
                </svg>
                <h6>{{ $auth_user->onboarding_state }}<span>%</span></h6>
            </div>
            <div class="greetings">
                <h6>Get Started!</h6>
                <span>{{ 100 - $auth_user->onboarding_state }}% remaining</span>
            </div>
        </div>
    @endif
    <ul class="content-nav">
        <li class="nav-item {{ $user_onboarding->account ? 'completed' : '' }} {{ $active_page == 'account' ? 'active' : '' }}">
            <div class="nav-icon">
                <img src="/images/profile-icon-gray.svg" alt="Profile icon" class="gray-icon">
                <img src="/images/profile-icon-active.svg" alt="Profile icon" class="green-icon">
            </div>
            <a class="nav-link" href="/settings/account">
                <span class="nav-text">Account</span>
            </a>
        </li>
        <li class="nav-item {{ $user_onboarding->reviews ? 'completed' : '' }} {{ $active_page == 'reviews' ? 'active' : '' }}">
            <div class="nav-icon">
                <img src="/images/review-star-icon-gray.svg" alt="Star icon" class="gray-icon">
                <img src="/images/review-star-icon-active.svg" alt="Star icon" class="green-icon">
            </div>
            <a class="nav-link" href="/settings/reviews">
                <span class="nav-text">Reviews</span>
            </a>
        </li>
        <li class="nav-item {{ $user_onboarding->subscriptions ? 'completed' : '' }} {{ $active_page == 'subscriptions' ? 'active' : '' }}">
            <div class="nav-icon">
                <img src="/images/subscription-icon-gray.svg" alt="Subscription icon" class="gray-icon">
                <img src="/images/subscription-icon-active.svg" alt="Subscription icon" class="green-icon">
            </div>
            <a class="nav-link" href="/settings/subscriptions">
                <span class="nav-text">Subscriptions</span>
            </a>
        </li>
        @if($user_onboarding->status == 'completed')
            <li class="nav-item {{ $active_page == 'security' ? 'active' : '' }}">
                <div class="nav-icon">
                    <img src="/images/security-key-icon-gray.svg" alt="Security key icon" class="gray-icon">
                    <img src="/images/security-key-icon-active.svg" alt="Security key icon" class="green-icon">
                </div>
                <a class="nav-link" href="/settings/security">
                    <span class="nav-text">Security</span>
                </a>
            </li>
        @endif
    </ul>
    @if($auth_user->tradiereview_subscription_expire_message)
        <div class="update-widget text-center">
            <h6>{{ $auth_user->tradiereview_subscription_expire_message }}</h6>
            <a href="/settings/subscriptions" class="btn update">Upgrade</a>
        </div>
    @endif
</div>
