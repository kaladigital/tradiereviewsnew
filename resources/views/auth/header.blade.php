<header class="header">
    <div class="container d-flex align-items-center">
        <a href="/" class="main-logo">
            <img src="/images/tradiereviews.svg" alt="">
        </a>
        @if(isset($auth_user) && $auth_user)
            <a href="/settings/account" class="ml-auto btn btn-primary btn--sqr">My Account</a>
        @else
            <a href="/auth/login" class="login-link ml-auto d-flex align-items-center">
                <img src="/images/user-icon.svg" alt="User icon green circle" class="icon">
                <span>Login</span>
            </a>
            <a href="/free-trial" class="btn btn-primary btn--sqr">Start Free Trial</a>
        @endif
    </div>
</header>
