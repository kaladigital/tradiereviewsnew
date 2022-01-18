<header class="main-header" id="main_header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="/" class="navbar-brand main-logo">
                <img src="/landing_media//images/tradiereviews-logo.svg" alt="TradieReviews logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ml-xl-auto md-md-affffff" id="navbarSupportedContent">
                <div class="nav-inner d-flex align-items-center">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#faqs">FAQs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#pricing">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#integrations">Integrations</a>
                        </li>
                    </ul>
                    <div class="btn-wrap d-flex align-items-center ml-lg-auto">
                        @if($auth_user)
                            <a href="/auth/logout" class="btn btn-login d-flex align-items-center"><img src="/landing_media//images/login-icon.svg" alt="Login icon" class="icon">
                                <span>Logout</span>
                            </a>
                            <a href="/reviews" class="btn btn-primary btn--sqr">My Account</a>
                        @else
                            <a href="/auth/login" class="btn btn-login d-flex align-items-center"><img src="/landing_media//images/login-icon.svg" alt="Login icon" class="icon">
                                <span>Login</span>
                            </a>
                            <a href="/free-trial" class="btn btn-primary btn--sqr animate-pulse">Start Free Trial</a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
