<template>
    <w-toolbar :fixed="true" height="3em">
        <router-link to="/">
            <h1 class="title2">
                <w-icon class="mr1 mb2" color="primary">mdi mdi-gift</w-icon>
                FuturePresents
            </h1>
        </router-link>
        <div class="spacer"></div>
        <router-link to="/" :class="'px3'">Connexion</router-link>
        <w-divider vertical class="mx2"></w-divider>
        <router-link to="/register" :class="'px3'">Inscription</router-link>
    </w-toolbar>
</template>
<script>
export default {
    name: 'AppMenu',
}
</script>
<style scoped>
.router-link-exact-active {
    font-weight: bold;
}
</style>
