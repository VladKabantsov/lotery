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
                            <v-btn to="/received-of-funds" class="green-btn ma-0 w-100">Заказать выплату</v-btn>
                        </v-flex>
                    </v-layout>
                    <v-layout wrap>
                        <v-flex xs12>
                            <p class="text-center mt-5 mb-1 header">Регистрация и Авторизация</p>
                        </v-flex>
                        <v-flex xs12>
                            <p class="text-center mt-2 mb-4 normal-text">Для входа в личный кабинет Вам необходима учетная запись на сайте <span class="red-text">vk.com</span> или <span class="red-text">ok.ru.</span> Нажимая на кнопку «Войти» Вы подтверждаете, что Вы ознакомились и согласились с <span class="red-text">пользовательским соглашением.</span> Нажимая на кнопку «Войти» Вы подтверждаете, что Вам исполнилось <span class="red-text">18 лет.</span></p>
                        </v-flex>
                        <v-flex xs12>
                            <div class="f-cc">
                                <a href="login/vk" class="auth-link px-2"><img src="../../img/vk2.png" alt=""></a>
                                <a href="login/ok" class="auth-link px-2"><img src="../../img/ok2.png" alt=""></a>
                            </div>
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

@media only screen and (min-width: 1904px)
    .container
        max-width 1185px
</style>

