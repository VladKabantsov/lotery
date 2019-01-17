<template>
    <p>{{ text }}</p>
</template>
<script>
export default {
    name: 'MenuText',
    props: {
        text: {
            type: String,
            default: 'default'
        }
    }
};
</script>
<style lang="stylus" scoped>
@import "../../style/variables"
p
    margin-top: -5px;
    text-transform uppercase
    font-size 26px
    font-weight 300
    line-height 1
    color white
    margin-bottom 0px
    border-width 30px
    padding-bottom 10px
    position relative
    cursor pointer
    font-family 'Gotham'

    &:after 
        position absolute
        content ""
        display inline-block
        width 50px
        height 2px
        background-color $accent
        bottom -5px
        left 0

</style>

