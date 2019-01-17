<template>
    <a :href="to">
        <button class="btn w-100 align-center">
            <slot></slot>
            <span class="ml-2">{{ text }}</span>
        </button>
    </a>
</template>
<script>
export default {
    name: 'EzBtn',
    props: {
        text: {
            type: String,
            default: 'button'
        },
        background: {
            type: String,
            default: ''
        },
        img: {
            type: String
        },
        to: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            newClass: []
        };
    }
};
</script>
<style lang="stylus" scoped>
@import "../../style/variables"

.btn
    background-color transparent
    color white
    text-transform uppercase
    border 1px solid white
    padding 5px 14px
    background-color $secondary!important
    color white
    text-transform uppercase
    border 1px solid white
    border-radius 0px
    display flex
    margin-bottom 10px
    min-width 180px
    font-family 'Book'
    font-size 18px

a
    text-decoration none


</style>

