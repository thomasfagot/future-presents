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
                    <router-link :to="{ name: 'Account' }" :class="'px3'"
                        >Mon compte</router-link
                    >
                    <w-divider class="my2"></w-divider>
                    <a href="#" @click="logout()">Se déconnecter</a>
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
                        v-model="store.state.currentNetwork"
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
                            Modifier le réseau
                        </router-link>
                    </w-menu>
                </div>
                <div
                    class="md3 d-flex align-center pr4"
                    v-if="store.state.currentNetwork"
                >
                    <w-select
                        :items="store.state.events"
                        :item-value-key="'id'"
                        :item-label-key="'name'"
                        label="Évènement"
                        no-unselect
                        v-model="store.state.currentEvent"
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
                            Nouvel évènement
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

function logout() {
    store.actions.logout().then(() => router.push({ name: 'Login' }))
}
</script>
<style scoped>
.router-link-exact-active {
    font-weight: bold;
}
</style>
