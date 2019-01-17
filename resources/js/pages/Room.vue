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
                        activeRoom
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
                    <v-layout wrap class="mt-5" v-if="showInput">
                        <v-flex xs12 md2 offset-md5>
                            <v-text-field
                                label="Ставка"
                                solo
                                v-model="bet"
                                class="text-center input-bet"
                                type="number"
                                min="0"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs12 v-if="errors">
                            <p class="text-center text-error" v-for="(err, i) in errors" :key="i">{{ err }}</p>
                        </v-flex>
                        <v-flex xs12 md4 offset-md4 class="px-3">
                            <v-btn class="green-btn  ma-0 w-100" @click="addBet()">Сделать ставку</v-btn>
                        </v-flex>
                    </v-layout>
                    <v-layout class="mt-4 mb-0" v-if="!showTimer">
                        <v-flex xs12 class="mt-4">
                            <p class="text-center timer">Игра начнётся после ставок 2-х игроков</p>
                        </v-flex>
                    </v-layout>
                    <v-layout class="mt-4 mb-0" v-if="showTimer">
                        <v-flex xs12 class="mt-4">
                            <!-- <p class="text-center timer">Розыгрыш скоро начнётся: <span class="text-error">{{ time }}</span></p> -->
                            <p class="text-center timer">Розыгрыш скоро начнётся <v-progress-circular
                                :size="40"
                                :width="5"
                                color="red"
                                indeterminate
                            ></v-progress-circular></p>
                        </v-flex>
                    </v-layout>
                    <div class="wrap_winner_div" ref="winner">
                        <v-layout wrap class="shadow px-2 pt-0 winer rounded" v-if="userAddBet.length > 0">
                            <v-flex class="my-4" :style="betInPercent(user.bet)" v-for="(user, i) in userAddBet" :key="i">
                                    <div class="f-cc">
                                        <img :src="user.image" alt="avatar" class="avatar shadow">
                                    </div>
                                    <p class="text-center mt-3 mb-0">{{ user.firstName }}</p>
                                    <p class="text-center my-0">{{ user.secondName }}</p>
                                    <p class="user-bet text-center mt-2" :class="[{'rounded-left': i == 0}, {'rounded-right': i == addBetLength - 1}]">{{ user.bet }} руб</p>
                            </v-flex>
                            <v-flex xs12 id="winner" class="winner my-2">
                                <div class="square" :style="goToDirection"></div>
                            </v-flex>
                            <v-flex xs12>
                                <p class="text-center mt-2 normal-text">100% общая сумма: {{ allBet }} руб</p>
                            </v-flex>
                        </v-layout>
                    </div>
                    <v-layout row v-if="userWinner.length > 0" class="shadow py-2 winer rounded">
                        <v-flex xs12 v-for="(user, i) in userWinner" :key="i">
                            <p class="text-center">Поздравляем победителя!!!</p>
                            <div class="f-cc">
                                <img :src="user.image" alt="avatar" class="avatar shadow">
                            </div>
                            <p class="text-center mt-3 mb-0">{{ user.firstName }}  {{ user.secondName }}</p>
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
import { setTimeout } from 'timers';
import moment from 'moment';

export default {
    name: "Room",
    components: {
        EzHeader,
        EzFooter,
        SmallRoom,
        EzBtn
    },
    data() {
        return {
            timer: null,
            time: 30,
            bet: 1,
            userData: null,
            isMounted: false,
            image: '',
            firstName: '',
            secondName: '',
            userCreate: '',
            userId: '',
            userAddBet: [],
            userWinner: [],
            whoWin: [],
            whoPlays: [],
            errors: [],
            direction: 0,
            showTimer: false,
            showInput: true,
            userPercent: []
        };
    },
    methods: {
        calculateDate(servDate) {
            let myDate = moment().diff(moment.utc(servDate).local(),'seconds');
            return myDate;
        },
        animateSquare(direction, steps, stop) {
            if (direction == 'right') {
                steps = (stop > 0) ? stop : steps;
                for (let i=0; i < steps; i++) {
                    setTimeout( () => {
                        this.direction += 1;
                    }, 1);
                }
            } else {
                for (let i=0; i < steps; i++) {
                    setTimeout( () => {
                        this.direction -= 1;
                    }, 1);
                }
            }
        },
        startRulet(data) {
            let widthBlock = this.calculateWidth;
            console.log('DATA ABOUT WINNER ', data);
            let allBets = this.allBet;
            for (let i = 0; i < this.userAddBet.length; i++) {
                let percentForUser = (100 * parseInt(this.userAddBet[i].bet)) / parseInt(allBets);
                let calcLength = (widthBlock * percentForUser) / 100;
                this.userPercent.push( {
                    percent: percentForUser,
                    lengthInterval: calcLength,
                    firstName: this.userAddBet[i].firstName,
                    lastName: this.userAddBet[i].secondName
                });
            }
            let stopTimer = 0;
            for (let i = 0; i < this.userPercent.length; i++) {
                console.log('first name ', this.userPercent[i].firstName);
                console.log('last name ', this.userPercent[i].secondName);
                console.log('first name winner ', data.winner.first_name);
                console.log('last name winner ', data.winner.last_name);
                if ((this.userPercent[i].firstName == data.winner.first_name) && (this.userPercent[i].lastName == data.winner.last_name)) {
                    stopTimer += this.userPercent[i].lengthInterval / 2;
                    console.log('break timer ', stopTimer);
                    break;
                }
                stopTimer += this.userPercent[i].lengthInterval;
                console.log('stop timer ', stopTimer);
            }
            console.log('TIMER STOP IN ', stopTimer);
            console.log('width block = ', widthBlock);
            this.animateSquare('right', widthBlock);
            this.animateSquare('left', widthBlock);
            this.animateSquare('right', widthBlock, stopTimer);
            setTimeout(() => {
                this.time = 0;
                this.userWinner.push ({
                    image: data.winner.big_photo,
                    firstName: data.winner.first_name,
                    secondName: data.winner.last_name
                });
                this.userAddBet = [];
                this.direction = 0;
            }, 5000);
        },
        startTimer() {
            console.log('START TIMER')
            this.showTimer = true;
            this.timer = setInterval( () => {
                if (this.time > 0) {
                        this.time--;
                } else {
                    clearInterval(this.timer);
                    this.showTimer = false;
                    this.time = 30;
                }
            }, 1000 )
        },
        async addBet() {
            this.direction = 0;
            try {
                let token =  JSON.parse(localStorage.getItem('user-info')).token.access_token;
                const response = await axios({
                    method: 'POST',
                    url: 'http://rublik.money/api/set-bet',
                    data: {bet: this.bet * 100, room_id: 1},
                    // data: {bet: this.bet, room_id: 1},
                    headers: {'Authorization':'Bearer ' + token}
                });
                this.userWinner = [];
                if (this.userAddBet.length > 1) {
                    this.startTimer();
                }
                this.errors = [];
                console.log('bet response ', response);
            } catch(error) {
                this.errors = [];
                if (error.response.data == 'Please make bet between 0 and 1000') {
                    this.errors.push('Сделайте ставку от 1 до 10');
                } else {
                    this.errors.push(error.response.data);
                }
                console.log('add bet error ', error);
            }
        },
        async getUsersInRoom() {
            let token = JSON.parse(localStorage.getItem('user-info')).token.access_token;
            if (token) {
                try {
                    let response = await axios({
                        method: 'GET',
                        url: `http://rublik.money/api/current-game/1`,
                        headers: {'Authorization':'Bearer ' + token}
                    });
                    console.log('get users in room ', response.data);
                    if(response.data.length > 1){
                        this.time = 30 - this.calculateDate(response.data[1].updated_at);
                        this.startTimer();
                    }
                    this.errors = [];
                    return response.data;
                } catch (error) {
                    this.errors.push(error.response.data);
                    console.log('error get users in room ', error);
                }
            } else {
                this.erros.push('Пожалуйста, войдите на сайт!');
            }
        },
        async calculateTimer() {
            let token = JSON.parse(localStorage.getItem('user-info')).token.access_token;
            if (token) {
                try {
                    let response = await axios({
                        method: 'GET',
                        url: `http://rublik.money/api/current-game/1`,
                        headers: {'Authorization':'Bearer ' + token}
                    });
                    // console.log('get users in room ', response.data);
                    this.errors = [];
                    return response.data;
                } catch (error) {
                    this.errors.push(error.response.data);
                    console.log('error get users in room ', error);
                }
            } else {
                this.erros.push('Пожалуйста, войдите на сайт!');
            }
        },
        betInPercent(bet) {
            let allBets = this.allBet;
            let percentForUser = (100 * parseInt(bet)) / parseInt(allBets);
            return `max-width:${percentForUser}%;`;
        }
    },
    computed: {
        calculateWidth(){
            // let blockWidth = this.$refs.winner.clientWidth;
            let block = document.getElementById('winner');
            let blockWidth = block.clientWidth;
            console.log('this refs ', blockWidth);
            return blockWidth;
        },
        goToDirection() {
            let string = `left: ${this.direction}px;`;
            return string;
        },
        userToken() {
            if (localStorage.getItem('user-info') !== null) {
                return JSON.parse(localStorage.getItem('user-info')).token.access_token;
            }
            return false;
        },
        addBetLength() {
            return this.userAddBet.length;
        },
        allBet() {
            let sumBet = null
            this.userAddBet.forEach( (bet) => {
                return sumBet += parseInt(bet.bet);
            });
            return sumBet;
        }
    },
    beforeMount: async function() {
        let usersInRoom = await this.getUsersInRoom();

        for (let i = 0; i < usersInRoom.length; i++) {
            this.userAddBet.push({
                image: usersInRoom[i].user.big_photo,
                firstName: usersInRoom[i].user.first_name,
                secondName: usersInRoom[i].user.last_name,
                bet: usersInRoom[i].bet / 100
            });
        }
    },
    mounted() {
        this.isMounted = true;
        this.direction = 0;
        this.showInput = (localStorage.getItem('user-info') !== null) ? true : false;
        window.Echo.channel('bet').listen('MakeBet', (data) => {
            this.userAddBet.push({
                image: data.user.big_photo,
                firstName: data.user.first_name,
                secondName: data.user.last_name,
                bet: parseInt(data.bet.bet) / 100
            });
            this.userWinner = [];
            console.log('bet ', data);
        });
        window.Echo.channel('game').listen('FinishGame', (data) => {
            this.startRulet(data);
            // setTimeout(() => {
            //     this.time = 0;
            //     this.userWinner.push ({
            //         image: data.winner.big_photo,
            //         firstName: data.winner.first_name,
            //         secondName: data.winner.last_name
            //     });
            //     this.userAddBet = [];
            //     this.direction = 0;
            // }, 5000);      
        });
        window.Echo.channel('start-game').listen('StartGame', (data) => {
            this.showTimer = true;
            this.startTimer();
            console.log('start game ', data);
        });
    }
};
</script>
<style lang="stylus">
@import "../../style/app"
@import "../../style/variables"
.square
    background-color red
    width 10px
    height 10px
    border-radius 50%
    position relative

.avatar
    border-radius 50%
    width 100px
    height 100px

.header
    font-size 30px
    font-weight bold
    color black

.winer
    margin-top 30px

.timer
    color  black
    font-size 22px
    font-weight bold

.user-bet
    background-color #e6e8eb
    color black
    font-weight 550
    font-size 14px
    border-right 1px solid #cdcfd1
    padding 3px 0px

.rounded-left
    border-top-left-radius 8px
    border-bottom-left-radius 8px

.rounded-right
    border-top-right-radius 8px
    border-bottom-right-radius 8px
    border none

.input-bet
    & input 
        text-align center
        color $accent!important
        font-weight bold
        font-size 18px

.text-error
    color red

.winner
    background-color #e6e8eb
    border-radius 10px
</style>

