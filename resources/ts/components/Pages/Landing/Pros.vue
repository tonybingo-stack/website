<script setup lang="ts">
import { onMounted, onUnmounted, ref } from "vue"
import axios from "axios"
import { Carousel, Slide } from "vue-carousel"
const isOpen = ref({ index: null })
let openIndex = null

const pros = ref([])

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
		const response = await axios.get("/api/pros")
		pros.value = response.data

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
	<div
		id="pro-section"
		class="flex justify-center items-center py-20">
		<section class="py-20 pt-18">
			<h2 class="text-xl font-theme-heading font-medium text-center font-semibold color mb-4 uppercase">Pros</h2>
			<h2 class="text-3xl md:text-4xl font-theme-heading font-medium text-center text-white font-bold mb-20">
				Some of our advantages
			</h2>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:w-3/5 mx-auto">
				<div
					v-for="(pro, index) in pros"
					:key="index">
					<img
						class="w-12 h-13 mb-2"
						src="/resources/images/icon1.svg"
						alt="Icon" />
					<h3 class="sc-95f3c3a0-5 gTAmEA font-bold text-xl text-white mb-2">{{ pro.word }}</h3>
					<p class="sc-95f3c3a0-6 gSVomU pro_color">{{ pro.sentence }}</p>
				</div>
			</div>
		</section>
	</div>
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

.pro_color {
	color: rgb(188, 182, 182);
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

#pro-section {
	background-color: #212121;
}
.color {
	color: #ee5c14;
}
</style>
