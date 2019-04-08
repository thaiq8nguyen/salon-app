<template>
	<div id="pending-registration">
		<v-app>
			<v-content>
				<v-container>
					<v-layout justify-center>
						<v-flex md6>
							<v-card>
								<v-card-title>
									<span class="title">Pending Approval</span>
								</v-card-title>
								<v-card-text class="subheading">
									Your registration is pending. Once it approved you can login.
								</v-card-text>
								<v-card-actions>
									<v-btn to="/login">Log in</v-btn>
								</v-card-actions>
							</v-card>
						</v-flex>
					</v-layout>
				</v-container>
			</v-content>
		</v-app>
	</div>
</template>

<script>
export default {
	name: "Approval",
	data () {

		return {

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
