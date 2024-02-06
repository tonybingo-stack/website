<script setup lang="ts">
import { EnvelopeIcon } from "@heroicons/vue/24/solid"
import axios from "axios"
import { useRecaptchaProvider, Checkbox } from "vue-recaptcha"

useRecaptchaProvider()

const name = ref("")
const email = ref("")
const message = ref("")
const recaptchaValue = ref(null)
const userValidation = ref(false)

const sendEmail = async () => {
	userValidation.value = true
	if (!recaptchaValue.value) {
		return
	}
	const payload = {
		name: name.value,
		email: email.value,
		message: message.value,
		"g-recaptcha-response": recaptchaValue.value,
	}
	try {
		const response = await axios.post("/send-email", payload)
		userValidation.value = false
	} catch (error) {
		console.log("Email sending failed", error)
	}
}
</script>
<template>
	<div>
		<div
			id="contact-section"
			class="contact-section mini-spacer back mt-[-100px] py-16">
			<v-container>
				<!-- -----------------------------------------------
            Start Contact Form
        ----------------------------------------------- -->
				<v-row justify="center">
					<v-col
						cols="12"
						md="8">
						<div>
							<h4>
								<div class="chat chat-start">
									<div class="chat-bubble chat-bubble-accent font-bold">Get in touch with us!</div>
								</div>
								<div class="chat chat-end">
									<div class="chat-bubble chat-bubble-info font-bold">That would be great!</div>
								</div>
							</h4>
							<form @submit.prevent="sendEmail">
								<v-row class="mt-7">
									<v-col
										cols="12"
										md="6"
										class="py-0">
										<v-text-field
											label="Name"
											variant="outlined"
											color="#EE5C14"
											v-model="name"
											placeholder="Name"
											required
											class="input-field"></v-text-field>
									</v-col>
									<v-col
										cols="12"
										md="6"
										class="py-0">
										<v-text-field
											label="Email"
											variant="outlined"
											type="email"
											v-model="email"
											color="#EE5C14"
											placeholder="Email"
											required
											class="input-field"></v-text-field>
									</v-col>
									<v-col
										cols="12"
										class="py-0">
										<v-textarea
											name="message"
											color="#EE5C14"
											variant="outlined"
											v-model="message"
											label="Message"
											rows="3"
											required></v-textarea>
									</v-col>
								</v-row>
								<v-row>
									<v-col
										cols="12"
										md="6"
										class="py-0">
										<label class="label">
											<span class="label-text text-primary">{{
												userValidation ? "Please click the checkbox" : ""
											}}</span>
										</label>
										<!-- <Checkbox v-model="recaptchaValue"> </Checkbox> -->
									</v-col>
								</v-row>
								<v-row class="mt-7">
									<v-col
										cols="12"
										md="6"
										class="py-0">
										<button class="btn btn-primary btn-wide text-white">
											Send
											<EnvelopeIcon class="h-6 w-6 text-white" />
										</button>
									</v-col>
								</v-row>
							</form>
						</div>
					</v-col>
				</v-row>
				<!-- -----------------------------------------------
            End Contact Form
        ----------------------------------------------- -->
			</v-container>
		</div>
	</div>
</template>

<style>
.chat-start .chat-bubble {
	background-color: #ee5c14;
	color: rgb(20, 18, 18);
}

.chat-end .chat-bubble {
	background-color: #212121;
	color: rgb(245, 238, 238);
}

.back {
	background-color: rgb(241, 241, 241);
	height: 50vh;
}
</style>
