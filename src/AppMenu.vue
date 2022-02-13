<template>
    <nav>
        <router-link to="/">Accueil</router-link>
        |
        <router-link to="/about">À propos</router-link>
        |
        <router-link to="/register">Inscription</router-link>
        |
        <router-link to="/login">Connexion</router-link>
    </nav>
</template>
<script>
export default {
    name: 'AppMenu',
}
</script>
