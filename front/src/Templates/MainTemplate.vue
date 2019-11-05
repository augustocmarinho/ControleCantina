<template>
    <v-app v-if="token" id="inspire">
        <v-navigation-drawer v-model="drawer" app>
            <v-list style="padding: 0">
                <v-list-item style="height: 64px;background-color: #1867c0;" class="text--white">
                    <v-list-item-content>
                        <v-list-item-title class="title" style="color: white">Cantina</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-divider></v-divider>
                
                <!-- Rota Home -->
                <v-list-item @click="$router.push('/home')">
                    <v-list-item-action>
                        <v-icon>home</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Início</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <!-- Rota Produtos -->
                <v-list-item @click="$router.push('/produtos')">
                    <v-list-item-action>
                        <v-icon>border_all</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Produtos</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <!-- Rota Funcionários -->
                <v-list-item @click="$router.push('/funcionarios')">
                    <v-list-item-action>
                        <v-icon>mdi-account-multiple</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Funcionários</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

            </v-list>

        </v-navigation-drawer>
        <v-app-bar app color="primary" dark>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>{{$route.name}}</v-toolbar-title>
            <v-text-field flat solo-inverted prepend-inner-icon="search" label="Pesquisar" clearable
                class="search pt-7 ml-8"></v-text-field>
            <v-spacer></v-spacer>
            
            <v-menu transition="scroll-y-transition" left bottom>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on">
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item @click="$router.push('/logout')">
                        <v-list-item-content>
                            <v-list-item-title>Encerrar sessão</v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-action>
                            <v-icon>logout</v-icon>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-progress-linear :active="inRequest" :indeterminate="true" absolute bottom color="white" height="5"
                reactive></v-progress-linear>
        </v-app-bar>
        <v-content>
            <v-snackbar v-model="snackbar" :color="snackBarConfig.type" :right="true" :timeout="snackBarConfig.timeout"
                :top="true">
                {{snackBarConfig.msg}}
                <v-btn dark text @click="snackbar = false">Fechar</v-btn>
            </v-snackbar>

            <!-- Carregamento das Views -->
            <router-view />
            <!-- End Carregamento das Views -->

        </v-content>
        <v-content>
            <!--Footer-->
            <v-footer padless absolute class="font-weight-small" max-height="50px" >
                <div class="flex-grow-1"></div>
                <v-col class="text-center" cols="12">
                </v-col>
            </v-footer>
            <!--End Footer-->
        </v-content>
        <v-overlay z-index="10" absolute :value="inRequest">
            <v-progress-circular :size="70" :width="7" color="white" :opacity="0.90" indeterminate>
            </v-progress-circular>
        </v-overlay>

    </v-app>
</template>

<script>
    export default {
        name: "MainTemplate",
        components: {},
        data() {
            return {
                drawer: null,
                titleBar: "",
                token: "",
                inRequest: false,
                overlay: true,
                snackbar: false,
                snackBarConfig: {
                    type: "",
                    timeout: 10000,
                    msg: ""
                }
            }
        },
        mounted() {
            this.$store.watch(
                (state, getters) => getters.getRequest,
                newValue => {
                    this.inRequest = newValue;
                }
            );
            this.$root.$on("snackbar", (msg = "", type = "", timeout = 10000) => {
                this.snackBarConfig.type = type;
                this.snackBarConfig.msg = msg;
                this.snackBarConfig.timeout = timeout;
                this.snackbar = true;
            });
        },
        created() {
            this.$root.$on("titleBar", (title) => {
                this.titleBar = title;
            });
            this.token = localStorage.getItem("token");
            if (!this.token) {
                this.$router.push("/login");
            }
        }
    }
</script>

<style scoped>

</style>