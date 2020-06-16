<template>
    <div class="finish-info-popup_container">
        <div class="finish-info-popup_wrapper">
            <div class="finish-info-popup_centrino">
                <div class="finish-info-popup">
                    <div class="finish-info-popup_panel">
                        <div class="finish-info-popup_panel_left">
                            <div class="back-btn" @click="$emit('closePopup')">
                                <img src="/img/arrow-left.svg">
                                <span>Назад</span>
                            </div>
                        </div>
                        <div class="finish-info-popup_panel_right">
							<span class="close-btn" @click="$emit('closePopup')">
								<svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <circle opacity="0.3" cx="15" cy="15" r="15" fill="#B3B4B3"/>
                                    <path d="M21 21L9 9M9 21L21 9L9 21Z" stroke="black" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
							</span>
                        </div>
                    </div>
                    <div>
                        <div class="finish-info-popup_header">
                            <img
                                    class="finish-info-popup_header_icon"
                                    src="/img/doc.svg"
                            >
                            <h3> {{ title }}</h3>
                            <span>{{ titleHint }}</span>
                        </div>
                        <div class="finish-info-popup_body">
                            <div class="finish-info-popup_body_container">
                                <a
                                        class="white-btn finish-info-popup_link-btn"
                                        :href="btnHref"
                                        @click.prevent="$emit('closePopup')"
                                >{{ btnTitle }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['title', 'titleHint', 'btnTitle', 'btnHref']
    }
</script>
<style lang="scss">
    @import "FinishInfoPopup";
</style>