<script setup lang="ts">
import { watchDebounced } from "@vueuse/core"
import axios from "axios"
import { onBeforeMount, ref } from "vue"
import { onMounted, watch } from "vue"
import TextInput from "./TextInput.vue"
import { PlusCircleIcon, XCircleIcon, TrashIcon, PencilIcon, CheckCircleIcon } from "@heroicons/vue/24/solid"
import { useForm } from "vee-validate"
import { route, current } from "momentum-trail"

const props = defineProps({
	headers: Array,
	fields: Array,
	table: String,
	api: String,
	singular: String,
})
const paginator = ref({})
const serverItems = computed(() => paginator.value.data)
const totalItems = computedEager(() => paginator.value.total || 0)
const loading = ref(false)
const submitting = ref(false)
const search = ref()
const dialog = ref(false)
const createMode = ref(false)

const form = ref({})

const generateFormData = () => {
	props.fields.forEach((field, index) => {
		const type = field.as
		// Initialize form field based on data type
		switch (type) {
			case "input":
				form.value[field.name] = ""
				break
			case "textarea":
				form.value[field.name] = ""
				break
			case "number":
				form.value[field.name] = 0
				break
			case "autocomplete":
				form.value[field.name] = 0
				break
			case "date":
				form.value[field.name] = dayjs().utc().format("YYYY-MM-DDTHH:mm")
				break
			case "video":
				form.value[field.name] = null
				break
			case "tags":
				form.value[field.name] = []
				break
			default:
				form.value[field.name] = 0
				break
		}
	})
	console.log("initial form", form.value)
}

const { resetForm } = useForm()

const openCreateDialog = () => {
	generateFormData()
	createMode.value = true
	dialog.value = true
}

const closeDialog = () => {
	dialog.value = false
}

const hasFields = computed(() => props.fields?.length > 0)

const editResource = (resource) => {
	dialog.value = true
	createMode.value = false
	const regex = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{6}Z$/
	generateFormData()
	Object.keys(form.value).forEach((field) => {
		if (resource.hasOwnProperty(field)) {
			form.value[field] = resource[field]
			if (regex.test(resource[field])) {
				console.log("yes date", resource[field])
				form.value[field] = dayjs(resource[field]).utc().format("YYYY-MM-DDTHH:mm")
				console.log("ch date from ", resource[field], "to ", form.value[field])
			}
		}
	})
	form.value.id = resource.id
	console.log("edit form", form.value)
	console.log("act res", resource)
}

const deleteResource = (resource) => {
	const confirmDelete = window.confirm("Are you sure you want to delete this item?")
	if (confirmDelete) {
		form.value.id = resource.id
		const paramName = `${props.table?.slice(0, -1)}`
		axios.delete(route(`${props.api}.destroy`, { [paramName]: form.value.id }), form.value).then(() => {
			generateFormData()
			fetchData()
		})
	}
}
const onSubmit = () => {
	submitting.value = true
	console.log("form is", form.value)
	const formData = new FormData()

	// Assuming 'form' is your reactive form object
	for (const [key, val] of Object.entries(form.value)) {
		if (val !== null && val.value instanceof File) {
			formData.append(key, val.value)
		} else if (val !== null && val instanceof Array) {
			formData.append(key, JSON.stringify(val))
		} else {
			formData.append(key, val)
		}
	}
	// Log FormData entries to console for debugging
	// for (const [key, val] of formData.entries()) {
	//     console.log(key, val);
	// }

	if (createMode.value) {
		axios
			.post(route(`${props.api}.store`), formData, {
				headers: {
					"Content-Type": "multipart/form-data",
				},
			})
			.then(() => {
				closeDialog()
				generateFormData()
				fetchData()
			})
			.finally(() => (submitting.value = false))
	} else {
		const paramName = `${props.singular?.toLocaleLowerCase()}`
		formData.append("_method", "PUT")
		axios
			.post(route(`${props.api}.update`, { [paramName]: form.value.id }), formData, {
				headers: {
					"Content-Type": "multipart/form-data",
				},
			})
			.then(() => {
				closeDialog()
				generateFormData()
				fetchData()
			})
			.finally(() => (submitting.value = false))
	}
}
const options = ref({
	sortBy: [],
	page: 1,
	itemsPerPage: 10,
})

const store = defineStore("data-server-store", () => {
	const hash = ref(dayjs().valueOf())
	function refresh() {
		hash.value = dayjs().valueOf()
	}
	return { hash, refresh }
})

if (import.meta.hot != null) {
	import.meta.hot.accept(acceptHMRUpdate(store, import.meta.hot))
}

const fetchData = () => {
	loading.value = true
	axios
		.get(route(`${props.api}.index`), {
			params: {
				paginate: true,
				...(search.value ? { qry: search.value } : {}),
				...options.value,
			},
		})
		.then((response) => {
			console.log("r", response.data)
			paginator.value = response.data
			loading.value = false
		})
}

watch(() => store.hash, fetchData)
watch(options, fetchData)
watchDebounced(search, fetchData, { debounce: 300 })
onBeforeMount(() => {
	fetchData()
	generateFormData()
})

const slots = defineSlots()
</script>

<template>
	<v-row v-if="hasFields">
		<v-col cols="10">
			<TextInput
				class="w-full border border-primary-custom"
				v-model="search"
				placeholder="Search" />
		</v-col>
		<v-col cols="2">
			<button
				class="btn btn-primary"
				@click="openCreateDialog">
				<PlusCircleIcon class="h-6 w-6 text-white" />
				New Item
			</button>
		</v-col>
	</v-row>

	<v-dialog
		v-model="dialog"
		max-width="500px">
		<v-card class="rounded">
			<v-card-title>{{ createMode ? `Create ${props.singular}` : `Edit ${props.singular}` }}</v-card-title>
			<Form
				@submit="onSubmit"
				validate-on-mount>
				<v-card-text>
					<div
						v-for="{ as, name, label, createOnly, ...attrs } in props.fields"
						:key="name">
						<FormField
							v-if="!(createOnly && !createMode)"
							:name="name"
							:label="label"
							:as="as"
							v-model="form[name] as any"
							v-bind="attrs" />
					</div>
				</v-card-text>
				<v-card-actions class="justify-end">
					<button
						class="btn btn-error text-white"
						@click.prevent="closeDialog">
						<XCircleIcon class="h-6 w-6 text-white" />
						Cancel
					</button>
					<button
						type="submit"
						class="btn mx-3 my-2 text-white"
						:class="createMode ? 'btn-primary ' : 'btn-warning'"
						:disabled="submitting">
						<span
							v-show="submitting"
							class="loading loading-spinner"></span>
						<PlusCircleIcon
							v-if="createMode"
							v-show="!submitting"
							class="h-6 w-6 text-white" />
						<CheckCircleIcon
							v-else
							v-show="!submitting"
							class="h-6 w-6 text-white" />
						{{ createMode ? `Create` : `Update` }}
					</button>
				</v-card-actions>
			</Form>
		</v-card>
	</v-dialog>
	<v-divider
		v-if="hasFields"
		class="my-4 mx-4"></v-divider>
	<VDataTableServer
		:items-length="totalItems"
		:loading="loading"
		item-value="name"
		:headers="props.headers as any"
		:items="serverItems"
		class="elevation-1 table rounded bg-primary mt-2"
		:page="options.page"
		v-model:options="options"
		:sort-by="options.sortBy"
		:items-per-page="options.itemsPerPage"
		density="comfortable"
		loading-text="Loading...">
		<template
			v-for="(_, slot) of slots"
			#[slot]="scope">
			<slot
				:name="slot"
				v-bind="scope || {}" />
		</template>
		<template v-slot:item.actions="{ item }">
			<button
				type="submit"
				class="btn btn-warning btn-sm mx-1 text-white"
				:disabled="submitting"
				@click="editResource(item)">
				<PencilIcon class="h-6 w-6 text-white" />
				<!-- Edit -->
			</button>
			<button
				type="submit"
				class="btn btn-error btn-sm mx-1 text-white"
				:disabled="submitting"
				@click="deleteResource(item)">
				<TrashIcon class="h-6 w-6 text-white" />
				<!-- Delete -->
			</button>
		</template>
	</VDataTableServer>
</template>
