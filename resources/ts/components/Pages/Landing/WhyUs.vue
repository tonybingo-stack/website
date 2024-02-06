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
		id="why-section"
		class="container-fluid mx-auto px-5">
		<section class="py-16 pt-16">
			<div>
				<div class="card text-neutral-content">
					<h2 class="card-title font-bold text-3xl text-base-100 mb-8">Why Us?</h2>

					<!-- Structură pentru linia de proiecte -->
					<div class="flex md:flex-row flex-col">
						<!-- Mock-up în stânga -->
						<div class="w-full pr-4 ml-4 md:w-1/2 md:pr-10 md:ml-10">
							<div class="mockup-code">
								<pre
									data-prefix="$"
									class="mockup-code-text"><code>npm run build</code></pre>
								<pre
									data-prefix=">"
									class="mockup-code-text text-warning"><code>Building next-level solution...</code></pre>
								<pre
									data-prefix=">"
									class="mockup-code-text bg-success text-success-content"><code>Deployed!</code></pre>
							</div>
						</div>

						<!-- Descriere în dreapta -->
						<div class="mr-10 text-base-100 font-semibold color w-full">
							<p class="card-text w-full">
								Transforming digital landscapes through visionary coding, we are Artificially, where every line of code
								is a symphony of innovation, elevating web performance to unparalleled heights.
							</p>
						</div>
					</div>
					<!-- Sfârșit: Structură pentru linia de proiecte -->
				</div>
			</div>
		</section>
	</div>
	<!-- Project Section End -->
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
.mockup-code-text {
	font-size: 1em;
}

#why-section {
	background: linear-gradient(to bottom, rgb(241, 241, 241) 50%, #212121 50%);
	height: 60vh;
	display: flex;
	align-items: center; /* Vertical centering */
	justify-content: center; /* Horizontal centering */
}

.card {
	height: 30vh; /* Ajustează înălțimea în funcție de preferințe */
	width: 80vh; /* Lățimea cardului - 90% din lățimea disponibilă a ecranului */
	flex-direction: column;
	justify-content: center; /* Ajustează pentru centrare verticală */
	align-items: center; /* Ajustează pentru centrare orizontală */
	background-color: #ee5c14;
}

@media screen and (max-width: 768px) {
    .card {
        width: 85vw; /* Adjust the width for smaller screens */
        height: 30vh; /* Make height auto to accommodate content */
        padding: 2rem; /* Add some padding */
    }

	.mockup-code-text {
	font-size: 0.8em;
	}


	.card-text {
		font-size: 0.5rem;
	}

    .card-title {
        font-size: 1rem; /* Reduce font size */
    }

    .mockup-code {
		width: 2rem;
    }

    .fade-in-up, .zoom-in, li {
        transition: opacity 0.3s, transform 0.3s;
        animation-duration: 0.3s; /* Speed up animations */
    }

    /* Stack flex items vertically in the project structure */
    .flex.md:flex-row {
        flex-direction: column;
    }

    .md:w-1 {
        width: 100%; /* Full width for mock-up and description */
    }
}
</style>
