<script setup lang="ts">
import anime from "animejs/lib/anime.es.js"
import { nextTick, onMounted, watchEffect } from "vue"
import { route } from "momentum-trail"

const parallaxSection = ref(null)
const parallaxTitle = ref(null)
const contentSection = ref(null)
const contentTitle = ref(null)
const contentText = ref(null)
const buttonWrapper = ref(null)
const animatedButton = ref(null)
const svgWrapper = ref(null)
const animatedText = ref([])

onMounted(async () => {
	await nextTick()

	const word = "Coding the Future".split("")
	let i = 0
	const typeInterval = setInterval(() => {
		animatedText.value.push(word[i])
		i++
		if (i >= word.length) {
			clearInterval(typeInterval)
		}
	}, 200)

	const updateParallax = () => {
		const offset = window.pageYOffset

		// Verifică dacă referințele sunt definite înainte de a le accesa
		if (parallaxSection.value && parallaxSection.value.style) {
			parallaxSection.value.style.backgroundPositionY = `${-offset * 0.3}px`
		}

		if (parallaxTitle.value && parallaxTitle.value.style) {
			parallaxTitle.value.style.transform = `translate(-50%, ${offset * 0.5}px)`
		}

		if (contentSection.value && contentSection.value.style) {
			const opacity = 1 - offset / 500
			contentSection.value.style.opacity = opacity > 0 ? opacity : 0
		}

		if (parallaxTitle.value && parallaxTitle.value.style && svgWrapper.value && svgWrapper.value.style) {
			// Scale parallax title and SVG
			const scale = 1.05 + offset / 1000
			parallaxTitle.value.style.transform = `translate(-50%, ${offset * 0.5}px) scale(${scale})`
			svgWrapper.value.style.transform = `scale(${scale})`
		}

		// Restul codului pentru updateParallax...
	}

	// Initial call to set parallax
	updateParallax()

	window.addEventListener("scroll", updateParallax)

	// Verifică dacă parallaxTitle.value este definit înainte de a încerca să accesezi proprietățile sale
	if (parallaxTitle.value && parallaxTitle.value.style) {
		anime({
			targets: parallaxTitle.value,
			opacity: [0, 1],
			translateY: [-200, 0],
			easing: "easeOutExpo",
			duration: 1000,
		})
	}

	// Verifică dacă contentTitle.value este definit înainte de a încerca să accesezi proprietățile sale
	if (contentTitle.value) {
		anime
			.timeline({ easing: "easeOutExpo", duration: 750 })
			.add({ targets: contentTitle.value, translateY: [-100, 0], opacity: [0, 1] })
	}

	// Verifică dacă contentText.value este definit înainte de a încerca să accesezi proprietățile sale
	if (contentText.value) {
		anime
			.timeline({ easing: "easeOutExpo", duration: 750 })
			.add({ targets: contentText.value, translateY: [100, 0], opacity: [0, 1] }, "-=600")
	}

	// Verifică dacă animatedButton.value este definit înainte de a încerca să accesezi proprietățile sale
	if (animatedButton.value) {
		anime
			.timeline({ easing: "easeOutExpo", duration: 750 })
			.add({ targets: animatedButton.value, scale: [0, 1], easing: "easeOutElastic(1, .8)" }, "-=600")
	}

	// Verifică dacă buttonWrapper.value și buttonWrapper.value.children sunt definite înainte de a încerca să accesezi proprietățile lor
	if (buttonWrapper.value && buttonWrapper.value.children) {
		anime({
			targets: buttonWrapper.value.children,
			opacity: [0, 1],
			delay: (el, i) => i * 200,
		})
	}
})
const smoothScrollTo = (elementId: string) => {
	const element = document.getElementById(elementId)
	if (element) {
		element.scrollIntoView({ behavior: "smooth" })
	}
}
</script>
<template>
	<div
		ref="parallaxSection"
		class="parallax-section flex">
		<h1
			ref="parallaxTitle"
			class="parallax-title w-full text-center">
			<!-- Primul rând de text -->
			<span class="word-container font-bold  text-uppercase">
				<span
					v-for="letter in animatedText"
					:key="letter"
					class="animated-letter">
					{{ letter }}
				</span>
			</span>
			<span class="cursor">|</span>

			<span class="word-container2 second-line">
				We specialize in enhancing web performance with smart, efficient coding practices. Our team is dedicated to delivering top-tier solutions that are not only fast and reliable but also pave the way for future advancements.
			</span>

			<!-- Butoane -->
			<div class="button-wrapper">
				<button class="btn orange-button text-lg" @click="() => smoothScrollTo('process-section')">About</button>
				<button
					class="btn black-button text-lg" @click="() => smoothScrollTo('contact-section')">
					Contact
				</button>
			</div>
		</h1>

	</div>
</template>

<style scoped>
.animated-text {
	display: inline-block;
}
.word-container {
	background-image: linear-gradient(90deg, #1d1d1d, #ee5c14);
	background-size: 100%;
	-webkit-background-clip: text;
	-moz-background-clip: text;
	-webkit-text-fill-color: transparent;
	-moz-text-fill-color: transparent;
	color: transparent !important;
	/* animation: fadeIn 3s; */
	text-shadow: none;
}
.word-container2 {
	background-image: linear-gradient(90deg, #585655, #585655);
	background-size: 100%;
	-webkit-background-clip: text;
	-moz-background-clip: text;
	-webkit-text-fill-color: transparent;
	-moz-text-fill-color: transparent;
	color: transparent !important;
	/* animation: fadeIn 3s; */
	text-shadow: none;
	margin-left: 10rem;
	margin-right: 10rem;
}
@keyframes fadeIn {
	0% {
		opacity: 0;
		transform: translateY(30px);
	}
	100% {
		opacity: 1;
		transform: translateY(0);
	}
}
.landing-page {
	text-align: center;
}

.button-wrapper {
	display: flex;
	justify-content: center;
	align-items: center;
	margin-top: 6rem;
}
.smaller-text {
	font-size: 1.5rem;
}
.second-line {
	margin-top: 1.5rem;
	display: block;
	font-size: 1.5rem;
}

.orange-button {
	background-color: #ee5c14;
	color: #fff;
	padding-left: 3rem;
	padding-right: 3rem;
}



.black-button {
	background-color: #1d1d1d;
	color: #fff;
	margin-left: 2rem;
	padding-left: 3rem;
	padding-right: 3rem;
}

.parallax-section {
	height: 50vh;
	background-size: cover;
	background-attachment: fixed;
	background-position: center;
	position: relative;
	overflow: hidden;
	flex-direction: column;
	background-color: rgb(241, 241, 241);
}

.parallax-image {
	position: absolute;
	width: 100%;
	top: 0;
	left: 0;
}

.parallax-title,
.content-section {
	position: absolute;
	align-self: center;
	left: 50%;
	transform: translateX(-50%);
	color: #000000;
	text-shadow: 2px 2px 4px #000;
}

.parallax-title {
	top: 20%;
	font-size: 3rem;
	margin-top: 5rem; 
}

.content-section {
	top: 50%;
	/* background-color: rgba(0, 0, 0, 0.6);  semi-transparent background */
	/* padding: 20px; */
	/* border-radius: 10px; */
	width: 80%; /* Adjust as needed for desired card width */
	max-width: 500px; /* Maximum width for the card */
	text-align: center;
	align-items: center;
	flex-direction: column;
	display: flex;
	justify-content: center;
}

.button-wrapper {
	display: flex;
	margin-top: 20px;
}
.btn:hover {
	transform: translateY(-5px);
	box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.cursor {
	animation: blink 1s infinite;
}

@keyframes blink {
	0% {
		opacity: 0;
	}
	50% {
		opacity: 1;
	}
	100% {
		opacity: 0;
	}
}
@media screen and (max-width: 768px) {
	.parallax-title {
    font-size: 2rem; /* Increase font size for better readability */
    line-height: 1.2; /* Optional: Adjust line height for better readability */
	margin-top: 2rem; 
  }

  .word-container2 {
    font-size: 1.2rem; /* Increase font size for the second line */
    line-height: 1.4; /* Improve line spacing */
	margin-left: 2rem;
	margin-right: 2rem;
  }

  .orange-button {
	padding-left: 2rem;
	padding-right: 2rem;
}



.black-button {
	padding-left: 2rem;
	padding-right: 2rem;
}



  .button-wrapper {
    flex-direction: column; /* Stack buttons vertically on small screens */
    align-items: center;
	margin-top: 2rem;
  }

  .btn {
    margin: 10px 0; /* Add margin between stacked buttons */
  }

  .content-section {
    width: 90%; /* Increase width percentage for better use of space on small screens */
  }

  .parallax-section {
	height: 75vh;
	background-size: cover;
	background-attachment: fixed;
	background-position: center;
	position: relative;
	overflow: hidden;
	flex-direction: column;
	background-color: rgb(241, 241, 241);
}


}
</style>
