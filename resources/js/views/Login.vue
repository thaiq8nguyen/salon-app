<template>
	<div id="login">
		<v-app>
			<v-content>
				<v-container fluid fill-height>
					<v-layout justify-center align-center>
						<v-flex sm4>
							<v-card>
								<v-card-title class="dark_primary">
									<span class="headline white--text">Login</span>
								</v-card-title>
								<v-form @submit.prevent="validate">
									<v-card-text>
										<v-text-field
												v-model="credential.email"
												v-validate="'required'"
												label="Email"
												type="text"
												name="email"
												data-vv-name="email"
												:error-messages="errors.collect('email')"
										>
										</v-text-field>
										<v-text-field
												v-model="credential.password"
												v-validate="'required'"
												label="Password"
												type="password"
												name="password"
												data-vv-name="password"
												:error-messages="errors.collect('password')"
										>
										</v-text-field>
									</v-card-text>
									<v-card-text v-if="errorMessage">
										<p class="danger--text">{{ errorMessage }}</p>
									</v-card-text>
									<v-card-actions>
										<v-spacer></v-spacer>
										<v-btn class="info" :loading="isAuthenticating" type="submit">Login</v-btn>
									</v-card-actions>
								</v-form>
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
	name: "Login",
	data () {

		return {
			credential: {
				email: "",
				password: ""
			},
			dictionary: {
				custom: {
					email: {
						required: "Enter your email",
					},
					password: {
						required: "Enter your password",
					},
				}
			},

		};

	},
	computed: {

		isAuthenticating () {

			return this.$store.getters["Authentications/isAuthenticating"];

		},

		errorMessage () {

			return this.$store.getters["Authentications/errorMessage"];

		}
	},
	created () {

		this.$validator.localize("en", this.dictionary);

	},
	methods: {
		validate () {

			this.$validator.validateAll().then((result) => {

				if (result) {

					this.login();

				}

			});

		},
		login (){

			this.$store.dispatch("Authentications/login", this.credential);

		}
	},
};
</script>

<style scoped>
</style>
