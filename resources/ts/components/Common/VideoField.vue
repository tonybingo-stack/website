<script setup lang="ts">
const fileInput = ref(null)

const emit = defineEmits()
const {
	modelValue: modelValueProp,
	errorMessage: errorMessage,
	isValid: isValid,
} = defineProps<{
	modelValue: any
	errorMessage: string | null
	isValid: boolean
}>()

const handleFileChange = (event: Event) => {
	const target = event.target as HTMLInputElement
	if (target.files) {
		emit("update:modelValue", target.files[0])
	}
}
</script>
<template>
	<input
		type="file"
		class="file-input file-input-ghost file-input-primary text-white w-full"
		:class="{ 'border-error': modelValue && !!errorMessage, 'border-success': isValid }"
		ref="fileInput"
		@change="handleFileChange" />
</template>
