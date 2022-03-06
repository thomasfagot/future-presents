<template>
    <section class="width-400px text-left margin-center mt4">
        <div class="text-center mb4">
            <w-image
                v-if="store.state.user.person.avatar"
                class="avatar-image avatar-medium"
                :src="store.state.user.person.avatar"
            ></w-image>
            <div v-else class="avatar-text avatar-medium margin-auto">
                {{
                    ('' + store.state.user.person.firstname)
                        .substring(0, 1)
                        .toUpperCase()
                }}
            </div>
        </div>
        <w-card shadow :title="'Mon compte'" title-class="blue-light5--bg">
            Bonjour {{ store.state.user.person.firstname || '' }}
        </w-card>
    </section>
</template>
<script setup>
import store from '@/store'
</script>
