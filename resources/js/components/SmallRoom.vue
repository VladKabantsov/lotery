<template>
    <div class="room" :class="classes">
        <div class="number-table">
            <div class="digit">{{ numberTable }}</div>
        </div>
        <div class="text">
            <p class="header">Комната</p>
            <p class="bet">ставки от {{ bet }} руб.</p>
        </div>
        <div class="f-cc">
            <v-btn class="green-btn" to="/room">Играть</v-btn>
        </div>
    </div>
</template>
<script>
export default {
    name: 'EzRoom',
    props: {
        bet: {
            type: String
        },
        limitBet: {
            type: String
        },
        numberTable: {
            type: String
        },
        activeRoom: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        classes() {
            const c = [];
            if (this.activeRoom) {
                c.push('active-room');
            }
            return c;
        }
    }
};
</script>
<style lang="stylus" scoped>
@import "../../style/variables"

.room
    background-color white
    width 255px
    height 190px
    position relative
    border 0px solid white
    border-radius 10px
    -webkit-box-shadow 0px 0px 37px -2px rgba(0,0,0,0.55)
    -moz-box-shadow 0px 0px 37px -2px rgba(0,0,0,0.55)
    box-shadow 0px 0px 37px -2px rgba(0,0,0,0.55)
    // margin 15px

.active-room
    background-color #e6e8eb

.number-table
    width 95px
    height 100px
    position absolute 
    top 0
    right 0
    background-position-y bottom
    background-image url('../../img/red-line.png')

.digit
    display flex
    justify-content center
    color white
    transform rotate(45deg)
    font-size 35px
    font-weight bold
    width 100px
    height 100px
    margin-bottom 0px
    padding 2px

.header
    font-size 30px
    color black 
    font-weight bold
    color black 
    margin-left 35px
    margin-top 15px
    margin-bottom 5px

.bet
    font-size 19px
    color black 
    margin-left 35px
    margin-bottom 15px

.green-btn
    background linear-gradient(to top, $primary, $secondary)!important
    color white
    border 0px solid transparent
    border-radius 20px
    padding 10px 35px
    height auto
    text-transform none
    font-weight 400

@media (max-width: 575px)
    .room
        margin auto

</style>
