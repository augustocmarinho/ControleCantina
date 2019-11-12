<template>
    <v-app class="split-bg">
        <v-content>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4 lg4>
                        <v-card class="elevation-1 pa-3">
                            <v-progress-linear :active="inRequest" :indeterminate="true" absolute top color="primary" height="5" reactive></v-progress-linear>
                            <v-card-text>
                                <div class="layout column align-center">
<!--                                    <img src="/static/m.png" alt="Vue Material Admin" width="120" height="120"/>-->
                                    <h1 class="flex my-4 primary--text">
                                        SCC - Dinâmico
                                    </h1>
                                </div>
                                <flash-message transitionIn="animated swing"></flash-message>
                                <v-form @submit.prevent="auth">
                                    <v-text-field append-icon="person" name="login" label="Email" type="email" v-model="email" required></v-text-field>
                                    <v-text-field append-icon="lock" name="password" label="Senha" id="password" type="password" v-model="password" required></v-text-field>
                                    <div class="login-btn">
                                        <v-spacer></v-spacer>
                                        <v-btn block type="submit" color="primary" :loading="finalizado">Login</v-btn>
                                    </div>
                                </v-form>
                                <br>
                                
                            </v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import { validationMixin } from 'vuelidate'
    import { required } from 'vuelidate/lib/validators'
    export default {
        name: "Login",
        mixins: [validationMixin],
        data(){
            return{
                email: "",
                password: "",
                finalizado: false,
                inRequest: false
            }
        },
        validations: {
            email: {
                required
            },
            password: {
                required
            }
        },
        methods:{
            auth(){
                this.inRequest = true;
                if(this.email && this.password){
                    this.$http.post(this.$url + 'login', {
                        email: this.email,
                        password: this.password
                    }).then(response => {
                        if(response.data.user && response.data.token){
                            let user = response.data.user;
                            let token = response.data.token;
                            // let roles = response.data.roles;
                            localStorage.setItem("user", JSON.stringify(user));
                            localStorage.setItem("token", token);
                            // localStorage.setItem("roles", JSON.stringify(roles));
                            this.$router.push("/");
                        }
                    }).catch(function (error) {
                        if(error.response.data.errors){
                            error.response.data.errors.forEach((item) => {
                                this.flash(item.message, item.level, {timeout: 10000});
                            });
                        }else if(error.response.status === 403){
                            this.flash("Credênciais inválidas, tente novamente", "error", {timeout: 10000});
                        }
                    }.bind(this)).finally(() =>{
                        this.inRequest = false;
                    })
                }else {
                    this.inRequest = false;
                    this.flash("Preencha as informações de login", "error", {timeout: 5000})
                }
            }
        }
    }
</script>

<style scoped lang="css">
    .split-bg {
        height: 50%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        content: "";
        z-index: 0;
    }
</style>