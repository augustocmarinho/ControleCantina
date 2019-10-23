<template>
    <div></div>
</template>

<script>
    export default {
        name: "Logout",
        beforeCreate() {
            localStorage.clear();
            this.$router.push('/login');
        }
    }
</script>

<style scoped>

</style>