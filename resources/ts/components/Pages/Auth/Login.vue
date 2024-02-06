<script setup lang="ts">
import AuthLayout from "@/components/Layouts/AuthLayout.vue"
import { LockClosedIcon } from "@heroicons/vue/24/solid"
import * as Yup from "yup"
import axios from "axios"
import { ref } from "vue"
import { Link, router } from "@inertiajs/vue3"

const form = ref({
	email: "",
	password: "",
	remember: false,
})

const submitting = ref(false)
const serverErrors = ref({})

const fields = ref([
	{
		label: "Email",
		name: "email",
		as: "input",
		visible: true,
		rules: Yup.string().required("Email is required").email("Must be a valid email"),
	},
	{
		label: "Password",
		name: "password",
		type: "password",
		as: "input",
		visible: true,
		rules: Yup.string().required("Password is required"),
	},
])

const onSubmit = async (values) => {
	submitting.value = true
	try {
		const response = await axios.post(route("login.store"), values)
		router.visit(route("dashboard"))
	} catch (error) {
		serverErrors.value = error.response.data
	} finally {
		submitting.value = false
	}
}

defineLayout(AuthLayout)
</script>

<template>
	<AuthenticationCard class="color">
		<template #logo>
			<img
				src="/resources/images/logo.svg"
				alt="Blob SVG"
				class="w-32 h-32 ml-25" />
		</template>

		<Form @submit="onSubmit">
			<div
				v-for="{ as, name, label, visible, ...attrs } in fields"
				:key="name">
				<FormField
					:name="name"
					:label="label"
					:as="as"
					:visible="visible"
					v-model="form[name] as any"
					v-bind="attrs" />
				<label class="label">
					<span
						class="label-text-alt text-red-500"
						v-show="serverErrors[name]"></span>
					<span
						class="label-text-alt text-red-500"
						v-show="serverErrors[name]"
						>{{ serverErrors[name] }}</span
					>
				</label>
			</div>
			<div class="flex justify-start space-x-4">
				<FormField
					name="remember"
					as="checkbox"
					v-model="form['remember']">
					<template #label>
						<div class="text-white text-sm">Remember Me</div>
					</template>
				</FormField>
			</div>

			<div class="flex items-center justify-end mt-4">
				<button
					type="submit"
					class="btn btn-primary ml-4 text-white"
					:disabled="submitting">
					<LockClosedIcon class="h-6 w-6 text-white" />
					Log in
				</button>
			</div>
		</Form>
	</AuthenticationCard>
</template>

<style scoped>
.color {
	background-color: #212121;
}
</style>
