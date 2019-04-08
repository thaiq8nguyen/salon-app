<template>
	<div id="settings">
		<v-app>
			<top-navigation-bar :title="title"></top-navigation-bar>
			<v-content>
				<v-container grid-list-md fluid>
					<v-layout row wrap>
						<v-flex md3>
							<technician-settings></technician-settings>
						</v-flex>
						<v-flex md3>
							<account-settings></account-settings>
						</v-flex>
						<v-flex md3>
							<user-settings></user-settings>
						</v-flex>
					</v-layout>
				</v-container>
			</v-content>
		</v-app>
	</div>
</template>

<script>
import TopNavigationBar from "Components/TopNavigationBar";
import TechnicianSettings from "Components/TechnicianSettings";
import AccountSettings from "Components/AccountSettings";
import UserSettings from "Components/UserSettings";

export default {
	name: "Settings",
	components: { TopNavigationBar, TechnicianSettings, AccountSettings, UserSettings },

	data () {

		return {

			title: this.$route.meta.title,

		};

	},
	computed: {

	},
	created () {

	},
	methods: {

	},
};
</script>

<style scoped>

</style>
