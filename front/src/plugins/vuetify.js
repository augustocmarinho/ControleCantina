import Vue from 'vue';
import Vuetify from 'vuetify/lib';

Vue.use(Vuetify);

export default new Vuetify({
    icons: {
        iconfont: 'mdi',
    },
    theme: {
        themes: {
            light: {
                primary: '#1867c0',
                secondary: '#1f3a93',
                accent: '#d81b60',
                error: '#b71c1c',
            },
        },
    }
});
