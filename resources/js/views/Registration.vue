<template>
	<div id="registration">
		<v-app>
			<v-content>
				<v-container fluid fill-height>
					<v-layout justify-center align-center>
						<v-flex md6>
							<v-card>
								<v-card-title>
									<span class="title">Registration</span>
								</v-card-title>
								<v-form @submit.prevent="validate">
									<v-card-text>
										<v-container grid-list-md>
											<v-layout row wrap>
												<v-flex md6>
													<v-text-field
															v-model="user.firstName"
															v-validate="'required|max:20'"
															data-vv-name="firstName"
															:error-messages="errors.collect('firstName')"
															label="First Name"
															type="text"
															name="firstName"
															outline
													>
													</v-text-field>
												</v-flex>
												<v-flex md6>
													<v-text-field
															v-model="user.lastName"
															v-validate="'required|max:20'"
															data-vv-name="lastName"
															:error-messages="errors.collect('lastName')"
															label="Last Name"
															type="text"
															name="lastName"
															outline
													>
													</v-text-field>
												</v-flex>
												<v-flex>
													<v-text-field
															v-model="user.email"
															v-validate="'required|email'"
															data-vv-name="email"
															:error-messages="errors.collect('email')"
															label="Email"
															type="text"
															name="email"
															outline
													>
													</v-text-field>
												</v-flex>
												<v-flex md12>
													<v-text-field
															v-model="user.password"
															v-validate="'required|min:6|max:12'"
															data-vv-name="password"
															:error-messages="errors.collect('password')"
															label="password"
															type="password"
															name="password"
															outline
													>
													</v-text-field>
												</v-flex>
											</v-layout>
										</v-container>
									</v-card-text>
									<v-card-actions>
										<v-btn to="/login">Log In</v-btn>
										<v-spacer></v-spacer>
										<v-btn class="info" :loading="registering" type="submit">Submit</v-btn>
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
	name: "Registration",
	data () {

		return {
			defaultUser: {
				firstName: "",
				lastName: "",
				email: "",
				password: "",
			},
			user: {
				firstName: "",
				lastName: "",
				email: "",
				password: "",
			},
			dictionary: {
				custom: {
					firstName: {
						required: "Your first name is required",
						max: "Maximum character (20) is exceeded"
					},
					lastName: {
						required: "Your last name is required",
						max: "Maximum character (20) is exceeded"
					},
					email: {
						required: "Your email is required",
						email: "Email is not valid"
					},
					password: {
						required: "Enter a password",
						min: "Password should have at least 6 characters",
						max: "Maximum character (12) is exceeded"
					}
				}

			},
			registering: false,
		};

	},
	computed: {

	},
	created () {

		this.$validator.localize("en", this.dictionary);

	},
	methods: {
		validate () {

			this.$validator.validateAll().then(result => {

				if (result) {

					this.register();

				}

			});

		},
		register () {

			this.registering = true;
			this.$store.dispatch("Authentications/register", this.user)
				.then(() => {

					this.user = Object.assign({}, this.defaultUser);
					this.registering = false;
					this.$router.push("pending-registration");

				});

		},

	},
};
</script>

<style scoped>

</style>
