<script setup lang="ts">
import { watchDebounced } from "@vueuse/core"
import { Field, ErrorMessage, useField } from "vee-validate"
import { onBeforeMount } from "vue"
import { watch } from "vue"
import { onMounted } from "vue"

interface FormProps {
	rules?: String
	name: String
	type?: string | undefined
	label?: String
	as: string
	visible?: Boolean
	foreign?: string | undefined
	successMessage?: string | undefined
}
const props = defineProps<FormProps>()
const dateValue = ref(null)

const {
	value: inputValue,
	errorMessage,
	handleBlur,
	handleChange,
	meta,
} = useField(props.name, props.rules, {
	syncVModel: true,
})

watch(inputValue, () => {
	if (props.as === "date") {
		dateValue.value = inputValue.value
	}
	if (props.as === "checkbox") {
		inputValue.value = inputValue.value === true // Convert to boolean
	}
})

watch(dateValue, (newDate) => {
	inputValue.value = dayjs(newDate).format("YYYY-MM-DDTHH:mm")
})

const handleSelectOption = (option: { id: number }) => {
	console.log("id ch", option.id)
	inputValue.value = option.id
}

const handleSelectedTags = (tags: Array) => {
	console.log("selected tags", tags)
	inputValue.value = tags
}

console.log(props)
</script>

<template>
	<Field :name="props.name">
		<slot
			name="label"
			v-if="$slots.label">
			<slot name="label" />
		</slot>
		<InputLabel
			:for="props.name"
			v-else
			>{{ props.label }}</InputLabel
		>
		<input
			v-if="props.as === 'checkbox'"
			type="checkbox"
			class="checkbox checkbox-primary"
			:name="props.name"
			:id="props.name"
			:checked="inputValue"
			@input="handleChange($event.target.checked)"
			@blur="handleBlur" />
		<input
			v-else-if="props.as === 'input' || props.as === 'number'"
			:class="{
				'w-full': true,
				input: true,
				'input-primary': !!props.visible,
				'input-ghost': !props.visible,
				'text-white': true,
				'border-primary': !!props.visible,
				'border-error': !!errorMessage,
				'border-success': meta.valid,
			}"
			:name="props.name"
			:type="props.type"
			:id="props.name"
			:value="inputValue"
			:placeholder="props.label"
			@input="handleChange"
			@blur="handleBlur" />
		<textarea
			v-else-if="props.as === 'textarea'"
			class="w-full textarea textarea-ghost text-white"
			:name="props.name"
			:type="props.type"
			:id="props.name"
			:value="inputValue"
			:placeholder="props.label"
			@input="handleChange"
			:class="{ 'border-error': !!errorMessage, 'border-success': meta.valid }"
			@blur="handleBlur" />
		<div v-else-if="props.as === 'date'">
			<VueDatePicker
				format="yyyy-MM-dd HH:mm"
				v-model="dateValue"
				:clearable="false"
				text-input
				auto-apply
				:dark="true"
				teleport-center
				:utc="false">
				<template #dp-input="{ value, onInput, onEnter, onTab, onClear, onBlur, onKeypress, onPaste, isMenuOpen }">
					<input
						type="text"
						class="input input-ghost text-white w-full"
						:class="'border-success'"
						:value="value"
						placeholder="props.label" />
				</template>
			</VueDatePicker>
		</div>
		<div
			v-else-if="props.as === 'autocomplete'"
			class="relative">
			<AutoComplete
				:selectedId="inputValue"
				:foreign="props.foreign"
				@selectOption="handleSelectOption" />
		</div>
		<div
			v-else-if="props.as === 'video'"
			class="relative">
			<VideoField
				:name="props.name"
				:modelValue="inputValue"
				:errorMessage="errorMessage"
				:isValid="meta.valid"
				@update:modelValue="inputValue = $event" />
		</div>
		<div
			v-else-if="props.as === 'tags'"
			class="relative">
			<Tags
				:selectedTags="inputValue"
				:foreign="props.foreign"
				@selectedTags="handleSelectedTags" />
		</div>
		<label class="label">
			<span
				class="label-text-alt"
				v-show="errorMessage || meta.valid"
				>{{ errorMessage || successMessage }}</span
			>
		</label>
	</Field>
</template>
