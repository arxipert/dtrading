<template>
    <div class="GoogeRecaptcha">
        <vue-recaptcha ref="recaptcha"
                       size="checkbox"
                       :sitekey="sitekey"
                       @verify="verify"
                       @expired="reject"
                       :loadRecaptchaScript=true
        >
        </vue-recaptcha>
        <div class="captcha-btn-holder">
            <button class="yellow-btn"
                    :class="{'disabled-btn':!recaptchaToken}"
                    :disabled="!recaptchaToken"
                    @click="fireSendEvent"
            >
                Відправити
            </button>
        </div>
    </div>
</template>

<script>

    import VueRecaptcha from 'vue-recaptcha'

    export default {
        data() {
            return {
                recaptchaToken: null,
                sitekey: process.env.MIX_GOOGLE_RECAPTCHA_SITE_KEY,
            }
        },
        components: {
            VueRecaptcha
        },
        methods: {
            /**
             * Отрабатывает, когда рекапча выбрана верно.
             *
             * @param {string} recaptchaToken.
             */
            verify(recaptchaToken) {
                this.recaptchaToken = recaptchaToken;
            },
            /**
             * Отрабатывает, когда рекапча выбрана некорректно.
             *
             */
            reject() {
                this.recaptchaToken = null;
                this.$refs.recaptcha.reset()
            },
            /**
             * Инициирует собыитие "googleRecaptchaPassed", если рекапча выбрана корректно.
             * В параметры события передается текущи токен рекапчи.
             *
             */
            fireSendEvent() {
                if (this.recaptchaToken) {
                    this.$emit('googleRecaptchaPassed', this.recaptchaToken);
                }
            }
        }
    };
</script>
<style lang="scss">
    @import "GoogeRecaptcha";
</style>