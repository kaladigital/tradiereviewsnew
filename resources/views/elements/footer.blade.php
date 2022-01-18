<footer class="main-footer-section" style="{{ $hide_footer ? 'display:none;' : '' }}">
    <div class="container">
        <div class="row newsletter-row">
            <div class="col-12 col-md-6">
                <h2>Signup Newsletter:</h2>
            </div>
            <div class="col-12 col-md-6">
                <form id="newsletter_form" autocomplete="off">
                    <div class="form-group">
                        <input type="email" class="form-control" id="newsletter_email" placeholder="Your Email" required="required">
                        <label for="newsletter_email">Your Email</label>
                        <button class="btn" type="submit">Join</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="copyright-area">
            <p>&copy; {{ Carbon\Carbon::now()->format('Y') }} TradieReviews Inc</p>
        </div>
    </div>
</footer>
@section('view_script_ext')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('submit','#newsletter_form',function(){
            var email = $('#newsletter_email').val();
            $.post('/newsletter/subscribe',{ email: email },function(data){
                if (data.status) {
                    new Noty({
                        type: 'success',
                        theme: 'metroui',
                        layout: 'topRight',
                        text: 'Successfully subscribed to newsletter',
                        timeout: 2500,
                        progressBar: false
                    }).show();
                    if (data.subscribed) {
                        @if(env('APP_ENV') != 'local')
                            dataLayer.push({'event': 'newsletter_subscribe'});
                        @endif
                    }
                    setTimeout(function(){
                        location.href = '/newsletter/subscribed';
                    },1000);
                }
                else{
                    new Noty({
                        type: 'info',
                        theme: 'metroui',
                        layout: 'topRight',
                        text: data.error,
                        timeout: 2500,
                        progressBar: false
                    }).show();
                }
            });
            return false;
        });
    });
</script>
@endsection
