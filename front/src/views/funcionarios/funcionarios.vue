<template>
  <v-container grid-list-md text-center>
    <v-layout row wrap>
      <v-flex md12 xs12 sm12>
        <v-container fluid>
          <v-layout row>
            <v-flex xs12 md8>
              <v-card>
                <v-card-title>
                  Funcionários
                  <v-spacer></v-spacer>
                  <v-text-field
                    v-model="search"
                    append-icon="search"
                    label="Pesquisar"
                    single-line
                    hide-details
                  ></v-text-field>
                </v-card-title>
                <v-data-table
                  :headers="headers"
                  :items="funcionarios"
                  class="elevation-1"
                  :search="search"
                >
                  <template v-slot:item.expandir="{ item }">
                    <v-icon small class="mr-2" @click="updateFuncionario(item)">edit</v-icon>
                    <v-icon v-if="item.id != user.id" small @click="deleteFuncionario(item)">delete</v-icon>
                  </template>
                </v-data-table>
              </v-card>
            </v-flex>
            <v-flex xs12 md4>
              <div class="my-2">
                <v-btn color="primary" @click="dialogCreate=true">Novo Funcionário</v-btn>
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
          <v-card-title class="headline">Novo Funcionário</v-card-title>
          <v-divider></v-divider>
          <br />
          <v-container>
            <v-row>
              <v-col>
                <v-text-field v-model="novoFuncionario.name" label="Nome*" required></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="novoFuncionario.cpf"
                  v-mask="'###.###.###-##'"
                  label="CPF*"
                  required
                ></v-text-field>
              </v-col>
              <v-col>
                <v-text-field v-model="novoFuncionario.usuario" label="Usuário*" required></v-text-field>
              </v-col>
              <v-col>
                <v-text-field v-model="novoFuncionario.email" label="e-mail*" required></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="novoFuncionario.password"
                  type="password"
                  label="Senha*"
                  required
                ></v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  v-model="novoFuncionario.rpassword"
                  type="password"
                  label="Repita a senha*"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="secondary darken-1" text @click="dialogCreate = false">Cancelar</v-btn>

            <v-btn color="primary darken-1" text @click="create">Criar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
    <!-- End Dialog Create -->

    <!-- Dialog Update -->
    <v-row justify="center">
      <v-dialog v-model="dialogUpdate">
        <v-card>
          <v-card-title class="headline">Editar Funcionário</v-card-title>
          <v-divider></v-divider>
          <br />
          <v-container v-if="selectedFuncionario">
            <v-row>
              <v-col>
                <v-text-field v-model="selectedFuncionario.name" label="Nome*" required></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="selectedFuncionario.cpf"
                  v-mask="'###.###.###-##'"
                  label="CPF*"
                  required
                ></v-text-field>
              </v-col>
              <v-col>
                <v-text-field v-model="selectedFuncionario.usuario" label="Usuário*" required></v-text-field>
              </v-col>
              <v-col>
                <v-text-field v-model="selectedFuncionario.email" label="e-mail*" required></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="selectedFuncionario.password"
                  type="password"
                  label="Senha*"
                  required
                ></v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  v-model="selectedFuncionario.rpassword"
                  label="Repita a senha*"
                  type="password"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="secondary darken-1" text @click="dialogUpdate = false">Cancelar</v-btn>

            <v-btn color="primary darken-1" text @click="confirmUpdate">Alterar</v-btn>
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
          <br />
          <v-card-text v-if="selectedFuncionario">
            <p style="text-align:center">
              Tem certeza que deseja excluir a funcionário
              "{{selectedFuncionario.name}}"?
            </p>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="secondary darken-1" text @click="dialogExcluir = false">Cancelar</v-btn>

            <v-btn color="primary darken-1" text @click="confirmDelete">Deletar</v-btn>
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
  directives: { mask },
  data() {
    return {
      search: "",
      headers: [
        {
          text: "Nome",
          value: "name"
        },
        {
          text: "CPF",
          value: "cpf"
        },
        {
          text: "e-mail",
          value: "email"
        },
        {
          text: "Ações",
          value: "expandir"
        }
      ],
      funcionarios: [],
      selectedFuncionario: null,
      dialogExcluir: false,
      novoFuncionario: {
        name: "",
        cpf: "",
        usuario: "",
        email: "",
        password: ""
      },
      user: "",
      dialogCreate: false,
      dialogUpdate: false
    };
  },
  mounted() {
    this.getFuncionarios();
    this.user = JSON.parse(localStorage.getItem("user"));
  },
  methods: {
    getFuncionarios() {
      this.$http
        .get(this.$url + "funcionarios")
        .then(response => {
          // console.log(response);
          this.funcionarios = response.data;
        })
        .catch(() => {
          this.$root.$emit(
            "snackbar",
            "Erro ao conectar com o servidor",
            "error"
          );
        });
    },
    create() {
      if (
        this.novoFuncionario.name == "" ||
        this.novoFuncionario.name == null
      ) {
        this.$root.$emit(
          "snackbar",
          "Favor preencher o nome do funcionário",
          "error"
        );
      } else if (
        this.novoFuncionario.cpf == "" ||
        this.novoFuncionario.cpf == null
      ) {
        this.$root.$emit(
          "snackbar",
          "Favor preencher o cpf do funcionário",
          "error"
        );
      } else if (
        this.novoFuncionario.usuario == "" ||
        this.novoFuncionario.usuario == null
      ) {
        this.$root.$emit(
          "snackbar",
          "Favor preencher o nome de usuário do funcionário",
          "error"
        );
      } else if (
        this.novoFuncionario.email == "" ||
        this.novoFuncionario.email == null
      ) {
        this.$root.$emit(
          "snackbar",
          "Favor preencher o email do funcionário",
          "error"
        );
      } else if (
        this.novoFuncionario.password == "" ||
        this.novoFuncionario.password == null
      ) {
        this.$root.$emit(
          "snackbar",
          "Favor preencher o senha do funcionário",
          "error"
        );
      } else if (
        this.novoFuncionario.password != this.novoFuncionario.rpassword
      ) {
        this.$root.$emit("snackbar", "As senhas não correspondem", "error");
      } else {
        this.$http
          .post(this.$url + "funcionarios", this.novoFuncionario)
          .then(response => {
            if (response.status === 201) {
              this.getFuncionarios();
              this.$root.$emit("snackbar", "Criado com sucesso", "success");
              (this.novoFuncionario = {
                name: "",
                cpf: "",
                usuario: "",
                email: "",
                password: ""
              }),
                (this.dialogCreate = false);
            }
          })
          .catch(e => {
            this.$root.$emit("snackbar", e.response.data.erro, "error");
          });
      }
    },
    updateFuncionario(item) {
      this.selectedFuncionario = item; //Pode gerar problemas, lembrar de corrigir
      this.dialogUpdate = true;
    },
    confirmUpdate() {
      if (
        this.selectedFuncionario.name == "" ||
        this.selectedFuncionario.name == null
      ) {
        this.$root.$emit(
          "snackbar",
          "Favor preencher o nome do funcionário",
          "error"
        );
      } else if (
        this.selectedFuncionario.cpf == "" ||
        this.selectedFuncionario.cpf == null
      ) {
        this.$root.$emit(
          "snackbar",
          "Favor preencher o cpf do funcionário",
          "error"
        );
      } else if (
        this.selectedFuncionario.usuario == "" ||
        this.selectedFuncionario.usuario == null
      ) {
        this.$root.$emit(
          "snackbar",
          "Favor preencher o nome de usuário do funcionário",
          "error"
        );
      } else if (
        this.selectedFuncionario.email == "" ||
        this.selectedFuncionario.email == null
      ) {
        this.$root.$emit(
          "snackbar",
          "Favor preencher o email do funcionário",
          "error"
        );
      } else if (
        this.selectedFuncionario.password != this.selectedFuncionario.rpassword
      ) {
        this.$root.$emit("snackbar", "As senhas não correspondem", "error");
      } else {
        this.$http
          .put(this.$url + "funcionarios/" + this.selectedFuncionario.id, {
            name: this.selectedFuncionario.name,
            cpf: this.selectedFuncionario.cpf,
            usuario: this.selectedFuncionario.usuario,
            email: this.selectedFuncionario.email,
            password: this.selectedFuncionario.password
          })
          .then(response => {
            if (response.status === 200) {
              this.getFuncionarios();
              this.$root.$emit("snackbar", "Atualizado com sucesso", "success");
              this.selectedFuncionario = null;
              this.dialogUpdate = false;
            }
          })
          .catch(e => {
            this.$root.$emit("snackbar", e.response.data.erro, "error");
          });
      }
    },
    deleteFuncionario(item) {
      this.selectedFuncionario = item;
      this.dialogExcluir = true;
    },
    confirmDelete() {
      this.$http
        .delete(this.$url + "funcionarios/" + this.selectedFuncionario.id)
        .then(response => {
          if (response.status === 204) {
            this.getFuncionarios();
            this.$root.$emit("snackbar", "Deletado com sucesso", "success");
            this.selectedFuncionario = null;
            this.dialogExcluir = false;
          }
        })
        .catch(() => {
          this.$root.$emit(
            "snackbar",
            "Erro ao conectar com o servidor",
            "error"
          );
        });
    }
  }
};
</script>