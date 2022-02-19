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
                router.push('/account')
            },
            () => router.push('/')
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
