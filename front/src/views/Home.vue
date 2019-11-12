<template>
    <v-container grid-list-md>
        <v-layout row wrap>
            <v-flex md12 xs12 sm12>
                <v-container fluid>
                    <v-layout row>
                        <v-flex md6>
                            <v-card>
                                <v-container>
                                Bem vindo {{usuario.name}}!
                                </v-container>
                            </v-card>
                        </v-flex>
                        
                        <!-- Card Demonstrativo de clima -->
                        <v-flex md6>
                            <v-card class="mx-auto" color="#F9F9F9" max-width="400">
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title class="headline">San Francisco</v-list-item-title>
                                        <v-list-item-subtitle>Mon, 12:30 PM, Mostly sunny</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>

                                <v-card-text>
                                    <v-row align="center">
                                        <v-col class="display-3" cols="6">
                                            23&deg;C
                                        </v-col>
                                        <v-col cols="6">
                                            <v-img src="https://cdn.vuetifyjs.com/images/cards/sun.png" alt="Sunny image"
                                                width="92"></v-img>
                                        </v-col>
                                    </v-row>
                                </v-card-text>

                                <v-list-item>
                                    <v-list-item-icon>
                                        <v-icon>mdi-send</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-subtitle>23 km/h</v-list-item-subtitle>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-icon>
                                        <v-icon>mdi-cloud-download</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-subtitle>48%</v-list-item-subtitle>
                                </v-list-item>

                                <v-slider v-model="time" :max="6" :tick-labels="labels" class="mx-4" ticks></v-slider>

                                <v-list class="transparent">
                                    <v-list-item v-for="item in forecast" :key="item.day">
                                        <v-list-item-title>{{ item.day }}</v-list-item-title>

                                        <v-list-item-icon>
                                            <v-icon>{{ item.icon }}</v-icon>
                                        </v-list-item-icon>

                                        <v-list-item-subtitle class="text-right">
                                            {{ item.temp }}
                                        </v-list-item-subtitle>
                                    </v-list-item>
                                </v-list>

                                <v-divider></v-divider>

                                <v-card-actions>
                                    <v-btn text>Full Report</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-flex>
                        <!-- End Card Demonstrativo de clima -->
                    </v-layout>
                </v-container>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
    export default {

        name: "Home",
        components: {},
        data() {
            return {
                usuario: null,
                labels: ['SU', 'MO', 'TU', 'WED', 'TH', 'FR', 'SA'],
                time: 0,
                forecast: [
                    { day: 'Tuesday', icon: 'mdi-white-balance-sunny', temp: '24\xB0/12\xB0' },
                    { day: 'Wednesday', icon: 'mdi-white-balance-sunny', temp: '22\xB0/14\xB0' },
                    { day: 'Thursday', icon: 'mdi-cloud', temp: '25\xB0/15\xB0' },
                ],
            }
        },
        mounted() {
            this.getUser();
        },
        methods: {
            getUser() {
                this.$http.get(this.$url + 'usuario/getUserCurrent').then(response => {
                    this.usuario = response.data;
                }).catch(() => {
                    this.$root.$emit('snackbar', "Erro ao conectar com o servidor", "error");
                })
            },
        }
    }
</script>
<style scoped></style>