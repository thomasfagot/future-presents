<template>
    <w-app>
        <AppMenu />
        <router-view />
    </w-app>
</template>

<script>
import AppMenu from '@/AppMenu'

export default {
    name: 'App',
    components: { AppMenu },
}
</script>

<style>
body {
    margin: 0;
}
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
}
</style>
