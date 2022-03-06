<template>
    <section class="width-400px text-left margin-center mt4">
        <w-card shadow :title="'Mon compte'" title-class="blue-light5--bg">
            Bonjour {{ store.state.user.person.firstname || '' }}
        </w-card>
    </section>
</template>
<script setup>
import store from '@/store'
</script>
