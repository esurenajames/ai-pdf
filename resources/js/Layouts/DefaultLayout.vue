<template>
    <div>
      <Navbar />
      <Sidebar />
      <main class="pt-16">
        <slot />
      </main>
    </div>
  </template>
  
  <script setup>
  import Navbar from '../Components/Navbar.vue';
  import Sidebar from '../Components/Sidebar.vue';
  </script>
  
  <style scoped>
  /* You can add layout-specific styles here */
  </style>
  