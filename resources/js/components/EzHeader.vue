<template>
    <header>
        <v-container>
            <v-layout align-center row fill-height>
                <v-flex xs12 md3>
                    <router-link to="/cabinet" class="logo">
                        <img src="../../img/logo.png" alt="">
                    </router-link>
                </v-flex>
                <v-flex xs12 md6 class="text-center">
                    <a href="#" class="nav-menu">Правила</a>
                    <a href="#" class="nav-menu">FAQ</a>
                    <a href="#" class="nav-menu">Новости</a>
                </v-flex>
                <v-flex xs12 md3 class="f-cr">
                    <span class="hiden-xs">Зайти через </span>
                    <a href="login/vk" class="auth-link"><img src="../../img/vk.png" alt=""></a>
                    <a href="login/ok" class="auth-link"><img src="../../img/ok.png" alt=""></a>
                </v-flex>
            </v-layout>
        </v-container>
    </header>
</template>
<script>
export default {
    name: 'EzHeader'
};
</script>
<style lang="stylus" scoped>
@import '../../style/app'
header
    background-color black
    max-height 100px

.logo
    color white
    font-weight bold
    font-size 35px

a
    color white
    text-decoration none

.nav-menu
    margin 0px 25px
    padding-bottom 34px
    border-bottom 5px solid black
    font-size 18px

    &:hover
        border-color $accent

span
    color white
    font-size 18px
    padding-right 5px

.auth-link
    padding 0px 5px

@media (max-width: 575px)
    .nav-menu
        border none
</style>
