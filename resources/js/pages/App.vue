<template>
    <div>
        <v-app>
            <router-view></router-view>
        </v-app>
    </div>
</template>
<script>
import axios from 'axios';
import EzHeader from '../components/EzHeader';
import EzFooter from '../components/EzFooter';
import EzBtn from '../components/EzBtn';

export default {
    name: 'start',
    props: ['user'],
    components: {
        EzHeader,
        EzFooter,
        EzBtn
    },
    data() {
        return {
            firstName: 'VK',
            secondName: 'Please auth in ',
            image: null,
            show: false,
            firstMenu: false,
            secondMenu: false
        };
    },
    created() {
        let data = JSON.parse(this.user);
        if (data) {
            this.$store.dispatch('authUser', data);
        }
        if (localStorage.getItem('user-info') !== null) {
            // let info = this.$store.getters.getUserInfo;

            let info = JSON.parse(localStorage.getItem('user-info'));
            this.image = info.photo;
            this.firstName = info.first_name;
            this.secondName = info.last_name;
            this.show = true;
        }
    },
    mounted() {
        // this.$root.$on('notauth', function (data) {
        //     console.log('user not auth', data);
        // });
    }
}
</script>
<style lang="stylus" scoped>
// @import "../../style/variables"
// @import "../../style/app"

@media only screen and (min-width: 1904px)
    .container
        max-width 1185px
</style>

