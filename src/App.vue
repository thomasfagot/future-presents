<template>
    <nav>
        <router-link to="/">Accueil</router-link> |
        <router-link to="/about">À propos</router-link> |
        <router-link to="/register">Inscription</router-link> |
        <router-link to="/login">Connexion</router-link>
    </nav>
    <router-view />
</template>

<script>
export default {
    name: 'App',
}
</script>

<style>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
}
</style>
