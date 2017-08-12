@extends('front.base')

@section('title')
    Personalised Gift Lists
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogImage' => url('/images/assets/fb_image.png'),
        'ogTitle' => 'Get a Custom Gift List',
        'ogDescription' => 'Get a custom gift list'
    ])
@endsection

@section('content')
    @include('front.partials.standardheader')
    <section class="signup-page-main-section">
        <div class="lead-text">
            <h1>Just a custom list. Just in time.</h1>
            <p>We'll find the best gifts based on his interests and send them to you 20 days before you need it.</p>
            <p>If you don't have 20 days, we'll act fast.</p>
            <p>We just need a budget, a date, and a few things he likes to get us started.</p>
            <p>It's totally free and we promise no ads or spam. Scouts honor, pinkie swear.</p>
        </div>
        <form class="signup-form" action="/recommendations/request" method="POST">
            {!! csrf_field() !!}
            <div class="form-section">
                <div class="form-text-box">
                    <h3>About You</h3>
                    <p>What should we call you, where should we send the list and how much are you willing to spend?</p>
                </div>
                <div class="form-input-box">
                    <div class="form-group{{ $errors->has('sender') ? ' has-error' : '' }}">
                        <label for="sender">Your Name</label>
                        @if($errors->has('sender'))
                        <span class="error-message">{{ $errors->first('sender') }}</span>
                        @endif
                        <input type="text" name="sender" value="{{ old('sender') }}" class="form-control">
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Your Email</label>
                        @if($errors->has('email'))
                        <span class="error-message">{{ $errors->first('email') }}</span>
                        @endif
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Your Budget</label>
                        <div class="gg-radio-option">
                            <input type="radio" name="budget" id="low_budget" value="low">
                            <label for="low_budget">
                                $50
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="budget" id="mid_budget" value="mid">
                            <label for="mid_budget">
                                $100
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="budget" id="big_budget" value="big">
                            <label for="big_budget">
                                $500
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="budget" id="huge_budget" value="huge">
                            <label for="huge_budget">
                                $1500
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="budget" id="limitless_budget" value="limitless">
                            <label for="limitless_budget">
                                No limit
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-section">
                <div class="form-text-box">
                    <h3>About Him</h3>
                    <p>Who is the gift for, when will you give him the gift and what age group does he fit into?</p>
                </div>
                <div class="form-input-box">
                    <div class="form-group{{ $errors->has('recipient') ? ' has-error' : '' }}">
                        <label for="recipient">His Name</label>
                        @if($errors->has('recipient'))
                        <span class="error-message">{{ $errors->first('recipient') }}</span>
                        @endif
                        <input type="text" name="recipient" value="{{ old('recipient') }}" class="form-control">
                    </div>
                    <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                        <label for="birthday">His big day</label><br>
                        <span class="error-message"></span>
                        <div class="style-select month">
                            <select name="birthday_month" id="month">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="style-select day">
                            <select name="birthday_day" id="day">
                                <option value="01">1</option>
                                <option value="02">2</option>
                                <option value="03">3</option>
                                <option value="04">4</option>
                                <option value="05">5</option>
                                <option value="06">6</option>
                                <option value="07">7</option>
                                <option value="08">8</option>
                                <option value="09">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('age_group') ? ' has-error' : '' }}">
                        <label>His Age group</label>
                        <div class="gg-radio-option">
                            <input type="radio" name="age_group" id="young" value="young">
                            <label for="young">
                                18 - 24
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="age_group" id="mid_age" value="mid">
                            <label for="mid_age">
                                25 - 39
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="age_group" id="mature" value="mature">
                            <label for="mature">
                                40 - 59
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="age_group" id="old_age" value="old">
                            <label for="old_age">
                                60+
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-section">
                <div class="form-text-box">
                    <h3>What's his thing?</h3>
                    <p>Tell us what makes him tick. We have given a few options to get you thinking, but don't shy to add some more. The more you give us, the more we can give you. We don't  judge.</p>
                </div>
                <div class="form-input-box">
                    <interests-chooser :interest-list='{{ json_encode($interests->pluck('tag')->all()) }}'></interests-chooser>
                </div>
            </div>
            <div class="form-section">
                <div class="form-text-box">
                    <h3>Let's do this</h3>
                    <p>We'll get on to that list ASAP! In the meantime, don't be shy to add a few more guys and get your gift shopping for the year done.</p>
                </div>
                <div class="form-input-box submit-box">
                    <button class="form-cta-button" type="submit">Make my list</button>
                </div>
            </div>
        </form>
    </section>
@endsection