<template>
    <div>
        <w-toolbar id="main-menu">
            <router-link to="/">
                <h1 class="title2">
                    <w-icon class="mr1 mb2" color="primary"
                        >mdi mdi-gift</w-icon
                    >
                    FuturePresents
                </h1>
            </router-link>
            <div class="spacer"></div>
            <template v-if="!store.state.user.id">
                <router-link to="/" :class="'px3'">Connexion</router-link>
                <w-divider vertical class="mx2"></w-divider>
                <router-link to="/register" :class="'px3'"
                    >Inscription</router-link
                >
            </template>
            <template v-else>
                <router-link to="/account" :class="'px3'"
                    >Mon compte</router-link
                >
            </template>
        </w-toolbar>
    </div>
</template>
<script setup>
import store from '@/store'
</script>
<style scoped>
.router-link-exact-active {
    font-weight: bold;
}
</style>
