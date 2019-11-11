<template>
    <v-container grid-list-md text-center>
        <v-layout row wrap>
            <v-flex md12 xs12 sm12>
                <v-container fluid>
                    <v-layout row>
                        <v-flex xs12 md8>
                            <v-card>
                                <v-card-title>
                                    Produtos
                                    <v-spacer></v-spacer>
                                    <v-text-field v-model="search" append-icon="search" label="Pesquisar" single-line
                                        hide-details></v-text-field>
                                </v-card-title>
                                <v-data-table :headers="headers" :items="produtos" class="elevation-1" :search="search">
                                    <template v-slot:item.expandir="{ item }">
                                        <v-icon small class="mr-2" @click="updateProduto(item)">
                                            edit
                                        </v-icon>
                                        <v-icon small @click="deleteProduto(item)">
                                            delete
                                        </v-icon>
                                    </template>
                                </v-data-table>
                            </v-card>
                        </v-flex>
                        <v-flex xs12 md4>
                            <div class="my-2">
                                <v-btn color="primary" @click="dialogCreate=true">Novo Produto</v-btn>
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
                    <v-card-title class="headline">Novo Produto</v-card-title>
                    <v-divider></v-divider>
                    <br>
                    <v-container>
                    <v-row>
                        
                        <v-col cols="12" md="6">
                            <v-text-field v-model="novoProduto.nome" label="Nome*" required></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field prefix="R$" v-money="$store.state.money" v-model="novoProduto.preco" label="Preço*" required></v-text-field>
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
                    <v-card-title class="headline">Editar Produto</v-card-title>
                    <v-divider></v-divider>
                    <br>
                    <v-container>
                    <v-row v-if="selectedProduto">
                        
                        <v-col cols="12" md="6">
                            <v-text-field v-model="selectedProduto.nome" label="Nome*" required></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field prefix="R$" v-money="$store.state.money" v-model="selectedProduto.preco" label="Preço*" required></v-text-field>
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
                    <v-card-text v-if="selectedProduto">
                        <p style="text-align:center">Tem Certeza que deseja excluir a produto
                            "{{selectedProduto.nome}}"?</p>
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
    export default {
        data() {
            return {
                search: "",
                headers: [{
                        text: 'Nome',
                        value: 'nome',
                    },
                    {
                        text: 'Preço',
                        value: 'preco'
                    },
                    {
                        text: 'Ações',
                        value: 'expandir'
                    },
                ],
                produtos: [],
                selectedProduto: null,
                dialogExcluir: false,
                novoProduto: {
                    nome: "",
                    preco: ""
                },
                dialogCreate: false,
                dialogUpdate: false,
            }
        },
        mounted() {
            this.getProdutos();
        },
        methods: {
            getProdutos() {
                this.$http.get(this.$url + 'produtos/getAll').then(response => {
                    // console.log(response);
                    this.produtos = response.data;
                }).catch(() => {
                    this.$root.$emit('snackbar', "Erro ao conectar com o servidor", "error");
                })
            },
            create(){
                if(this.novoProduto.nome==""||this.novoProduto.nome==null){
                    this.$root.$emit('snackbar', "Favor preencher o nome do produto", "error");
                } else if(this.novoProduto.preco==0||this.novoProduto.preco==null){
                    this.$root.$emit('snackbar', "Favor preencher o preço do produto", "error");
                } else{
                    this.$http.post(this.$url + 'produtos/create',this.novoProduto).then(response => {
                        if (response.status === 201) {
                            this.getProdutos();
                            this.$root.$emit('snackbar', "Criado com sucesso", "success");
                            this.novoProduto = { nome: "", preco: "" },
                            this.dialogCreate = false
                        }
                    }).catch(() => {
                        this.$root.$emit('snackbar', "Erro ao conectar com o servidor", "error");
                    })
                }
            },
            updateProduto(item) {
                this.selectedProduto = item; //Pode gerar problemas, lembrar de corrigir
                this.dialogUpdate = true;
            },
            confirmUpdate() {
                if(this.selectedProduto.nome==""||this.selectedProduto.nome==null){
                    this.$root.$emit('snackbar', "Favor preencher o nome do produto", "error");
                } else if(this.selectedProduto.preco==0||this.selectedProduto.preco==null){
                    this.$root.$emit('snackbar', "Favor preencher o preço do produto", "error");
                } else{
                    this.$http.post(this.$url + 'produtos/update', {
                        id: this.selectedProduto.id,
                        nome: this.selectedProduto.nome,
                        preco: this.selectedProduto.preco,
                    }).then(response => {
                        if (response.status === 200) {
                            this.getProdutos();
                            this.$root.$emit('snackbar', "Atualziado com sucesso", "success");
                            this.selectedProduto = null
                            this.dialogUpdate = false
                        }
                    }).catch(() => {
                        this.$root.$emit('snackbar', "Erro ao conectar com o servidor", "error");
                    })
                }
            },
            deleteProduto(item) {
                this.selectedProduto = item;
                this.dialogExcluir = true;
            },
            confirmDelete() {
                this.$http.post(this.$url + 'produtos/delete', {
                    id: this.selectedProduto.id
                }).then(response => {
                    if (response.status === 200) {
                        this.getProdutos();
                        this.$root.$emit('snackbar', "Deletado com sucesso", "success");
                        this.selectedProduto = null
                        this.dialogExcluir = false
                    }
                }).catch(() => {
                    this.$root.$emit('snackbar', "Erro ao conectar com o servidor", "error");
                })
            }
        },

    }
</script>