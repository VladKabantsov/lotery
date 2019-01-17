<template>
    <v-app>
        <ez-header></ez-header>
        <p class="text-center mb-2 mt-5">Для входа в личный кабинет вам необходима учетная запись на сайте <span class="red-text">vk.com или OK.ru</span></p> 
        <p class="text-center mb-2">Нажимая на кнопку "Войти" вы подтверждете что вы ознакомились и согласились с <span class="red-text">Пользовательским соглашением.</span></p> 
        <p class="text-center mb-2">Нажимая на кнопку "Войти" вы подтверждете что вам исполнилось <span class="red-text">18 лет.</span></p> 
        <div class="f-cc">
            <v-btn class="green-btn mt-4" to="/signin">Войти</v-btn>
        </div>
        <v-container>
            <v-layout wrap>
                <v-flex xs12 md6 class="f-cr rooms">
                    <ez-room
                        bet="1"
                        numberTable="1"
                        class="ma-3"
                    ></ez-room>
                </v-flex>
                <v-flex xs12 md6 class="f-cl rooms">
                    <ez-room
                        bet="10"
                        numberTable="2"
                        class="ma-3"
                    ></ez-room>
                </v-flex>
            </v-layout>
            <v-layout wrap>
                <v-flex xs12 md6 class="f-cr rooms">
                    <ez-room
                        bet="100"
                        numberTable="3"
                        class="ma-3"
                    ></ez-room>
                </v-flex>
                <v-flex xs12 md6 class="f-cl rooms">
                    <ez-room
                        bet="1000"
                        numberTable="4"
                        class="ma-3"
                    ></ez-room>
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
import EzRoom from '../components/EzRoom';
import EzBtn from '../components/EzBtn';

export default {
    name: 'home',
    props: ['user'],
    components: {
        EzHeader,
        EzFooter,
        EzRoom,
        EzBtn
    },
    data() {
        return {
            firstName: 'VK',
            secondName: 'Please auth in ',
            image: null,
            show: false      
        };
    },
    // methods: {
    //     notAuth() {
    //         console.log('user not auth');
    //     }
    // },
    computed: {
        isAuthenticated() {
            return this.$store.getters.isAuthenticated;
        }
    },
    mounted() {
        console.log('mounted home', this.$store.getters.isAuthenticated);
        // this.$nextTick(() => {
        //     if (localStorage.getItem('user-info') !== null) {
        //         this.show = true;
        //     }
        // });
        // window.Echo.channel('bet').listen('MakeBet', (data) => {
        //     console.log('bet ', data);
        // });
        // window.Echo.channel('game').listen('FinishGame', (data) => {
        //    console.log('game', data);
        // });
        // console.log(window.Echo);
    }
}
</script>
<style lang="stylus" scoped>
@import "../../style/variables"
@import "../../style/app"

.red-text
    color $accent

p
    font-size 18px

.green-btn
    background linear-gradient(to top, $primary, $secondary)!important
    color white
    border 0px solid transparent
    border-radius 20px
    padding 10px 35px
    height auto
    text-transform none
    font-weight 400
</style>
