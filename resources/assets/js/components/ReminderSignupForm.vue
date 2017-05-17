<style></style>

<template>
    <div class="reminder-signup-component">
        <h2 class="signup-ad-header">How about this for a crazy idea?</h2>

        <p class="signup-ad-copy">We take his interests, mix them with your budget and send you a customized gift list 30 days before his birthday.</p>
        <p class="signup-ad-copy">Yay or Nay?</p>
        <span @click="openModal" class="signup-cta">Yay!</span>
        <p class="signup-ad-copy">Oh, and it's totally free.</p>
        <modal :show="modalOpen" :wider="true" class="recommendation-signup-modal">
            <div slot="header">

            </div>
            <div slot="body">
                <p class="signup-lead" v-text="lead_text" :class="{'sending': sending}"></p>
                <div class="loader" v-show="sending"></div>
                <transition name="modal">
                <form action="" v-show="fresh" @submit.stop.prevent="submitRequest" :class="{'waiting': sending}">
                    <div class="form-group" :class="{'has-error': errors.email}">
                        <label for="email">Your email: </label>
                        <span class="error-message" v-show="errors.email">{{ errors.email }}</span>
                        <input type="email" v-model="form.email" class="form-control">
                    </div>
                    <div class="form-group" :class="{'has-error': errors.sender}">
                        <label for="sender">Your name: </label>
                        <span class="error-message" v-show="errors.sender">{{ errors.sender }}</span>
                        <input type="text" v-model="form.sender" class="form-control" placeholder="How should we greet you?">
                    </div>
                    <div class="form-group" :class="{'has-error': errors.recipient}">
                        <label for="recipient">His name: </label>
                        <span class="error-message" v-show="errors.recipient">{{ errors.recipient }}</span>
                        <input type="text" v-model="form.recipient" class="form-control" placeholder="Who would the gifts be for?">
                    </div>
                    <div class="form-group" :class="{'has-error': errors.birthday}">
                        <label for="birthday">His birthday: </label><br>
                        <span class="error-message" v-show="errors.birthday">{{ errors.birthday }}</span>
                        <div class="style-select month">
                            <select name="month" id="month" v-model="form.birthday.month">
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
                            <select name="day" id="day" v-model="form.birthday.day">
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

                    <div class="form-group" :class="{'has-error': errors.interests}">
                        <label for="interests">His interests: </label>
                        <span class="error-message" v-show="errors.interests">{{ errors.interests }}</span>
                        <input type="text"
                               v-model="form.interests"
                               class="form-control"
                               placeholder="Outdoors, design, cooking, office, etc"
                               required
                        >
                    </div>
                    <div class="form-group">
                        <label>What's your budget?</label>
                        <p class="budget-text">{{ budget_text }}</p>
                        <range-slider class="slider"
                                      min="0"
                                      max="1050"
                                      step="10"
                                      v-model="form.budget"
                        ></range-slider>

                    </div>

                    <div class="form-group button-group">
                        <button type="button"
                                @click="closeModal"
                                :disabled="sending"
                                class="signup-btn"
                        >Maybe later
                        </button>
                        <button type="submit"
                                class="signup-btn action-button"
                                :disabled="sending"
                                v-text="sending ? 'sending' : `Hit it!`"
                        >
                        </button>
                    </div>
                </form>
                </transition>
                <transition name="modal">
                    <div class="signup-confirmation-panel" v-show="!fresh">
                        <div class="form-group button-group">
                            <button
                                    class="signup-btn"
                                    v-text="this.requestStatus === 'success' ? 'Do another one' : 'Try again'"
                                    @click="resetComponent"></button>
                            <button
                                    class="signup-btn action-button"
                                    v-text="this.requestStatus === 'success' ? 'All done' : 'I am done here'"
                                    @click="clearAndClose"></button>
                        </div>
                    </div>
                </transition>

            </div>
            <div slot="footer">

            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    import RangeSlider from 'vue-range-slider'
    import 'vue-range-slider/dist/vue-range-slider.css'

    export default {
        data() {
            return {
                form: {
                    sender: '',
                    recipient: '',
                    birthday: {month: "03", day: "15"},
                    budget: 100,
                    interests: '',
                    email: ''
                },
                errors: {
                    sender: '',
                    recipient: '',
                    birthday: '',
                    budget: '',
                    interests: '',
                    email: ''
                },
                modalOpen: false,
                fresh: true,
                sending: false,
                messages: {
                    success: 'Rest easy, our minions are already hard at work. Your list will arrive 30 days before his next birthday.',
                    error: 'Oh hell, it looks like we need a mulligan. Please refresh and try again. Sorry.',
                    invalid: 'There was a problem with your input, please check below.'
                },
                requestStatus: 'success',
            };
        },

        components: {
            RangeSlider
        },

        computed: {
            budget_block() {
                const blocks = [
                    {value: 0, label: 'Be reasonable (up to $50)'},
                    {value: 20, label: 'Give me options (up to $100)'},
                    {value: 40, label: 'Let\s go to town (up to $500)'},
                    {value: 60, label: 'Don\'t hold back (up to $1000)'},
                    {value: 80, label: 'I want to see it all (no limits)'}
                ];
                return blocks.filter(block => block.value <= this.form.budget)
                        .sort((a, b) => a.value - b.value)
                        .pop().label;
            },

            budget_text() {
              if(this.form.budget < 1000) {
                  return `US$${this.form.budget}`;
              }
                return `No expenses spared!`;
            },

            lead_text() {
                if(this.sending) {
                    return 'Sending...';
                }

                if(this.fresh && this.requestStatus === 'success') {
                    return 'High five! Glad to have you on board. We just need a few details.';
                }

                return this.messages[this.requestStatus];
            }
        },

        methods: {
            submitRequest() {
                this.sending = true;
                this.clearErrors();
                this.requestStatus = 'success';
                this.$http.post('/recommendations/request', this.formData())
                        .then(({data}) => this.onSuccess(data))
                        .catch(err => this.onFailure(err.response));
            },

            formData() {
                const bday = this.form.birthday.month + '-' + this.form.birthday.day;
                return {
                    sender: this.form.sender,
                    recipient: this.form.recipient,
                    birthday: bday,
                    budget: this.budget_block,
                    interests: this.form.interests,
                    email: this.form.email
                };
            },

            onSuccess(data) {
                this.sending = false;
                this.fresh = false;
            },

            onFailure(err) {
                this.sending = false;
                this.requestStatus = 'error';

                if(err.status === 422) {
                    return this.handleInvalidInput(err.data);
                }
                this.fresh = false;
            },

            handleInvalidInput(data) {
                this.requestStatus = 'invalid';
                Object.keys(data).forEach(field => this.errors[field] = data[field][0]);
            },

            resetComponent() {
                this.clearForm();
                this.clearErrors();
                this.fresh = true;
            },

            clearAndClose() {
                this.resetComponent();
                this.closeModal();
            },

            clearForm() {
              this.form = {
                  sender: this.form.sender,
                  recipient: '',
                  birthday: {month: "03", day: "15"},
                  budget: 100,
                  interests: '',
                  email: this.form.email
              };
            },

            clearErrors() {
              this.errors = {
                  sender: '',
                  recipient: '',
                  birthday: '',
                  budget: '',
                  interests: '',
                  email: ''
              };
            },

            openModal() {
                document.body.classList.add('modal-open');
                this.modalOpen = true;
            },

            closeModal() {
                document.body.classList.remove('modal-open');
                this.modalOpen = false;
            }
        }
    }
</script>