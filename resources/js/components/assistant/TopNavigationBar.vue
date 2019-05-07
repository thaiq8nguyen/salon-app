<template>
	<div id="top-navigation-bar">
		<v-toolbar
				class="primary"
				app
				fixed

		>
			<v-toolbar-side-icon class="white--text" @click="toggleNavigationDrawer"></v-toolbar-side-icon>
			<v-toolbar-title>
			</v-toolbar-title>
			<v-spacer></v-spacer>
			<v-toolbar-items>
			</v-toolbar-items>
			<v-menu offset-y>
				<v-btn slot="activator" class="white--text" flat>
					{{ userFullName }}
					<v-icon right>keyboard_arrow_down</v-icon>
				</v-btn>
				<v-list>
					<v-list-tile v-for="(item, key) in items" :key="key" @click="logout">
						<v-list-tile-title>{{ item.name }}</v-list-tile-title>
					</v-list-tile>
				</v-list>
			</v-menu>
		</v-toolbar>
	</div>
</template>

<script>
export default {
	name: "TopNavigationBar",

	data () {

		return {
			items: [
				{ name: "Logout" }
			]
		};

	},
	computed: {

		userFullName () {

			return this.$store.getters["Authentications/userFullName"];

		}

	},
	methods: {

		toggleNavigationDrawer () {

			this.$emit("toggleNavigationDrawer");

		},
		logout () {

			this.$store.dispatch("Authentications/logout");

		}

	},
};

</script>

<style scoped>

</style>
