<template>
    <w-app>
        <w-spinner v-if="isLoadingApp" id="global-spinner"></w-spinner>
        <template v-else>
            <AppMenu />
            <main id="app-content">
                <router-view />
            </main>
        </template>
    </w-app>
</template>

<script setup>
import AppMenu from '@/components/AppMenu'
import store from '@/store'
import { onMounted, ref } from 'vue'
import router from '@/router'

const isLoadingApp = ref(true)
onMounted(() => {
    store.actions
        .getUser()
        .then(
            (response) => {
                store.mutations.setUser(response.data)
                router.push({ name: 'Account' })
            },
            () => router.push({ name: 'Login' })
        )
        .finally(() => (isLoadingApp.value = false))
})
</script>

<style>
body {
    margin: 0;
}
#global-spinner {
    position: fixed;
    top: 50%;
    left: 50%;
    margin-left: -1.9em;
}
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
}
#app-content {
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
.cursor-pointer {
    cursor: pointer;
}
.avatar-image .w-image {
    background-position: center;
    border-radius: 100%;
}
.avatar-text {
    background-color: #ef6c00;
    color: white;
    font-weight: bold;
    font-size: 20px;
    border-radius: 100%;
    text-align: center;
}
.avatar-small {
    height: 40px !important;
    width: 40px !important;
    line-height: 40px;
}
.avatar-medium {
    height: 100px !important;
    width: 100px !important;
    line-height: 100px;
}
.w-card.w-menu {
    text-align: left;
}
a .w-icon {
    margin-top: -3px;
}
</style>
