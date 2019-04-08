<template>
	<div id="user-settings">
		<v-card>
			<v-card-title>
				<span class="title">Users</span>
			</v-card-title>
			<v-divider></v-divider>
			<v-card-text>
				<v-list>
					<v-subheader>Users need approval</v-subheader>
					<v-list-tile v-for="user in unApprovedUsers" :key="user.id">
						<v-list-tile-content>{{ user.name }}</v-list-tile-content>
						<v-list-tile-action>
							<v-btn @click="approve(user.id)">Approve</v-btn>
						</v-list-tile-action>
					</v-list-tile>
				</v-list>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
export default {
	name: "UserSettings",
	data () {

		return {

		};

	},
	computed: {

		unApprovedUsers () {

			return this.$store.getters["Users/unApprovedUsers"];

		}

	},
	created () {

		this.$store.dispatch("Users/getUnApprovedUsers");

	},
	methods: {

		approve (userID) {

			this.$store.dispatch("Users/approveUser", userID);

		}

	},
};
</script>

<style scoped>

</style>
