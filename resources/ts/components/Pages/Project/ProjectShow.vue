<script setup lang="ts">
const project = ref(usePage().props.project)
console.log(project.value)
</script>

<template>
	<Head title="Projects" />
</template>
