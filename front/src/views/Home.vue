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
                        
                        <!-- Card Date -->
                        <v-flex md6>
                            <v-row justify="center">
                                <v-date-picker v-model="date" readonly locale="pt-br"></v-date-picker>
                            </v-row>
                        </v-flex>
                        <!-- End Card Date -->
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
                date: new Date().toISOString().substr(0, 10),
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