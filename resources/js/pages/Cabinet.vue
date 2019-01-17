<template>
    <v-app>
        <ez-header></ez-header>
        <v-container v-if="isMounted">
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
                            <v-btn to="/cabinet" class="green-btn ma-0 w-100 green-btn__active">Личный кабинет</v-btn>
                        </v-flex>
                        <v-flex xs12 md4 class="px-3">
                            <v-btn class="green-btn ma-0 w-100" to="/payment">Пополнить баланс</v-btn>
                        </v-flex>
                        <v-flex xs12 md4 class="px-3">
                            <v-btn class="green-btn ma-0 w-100" to="/received-of-funds">Заказать выплату</v-btn>
                        </v-flex>
                    </v-layout>
                    <p class="text-center mt-5 header">Вы вошли как:</p>
                    <div class="f-cc">
                        <img :src="image" alt="avatar" class="avatar shadow">
                    </div>
                    <p class="text-center mt-2 normal-text">{{ firstName }}  {{ secondName }}</p>
                    <div class="f-cc">
                        <v-btn class="green-btn" @click="logOut()">Выход</v-btn>
                    </div>
                    <v-flex xs12 md6 offset-md3 class="shadow pa-4 rounded mt-5">
                        <!-- <v-layout wrap class="mb-2 fs-16">
                            <v-flex xs7>Вы вывели</v-flex>
                            <v-flex xs5  class="text-right red-text">0.00 руб</v-flex>
                        </v-layout> -->
                        <v-layout wrap class="mb-2 fs-16">
                            <v-flex xs7>Вы зарегистрированы</v-flex>
                            <v-flex xs5  class="text-right red-text">{{ userCreate }}</v-flex>
                        </v-layout>
                        <v-layout wrap class="mb-2 fs-16">
                            <v-flex xs7>Ваш ID</v-flex>
                            <v-flex xs5  class="text-right red-text">{{ userId }}</v-flex>
                        </v-layout>
                        <v-layout wrap class="mb-2 fs-16">
                            <v-flex xs7>Ваш баланс</v-flex>
                            <v-flex xs5  class="text-right red-text">{{ balance }} руб</v-flex>
                        </v-layout>
                        <v-layout wrap class="mb-2 fs-16">
                            <v-flex xs10 offset-xs1 md6 offset-md3>
                                <v-btn class="green-btn w-100 mx-0" to="/payment">Пополнение баланса</v-btn>
                                <v-btn class="green-btn w-100 mx-0" to="/received-of-funds">Заказать выплату</v-btn>
                            </v-flex>
                        </v-layout>
                        <!-- <p class="text-center red-text fs-16">История операций</p> -->
                    </v-flex>
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
        return{
            userData: null,
            isMounted: false,
            image: '',
            firstName: '',
            secondName: '',
            userCreate: '',
            userId: '',
            balance: ''
        };
    },
    methods: {
        logOut() {
            this.$store.dispatch('logOut', false);
            this.$router.push('/')
        },
        async getUserInfo() {
            let token = JSON.parse(localStorage.getItem('user-info')).token.access_token;
            if (token) {
                try {
                    let response = await axios({
                        method: 'GET',
                        url: `http://rublik.money/api/user`,
                        headers: {'Authorization':'Bearer ' + token}
                    });
                    console.log('response get user info ', response.data);
                    console.log('response balance ', response.data.balance.amount);
                    return response.data;
                } catch(error) {
                    console.log('error in get user Info ', error);
                }
            }
        }
    },
    beforeMount: async function() {
        let info = await this.getUserInfo();
        this.image = info.big_photo;
        this.firstName = info.first_name;
        this.secondName = info.last_name;
        this.userCreate = info.created_at;
        this.userId = info.id;
        this.balance = (parseInt(info.balance.amount) / 100).toFixed(2);
        this.isMounted = true;
    },
    // mounted() {
    //     if (localStorage.getItem('user-info') !== null) {
    //         let info = JSON.parse(localStorage.getItem('user-info'));
    //         console.log("user info cabinet ", info);
    //         this.image = info.big_photo;
    //         this.firstName = info.first_name;
    //         this.secondName = info.last_name;
    //         this.userCreate = info.created_at;
    //         this.userId = info.id;
    //         this.isMounted = true;
    //     }
    // },
};
</script>
<style lang="stylus" scoped>
@import "../../style/app"
@import "../../style/variables"

.header
    font-size 30px
    font-weight bold
    color black

@media only screen and (min-width: 1904px)
    .container
        max-width 1185px
</style>

