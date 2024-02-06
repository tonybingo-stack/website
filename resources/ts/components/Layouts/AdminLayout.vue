<script setup lang="ts"></script>

<template>
	<VApp class="bg-base-100">
		<AdminHeader />
		<VMain>
			<slot />
		</VMain>
		<Footer />
	</VApp>
</template>
