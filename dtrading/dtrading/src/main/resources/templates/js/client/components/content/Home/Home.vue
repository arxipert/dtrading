<template>
    <main class="content">

        <div class="content-left">
            <h5 class="content-left_header">{{ contentLeft.title }}</h5>

            <div class="content-left_body">
                <div class="content-left_body_card" v-for="contentLeftBodyCard in contentLeft.items">
                    <img class="content-left_body_card_img" :src="contentLeftBodyCard.img">
                    <p class="content-left_body_card_text">{{ contentLeftBodyCard.text}}</p>
                </div>
            </div>
        </div>

        <div class="content-right">
            <h5 class="content-right_header">{{ contentRight.title }}</h5>

            <ul class="content-right_body" v-for="contentRightBodyCard in contentRight.items">
                <li class="content-right_body_card">
                    <img class="content-right_body_card_img" src="/img/arrow-right.svg">
                    <p class="content-right_body_card_text">{{ contentRightBodyCard.text }}</p>
                </li>
            </ul>

            <div class="content-right_footer">
                    <span class="yellow-btn"
                          v-for="inquiryTypeModel in inquiryTypes"
                          @click="showInquiryPopup(inquiryTypeModel)"
                    >
                        {{ inquiryTypeModel.name }}
                    </span>
            </div>
        </div>
        <InquiryPopup
                v-if="visibleInquiryPopup"
                :popupData="inquiryPopupData"
                @closePopup="visibleInquiryPopup = false"
        ></InquiryPopup>
    </main>
</template>
<script>
    import InquiryPopup from '../../popup/Inquiry/InquiryPopup'

    export default {
        data() {
            return {
                /** inquiryTypes передается с бека в шаблоне resources/views/client/home/index.html*/
                inquiryTypes,
                visibleInquiryPopup: false,
                inquiryPopupData: null,
                contentLeft: {
                    title: 'Особистий кабінет Кліента',
                    items:
                        [
                            {
                                img: '/img/power.svg',
                                text: 'Регулювання об`єму споживання енергопродуктів протягом місяця (реномінації)'
                            },
                            {
                                img: '/img/account.svg',
                                text: 'Регулювання об`єму споживання енергопродуктів протягом місяця (реномінації)'
                            },
                            {
                                img: '/img/clipboard.svg',
                                text: 'Регулювання об`єму споживання енергопродуктів протягом місяця (реномінації)'
                            },
                            {
                                img: '/img/bill.svg',
                                text: 'Регулювання об`єму споживання енергопродуктів протягом місяця (реномінації)'
                            },
                        ]

                },
                contentRight: {
                    title: 'Щоб почати співпрацювати з D.TRADING та самостійно керувати закупівлями в онлайн-кабінеті, треба зробити:',
                    items:
                        [
                            {
                                text: 'Залиш запит на консультацію або на укладання договору'
                            },
                            {
                                text: 'З Вами зв`яжеться менеджер з продажу'
                            },
                            {
                                text: 'Укласти договір з D.TRADING'
                            },
                            {
                                text: 'Користуватись перевагами купівлі енергопродуктів онлайн'
                            },
                        ]

                },
            }
        },
        components: {
            InquiryPopup
        },
        methods: {
            showInquiryPopup(inquiryTypeModel) {
                axios.get('inquiry/' + inquiryTypeModel.id).then(json => {
                    this.inquiryPopupData = json.data;
                    this.visibleInquiryPopup = true;
                });
            },
        }
    }
</script>

<style lang="scss">
    @import "Home";
</style>