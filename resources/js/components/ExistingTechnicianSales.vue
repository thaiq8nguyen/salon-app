<template>
	<div id="existing-technician-sales">
		<v-card v-if="techniciansWithSale.length">
			<v-card-title>
				<span class="title">Existing Sales</span>
				<v-spacer></v-spacer>
			</v-card-title>
			<v-divider></v-divider>
			<v-card-text>
				<v-data-table
						:headers="technicianHeaders"
						:items="techniciansWithSale"
						hide-actions
				>
					<template slot="items" slot-scope="props">
						<td class="text-md-center primary_text--text subheading">{{ props.item.first_name }}&nbsp;{{ props.item.last_name }}</td>
						<td class="text-md-center primary_text--text subheading">{{ $dollar.format(props.item.sale.sale_amount) }}</td>
						<td class="text-md-center primary_text--text subheading">{{ $dollar.format(props.item.sale.tip_amount) }}</td>
						<td class="text-sm-center primary_text--text subheading">
							<v-icon @click="showUpdateDialog(props.item)">edit</v-icon>
							<v-icon class="primary--text" @click="showDeleteDialog(props.item)">delete</v-icon>
						</td>
					</template>
				</v-data-table>
			</v-card-text>
		</v-card>
		<v-card v-else>
			<v-card-title>
				<span class="title">No Technician Sales Entered</span>
			</v-card-title>
			<v-divider></v-divider>
			<v-card-text>
				<span class="subheading">You can enter the technician sales by clicking the button below</span><br>
				<v-btn to="add-technician-sales">Add Technician Sales</v-btn>
			</v-card-text>
		</v-card>
		<v-dialog v-model="updateDialog" :max-width="500">
			<v-card>
				<v-card-title>
					<span class="title">{{ updateSale.firstName }}&nbsp;{{ updateSale.lastName }}</span>
					<v-spacer></v-spacer>
					<v-btn icon @click="updateDialog = false"><v-icon>close</v-icon></v-btn>
				</v-card-title>
				<v-divider></v-divider>
				<v-form data-vv-scope="updateSaleForm" @submit.prevent="validate('updateSaleForm')">
					<v-card-text>
						<v-container grid-list-md>
							<v-layout row wrap>
								<v-flex md6>
									<v-text-field
											v-model.number="updateSale.saleAmount"
											v-validate="'required|numeric|between: 1,500'"
											label="Sale"
											type="number"
											:error-messages="errors.collect('updateSale')"
											data-vv-name="updateSale"
											name="updateSale"
											outline
									></v-text-field>
								</v-flex>
								<v-flex md6>
									<v-text-field
											v-model.number="updateSale.tipAmount"
											v-validate="'numeric|between: 1,500'"
											label="Tip"
											type="number"
											:error-messages="errors.collect('updateTip')"
											data-vv-name="updateTip"
											name="updateTip"
											outline
									></v-text-field>
								</v-flex>
							</v-layout>
						</v-container>
					</v-card-text>
					<v-card-actions>
						<v-btn @click="updateDialog= false">Close</v-btn>
						<v-spacer></v-spacer>
						<v-btn class="info" :loading="loading" type="submit">Update</v-btn>
					</v-card-actions>
				</v-form>
			</v-card>
		</v-dialog>
		<v-dialog v-model="deleteDialog" :max-width="600">
			<v-card>
				<v-card-title>
					<span class="title">Delete Confirmation</span>
					<v-spacer></v-spacer>
					<v-btn icon @click="deleteDialog = false"><v-icon>close</v-icon></v-btn>
				</v-card-title>
				<v-divider></v-divider>
				<v-form @submit.prevent="deleteSale">
					<v-card-text>
						<span class="title">Are you sure you want to delete this {{ updateSale.firstName }}`s sale?</span>
					</v-card-text>
					<v-card-text>
						<span class="title secondary_text--text">Sale: </span><span class="title primary_text--text">{{ $dollar.format(updateSale.saleAmount) }}</span>
					</v-card-text>
					<v-card-text>
						<span class="title secondary_text--text">Tip: </span><span class="title primary_text--text">{{ $dollar.format(updateSale.tipAmount) }}</span>
					</v-card-text>
					<v-card-actions>
						<v-btn @click="deleteDialog=false">Cancel</v-btn>
						<v-spacer></v-spacer>
						<v-btn class="info" :loading="loading" type="submit">Delete</v-btn>
					</v-card-actions>
				</v-form>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
export default {
	name: "ExistingTechnicianSales",
	data () {

		return {
			technicianHeaders: [
				{ text: "Name", value: "name", sortable: false, class: "text-sm-center secondary_text--text subheading" },
				{ text: "Sale", value: "sale", sortable: false, class: "text-sm-center secondary_text--text subheading" },
				{ text: "Tip", value: "tip", sortable: false, class: "text-sm-center secondary_text--text subheading" },
				{ text: "Actions", value: "actions", sortable: false, class: "text-sm-center secondary_text--text subheading" },
			],
			updateDialog: false,

			updateSale: {
				firstName: "",
				lastName: "",
				saleID: "",
				saleAmount: "",
				tipAmount: ""
			},
			defaultSale: {
				firstName: "",
				lastName: "",
				saleID: "",
				saleAmount: "",
				tipAmount: ""
			},
			dictionary: {
				custom: {
					updateSale: {
						required: "Enter a sale amount",
						numeric: "The sale amount must be a numbers",
						between: "The sale amount must be between $ 1 and $ 500"
					},
					updateTip: {
						numeric: "The tip amount must be a number",
						between: "The tip amount must be between $ 1 and $ 500"
					},
				}
			},
			deleteDialog: false,
			newSaleDialog: false,
			selectedTechnician: "",

		};

	},
	computed: {

		techniciansWithSale () {

			return this.$store.getters["UpdateTechnicianSales/techniciansWithSale"];

		},
		techniciansWithNoSale () {

			return this.$store.getters["UpdateTechnicianSales/techniciansWithNoSale"];

		},
		existingSaleTotal () {

			return this.$store.getters["UpdateTechnicianSales/technicianSaleTotal"];

		},
		loading () {

			return this.$store.getters["UpdateTechnicianSales/loading"];

		}

	},
	mounted () {

		this.$validator.localize("en", this.dictionary);

	},
	methods: {
		showUpdateDialog (technician) {

			this.populateDialog(technician);
			this.updateDialog = true;

		},
		showDeleteDialog (technician) {

			this.populateDialog(technician);
			this.deleteDialog = true;

		},
		populateDialog (technician) {

			this.updateSale.firstName = technician.first_name;
			this.updateSale.lastName = technician.last_name;
			this.updateSale.saleID = technician.sale.id;
			this.updateSale.saleAmount = parseFloat(technician.sale.sale_amount);
			this.updateSale.tipAmount = parseFloat(technician.sale.tip_amount);

		},
		validate (scope) {

			this.$validator.validateAll(scope).then((result) => {

				if (result) {

					this.updateTechnicianSale();

				}

			});

		},

		updateTechnicianSale () {

			this.$store.dispatch("UpdateTechnicianSales/updateExistingSale", this.updateSale)
				.then(response => {

					this.updateSale = Object.assign({}, this.defaultSale);
					this.updateDialog = false;

				})
				.catch(errors => {

				});

		},
		deleteSale () {

			this.$store.dispatch("UpdateTechnicianSales/deleteExistingSale", this.updateSale.saleID)
				.then(response => {

					this.updateSale = Object.assign({}, this.defaultSale);
					this.deleteDialog = false;

				})
				.catch(errors => {

				});

		}
	}
};
</script>

<style scoped>

</style>
