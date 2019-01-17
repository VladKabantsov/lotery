<template>
    <v-app>
        <ez-header></ez-header>
        <v-container>
            <v-layout wrap>
                <v-flex xs12 md3 column>
                    <small-room
                        bet="1"
                        numberTable="1"
                        class="pa-1 mb-3"
                    ></small-room>
                    <small-room
                        bet="10"
                        numberTable="2"
                        class="pa-1 mb-3"
                    ></small-room>
                    <small-room
                        bet="100"
                        numberTable="3"
                        class="pa-1 mb-3"
                    ></small-room>
                    <small-room
                        bet="1000"
                        numberTable="4"
                        class="pa-1 mb-3"
                    ></small-room>
                </v-flex>
                <v-flex xs12 md9>
                    <v-layout wrap>
                        <v-flex xs12 md4 class="px-3">
                            <v-btn to="/cabinet" class="green-btn ma-0 w-100">Личный кабинет</v-btn>
                        </v-flex>
                        <v-flex xs12 md4 class="px-3">
                            <v-btn to="/payment" class="green-btn ma-0 w-100 green-btn__active">Пополнить баланс</v-btn>
                        </v-flex>
                        <v-flex xs12 md4 class="px-3">
                            <v-btn to="/received-of-funds" class="green-btn ma-0 w-100">Заказать выплату</v-btn>
                        </v-flex>
                    </v-layout>
                    
                    <v-layout wrap v-if="!paymentSystem">
                        <v-flex xs12>
                            <p class="text-center mt-5 mb-1 header">Пополнение баланса</p>
                        </v-flex>
                        <v-flex xs12>
                            <p class="text-center mt-2 mb-4 normal-text">Выберите способ</p>
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="shadow rounded f-cc mb-4 payment-system" @click="paymentSystem = 'qiwi'">
                            <img src="../../img/qiwi.png" alt="">
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="shadow rounded f-cc mb-4 payment-system" @click="paymentSystem = 'visa'">
                            <img src="../../img/visa.png" alt="">
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="shadow rounded f-cc mb-4 payment-system" @click="paymentSystem = 'yandex'">
                            <img src="../../img/yandex.png" alt="">
                        </v-flex>
                    </v-layout>

                    <v-layout wrap v-if="paymentSystem == 'qiwi' || paymentSystem == 'visa' || paymentSystem == 'yandex'">
                        <v-flex xs12>
                            <p class="text-center mt-5 mb-5 header">Пополнить с {{ paymentSystem }}</p>
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="shadow rounded f-cc mb-5 payment-system">
                            <img src="../../img/qiwi.png" alt="" v-if="paymentSystem == 'qiwi'">
                            <img src="../../img/visa.png" alt="" v-if="paymentSystem == 'visa'">
                            <img src="../../img/yandex.png" alt="" v-if="paymentSystem == 'yandex'">
                        </v-flex>
                        <v-flex xs12>
                            <p class="text-center mb-2">Зачисление средств на баланс производится в автоматическом режиме. <br> Введите сумму в <span class="red-text">рублях</span>, которую вы хотите зачислить на свой баланс</p> 
                        </v-flex>
                        <v-flex xs12>
                            <p class="text-center mb-2">Информация об оплате будет направлена на e-mail.</p>
                        </v-flex>
                        <v-flex xs12>
                            <p class="text-center mb-2 red-text">Введите сумму:</p> 
                        </v-flex>
                        <v-flex xs12 md2 offset-md5>
                            <v-text-field
                                label="100"
                                solo
                                v-model="orderAmount"
                                class="text-center input-bet"
                                type="number"
                                min="0"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs12 v-if="errors">
                            <p class="text-center text-error" v-for="(err, i) in errors" :key="i">{{ err }}</p>
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="px-3">
                            <v-btn class="green-btn  ma-0 w-100" @click="addMoney()">Пополнить баланс</v-btn>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-container>
        <ez-footer></ez-footer>
    </v-app>
</template>
<script>
import axios from 'axios';
import EzHeader from '../components/EzHeader';
import EzFooter from '../components/EzFooter';
import SmallRoom from '../components/SmallRoom';
import EzBtn from '../components/EzBtn';

export default {
    name: "Cabinet",
    components: {
        EzHeader,
        EzFooter,
        SmallRoom,
        EzBtn
    },
    data() {
        return {
            paymentSystem: null,
            merchantId: null,
            orderAmount: null,
            orderId: null,
            sign: null,
            login: null,
            errors: []
        };
    },
    computed: {
        typeCurrency() {
            if (this.paymentSystem === 'qiwi') return 63;
            if (this.paymentSystem === 'visa') return 160;
            if (this.paymentSystem === 'yandex') return 45;
        }
    },
    methods: {
        async addMoney() {
            try {
                let token =  JSON.parse(localStorage.getItem('user-info')).token.access_token;
                const response = await axios({
                    method: 'POST',
                    url: 'http://rublik.money/api/top-up-the-balance',
                    data: {order_amount: this.orderAmount, currency: this.typeCurrency},
                    headers: {'Authorization':'Bearer ' + token}
                });
                window.location.href = 'http://www.free-kassa.ru/merchant/cash.php?' + response.data;
                this.errors = [];
                console.log('top-up-the-balance ', response);
            } catch(error) {
                this.errors = [];
                this.errors.push(error.response.data);
                console.log('top-up-the-balance error ', error);
            }
        }
    }
};
</script>
<style lang="stylus" scoped>
@import "../../style/app"
@import "../../style/variables"

.header
    font-size 30px
    font-weight bold
    color black

.payment-system
    min-height 180px
    cursor pointer

.red-text
    color $accent

p
    font-size 18px

@media only screen and (min-width: 1904px)
    .container
        max-width 1185px
</style>

