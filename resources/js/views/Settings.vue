<template>
	<div id="settings">
		<v-app>
			<top-navigation-bar :title="title"></top-navigation-bar>
			<v-content>
				<v-container grid-list-md fluid>
					<v-layout row wrap>
						<v-flex md3>
							<v-card>
								<v-card-title>
									<span class="title">Accounts</span>
								</v-card-title>
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
										<v-spacer></v-spacer>
										<v-btn class="info" :loading="loading" type="submit">Add</v-btn>
									</v-card-actions>
								</v-form>
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
						</v-flex>
					</v-layout>
				</v-container>
			</v-content>
		</v-app>
	</div>
</template>

<script>
import TopNavigationBar from "Components/TopNavigationBar";
export default {
	name: "Settings",
	components: { TopNavigationBar },

	data () {

		return {
			title: this.$route.meta.title,
			newAccount: {
				accountTypeID: "",
				accountName: ""
			},
			defaultNewAccount: {
				accountTypeID: "",
				accountName: ""
			},
			accountHeaders: [
				{ text: "Account Name", value: "accountName", sortable: false, class: "text-md-left secondary_text--text subheading" },
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
			}
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

			this.$validator.validateAll((result) => {

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

				});

		},
	},
};
</script>

<style scoped>

</style>
