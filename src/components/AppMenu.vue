<template>
    <div>
        <w-toolbar id="main-menu">
            <router-link
                :to="{
                    name: store.isAuthenticated.value ? 'Account' : 'Login',
                }"
            >
                <h1 class="title2">
                    <w-icon class="mr1 mb2" color="primary"
                        >mdi mdi-gift</w-icon
                    >
                    FuturePresents
                </h1>
            </router-link>
            <div class="spacer"></div>
            <template v-if="!store.isAuthenticated.value">
                <router-link :to="{ name: 'Login' }" :class="'px3'"
                    >Connexion</router-link
                >
                <w-divider vertical class="mx2"></w-divider>
                <router-link :to="{ name: 'Register' }" :class="'px3'"
                    >Inscription</router-link
                >
            </template>
            <template v-else>
                <w-menu hide-on-menu-click arrow align-right>
                    <template #activator="{ on }">
                        <w-image
                            v-if="store.state.user.person.avatar"
                            v-on="on"
                            class="avatar-image avatar-small cursor-pointer"
                            :src="store.state.user.person.avatar"
                        ></w-image>
                        <div
                            v-else
                            v-on="on"
                            class="avatar-text avatar-small cursor-pointer"
                        >
                            {{
                                ('' + store.state.user.person.firstname)
                                    .substring(0, 1)
                                    .toUpperCase()
                            }}
                        </div>
                    </template>
                    <router-link :to="{ name: 'Account' }">
                        <w-icon>mdi mdi-account</w-icon>
                        Mon compte
                    </router-link>
                    <w-divider class="my2"></w-divider>
                    <a href="#" @click="logout()">
                        <w-icon>mdi mdi-logout</w-icon>
                        Se déconnecter
                    </a>
                </w-menu>
            </template>
        </w-toolbar>

        <w-toolbar v-if="store.isAuthenticated.value">
            <w-flex>
                <div class="md3 d-flex align-center pr4">
                    <w-select
                        :items="store.state.networks"
                        :item-value-key="'id'"
                        :item-label-key="'name'"
                        label="Réseau"
                        no-unselect
                        v-model="currentNetwork"
                    >
                    </w-select>
                    <w-menu hide-on-menu-click arrow>
                        <template #activator="{ on }">
                            <w-button
                                v-on="on"
                                class="ma1"
                                icon="mdi mdi-dots-vertical"
                                outline
                                text
                            ></w-button>
                        </template>
                        <router-link :to="{ name: 'Network.add' }">
                            <w-icon>mdi mdi-plus</w-icon>
                            Nouveau réseau
                        </router-link>
                        <w-divider
                            v-if="store.state.currentNetwork"
                            class="my2"
                        ></w-divider>
                        <router-link
                            v-if="store.state.currentNetwork"
                            :to="{ name: 'Network.edit' }"
                        >
                            <w-icon>mdi mdi-pencil</w-icon>
                            Modifier le réseau
                        </router-link>
                    </w-menu>
                </div>
                <div
                    class="md3 d-flex align-center pr4"
                    v-if="store.state.currentNetwork"
                >
                    <w-select
                        :items="
                            store.state.events.filter(
                                (e) =>
                                    store.state.currentNetwork.id ===
                                    parseInt(e.network)
                            )
                        "
                        :item-value-key="'id'"
                        :item-label-key="'name'"
                        label="Évènement"
                        no-unselect
                        v-model="currentEvent"
                    >
                    </w-select>
                    <w-menu hide-on-menu-click arrow>
                        <template #activator="{ on }">
                            <w-button
                                v-on="on"
                                class="ma1"
                                icon="mdi mdi-dots-vertical"
                                outline
                                text
                            ></w-button>
                        </template>
                        <router-link :to="{ name: 'Event.add' }">
                            <w-icon>mdi mdi-plus</w-icon>
                            Nouvel évènement
                        </router-link>
                        <w-divider
                            v-if="store.state.currentEvent"
                            class="my2"
                        ></w-divider>
                        <router-link
                            v-if="store.state.currentEvent"
                            :to="{ name: 'Event.edit' }"
                        >
                            <w-icon>mdi mdi-pencil</w-icon>
                            Modifier l'évènement
                        </router-link>
                    </w-menu>
                </div>
            </w-flex>
        </w-toolbar>
    </div>
</template>
<script setup>
import store from '@/store'
import router from '@/router'
import { computed } from 'vue'

const currentNetwork = computed({
    get() {
        return store.state.currentNetwork
    },
    set(newValue) {
        store.mutations.setCurrentNetwork(newValue)
    },
})
const currentEvent = computed({
    get() {
        return store.state.currentEvent
    },
    set(newValue) {
        store.mutations.setCurrentEvent(newValue)
    },
})
function logout() {
    store.actions.logout().then(() => router.push({ name: 'Login' }))
}
</script>
<style scoped>
.router-link-exact-active {
    font-weight: bold;
}
</style>
