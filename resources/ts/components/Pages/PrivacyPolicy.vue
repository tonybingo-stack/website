<script setup lang="ts">
import GuestLayout from "@/components/Layouts/GuestLayout.vue"
defineLayout(GuestLayout)
defineProps({
	policy: String,
})
</script>

<template>
	<Head title="Privacy Policy" />

	<div class="font-sans text-gray-900 antialiased overflow-hidden" style="margin-top: 100px; margin-bottom: 100px;">
	  <div class="pt-6 pb-12 bg-gray-100">
		<div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
		  <div
			class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose"

			v-html="policy">
		  </div>
		</div>
	  </div>
	</div>
</template>
