<script setup lang="ts">
const drawer = ref(null)
const smoothScrollTo = (elementId: string) => {
	const element = document.getElementById(elementId)
	if (element) {
		element.scrollIntoView({ behavior: "smooth" })
	}
}
</script>
<template>
	<div>
		<v-app-bar
			class="app-header"
			absolute
			flat
			elevate-on-scroll>
			<v-container class="fill-height">
				<v-toolbar class="bg-transparent d-flex align-center">
					<!-- Adaugă logo-ul în stânga -->
					<div
						class="logo mr-auto d-lg-block"
						style="margin-top: 20px">
						<Link :href="route('welcome')">
						<img
							src="/resources/images/logo.svg"
							alt="Logo"
							width="85" />
						</Link>
					</div>

					<ul class="d-flex navbar-nav ml-auto">
						<li class="nav-item ml-2">
							<a
								class="nav-link cursor-pointer border-b-2 border-transparent hover:border-b-2 hover:border-primary transition duration-500 custom_text"
								@click="() => smoothScrollTo('process-section')"
								>About</a
							>
						</li>
						<li class="nav-item ml-2 d-md-flex d-sm-none">
							<a
								class="nav-link cursor-pointer border-b-2 border-transparent hover:border-b-2 hover:border-primary transition duration-500 custom_text"
								@click="() => smoothScrollTo('projects-section')"
								>Projects</a
							>
						</li>
						<li class="nav-item ml-2 d-md-flex d-sm-none">
							<a
								class="nav-link cursor-pointer border-b-2 border-transparent hover:border-b-2 hover:border-primary transition duration-500 custom_text"
								@click="() => smoothScrollTo('contact-section')"
								>Contact</a
							>
						</li>
					</ul>

					<v-app-bar-nav-icon
						width="40"
						class="d-md-none d-sm-flex ml-auto drawer-icon text-black mr-0"
						@click.stop="drawer = !drawer">
					</v-app-bar-nav-icon>
				</v-toolbar>
			</v-container>
		</v-app-bar>
	</div>
</template>

<style>
.custom-text {
	color: black;
}
</style>
