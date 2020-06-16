<template>
    <div>
        <div class="inquiry-popup_container" v-if="!isLastStep">
            <div class="inquiry-popup_wrapper">
                <div class="inquiry-popup_centrino">
                    <div class="inquiry-popup">
                        <div class="inquiry-popup_panel">
                            <div class="inquiry-popup_panel_left" v-if="parseInt(activeStep) !== 1">
                                <div class="back-btn" @click="stepBack">
                                    <img src="/img/arrow-left.svg">
                                    <span>Назад</span>
                                </div>
                            </div>
                            <div class="inquiry-popup_panel_right">
							<span class="close-btn" @click="$emit('closePopup')">
								<svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
<circle opacity="0.3" cx="15" cy="15" r="15" fill="#B3B4B3"/>
<path d="M21 21L9 9M9 21L21 9L9 21Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
							</span>
                            </div>
                        </div>
                        <div class="inquiry-popup_header">
                            <h3>{{ popupTitle }}</h3>
                            <span> {{ popupTitleHint }}</span>
                        </div>
                        <div class="inquiry-popup_steps" v-if="popupData.steps[activeStep].showInSteps">
                            <div
                                    class="inquiry-popup_steps_item"
                                    v-for="(step,stepNum) in popupData.steps"
                                    v-if="step.showInSteps"
                                    :class="{'active':step.active}"
                            >
							<span class="num">
                                {{ stepNum }}
                                <i class="title">{{ step.title }}</i>
                            </span>
                            </div>
                        </div>
                        <div class="inquiry-popup_body">
                            <div
                                    class="inquiry-popup_body_container"
                                    v-if="`items` in popupData.steps[activeStep] && popupData.steps[activeStep].items"
                            >
                                <div
                                        class="consultation-contract-type_item"
                                        v-for="stepItem in popupData.steps[activeStep].items"
                                        @click="nextStep(stepItem.id)"
                                        :class="{'chosen':stepItem.chosen}"
                                >
                                    <img :src="stepItem.img">
                                    <div class="consultation-contract-type_item_container">
                                        <span>{{ stepItem.title }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="inquiry-popup_form_container" v-else>
                                <form class="consultation-form" @submit.prevent="submitForm"
                                      v-if="!showGoogleRecaptcha">
                                    <input type="hidden" v-model="this.form.inquiry_id">

                                    <div class="inputs-triple-wrapper">
                                        <div>
                                            <label>Прізвище*:</label>
                                            <input
                                                    v-model="form.first_name"
                                                    name="first_name"
                                                    :class="{'input-error':errors.has('first_name')}"
                                                    v-validate="'required|min:2|max:64'"
                                            >
                                            <div v-if="errors.has('first_name')" class="error">
                                                {{ errors.first('first_name') }}
                                            </div>
                                        </div>

                                        <div>
                                            <label>Ім`я*:</label>
                                            <input
                                                    v-model="form.middle_name"
                                                    name="middle_name"
                                                    :class="{'input-error':errors.has('middle_name')}"
                                                    v-validate="'required|min:2|max:64'"
                                            >
                                            <div v-if="errors.has('middle_name')" class="error">
                                                {{ errors.first('middle_name') }}
                                            </div>
                                        </div>

                                        <div>
                                            <label>По-батькові:</label>
                                            <input
                                                    v-model="form.last_name"
                                                    name="last_name"
                                                    :class="{'input-error':errors.has('last_name')}"
                                                    v-validate="'required|min:2|max:64'"
                                            >
                                            <div v-if="errors.has('last_name')" class="error">
                                                {{ errors.first('last_name') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="inputs-single-wrapper">
                                        <div>
                                            <label>Назва компанії або код ЄРДПОУ:</label>
                                            <input
                                                    v-model="form.name_or_lei"
                                                    name="name_or_lei"
                                                    :class="{'input-error':errors.has('name_or_lei')}"
                                                    v-validate="'required|min:2|max:510'"
                                            >
                                            <div v-if="errors.has('name_or_lei')" class="error">
                                                {{ errors.first('name_or_lei') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="inputs-double-wrapper">
                                        <div>
                                            <label>Email*:</label>
                                            <input
                                                    v-model="form.email"
                                                    name="email"
                                                    :class="{'input-error':errors.has('email')}"
                                                    v-validate="'required|min:2|max:160|email'"
                                            >
                                            <div v-if="errors.has('email')" class="error">
                                                {{ errors.first('email') }}
                                            </div>
                                        </div>
                                        <div>
                                            <label>Телефон*:</label>
                                            <input
                                                    v-model="form.phone"
                                                    name="phone"
                                                    :class="{'input-error':errors.has('phone')}"
                                                    v-validate="'required|min:2|phone'"
                                            >
                                            <div v-if="errors.has('phone')" class="error">
                                                {{ errors.first('phone') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="textarea-wrapper">
                                        <div>
                                            <label>Залиште повідомлення*:</label>
                                            <textarea
                                                    v-model="form.inquiry_text"
                                                    name="inquiry_text"
                                                    :class="{'input-error':errors.has('inquiry_text')}"
                                                    v-validate="{ required: true, min:2, max:510}"
                                            ></textarea>
                                        </div>
                                    </div>

                                    <div class="form-notice">
                                        *Поля обов`язкові для заповнення
                                        {{ errors.first('inquiry_text') }}
                                    </div>

                                    <div class="personal-data-approve">
                                        <label>
                                            <input type="checkbox"
                                                   v-model="form.consent_pdp"
                                                   name="consent_pdp"
                                                   :value="1"
                                                   v-validate="{ required: true }"
                                            >
                                            <div class="check-box"></div>
                                        </label>
                                        <span>Даю свою згоду на <a
                                                href="#">збір та обробку персональних даних</a> </span>
                                    </div>

                                    <div>
                                        <button class="yellow-btn"
                                                :class="{'disabled-btn':errors.any()}"
                                                :disabled="errors.any()"
                                        >
                                            {{ popupData.steps[activeStep].btnTitle}}
                                        </button>
                                    </div>
                                </form>
                                <google-recapthca
                                        v-if="showGoogleRecaptcha"
                                        @googleRecaptchaPassed="sendForm"
                                ></google-recapthca>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <finish-info-popup
                v-else
                :title="popupTitle"
                :titleHint="popupTitleHint"
                btnTitle="Повернутися на сайт"
                btnHref="2"
                @closePopup="$emit('closePopup')"
        >
        </finish-info-popup>
    </div>
</template>
<script>

    import PhoneNumber from 'awesome-phonenumber'
    import uk from 'vee-validate/dist/locale/uk';
    import GoogleRecapthca from '../../common/GoogeRecaptcha/GoogeRecaptcha'
    import FinishInfoPopup from '../FinishInfoPopup/FinishInfoPopup'

    export default {
        props: ['popupData'],
        components: {GoogleRecapthca, FinishInfoPopup},
        data() {
            return {
                activeStep: 1,
                showGoogleRecaptcha: false,
                form: {
                    first_name: '',
                    middle_name: '',
                    last_name: '',
                    name_or_lei: '',
                    email: '',
                    phone: '',
                    inquiry_text: '',
                    consent_pdp: 1,
                    //Идишники выбранных "items" на шагах 1 и 2
                    chosenStepOptions: {
                        1: null,
                        2: null,
                    },
                },
            }
        },
        methods: {
            changeStep(curStep) {
                Object.keys(this.popupData.steps).forEach(stepIterNumber => {
                    if (parseInt(stepIterNumber) === parseInt(curStep)) {
                        this.activeStep = stepIterNumber;
                        this.popupData.steps[stepIterNumber].active = true;
                    } else if (curStep < stepIterNumber) {
                        this.popupData.steps[stepIterNumber].active = false;
                    }
                });
            },
            nextStep(selectedStepItemId = null) {
                if (selectedStepItemId && this.activeStep <= this.stepAmount) {
                    Object.keys(this.popupData.steps[this.activeStep].items).forEach(index => {
                        let curStepItem = this.popupData.steps[this.activeStep].items[index];

                        if (parseInt(curStepItem.id) === parseInt(selectedStepItemId)) {
                            curStepItem.chosen = true;

                            if (+this.activeStep === 1 || +this.activeStep === 2) {
                                this.form.chosenStepOptions[this.activeStep] = selectedStepItemId;
                            }

                        } else {
                            curStepItem.chosen = false;
                        }
                    });

                    this.changeStep(++this.activeStep);
                } else if (this.activeStep <= this.stepAmount) {
                    this.changeStep(++this.activeStep);
                }

            },
            stepBack() {
                if (this.activeStep > 0) {
                    this.changeStep(--this.activeStep);
                }

                //Скрываем рекапчу, если не последний шаг
                if (!this.isLastStep) {
                    this.showGoogleRecaptcha = false;
                }
            },
            submitForm() {
                this.$validator.validate().then(valid => {
                    if (valid) {
                        this.showGoogleRecaptcha = true;
                        this.nextStep();
                    }
                });
            },

            /**
             * Отправляет данные формы на бек после прохождения рекапчи на шаге и после ответа с сервера
             * переключается на шаг 5.
             *
             * @param {string} recaptchaToken.
             */
            sendForm(recaptchaToken) {
                this.form.recaptchaToken = recaptchaToken;
                this.form.captcha_pass = 1;
                //ISO8601-форамат datetime ms sql
                this.form.loc_inquiry_datetime = this.$moment();

                axios.post('inquiry', this.form).then(response => {
                    this.nextStep();
                });
            },
            /**
             * Добавляем +3/+38/+380 к полю телефона и (если надо) возвращаем.
             *
             * @constructor
             * @param {string} phone - неформатированный телефон
             * @return {string} - отформатированный телефон
             */
            parsePhone(phone) {
                if (phone.startsWith('0')) {
                    phone = `+38${phone}`;
                } else if (phone.startsWith('8')) {
                    phone = `+3${phone}`;
                } else if (phone.startsWith('3')) {
                    phone = `+${phone}`;
                }

                return phone;
            }
        },
        created() {
            this.form.inquiry_type_id = this.popupData.inquiry_type_id;

            //Настройка валидатора
            this.$validator.localize('uk', {
                attributes: {
                    first_name: 'Прізвище',
                    middle_name: 'Ім`я',
                    last_name: 'По-батькові',
                    name_or_lei: 'Назва компанії або код ЄРДПОУ',
                    email: 'Email',
                    phone: 'Телефон',
                    inquiry_text: 'Повідомлення',
                },
                messages: uk.messages
            });

            this.$validator.extend('phone', {
                getMessage: field => `Поле "${field}" не э валідним номером телефону!`,
                validate: value => new Promise(resolve => resolve({valid: new PhoneNumber(value, 'UK').isValid()}))
            });
        },
        computed: {
            stepAmount() {
                return Object.keys(this.popupData.steps).length;
            },
            isLastStep() {
                return parseInt(this.activeStep) === parseInt(this.stepAmount);
            },
            popupTitle() {
                if (this.popupData.steps[this.activeStep].overrideParent) {
                    return this.popupData.steps[this.activeStep].title;
                } else {
                    return this.popupData.title;
                }
            },
            popupTitleHint() {
                if (this.popupData.steps[this.activeStep].overrideParent) {
                    return this.popupData.steps[this.activeStep].titleHint;
                } else {
                    return this.popupData.titleHint;
                }
            },
        },
        watch: {
            form: {
                handler(val) {
                    this.form.phone = this.parsePhone(val.phone);
                },
                deep: true
            }
        }

    }
</script>
<style lang="scss">
    @import "InquiryPopup";
</style>
