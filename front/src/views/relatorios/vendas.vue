<template>
  <v-container grid-list-md text-center>
    <v-flex md12 xs12 sm12>
      <v-container fluid>
        <v-layout row>
          <v-flex xs12 md8>
            <v-card>
              <v-card-title>Relatório de vendas</v-card-title>
              <v-card-text class="py-0 my-0">
                <v-container class="py-0 my-0">
                  <v-row>
                    <v-col class="py-0 my-0">
                      <v-menu
                        ref="menu"
                        v-model="menu_inicial"
                        :close-on-content-click="false"
                        :return-value.sync="data_inicial"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="data_inicial"
                            label="Data inicial"
                            prepend-icon="event"
                            readonly
                            v-on="on"
                            hide-details
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="data_inicial" no-title scrollable>
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                          <v-btn text color="primary" @click="$refs.menu.save(data_inicial)">OK</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-col>
                    <v-col class="py-0 my-0">
                      <v-menu
                        ref="menu"
                        v-model="menu_final"
                        :close-on-content-click="false"
                        :return-value.sync="data_final"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="data_final"
                            label="Data final"
                            prepend-icon="event"
                            readonly
                            v-on="on"
                            hide-details
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="data_final" no-title scrollable>
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                          <v-btn text color="primary" @click="$refs.menu.save(data_final)">OK</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col class="py-0 my-0">
                      <v-autocomplete
                        v-model="funcionarios"
                        :items="lista_funcionarios"
                        item-text="name"
                        item-value="id"
                        label="Funcionário"
                        hide-details
                      ></v-autocomplete>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col class="py-0 my-0">
                      <v-autocomplete
                        v-model="clientes"
                        :items="lista_clientes"
                        item-text="nome"
                        item-value="id"
                        label="Cliente"
                        hide-details
                      ></v-autocomplete>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-container class="py-0 my-0">
                  <v-row justify="end">
                    <v-btn @click="gerar()" color="primary">Gerar</v-btn>
                  </v-row>
                </v-container>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-flex>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      menu_inicial: false,
      data_inicial: "",
      menu_final: false,
      data_final: "",
      funcionarios: "",
      lista_funcionarios: [],
      clientes: "",
      lista_clientes: [],
      relatorio: ""
    };
  },
  mounted() {
    this.$http
      .get(this.$url + "funcionarios")
      .then(response => {
        this.lista_funcionarios = response.data;
      })
      .catch(e => {
        console.error(e.response);
      });
    this.$http
      .get(this.$url + "clientes/getAll")
      .then(response => {
        this.lista_clientes = response.data;
      })
      .catch(e => {
        console.error(e.response);
      });
  },
  methods: {
    gerar() {
        var dados = {data_inicial: this.data_inicial, data_final: this.data_final};
      this.$http.get(this.$url + "relatorios/vendas", dados).then(response => {
        if (response) {
          this.relatorio = response.data;
        }
      });
    }
  }
};
</script>