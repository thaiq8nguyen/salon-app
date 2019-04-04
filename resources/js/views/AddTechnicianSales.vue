<template>
	<div id="technician-sales">
		<v-app>
			<top-navigation-bar :title="title"></top-navigation-bar>
			<v-content>
				<v-container v-if="hasSquareReceipts" fluid grid-list-md>
					<v-layout row wrap>
						<v-flex md3>
							<v-layout row wrap>
								<v-flex md12>
									<sale-date-picker></sale-date-picker>
								</v-flex>
								<v-flex md12 class="mt-3">
									<gift-register></gift-register>
								</v-flex>
								<v-flex md12 class="mt-2">
									<square-register></square-register>
								</v-flex>
							</v-layout>
						</v-flex>
						<v-flex md4>
							<v-layout row wrap>
								<v-flex md12>
									<v-card>
										<v-card-title>
											<span class="title">Technicians</span>
											<v-spacer></v-spacer>
											<span v-if="hasNoExistingTechnicianSales">There are no existing technician sales</span>
										</v-card-title>
										<v-divider></v-divider>
										<v-list>
											<template v-for="technician in technicians">
												<v-list-tile :key="technician.id" @click="showNewSaleDialog(technician)">
													<v-list-tile-avatar>
														<v-icon large>account_box</v-icon>
													</v-list-tile-avatar>
													<v-list-tile-content>{{ technician.first_name }}&nbsp;{{ technician.last_name }}</v-list-tile-content>
												</v-list-tile>
												<v-divider></v-divider>
											</template>
										</v-list>
									</v-card>
								</v-flex>
							</v-layout>
						</v-flex>
						<v-flex md4 offset-md1>
							<technician-pending-sales></technician-pending-sales>
						</v-flex>
					</v-layout>
				</v-container>
				<!-- IF no Square Receipt recorded-->
				<v-container v-else fill-height>
					<v-layout justify-center align-center>
						<v-flex md6>
							<sale-date-picker></sale-date-picker>
							<v-card>
								<v-card-text class="text-md-center">
									<span class="headline">No Sales</span>
								</v-card-text>
							</v-card>
						</v-flex>
					</v-layout>
				</v-container>
			</v-content>
		</v-app>
		<v-dialog v-model="newSaleDialog" :max-width="600">
			<v-card>
				<v-card-title>
					<span class="title">{{ sale.fullName }}</span>
				</v-card-title>
				<v-divider></v-divider>
				<v-form @submit.prevent="validate">
					<v-card-text>
						<v-container fluid grid-list-md>
							<v-layout row wrap>
								<v-flex md6>
									<v-text-field
											v-model.number="sale.amount"
											v-validate="'required|numeric|between:1,500'"
											label="Sale"
											outline
											name="sale"
											:error-message="errors.collect('sale')"
											data-vv-model="sale"
									>
									</v-text-field>
								</v-flex>
								<v-flex md6>
									<v-text-field
											v-model.number="sale.tipAmount"
											v-validate="'numeric|between:1,500'"
											label="Tip"
											outline
											name="tip"
											:error-message="errors.collect('tip')"
											data-vv-model="tip"
									>
									</v-text-field>
								</v-flex>

							</v-layout>
						</v-container>
					</v-card-text>
					<v-card-actions>
						<v-btn @click="newSaleDialog=false">Cancel</v-btn>
						<v-spacer></v-spacer>
						<v-btn type="submit" class="info">Add</v-btn>
					</v-card-actions>
				</v-form>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
import TopNavigationBar from "Components/TopNavigationBar";
import SquareRegister from "Components/SquareRegister";
import SaleDatePicker from "Components/SaleDatePicker";
import GiftRegister from "Components/GiftRegister";
import TechnicianPendingSales from "Components/TechnicianPendingSales";

export default {
	name: "TechnicianSales",
	components: { TopNavigationBar, SquareRegister, SaleDatePicker, GiftRegister, TechnicianPendingSales },
	data () {

		return {
			sale: {
				technicianID: "",
				fullName: "",
				amount: "",
				tipAmount: ""
			},
			defaultSale: {
				technicianID: "",
				fullName: "",
				amount: "",
				tipAmount: ""
			},

			dictionary: {
				custom: {
					sale: {
						required: "Enter a sale amount",
						numeric: "The sale amount must be a number",
						between: "The sale amount must be between $ 1 and $ 500"
					},
					tip: {
						numeric: "The tip amount must be a number",
						between: "The tip amount must be between $ 1 and $ 500"
					},
				}
			},
			newSaleDialog: false,

		};

	},
	computed: {
		title () {

			return this.$route.meta.title;

		},
		technicians () {

			return this.$store.getters["AddTechnicianSales/technicians"];

		},
		hasSquareReceipts () {

			return this.$store.getters["Square/hasReceipts"];

		},
		hasNoExistingTechnicianSales () {

			return this.$store.getters["AddTechnicianSales/hasNoExistingTechnicianSales"];

		},
		date: {
			get () {

				return this.$store.getters["date"];

			},
			set (date) {

				this.$store.dispatch("setDate", date);

			}
		},
		friendlyDate () {

			return this.$store.getters["dateTextField"];

		},

	},
	watch: {
		date () {

			this.$store.dispatch("AddTechnicianSales/init");

		}
	},
	created () {

		this.$store.dispatch("AddTechnicianSales/init");
		this.$validator.localize("en", this.dictionary);

	},
	methods: {
		showNewSaleDialog (technician) {

			this.sale.fullName = technician.first_name + " " + technician.last_name;
			this.sale.technicianID = technician.id;
			this.newSaleDialog = true;

		},
		validate () {

			this.$validator.validateAll().then((result) => {

				if (result) {

					this.add();

				}

			});

		},
		add () {

			this.sale.tipAmount = this.sale.tipAmount ? this.sale.tipAmount : 0;
			this.$store.dispatch("AddTechnicianSales/add", this.sale);
			this.$validator.reset();
			this.reset();
			this.newSaleDialog = false;

		},
		reset () {

			this.sale = Object.assign({}, this.defaultSale);

		},

	},

};

</script>

<style scoped>

</style>
