<script setup lang="ts">
import { onMounted, onUnmounted, ref } from "vue"
import axios from "axios"
import { Carousel, Slide } from "vue-carousel"
const isOpen = ref({ index: null })
let openIndex = null

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

onMounted(async () => {
	try {
		const response = await axios.get("/api/projects")
		projects.value = response.data.map((project) => ({
			...project,
			image: `/resources/images/project${project.id}.svg`,
		}))

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
		id="projects-section"
		class="container-fluid mx-auto px-5 text-center">
		<section class="py-20 pt-18">
			<h2 class="text-xl font-theme-heading font-medium text-center font-extrabold color mb-4 uppercase">Projects</h2>
			<h2 class="text-3xl md:text-4xl font-theme-heading font-medium text-center text-black font-bold">
				Take a look at our work
			</h2>
			<div class="carousel md:w-3/5 mx-auto">
				<div
					v-for="(project, index) in projects"
					:key="index"
					:id="'item' + (index + 1)"
					class="carousel-item w-full flex items-center justify-between">
					<div class="flex justify-center items-center w-2/5 pl-20">
						<img
							src="/resources/images/project3.svg"
							alt="Project Image" />
					</div>
					<div class="flex-grow text-center w-1/2 pl-6">
						<h3 class="text-2xl font-bold">{{ project.title }}</h3>
						<p class="text-md project_color font-semibold mt-3">{{ project.description }}</p>
					</div>
				</div>
			</div>
			<div class="flex justify-center w-full py-2 gap-2">
				<a
					href="#item1"
					class="btn btn-xs"
					>1</a
				>
				<a
					href="#item2"
					class="btn btn-xs"
					>2</a
				>
				<a
					href="#item3"
					class="btn btn-xs"
					>3</a
				>
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

#projects-section {
	background-color: rgb(241, 241, 241);
}

.project_color {
	color: rgb(74, 73, 73);
}

.color {
	color: #ee5c14;
}
</style>
