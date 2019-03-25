<template>
	<div id="technician-settings">
		<v-card>
			<v-card-title>
				<span class="title">Technicians</span>
				<v-spacer></v-spacer>
				<v-btn @click="newTechnicianDialog=true">New Technician</v-btn>
			</v-card-title>
			<v-divider></v-divider>
			<v-card-text>
				<v-data-table
						:headers="technicianHeaders"
						:items="technicians"
				>
					<template slot="items" slot-scope="props">
						<td class="text-md-left primary_text--text subheading">{{ props.item.first_name }}&nbsp;{{ props.item.last_name }}</td>
					</template>
				</v-data-table>
			</v-card-text>
		</v-card>
		<v-dialog v-model="newTechnicianDialog" :max-width="600">
			<v-card>
				<v-card-title>
					<span class="title">New Technician</span>
				</v-card-title>
				<v-divider></v-divider>
				<v-form @submit.prevent="validate">
					<v-card-text>
						<v-container fluid grid-list-md>
							<v-layout row wrap>
								<v-flex md6>
									<v-text-field
											v-model="newTechnician.firstName"
											v-validate="'required'"
											data-vv-name="firstName"
											:error-messages="errors.collect('firstName')"
											label="First Name"
											name="firstName"
											outline
									>
									</v-text-field>
								</v-flex>
								<v-flex md6>
									<v-text-field
											v-model="newTechnician.lastName"
											v-validate="'required'"
											data-vv-name="lastName"
											:error-messages="errors.collect('lastName')"
											label="Last Name"
											name="lastName"
											outline
									>
									</v-text-field>
								</v-flex>
								<v-flex md12>
									<v-text-field
											v-model="newTechnician.email"
											v-validate="'required'"
											data-vv-name="email"
											:error-messages="errors.collect('email')"
											label="Email"
											name="email"
											outline
									>
									</v-text-field>
								</v-flex>
								<v-flex md6>
									<v-text-field
											v-model="newTechnician.phone"
											v-validate="'required'"
											data-vv-name="phone"
											:error-messages="errors.collect('phone')"
											label="Phone"
											name="phone"
											outline
									>
									</v-text-field>
								</v-flex>
							</v-layout>
						</v-container>
					</v-card-text>
					<v-card-actions>
						<v-btn @click="newTechnicianDialog=false">Cancel</v-btn>
						<v-spacer></v-spacer>
						<v-btn class="info" type="submit" :loading="loading">Add</v-btn>
					</v-card-actions>
				</v-form>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
export default {
	name: "TechnicianSettings",
	data () {

		return {
			technicianHeaders: [
				{ text: "Technicians", value: "technicians", sortable: false, class: "text-sm-left secondary_text--text subheading" }
			],
			newTechnicianDialog: false,
			newTechnician: {
				firstName: "",
				lastName: "",
				email: "",
				phone: ""
			},
			defaultTechnician: {
				firstName: "",
				lastName: "",
				email: "",
				phone: ""
			},
			dictionary: {
				custom: {
					firstName: {
						required: "Enter the technician first name"
					},
					lastName: {
						required: "Enter the technician last name"
					},
					email: {
						required: "Enter the technician email"
					},
					phone: {
						required: "Enter the technician phone number"
					}
				}
			},
			loading: false,
		};

	},
	computed: {

		technicians () {

			return this.$store.getters["Technicians/technicians"];

		}
	},
	created () {

		this.$validator.localize("en", this.dictionary);

	},
	methods: {

		validate () {

			this.$validator.validateAll().then((result) => {

				if (result) {

					this.add();

				}

			});

		},
		add () {

			this.$store.dispatch("Technicians/addTechnician", this.newTechnician)
				.then(() => {

					this.loading = false;
					this.newTechnician = Object.assign({}, this.defaultTechnician);
					this.$validator.reset();
					this.newTechnicianDialog = false;

				});

		}
	},
};
</script>

<style scoped>

</style>
