<template>
  <v-container grid-list-md text-center>
    <v-flex md12 xs12 sm12>
      <v-container fluid>
        <v-layout row>
          <v-flex xs12 md8>
            <v-card>
              <v-card-title>Relatório de estoque</v-card-title>
              <v-card-text class="py-0 my-0">
                <v-container class="py-0 my-0">
                  <v-row>
                    <v-col class="py-0 my-0">
                      <v-menu
                        ref="menu"
                        v-model="menu_inicialE"
                        :close-on-content-click="false"
                        :return-value.sync="data_inicialE"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="data_inicialE"
                            label="Data inicial de entrada"
                            prepend-icon="event"
                            readonly
                            v-on="on"
                            hide-details
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="data_inicialE" no-title scrollable>
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                          <v-btn text color="primary" @click="$refs.menu.save(data_inicialE)">OK</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-col>
                    <v-col class="py-0 my-0">
                      <v-menu
                        ref="menu"
                        v-model="menu_finalE"
                        :close-on-content-click="false"
                        :return-value.sync="data_finalE"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="data_finalE"
                            label="Data final de entrada"
                            prepend-icon="event"
                            readonly
                            v-on="on"
                            hide-details
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="data_finalE" no-title scrollable>
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                          <v-btn text color="primary" @click="$refs.menu.save(data_finalE)">OK</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col class="py-0 my-0">
                      <v-menu
                        ref="menu"
                        v-model="menu_inicialS"
                        :close-on-content-click="false"
                        :return-value.sync="data_inicialS"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="data_inicialS"
                            label="Data inicial de saída"
                            prepend-icon="event"
                            readonly
                            v-on="on"
                            hide-details
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="data_inicialS" no-title scrollable>
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                          <v-btn text color="primary" @click="$refs.menu.save(data_inicialS)">OK</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-col>
                    <v-col class="py-0 my-0">
                      <v-menu
                        ref="menu"
                        v-model="menu_finalS"
                        :close-on-content-click="false"
                        :return-value.sync="data_finalS"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="data_finalS"
                            label="Data final de saída"
                            prepend-icon="event"
                            readonly
                            v-on="on"
                            hide-details
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="data_finalS" no-title scrollable>
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                          <v-btn text color="primary" @click="$refs.menu.save(data_finalS)">OK</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col class="py-0 my-0">
                      <v-autocomplete
                        v-model="produtos"
                        :items="lista_produtos"
                        item-text="nome"
                        item-value="id"
                        label="Produto"
                        hide-details
                      ></v-autocomplete>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions class="py-0 my-0">
                <v-container>
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
      menu_inicialE: false,
      data_inicialE: "",
      menu_finalE: false,
      data_finalE: "",
      menu_inicialS: false,
      data_inicialS: "",
      menu_finalS: false,
      data_finalS: "",
      produtos: "",
      lista_produtos: [],
      relatorio: ""
    };
  },
  mounted() {
    this.$http
      .get(this.$url + "produtos/getAll")
      .then(response => {
        this.lista_produtos = response.data;
      })
      .catch(e => {
        console.error(e.response);
      });
  },
  methods: {
    gerar() {
      this.$http
        .get(this.$url + "relatorios/estoque")
        .then(response => {
          this.relatorio = response.data;
        })
        .catch(e => {
          console.error(e.response);
        });
    }
  }
};
</script>