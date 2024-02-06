<script setup lang="ts">
import { onMounted, onUnmounted, ref } from "vue"
import axios from "axios"

const testimonials = ref([])

const observer = ref(null)
const elementsToAnimate = ref([])

const handleIntersection = (entries, observer) => {
	entries.forEach((entry) => {
		// your intersection observer logic
	})
}

onMounted(async () => {
	try {
		const response = await axios.get("/api/testimonials")
		testimonials.value = response.data

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
	<!-- Testimonials Section Start -->
	<!-- <div
		id="testimonials-section"
		class="container-fluid mx-auto px-5 text-center">
		<section class="py-20 pt-0">
			<div class="h-96 carousel rounded-box">
				<div
					v-for="(testimonial, index) in testimonials"
					:key="index"
					class="carousel-item w-full flex justify-center items-center">
					<div class="text-center">
						<h3>
							<div class="avatar">
								<div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
									<img src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
								</div>
							</div>
						</h3>
						<h3 class="text-2xl font-bold">{{ testimonial.name }}</h3>
						<p class="text-md font-semibold mt-2 rev_color">{{ testimonial.review }}</p>
						<div class="rating mt-3">
							<input
								type="radio"
								name="rating-2"
								class="mask mask-star-2 bg-orange-400" />
							<input
								type="radio"
								name="rating-2"
								class="mask mask-star-2 bg-orange-400"
								checked />
							<input
								type="radio"
								name="rating-2"
								class="mask mask-star-2 bg-orange-400" />
							<input
								type="radio"
								name="rating-2"
								class="mask mask-star-2 bg-orange-400" />
							<input
								type="radio"
								name="rating-2"
								class="mask mask-star-2 bg-orange-400" />
						</div>
					</div>
				</div>
			</div>
		</section>
	</div> -->
	<!-- Testimonials Section End -->
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

#testimonials-section {
	background-color: rgb(241, 241, 241);
	height: 35vh;
}

.rev_color {
	color: rgb(76, 75, 75);
}
</style>
