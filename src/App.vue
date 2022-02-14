<template>
    <w-app>
        <AppMenu />
        <main id="app-content">
            <router-view />
        </main>
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
#app-content {
    margin-top: 3em;
    padding: 10px;
}
.width-300px {
    max-width: 300px;
}
.margin-center {
    margin-right: auto;
    margin-left: auto;
}
</style>
