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
        <h1>Need help finding the perfect gift for him?</h1>
        <p>Worry not, we have your back.</p>
        <form class="signup-form" action="">
            <div class="form-section">
                <div class="form-text-box">
                    <h3>All About You</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores consectetur consequatur eius minima numquam quam.</p>
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
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Your Budget</label>
                        <div class="gg-radio-option">
                            <input type="radio" name="budget" id="low_budget" value="low">
                            <label for="low_budget">
                                Low (less than $50)
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="budget" id="mid_budget" value="mid">
                            <label for="mid_budget">
                                Fair (less than $100)
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="budget" id="big_budget" value="big">
                            <label for="big_budget">
                                Big (up to $500)
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="budget" id="huge_budget" value="huge">
                            <label for="huge_budget">
                                Huge (up to $1500)
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="budget" id="limitless_budget" value="limitless">
                            <label for="limitless_budget">
                                Limitless
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-section">
                <div class="form-text-box">
                    <h3>Who is the lucky lad?</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium consequatur doloribus ducimus ea earum impedit incidunt ipsum laborum laudantium libero, necessitatibus, obcaecati quae quidem temporibus tenetur ut veniam voluptate voluptatibus!</p>
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
                        <label for="birthday">His Birthday</label><br>
                        <span class="error-message"></span>
                        <div class="style-select month">
                            <select name="month" id="month">
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
                            <select name="day" id="day">
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
                                25 - 40
                            </label>
                        </div>
                        <div class="gg-radio-option">
                            <input type="radio" name="age_group" id="mature" value="mature">
                            <label for="mature">
                                41 - 60
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
                    <h3>What does he like?</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium asperiores delectus eligendi expedita laborum nobis nostrum omnis quo quos tenetur! Ad eos fugit laboriosam repudiandae sed voluptates! Aliquid, debitis, modi?</p>
                </div>
                <div class="form-input-box">
                    <div class="selected-interests">
                        <label>His interests are: </label><br>
                        <span class="chosen-interest">Snow angels</span>
                        <span class="chosen-interest">Figure skating</span>
                        <span class="chosen-interest">Dance</span>
                    </div>
                    <div class="interest-options">
                        <small class="instruction-line">Click on an interest below to add it to his list.</small>
                        <span class="potential-interest">Swimming</span>
                        <span class="potential-interest">Jumping</span>
                        <span class="potential-interest">Yoga</span>
                        <span class="potential-interest">Badminton</span>
                        <span class="potential-interest">Naked Wrestling</span>
                        <span class="potential-interest">Sharks</span>
                        <span class="potential-interest">Coffee and Tea</span>
                        <span class="potential-interest">Drinking</span>
                    </div>
                    <div class="add-interests">
                        <small class="instruction-line">Or add any other interest of his below</small>
                        <div class="buttoned-input">
                            <input type="text" name="add_interest">
                            <button>Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-section">
                <div class="form-text-box">
                    <h3>Let's do this</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium architecto, aut autem consequuntur.</p>
                </div>
                <div class="form-input-box submit-box">
                    <button class="form-cta-button" type="submit">Hit it</button>
                </div>
            </div>
        </form>
    </section>
@endsection