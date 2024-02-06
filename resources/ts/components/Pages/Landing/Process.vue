<script setup lang="ts">
import { onMounted, onUnmounted, ref } from "vue"
import axios from "axios"

const projects = ref([])

const header = ref("Header Title")
const observer = ref(null)

const elementsToAnimate = ref([])

const handleIntersection = (entries, observer) => {
	entries.forEach((entry) => {
		if (entry.isIntersecting) {
			entry.target.classList.remove("hidden-element")
			entry.target.style.animation = ""
			if (entry.target.classList.contains("fade-in-up")) {
				entry.target.classList.remove("fade-in-up") // force reflow for re-triggering the animation
				void entry.target.offsetWidth
				entry.target.classList.add("fade-in-up")
			}
		} else {
			entry.target.classList.add("hidden-element")
			entry.target.classList.remove("fade-in-up")
		}
	})
}

const redirectToProject = () => {
	window.location.href = route("project")
}

onMounted(async () => {
	try {
		const response = await axios.get("/api/projects")
		projects.value = response.data

		observer.value = new IntersectionObserver(handleIntersection, {
			rootMargin: "0px 0px -10px 0px",
			threshold: 0.4,
		})

		elementsToAnimate.value = document.querySelectorAll(".hidden-element")
		elementsToAnimate.value.forEach((element) => {
			observer.value.observe(element)
		})
	} catch (error) {
		console.error(error)
	}
})

onUnmounted(() => {
	if (observer.value) {
		elementsToAnimate.value.forEach((element) => {
			observer.value.unobserve(element)
		})
	}
})
</script>

<template>
	<!-- Projects Section Start -->
	<div
		id="process-section"
		class="container-fluid mx-auto px-5">
		<section class="py-20 pt-0">
			<div class="w-4/5 md:w-3/5 mx-auto">
				<h3 class="text-xl font-theme-heading font-extrabold text-center color mb-4 uppercase">Process</h3>
				<h3 class="text-3xl md:text-4xl font-theme-heading font-medium text-center text-white">How Is It Done?</h3>
				<div class="grid items-center gap-20 md:grid-cols-5">
					<article class="md:col-span-2">
						<div
							class="flex items-center justify-center w-12 h-12 text-xl font-bold circle-color border border-gray-600 rounded-full shadow-xl font-display border-opacity-40">
							1
						</div>

						<h2 class="mt-6 text-2xl font-bold tracking-tighter md:text-4xl font-display text-white">
							Start a new project
						</h2>

						<p class="mt-2 text-base text-gray-300 md:text-xl">
							Register and create menus, fields and relationships online, install modules. No coding required. Test your
							panel on our server.
						</p>
					</article>

					<div class="flex flex-col md:col-span-3">
						<img
							src="/resources/images/step1.svg"
							alt="Step 1"
							class="w-full h-auto rounded-t-xl" />
					</div>
				</div>

				<div class="grid items-center gap-20 md:grid-cols-5">
					<div class="flex flex-col h-full md:col-span-3">
						<img
							src="/resources/images/step2.svg"
							alt="Step 2"
							class="w-full md:w-2/3 h-auto rounded-t-xl" />
					</div>

					<article class="md:col-span-2">
						<div
							class="flex items-center justify-center w-12 h-12 text-xl font-bold circle-color border border-gray-600 rounded-full shadow-xl font-display border-opacity-40">
							2
						</div>

						<h2 class="mt-6 text-2xl font-bold tracking-tighter md:text-4xl font-display text-white">Step 2</h2>

						<p class="mt-2 text-base text-gray-300 md:text-xl">
							Register and create menus, fields and relationships online, install modules. No coding required. Test your
							panel on our server.
						</p>
					</article>
				</div>

				<div class="grid items-center gap-20 md:grid-cols-5">
					<article class="md:col-span-2">
						<div
							class="flex items-center justify-center w-12 h-12 text-xl font-bold circle-color border border-gray-600 rounded-full shadow-xl font-display border-opacity-40">
							3
						</div>

						<h2 class="mt-6 text-2xl font-bold tracking-tighter md:text-4xl font-display text-white">Step 3</h2>

						<p class="mt-2 text-base text-gray-300 md:text-xl">
							Register and create menus, fields and relationships online, install modules. No coding required. Test your
							panel on our server.
						</p>
					</article>

					<div class="flex flex-col md:col-span-3">
						<img
							src="/resources/images/step3.svg"
							alt="Step 1"
							class="w-full h-auto rounded-t-xl" />
					</div>
				</div>

				<div class="grid items-center gap-20 md:grid-cols-5">
					<div class="flex flex-col h-full md:col-span-3">
						<img
							src="/resources/images/step4.svg"
							alt="Step 2"
							class="w-full md:w-2/3 h-auto rounded-t-xl" />
					</div>

					<article class="md:col-span-2">
						<div
							class="flex items-center justify-center w-12 h-12 text-xl font-bold circle-color border border-gray-600 rounded-full shadow-xl font-display border-opacity-40">
							4
						</div>

						<h2 class="mt-6 text-2xl font-bold tracking-tighter md:text-4xl font-display text-white">Step 4</h2>

						<p class="mt-2 text-base text-gray-300 md:text-xl">
							Register and create menus, fields and relationships online, install modules. No coding required. Test your
							panel on our server.
						</p>
					</article>
				</div>
			</div>
		</section>
	</div>
	<!-- project Section End -->
</template>
<style scoped>
@keyframes fadeInUp {
	from {
		opacity: 0;
		transform: translateY(20px);
	}
	to {
		opacity: 1;
		transform: translateY(0);
	}
}

@keyframes zoomIn {
	from {
		transform: scale(0.95);
	}
	to {
		transform: scale(1);
	}
}

.fade-in-up {
	animation: fadeInUp 0.5s forwards;
}

.zoom-in {
	animation: zoomIn 0.5s forwards;
}

/* Staggered delay for list items */
li:nth-child(1) .fade-in-up {
	animation-delay: 0.3s;
}
li:nth-child(2) .fade-in-up {
	animation-delay: 0.5s;
}
li:nth-child(3) .fade-in-up {
	animation-delay: 0.7s;
}
li:nth-child(4) .fade-in-up {
	animation-delay: 0.9s;
}

.hidden-element {
	opacity: 0;
	transform: translateY(20px);
}
.fade-in-up,
.zoom-in,
li {
	transition:
		opacity 0.5s,
		transform 0.5s;
}

#process-section {
	background-color: #212121;
}

.circle-color {
	background-color: #ee5c14;
}

.color {
	color: #ee5c14;
}
</style>
