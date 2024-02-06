<script setup lang="ts">
defineProps({
	value: String,
})
</script>

<template>
	<label class="label label-primary">
		<span
			class="label-text"
			v-if="value"
			>{{ value }}</span
		>
		<span
			class="label-text"
			v-else
			><slot
		/></span>
	</label>
</template>
