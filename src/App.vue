<template>
    <w-app>
        <AppMenu />
        <main id="app-content">
            <router-view />
        </main>
    </w-app>
</template>

<script setup>
import AppMenu from '@/components/AppMenu'
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
.width-400px {
    max-width: 400px;
}
.margin-center {
    margin-right: auto;
    margin-left: auto;
}
.w-button.size--md {
    height: 30px !important;
}
</style>
