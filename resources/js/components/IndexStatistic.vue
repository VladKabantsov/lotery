<template>
    <div class="statistic">
        <p class="statistic__number text-center">{{ number }}</p>
        <p class="statistic__text text-center">{{ text }}</p>
    </div>
</template>
<script>
export default {
    name: 'IndexStatistic',
    props: {
        number: {
            type: String,
            default: '400 000'
        },
        text: {
            type: String,
            default: 'text'
        }
    }
}
</script>
<style lang="stylus" scoped>
@import "../../style/app"

.statistic
    margin 50px 0px
    margin-top 0px
    padding 0px 20px

.statistic__number
    color white
    line-height 1
    border-bottom 1px solid white
    font-size 48px
    margin-bottom 0
    padding-bottom 10px
    text-transform uppercase
    font-family 'Gotham'

.statistic__text
    color white
    font-size 24px
    margin-bottom 0
    padding-bottom 10px
    text-transform uppercase
    font-family 'Book'

</style>

