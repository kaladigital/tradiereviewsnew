@extends('layouts.master')
@section('view_css')
<link rel="stylesheet" href="/css/font-awesome.min.css">
<link rel="stylesheet" href="/js/jquery-bar-rating/themes/fontawesome-stars.css">
@endsection
@section('content')
    @include('dashboard.left_sidebar_full_menu',['active_page' => 'reviews'])
    <div class="col-md-auto col-12 content-wrap reviews-list-view">
        <div class="content-inner">
            <div class="heading-row d-flex">
                <h2>Customer Feedback</h2>
            </div>
            <div class="widget-box">
                <div class="row">
                    <div class="col-12 col-md-auto intro-col">
                        <div class="title-wrap">
                            <h2>{{ $auth_user->name }}</h2>
                            <p class="d-flex justify-content-center align-items-center mb-0">
                                <img src="/images/location-icon-blue.svg" alt="Location icon" class="icon">
                                <span>{{ $auth_user->city ? $auth_user->city.', ' : '' }}{{ $auth_user->Country ? $auth_user->Country->name : '' }}</span>
                            </p>
                        </div>
                        <div class="review-hint">
                            <h3>Customer Reviews</h3>
                            <div class="rating-points d-flex align-items-center">
                                <select class="rating star-rating" data-current-rating="0" autocomplete="off">
                                    <option hidden="" value="0">0</option>
                                    <option value="1" {{ $avg_reviews_received_star == '1' ? 'selected="selected"' : '' }}>1</option>
                                    <option value="2" {{ $avg_reviews_received_star == '2' ? 'selected="selected"' : '' }}>2</option>
                                    <option value="3" {{ $avg_reviews_received_star == '3' ? 'selected="selected"' : '' }}>3</option>
                                    <option value="4" {{ $avg_reviews_received_star == '4' ? 'selected="selected"' : '' }}>4</option>
                                    <option value="5" {{ $avg_reviews_received_star == '5' ? 'selected="selected"' : '' }}>5</option>
                                </select>
                                <span class="points">{{ $avg_reviews_received }} out of 5</span>
                            </div>
                            <p>{{ $total_reviews_received }} customer ratings</p>
                            <div class="review-rating-slide-wrap">
                                <div class="slide-item d-flex align-items-center">
                                    <span>5 star</span>
                                    <div class="progress-slide" data-rating-progress="{{ $five_start_percentage_rounded }}">
                                        <span class="progress-slide--thumb"></span>
                                    </div>
                                    <span class="rating-percent">{{ sprintf('%.2f',$five_start_review_percentage) }}%</span>
                                </div>
                                <div class="slide-item d-flex align-items-center">
                                    <span>4 star</span>
                                    <div class="progress-slide" data-rating-progress="{{ $four_start_percentage_rounded }}">
                                        <span class="progress-slide--thumb"></span>
                                    </div>
                                    <span class="rating-percent">{{ sprintf('%.2f',$four_start_review_percentage) }}%</span>
                                </div>
                                <div class="slide-item d-flex align-items-center">
                                    <span>3 star</span>
                                    <div class="progress-slide" data-rating-progress="{{ $three_start_percentage_rounded }}">
                                        <span class="progress-slide--thumb"></span>
                                    </div>
                                    <span class="rating-percent">{{ sprintf('%.2f',$three_start_review_percentage) }}%</span>
                                </div>
                                <div class="slide-item d-flex align-items-center">
                                    <span>2 star</span>
                                    <div class="progress-slide" data-rating-progress="{{ $two_start_percentage_rounded }}">
                                        <span class="progress-slide--thumb"></span>
                                    </div>
                                    <span class="rating-percent">{{ sprintf('%.2f',$two_start_review_percentage) }}%</span>
                                </div>
                                <div class="slide-item d-flex align-items-center">
                                    <span>1 star</span>
                                    <div class="progress-slide" data-rating-progress="{{ $one_start_percentage_rounded }}">
                                        <span class="progress-slide--thumb"></span>
                                    </div>
                                    <span class="rating-percent">{{ sprintf('%.2f',$one_start_review_percentage) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-auto des-col mt-4 mt-lg-0">
                        <div class="review-list-contents tab-pane fade show active" id="reviews_list_container">
                            <div class="rating-filter-row row">
                                <div class="col-12 col-lg-6 filter-rating-options">
                                    <h6>Reviews ({{ $total_reviews_received }})</h6>
                                    <div class="reviews-filter">
                                        <div class="reviews-filter--item slide-item d-flex align-items-center" data-rating-progress="{{ $five_start_percentage_rounded }}">
                                            <div class="reviews-filter--status">
                                                <div class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('five_star_filter','1',true,['class' => 'custom-control-input filter_item', 'id' => 'five_star_filter', 'autocomplete' => 'off']) !!}
                                                    {!! Form::label('five_star_filter','5 (Excellent)',['class' => 'custom-control-label']) !!}
                                                </div>
                                            </div>
                                            <div class="progress-slide" data-rating-progress="{{ $five_start_percentage_rounded }}">
                                                <span class="progress-slide--thumb"></span>
                                            </div>
                                            <span>{{ intval($totals['2']->num) }}</span>
                                        </div>
                                        <div class="reviews-filter--item slide-item d-flex align-items-center" data-rating-progress="{{ $four_start_percentage_rounded }}">
                                            <div class="reviews-filter--status">
                                                <div class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('four_star_filter','1',true,['class' => 'custom-control-input filter_item', 'id' => 'four_star_filter', 'autocomplete' => 'off']) !!}
                                                    {!! Form::label('four_star_filter','4 (Very good)',['class' => 'custom-control-label']) !!}
                                                </div>
                                            </div>
                                            <div class="progress-slide" data-rating-progress="{{ $four_start_percentage_rounded }}">
                                                <span class="progress-slide--thumb"></span>
                                            </div>
                                            <span>{{ intval($totals['3']->num) }}</span>
                                        </div>
                                        <div class="reviews-filter--item slide-item d-flex align-items-center" data-rating-progress="{{ $three_start_percentage_rounded }}">
                                            <div class="reviews-filter--status">
                                                <div class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('three_star_filter','1',true,['class' => 'custom-control-input filter_item', 'id' => 'three_star_filter', 'autocomplete' => 'off']) !!}
                                                    {!! Form::label('three_star_filter','3 (Average)',['class' => 'custom-control-label']) !!}
                                                </div>
                                            </div>
                                            <div class="progress-slide" data-rating-progress="{{ $three_start_percentage_rounded }}">
                                                <span class="progress-slide--thumb"></span>
                                            </div>
                                            <span>{{ intval($totals['4']->num) }}</span>
                                        </div>
                                        <div class="reviews-filter--item slide-item d-flex align-items-center" data-rating-progress="{{ $two_start_percentage_rounded }}">
                                            <div class="reviews-filter--status">
                                                <div class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('two_star_filter','1',true,['class' => 'custom-control-input filter_item', 'id' => 'two_star_filter', 'autocomplete' => 'off']) !!}
                                                    {!! Form::label('two_star_filter','2 (Poor)',['class' => 'custom-control-label']) !!}
                                                </div>
                                            </div>
                                            <div class="progress-slide" data-rating-progress="{{ $two_start_percentage_rounded }}">
                                                <span class="progress-slide--thumb"></span>
                                            </div>
                                            <span>{{ intval($totals['5']->num) }}</span>
                                        </div>
                                        <div class="reviews-filter--item slide-item d-flex align-items-center" data-rating-progress="{{ $one_start_percentage_rounded }}">
                                            <div class="reviews-filter--status">
                                                <div class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('one_star_filter','1',true,['class' => 'custom-control-input filter_item', 'id' => 'one_star_filter', 'autocomplete' => 'off']) !!}
                                                    {!! Form::label('one_star_filter','1 (Terrible)',['class' => 'custom-control-label']) !!}
                                                </div>
                                            </div>
                                            <div class="progress-slide" data-rating-progress="{{ $one_start_percentage_rounded }}">
                                                <span class="progress-slide--thumb"></span>
                                            </div>
                                            <span>{{ intval($totals['6']->num) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 filter-radio-options">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <h6>Review Type</h6>
                                            <div class="custom-control custom-radio">
                                                {!! Form::radio('written_review_filter','all',true,['class' => 'custom-control-input filter_item', 'id' => 'written_review_filter_all', 'autocomplete' => 'off']) !!}
                                                {!! Form::label('written_review_filter_all','Show All',['class' => 'custom-control-label']) !!}
                                            </div>
                                            <div class="custom-control custom-radio">
                                                {!! Form::radio('written_review_filter','reviews',false,['class' => 'custom-control-input filter_item', 'id' => 'written_review_filter_reviews', 'autocomplete' => 'off']) !!}
                                                {!! Form::label('written_review_filter_reviews','Show Written Reviews only',['class' => 'custom-control-label']) !!}
                                            </div>
                                            <div class="custom-control custom-radio">
                                                {!! Form::radio('written_review_filter','stars_only',false,['class' => 'custom-control-input filter_item', 'id' => 'written_review_filter_stars', 'autocomplete' => 'off']) !!}
                                                {!! Form::label('written_review_filter_stars','Show Stars-only',['class' => 'custom-control-label']) !!}
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 mt-4 mt-lg-0">
                                            <h6>Sort by</h6>
                                            <div class="custom-control custom-radio">
                                                {!! Form::radio('sort_by','latest',true,['class' => 'custom-control-input filter_item', 'id' => 'sort_by_latest', 'autocomplete' => 'off']) !!}
                                                {!! Form::label('sort_by_latest','Latest first',['class' => 'custom-control-label']) !!}
                                            </div>
                                            <div class="custom-control custom-radio">
                                                {!! Form::radio('sort_by','oldest',false,['class' => 'custom-control-input filter_item', 'id' => 'sort_by_oldest', 'autocomplete' => 'off']) !!}
                                                {!! Form::label('sort_by_oldest','Oldest first',['class' => 'custom-control-label']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-reviews">
                                <div class="rating-reviews--wrap">
                                    @foreach($reviews as $item)
                                        <div class="rating-reviews--item">
                                            <div class="title-row d-flex align-items-center">
                                                {!! Form::select('star_rating',$rate_points,$item->rate,['class' => 'star-rating', 'style' => 'display:none;', 'autocomplete' => 'off']) !!}
                                                <span class="name">{{ $item->reviewer_name }}</span>
                                                <span class="time">{{ $item->created_at->format('j F, Y') }}</span>
                                                <div class="action-trigers ml-auto">
                                                    <button class="btn btn-call make_call {{ $item->reviewer_phone ? '' : 'not-added' }}" data-name="{{ $item->reviewer_name }}" data-phone="{{ $item->reviewer_phone }}" data-phone-format="{{ $item->reviewer_phone_format }}" data-client="{{ $item->client_id }}">
                                                        <img class="icon-green" src="/images/calendar-event-call.svg" alt="Call icon">
                                                        <img class="icon-gray" src="/images/calendar-event-call-gray.svg" alt="Call icon">
                                                    </button>
                                                    <button class="btn btn-message">
                                                        <img class="icon-green" src="/images/calendar-event-email.svg" alt="Email icon">
                                                        <img class="icon-gray" src="/images/calendar-event-email-gray.svg" alt="Email icon">
                                                    </button>
                                                    <button class="btn btn-message">
                                                        <img class="icon-green" src="/images/calendar-event-text-message.svg" alt="Message icon">
                                                        <img class="icon-gray" src="/images/calendar-event-text-message-gray.svg" alt="Message icon">
                                                    </button>
                                                </div>
                                            </div>
                                            <p>{{ $item->description }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="pagination-row d-flex">
                                <div class="page-count">Show 1 of {{ $reviews->lastPage() }} pages</div>
                                <div class="nav col-auto ml-auto pagination">
                                    <div id="pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('view_script')
<script type="text/javascript" src="/js/jquery-bar-rating/jquery.barrating.min.js"></script>
<script type="text/javascript" src="/js/jquery.twbsPagination.min.js"></script>
<script type="text/javascript" src="/js/tagsinput/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        window.default_pagination_options = {
            totalPages: '{{ $reviews->lastPage() }}',
            initiateStartPageClick: false,
            visiblePages: 4,
            hideOnlyOnePage: true,
            lastClass: 'display-hidden',
            firstClass: 'display-hidden',
            paginationClass: 'pagination',
            startPage: 1,
            onPageClick: function (event, page) {
                $('body,html').animate({
                    scrollTop: $('.rating-reviews--wrap').offset().top,
                }, {
                    duration: 900
                });
                load_reviews(page);
            }
        }

        $('#pagination').twbsPagination(default_pagination_options);
        handle_star_ratings();

        $('#review_emails').tagsinput({
            allowDuplicates: false,
            tagClass: 'added-email-item',
            trimValue: true,
            maxTags: 100
        });

        $(document).on('change','.filter_item',function(){
            load_reviews(1);
            return false;
        });

        $(document).on('click','.make_call',function(){
            @if($user_twilio_phone)
                var phone = $(this).attr('data-phone');
                if (phone.length) {
                    App.call.process_outgoing_call(App.call.twilio_outgoing_obj,
                        phone,
                        '{{ $user_twilio_phone->phone }}',
                        'client',
                        $(this).attr('data-name'),
                        $(this).attr('data-client'),
                        $(this).attr('data-phone-format')
                    );
                }
                else{
                    App.render_message('info','No phone number found to make a call')
                }
            @else
                alert('Please purchase a new subscription to make calls')
            @endif
            return false;
        });
    });

    var load_reviews = function(page){
        $.post('/reviews/filter', {
            five_star_filter: $('#five_star_filter').prop('checked') ? '1' : '0',
            four_star_filter: $('#four_star_filter').prop('checked') ? '1' : '0',
            three_star_filter: $('#three_star_filter').prop('checked') ? '1' : '0',
            two_star_filter: $('#two_star_filter').prop('checked') ? '1' : '0',
            one_star_filter: $('#one_star_filter').prop('checked') ? '1' : '0',
            written_reviews: $('#written_review_filter_reviews').prop('checked') ? '1' : '0',
            stars_only_reviews: $('#written_review_filter_stars').prop('checked') ? '1' : '0',
            sort_by_latest: $('#sort_by_latest').prop('checked') ? '1' : '0',
            sort_by_oldest: $('#sort_by_oldest').prop('checked') ? '1' : '0',
            page: page
        }, function(data) {
            if (data.status) {
                $('.rating-reviews--wrap').html(_.template($('#review_item_template').html())({
                    items: data.items
                }));

                handle_star_ratings();
                if (data.total_pages) {
                    $('#pagination').twbsPagination('destroy');
                    $('#pagination').twbsPagination($.extend({}, default_pagination_options, {
                        startPage: page,
                        totalPages: data.total_pages
                    }));
                }
            }
        },'json');
    }

    var handle_star_ratings = function(){
        $('.star-rating').barrating({
            theme: 'css-stars',
            showSelectedRating: false,
            readonly: true,
            allowEmpty: true,
            emptyValue: 0,
        });
    }
</script>
<script type="text/template" id="review_item_template">
    <% for (let i in items) { %>
    <div class="rating-reviews--item">
        <div class="title-row d-flex align-items-center">
            <select class="star-rating" style="display:none;" autocomplete="off">
                @foreach($rate_points as $item)
                    <option value="{{ $item }}" <%= items[i].rate == '{{ $item }}' ? 'selected="selected"' : '' %>>{{ $item }}</option>
                @endforeach
            </select>
            <span class="name"><%= items[i].reviewer_name %></span>
            <span class="time"><%= items[i].created_at %></span>
            <div class="action-trigers ml-auto">
                <button class="btn btn-call make_call <%= items[i].reviewer_phone ? '' : 'not-added' %>" data-name="<%= items[i].reviewer_name %>" data-phone="<%= items[i].reviewer_phone %>" data-phone-format="<%= items[i].reviewer_phone_format %>" data-client="<%= items[i].client_id %>">
                    <img class="icon-green" src="/images/calendar-event-call.svg" alt="Call icon">
                    <img class="icon-gray" src="/images/calendar-event-call-gray.svg" alt="Call icon">
                </button>
                <button class="btn btn-message">
                    <img class="icon-green" src="/images/calendar-event-email.svg" alt="Email icon">
                    <img class="icon-gray" src="/images/calendar-event-email-gray.svg" alt="Email icon">
                </button>
                <button class="btn btn-message">
                    <img class="icon-green" src="/images/calendar-event-text-message.svg" alt="Message icon">
                    <img class="icon-gray" src="/images/calendar-event-text-message-gray.svg" alt="Message icon">
                </button>
            </div>
        </div>
        <p><%= items[i].description %></p>
    </div>
    <% } %>
</script>
@endsection
