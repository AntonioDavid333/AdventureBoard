<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

</script>

<template>
  <div>
    {{ $page.props }}
    <h2>Roles:</h2>
    <ul>
      <li v-for="role in $page.props.auth.user.roles" :key="role">{{ role }}</li>
    </ul>

    <h2>Permisos:</h2>
    <ul>
      <li v-for="perm in $page.props.auth.user.permissions" :key="perm">{{ perm }}</li>
    </ul>
  </div>
</template>

