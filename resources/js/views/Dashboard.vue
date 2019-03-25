<template>
	<div id="dashboard">
		<v-app>
			<top-navigation-bar :title="title"></top-navigation-bar>
			<v-content>
				<v-card>
				</v-card>
			</v-content>
		</v-app>
	</div>
</template>

<script>
import TopNavigationBar from "Components/TopNavigationBar";
export default {
	name: "Dashboard",
	components: { TopNavigationBar },
	data () {

		return {

		};

	},
	computed: {
		title () {

			return this.$route.meta.title;

		}
	},

	created () {

		this.$store.dispatch("init");

	},

	methods: {},
};

</script>

<style scoped>

</style>
