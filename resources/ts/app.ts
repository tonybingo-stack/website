import "@/assets/app.css"

import { createApp, h } from "vue"
import { createInertiaApp, Head, Link } from "@inertiajs/vue3"
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers"
import type { DefineComponent } from "vue"
import { trail } from "momentum-trail"
import routes from "./routes.json"
import { createVuetify } from "vuetify"
import type { ThemeDefinition } from "vuetify"
import "@mdi/font/css/materialdesignicons.css"
import * as components from "vuetify/components"
import * as directives from "vuetify/directives"
import "vuetify/dist/vuetify.min.css"
import "@/assets/scss/style.scss"
import AppLayout from "./components/Layouts/AppLayout.vue"
import VueDatePicker from "@vuepic/vue-datepicker"
import Toast, { PluginOptions } from "vue-toastification"
import { Field, Form, ErrorMessage } from "vee-validate"
import "./plugins/axios-interceptor"
import dayjs from "dayjs"
import "dayjs/locale/ro"
import relativeTime from "dayjs/plugin/relativeTime" // Import the relativeTime plugin
import utc from "dayjs/plugin/utc"
import customParseFormat from "dayjs/plugin/customParseFormat"
import { VueRecaptchaPlugin } from "vue-recaptcha/head"

const DarkTheme: ThemeDefinition = {
	colors: {},
}

const vuetify = createVuetify({
	components: {},
	directives,

	theme: {
		themes: {
			light: DarkTheme,
			variables: {},
		},
	},
})

const appName = window.document.getElementsByTagName("title")[0]?.innerText || "Template"

createInertiaApp({
	title: (title) => `${title} - ${appName}`,
	resolve: (name) => {
		const pages = import.meta.glob("./components/Pages/**/*.vue", { eager: true })
		let page = pages[`./components/Pages/${name}.vue`]
		page.default.layout = page.default.layout || AppLayout
		return page
	},
	setup({ el, App, props, plugin }) {
		dayjs.locale("en")
		dayjs.extend(utc)
		dayjs.extend(relativeTime) // Extend dayjs with the relativeTime plugin
		dayjs.extend(customParseFormat)

		return createApp({ render: () => h(App, props) })
			.use(plugin)
			.use(vuetify)
			.use(Toast)
			.use(trail, { routes })
			.use(VueRecaptchaPlugin, {
				v2SiteKey: import.meta.env.VITE_RECAPTCHA_SITEKEY,
			})
			.component("Form", Form)
			.component("Field", Field)
			.component("ErrorMessage", ErrorMessage)
			.component("VueDatePicker", VueDatePicker)
			.mount(el)
	},
	progress: {
		color: "#EE5C14",
		delay: 0,
		showSpinner: true,
	},
})
