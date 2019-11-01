import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        inRequest: false,
        temas: [
                {text: 'Primário', value: 'primary'},
                {text: 'Acentuado', value: 'accent'},
                {text: 'Indigo', value: 'indigo'},
                {text: 'Purple', value: 'purple'},
                {text: 'Blue', value: 'blue'},
                {text: 'Teal', value: 'teal'},
                {text: 'Green', value: 'green'},
                {text: 'Amber', value: 'amber'},
                {text: 'Yellow', value: 'yellow'},
                {text: 'Blue-grey', value: 'blue-grey'},
            ],
        money: {
            decimal: '.',
            thousands: '',
            precision: 2,
            masked: false
        }
    },
    mutations: {
        setRequest(state, n) {
            state.inRequest = n;
        },
    },
    getters: {
        getRequest: state => {
            return state.inRequest;
        },
    },
    actions: {}
})
