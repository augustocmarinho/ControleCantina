<template>
    <v-container grid-list-md text-center>
        <v-layout row wrap>
            <v-flex md12 xs12 sm12>
                <v-container fluid>
                    <v-layout row>
                        <v-flex xs12 md8>
                            <v-card>
                                <v-card-title>
                                    Clientes
                                    <v-spacer></v-spacer>
                                    <v-text-field v-model="search" append-icon="search" label="Pesquisar" single-line
                                        hide-details></v-text-field>
                                </v-card-title>
                                <v-data-table :headers="headers" :items="clientes" class="elevation-1" :search="search">
                                    <template v-slot:item.expandir="{ item }">
                                        <v-icon small class="mr-2" @click="updateCliente(item)">
                                            edit
                                        </v-icon>
                                        <v-icon small @click="deleteCliente(item)">
                                            delete
                                        </v-icon>
                                    </template>
                                </v-data-table>
                            </v-card>
                        </v-flex>
                        <v-flex xs12 md4>
                            <div class="my-2">
                                <v-btn color="primary" @click="dialogCreate=true">Novo Cliente</v-btn>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-flex>
        </v-layout>

        <!-- Dialog Create -->
        <v-row justify="center">
            <v-dialog v-model="dialogCreate">
                <v-card>
                    <v-card-title class="headline">Novo Cliente</v-card-title>
                    <v-divider></v-divider>
                    <br>
                    <v-container>
                    <v-row>

                        <v-col cols="12" md="6">
                            <v-text-field v-model="novoCliente.nome" label="Nome*" required></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-menu ref="menu" v-model="menu" :close-on-content-click="false" transition="scale-transition" offset-y full-width
                                min-width="290px">
                                <template v-slot:activator="{ on }">
                                    <v-text-field v-model="novoCliente.dataNascimento" label="Data de Nascimento" prepend-icon="event" readonly v-on="on"></v-text-field>
                                </template>
                                <v-date-picker locale="pt-br" ref="picker" v-model="novoCliente.dataNascimento" :max="new Date().toISOString().substr(0, 10)" min="1950-01-01"
                                    @change="save"></v-date-picker>
                            </v-menu>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field v-mask="'###.###.###-##'" v-model="novoCliente.cpf" label="CPF" required></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field v-model="novoCliente.email" label="Email" required></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6" v-for="(item,index) in novoCliente.telefones" :key="index">
                            <v-text-field  v-mask="['(##)####-####', '(##)#####-####']" v-model="item.telefone" :label="'Telefone '+ (index+1)">
                                <template v-slot:append>
                                    <v-icon color="red" @click="removeTelefoneNovoCliente(index)">delete
                                    </v-icon>
                                </template>
                            </v-text-field>
                        </v-col>
                        <v-col cols="12" md="12" align-right>
                            <v-btn class="ma-2" @click="addTelefoneNovoCliente" tile color="primary" dark>Adicionar Telefone</v-btn>
                        </v-col>
                    </v-row>
                    </v-container>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn color="secondary darken-1" text @click="dialogCreate = false">
                            Cancelar
                        </v-btn>

                        <v-btn color="primary darken-1" text @click="create">
                            Criar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        <!-- End Dialog Create -->

        <!-- Dialog Update -->
        <v-row justify="center">
            <v-dialog v-model="dialogUpdate">
                <v-card>
                    <v-card-title class="headline">Editar Cliente</v-card-title>
                    <v-divider></v-divider>
                    <br>
                    <v-container>
                        <v-row v-if="selectedCliente">
                            
                            <v-col cols="12" md="6">
                                <v-text-field v-model="selectedCliente.nome" label="Nome*" required></v-text-field>
                            </v-col>

                            <v-col cols="12" md="6">
                                <v-menu ref="menu2" v-model="menu2" :close-on-content-click="false" transition="scale-transition" offset-y full-width
                                    min-width="290px">
                                    <template v-slot:activator="{ on }">
                                        <v-text-field v-model="selectedCliente.dataNascimento" label="Data de Nascimento" prepend-icon="event" readonly v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker locale="pt-br" ref="picker" v-model="selectedCliente.dataNascimento" :max="new Date().toISOString().substr(0, 10)" min="1950-01-01"
                                        @change="save"></v-date-picker>
                                </v-menu>
                            </v-col>

                            <v-col cols="12" md="6">
                                <v-text-field v-mask="'###.###.###-##'" v-model="selectedCliente.cpf" label="CPF" required></v-text-field>
                            </v-col>
                            
                            <v-col cols="12" md="6">
                                <v-text-field v-model="selectedCliente.email" label="Email" required></v-text-field>
                            </v-col>

                            <v-col cols="12" md="6" v-for="(item,index) in selectedCliente.telefones" :key="index">
                            <v-text-field v-mask="['(##)####-####','(##)#####-####']" v-model="item.telefone" :label="'Telefone '+ (index+1)">
                                <template v-slot:append>
                                    <v-icon color="red" @click="removeTelefoneUpdateCliente(index)">delete
                                    </v-icon>
                                </template>
                            </v-text-field>
                            </v-col>
                            <v-col cols="12" md="12" align-right>
                                <v-btn class="ma-2" @click="addTelefoneUpdateCliente" tile color="primary" dark>Adicionar Telefone</v-btn>
                            </v-col>

                        </v-row>
                    </v-container>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn color="secondary darken-1" text @click="dialogUpdate = false">
                            Cancelar
                        </v-btn>

                        <v-btn color="primary darken-1" text @click="confirmUpdate">
                            Alterar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        <!-- End Dialog Update -->

        <!-- Dialog Confirm Delete -->
        <v-row justify="center">
            <v-dialog v-model="dialogExcluir" max-width="290">
                <v-card>
                    <v-card-title class="headline">Confirmar Exclusão</v-card-title>
                    <v-divider></v-divider>
                    <br>
                    <v-card-text v-if="selectedCliente">
                        <p style="text-align:center">Tem Certeza que deseja excluir a cliente
                            "{{selectedCliente.nome}}"?</p>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn color="secondary darken-1" text @click="dialogExcluir = false">
                            Cancelar
                        </v-btn>

                        <v-btn color="primary darken-1" text @click="confirmDelete">
                            Deletar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        <!-- End Dialog Delete -->

    </v-container>
</template>

<script>
    import { mask } from 'vue-the-mask'

    export default {
        directives: {
            mask
        },
        data() {
            return {
                search: "",
                headers: [{
                        text: 'Nome',
                        value: 'nome',
                    },
                    {
                        text: 'Data de Nascimento',
                        value: 'dataNascimento'
                    },
                    {
                        text: 'Ações',
                        value: 'expandir'
                    },
                ],
                clientes: [],
                selectedCliente: null,
                dialogExcluir: false,
                novoCliente: {
                    nome: "",
                    dataNascimento: null,
                    cpf:"",
                    email:"",
                    telefones:[]
                },
                dialogCreate: false,
                dialogUpdate: false,
                menu:false,
                menu2:false,
            }
        },
        mounted() {
            this.getClientes();
        },
        methods: {
            addTelefoneNovoCliente() {
                this.novoCliente.telefones.push({
                    telefone: "",
                });
            },
            removeTelefoneNovoCliente(index){
                this.novoCliente.telefones.splice(index,1);
            },
            addTelefoneUpdateCliente() {
                this.selectedCliente.telefones.push({
                    telefone: "",
                });
            },
            removeTelefoneUpdateCliente(index){
                this.selectedCliente.telefones.splice(index,1);
            },
            getClientes() {
                this.$http.get(this.$url + 'clientes/getAll').then(response => {
                    this.clientes = response.data;
                }).catch(() => {
                    this.$root.$emit('snackbar', "Erro ao conectar com o servidor", "error");
                })
            },
            create(){
                if(this.novoCliente.nome==""||this.novoCliente.nome==null){
                    this.$root.$emit('snackbar', "Favor preencher o nome do cliente", "error");
                } else{
                    this.$http.post(this.$url + 'clientes/create',this.novoCliente).then(response => {
                        if (response.status === 201) {
                            this.getClientes();
                            this.$root.$emit('snackbar', "Criado com sucesso", "success");
                            this.novoCliente = {
                                nome: "",
                                dataNascimento: null,
                                cpf:"",
                                email:"",
                                telefones:[]
                            },
                            this.dialogCreate = false
                        }
                    }).catch(() => {
                        this.$root.$emit('snackbar', "Erro ao conectar com o servidor", "error");
                    })
                }
            },
            updateCliente(item) {
                this.selectedCliente = item; //Pode gerar problemas, lembrar de corrigir
                this.dialogUpdate = true;
            },
            confirmUpdate() {
                if(this.selectedCliente.nome==""||this.selectedCliente.nome==null){
                    this.$root.$emit('snackbar', "Favor preencher o nome do cliente", "error");
                } else{
                    this.$http.post(this.$url + 'clientes/update', this.selectedCliente).then(response => {
                        if (response.status === 200) {
                            this.getClientes();
                            this.$root.$emit('snackbar', "Editado com sucesso", "success");
                            this.selectedCliente = null
                            this.dialogUpdate = false
                        }
                    }).catch(() => {
                        this.$root.$emit('snackbar', "Erro ao conectar com o servidor", "error");
                    })
                }
            },
            deleteCliente(item) {
                this.selectedCliente = item;
                this.dialogExcluir = true;
            },
            confirmDelete() {
                this.$http.post(this.$url + 'clientes/delete', {
                    id: this.selectedCliente.id
                }).then(response => {
                    if (response.status === 200) {
                        this.getClientes();
                        this.$root.$emit('snackbar', "Deletado com sucesso", "success");
                        this.selectedCliente = null
                        this.dialogExcluir = false
                    }
                }).catch(() => {
                    this.$root.$emit('snackbar', "Erro ao conectar com o servidor", "error");
                })
            },
            save (date) {
                this.$refs.menu.save(date)
            },
        },

    }
</script>