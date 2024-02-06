<script setup lang="ts">
const drawer = ref(null)
import { Link, router } from "@inertiajs/vue3"
import { HomeIcon } from "@heroicons/vue/24/solid"
import ApplicationLogo from "../ApplicationLogo.vue"
import CommonHeader from "./CommonHeader.vue"
const isLoggingOut = ref(false)

function isRouteActive(routeName: string) {
	return window.location.pathname === routeName
}

async function logout() {
	if (isLoggingOut.value) {
		return
	}

	isLoggingOut.value = true

	try {
		router.visit(route("login.destroy"))
		isLoggingOut.value = false
	} catch (error) {
		isLoggingOut.value = false // Reset the flag on error as well
	}
}
</script>
<template>
	<div>
		<CommonHeader />
	</div>
	<v-navigation-drawer
		class="bg-base-200"
		v-model="drawer">
		<div class="sidebar-header flex items-center justify-center py-4">
			<div class="inline-flex">
				<a
					href="#"
					class="inline-flex flex-row items-center">
					<ApplicationLogo />
				</a>
			</div>
		</div>
		<ul class="menu py-4">
			<VListItem
				class="px-5 nav-item mb-2 focus:outline-none hover:bg-base-100 text-white hover:text-primary border-l-4 border-transparent hover:border-primary pr-6"
				:class="{ 'bg-base-100': isRouteActive('/dashboard') }">
				<Link
					class="py-0 active text-white relative flex flex-row items-center h-11"
					:href="route('dashboard')">
					<span class="inline-flex justify-center items-center">
						<HomeIcon class="h-5 w-5 text-white"></HomeIcon>
					</span>
					<span class="ml-2 text-sm tracking-wide truncate">Home</span>
				</Link>
			</VListItem>
		</ul>
	</v-navigation-drawer>
</template>
