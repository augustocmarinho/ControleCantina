<template>
    <v-layout class="ma-5" wrap>
        <v-flex class="pa-0 mb-5" md12>
            <span class="headline mr-5 font-weight-light">{{titleBar}}</span>
            <v-breadcrumbs style="display: inline" class="pa-0 mb-5" :items="items">
                <template v-slot:divider>
                    <v-icon>chevron_right</v-icon>
                </template>
                <template v-slot:item="props">
                    <v-breadcrumbs-item :href="props.item.href" :class="[props.item.disabled && 'disabled']">
                        {{ props.item.text.toUpperCase() }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </v-flex>
        <v-flex md12 xs12 sm12>
            <slot/>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "CommonPage",
        data(){
            return{
                items: [],
                titleBar: ""
            }
        },
        created() {
            this.$root.$on("titleBar", (title) => {
                this.titleBar = title;
            });
            this.$route.path.split('/').forEach((item, index) => {
                if(index === 0){
                    this.items.push({text: 'início', disabled: false, href: '/'});
                }else {
                    this.items.push({text: item, disabled: false});
                }
            })
        },
    }
</script>

<style scoped>

</style>