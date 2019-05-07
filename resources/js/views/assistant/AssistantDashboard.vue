<template>
	<div id="assistant-dashboard">
		<v-app>
			<top-navigation-bar @toggleNavigationDrawer="navigationDrawer=!navigationDrawer"></top-navigation-bar>
			<v-navigation-drawer
					v-model="navigationDrawer"
					app
					fixed
			>
				<v-toolbar flat>
					<v-list>
						<v-list-tile>
							<v-list-tile-title class="title">
								Application
							</v-list-tile-title>
						</v-list-tile>
					</v-list>
				</v-toolbar>

				<v-divider></v-divider>

				<v-list dense class="pt-0">
					<v-list-tile
							v-for="item in items"
							:key="item.title"
							@click=""
					>
						<v-list-tile-action>
							<v-icon>{{ item.icon }}</v-icon>
						</v-list-tile-action>
						<v-list-tile-content>
							<v-list-tile-title class="subheading">{{ item.title }}</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
				</v-list>
			</v-navigation-drawer>
			<v-content>
				<v-container>
					<v-layout>

					</v-layout>
				</v-container>
			</v-content>
		</v-app>

	</div>

</template>

<script>
import TopNavigationBar from "Components/assistant/TopNavigationBar";

export default {
	name: "AssistantDashboard",
	components: { TopNavigationBar },
	data () {

		return {
			navigationDrawer: false,
			items: [
				{ title: "Add Technician Sales", icon: "add" },
			]

		};

	},
	computed: {

	},
	methods: {

	},
};
</script>

<style scoped>

</style>
