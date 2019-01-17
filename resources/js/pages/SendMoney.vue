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
                            <v-btn to="/payment" class="green-btn ma-0 w-100">Пополнить баланс</v-btn>
                        </v-flex>
                        <v-flex xs12 md4 class="px-3">
                            <v-btn to="/received-of-funds" class="green-btn ma-0 w-100 green-btn__active">Заказать выплату</v-btn>
                        </v-flex>
                    </v-layout>
                    
                    <v-layout wrap v-if="!paymentSystem">
                        <v-flex xs12>
                            <p class="text-center mt-5 mb-1 header">Вывод средств</p>
                        </v-flex>
                        <v-flex xs12>
                            <p class="text-center mt-2 mb-4 normal-text">Выберите способ:</p>
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="shadow rounded f-cc mb-4 payment-system" @click="paymentSystem = 'qiwi'">
                            <img src="../../img/qiwi.png" alt="">
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="shadow rounded f-cc mb-4 payment-system" @click="paymentSystem = 'visa'">
                            <img src="../../img/visa.png" alt="">
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="shadow rounded f-cc mb-4 payment-system" @click="paymentSystem = 'mastercard'">
                            <img src="../../img/mastercard.png" alt="">
                        </v-flex>
                    </v-layout>

                    <v-layout wrap v-if="paymentSystem == 'qiwi' || paymentSystem == 'visa' || paymentSystem == 'mastercard'">
                        <v-flex xs12>
                            <p class="text-center mt-5 mb-5 header">Вывод на {{ paymentSystem }}</p>
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="shadow rounded f-cc mb-5 payment-system">
                            <img src="../../img/qiwi.png" alt="" v-if="paymentSystem == 'qiwi'">
                            <img src="../../img/visa.png" alt="" v-if="paymentSystem == 'visa'">
                            <img src="../../img/mastercard.png" alt="" v-if="paymentSystem == 'mastercard'">
                        </v-flex>
                        <v-flex xs12>
                            <p class="text-center mb-1">Вывод средств на кошелек производится в автоматическом режиме и занимает от 5 минут до 12 часов. Введите сумму в <span class="red-text">рублях</span>, которую вы хотите вывести на свой кошелек. Срок перевода денег зависит от банка-эмитента карты (от нескольких секунд до 5 банковских дней <span class="small-text">{{ amountComission }}</span>.)</p> 
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="mt-4">
                            <v-text-field
                                label="Введите сумму"
                                solo
                                v-model="orderAmount"
                                class="text-center input-bet"
                                type="number"
                                min="0"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs12 md4 offset-md4>
                            <v-text-field
                                :label="labelWallet"
                                solo
                                v-model="wallet"
                                class="text-center input-bet"
                                type="text"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs12 v-if="errors">
                            <p class="text-center text-error" v-for="(err, i) in errors" :key="i">{{ err }}</p>
                        </v-flex>
                        <v-flex xs12 v-if="success">
                            <p class="text-center text-success">{{ success }}</p>
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="px-2">
                            <v-btn class="green-btn  ma-0 w-100" @click="sendMoney()">Вывести деньги</v-btn>
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
            errors: [],
            wallet: '',
            success: ''
        };
    },
    computed: {
        amountComission() {
            if (this.paymentSystem === 'qiwi') return 'Без комиссии';
            return 'комиссия 50 руб';
        },
        typeCurrency() {
            if (this.paymentSystem === 'qiwi') return 99;
            if (this.paymentSystem === 'visa') return 1963;
            if (this.paymentSystem === 'mastercard') return 21013;
        },
        labelWallet() {
            if (this.paymentSystem === 'qiwi') return '+78001122334';
            return '1234567812345678';
        },
        makeUrl() {
            if(this.paymentSystem === 'qiwi') return 'top-up-the-balance-kiwi';
            return 'top-up-the-balance-bank';
        }
    },
    methods: {
        async sendMoney() {
            try {
                let token =  JSON.parse(localStorage.getItem('user-info')).token.access_token;
                if(this.typeCurrency === 99){
                    const response = await axios({
                        method: 'POST',
                        url: 'http://rublik.money/api/' + this.makeUrl,
                        data: {amount: this.orderAmount, account: this.wallet},
                        headers: {'Authorization':'Bearer ' + token}
                    });
                    this.errors = [];
                    this.success = 'Успешный вывод средств!';
                    console.log('get-payment ', response);
                } else {
                    const response = await axios({
                        method: 'POST',
                        url: 'http://rublik.money/api/' + this.makeUrl,
                        data: {amount: this.orderAmount, account: this.wallet, bank_id: this.typeCurrency},
                        headers: {'Authorization':'Bearer ' + token}
                    });
                    this.errors = [];
                    this.success = 'Успешный вывод средств!';
                    console.log('get-payment ', response);
                }
            } catch(error) {
                this.success = '';
                this.errors = [];
                // this.errors.push(error.response.data);
                console.log('get-payment error ', error);
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

.small-text
    font-size 12px

@media only screen and (min-width: 1904px)
    .container
        max-width 1185px
</style>

