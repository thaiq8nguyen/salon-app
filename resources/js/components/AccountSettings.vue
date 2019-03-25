<template>
	<div id="account-settings">
		<v-card>
			<v-card-title>
				<span class="title">Accounts</span>
				<v-spacer></v-spacer>
				<v-btn @click="newAccountDialog=true">New Account</v-btn>
			</v-card-title>
			<v-divider></v-divider>
			<v-data-table
					:headers="accountHeaders"
					:items="accounts"
			>
				<template slot="items" slot-scope="props">
					<td class="text-md-left primary_text--text subheading">{{ props.item.name }}</td>
				</template>
			</v-data-table>
		</v-card>
		<v-dialog v-model="newAccountDialog" :max-width="500">
			<v-card>
				<v-card-title>
					<span class="title">New Account</span>
				</v-card-title>
				<v-divider></v-divider>
				<v-form @submit.prevent="validate">
					<v-card-text>
						<v-select
								v-model="newAccount.accountTypeID"
								v-validate="'required'"
								data-vv-name="accountTypeID"
								:error-messages="errors.collect('accountTypeID')"
								name="accountTypeID"
								label="Account Types"
								:items="accountTypes"
								item-text="name"
								item-value="id"
								outline
						>
						</v-select>
						<v-text-field
								v-model="newAccount.accountName"
								v-validate="'required'"
								data-vv-name="accountName"
								:error-messages="errors.collect('accountName')"
								name="accountName"
								label="Account Name"
								outline
						>
						</v-text-field>
					</v-card-text>
					<v-card-actions>
						<v-btn @click="newAccountDialog=false">Cancel</v-btn>
						<v-spacer></v-spacer>
						<v-btn class="info" :loading="loading" type="submit">Add</v-btn>
					</v-card-actions>
				</v-form>
			</v-card>
		</v-dialog>
	</div>

</template>

<script>
export default {
	name: "AccountSettings",
	data () {

		return {

			newAccount: {
				accountTypeID: "",
				accountName: ""
			},
			defaultNewAccount: {
				accountTypeID: "",
				accountName: ""
			},
			accountHeaders: [
				{ text: "Accounts", value: "accounts", sortable: false, class: "text-md-left secondary_text--text subheading" },
			],
			loading: false,
			dictionary: {
				custom: {
					accountTypeID: {
						required: "Select an account type",
					},
					accountName: {
						required: "Enter the account name",
					}
				}
			},
			newAccountDialog: false,

		};

	},
	computed: {

		accountTypes () {

			return this.$store.getters["Accounts/accountTypes"];

		},
		accounts () {

			return this.$store.getters["Accounts/accounts"];

		},

	},
	created () {

		this.$store.dispatch("Accounts/init");
		this.$validator.localize("en", this.dictionary);

	},
	methods: {

		validate () {

			this.$validator.validateAll().then((result) => {

				if (result) {

					this.addAccount();

				}

			});

		},
		addAccount () {

			this.loading = true;
			this.$store.dispatch("Accounts/addAccount", this.newAccount)
				.then(() => {

					this.loading = false;
					this.newAccount = Object.assign({}, this.defaultNewAccount);
					this.$validator.reset();
					this.newAccountDialog = false;

				});

		},

	},
};
</script>

<style scoped>

</style>
