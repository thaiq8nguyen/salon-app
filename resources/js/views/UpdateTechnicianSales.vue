<template>
	<div id="update-technician-sales">
		<v-app>
			<top-navigation-bar :title="title"></top-navigation-bar>
			<v-content>
				<v-container grid-list-md fluid>
					<v-layout row wrap>
						<v-flex md3>
							<sale-date-picker></sale-date-picker>
						</v-flex>
						<v-flex md12 class="mt-5">
							<v-layout row wrap>
								<v-flex md3>
									<v-card>
										<v-card-title>
											<span class="title">Summary</span>
										</v-card-title>
										<v-divider></v-divider>
										<v-list>
											<v-list-tile>
												<v-list-tile-content>Technician Sale Total</v-list-tile-content>
												<v-list-tile-content class="align-end">{{ $dollar.format(technicianSaleTotal) }}</v-list-tile-content>
											</v-list-tile>
											<v-list-tile>
												<v-list-tile-content>{{ convenienceFee.name }}</v-list-tile-content>
												<v-list-tile-content class="align-end">+ &nbsp;{{ $dollar.format(convenienceFee.amount) }}</v-list-tile-content>
											</v-list-tile>
											<v-list-tile>
												<v-list-tile-content>{{ giftCardRedeem.name }}</v-list-tile-content>
												<v-list-tile-content class="align-end">-&nbsp;{{ $dollar.format(giftCardRedeem.amount) }}</v-list-tile-content>
											</v-list-tile>
											<v-list-tile>
												<v-list-tile-content>{{ giftCardSold.name }}</v-list-tile-content>
												<v-list-tile-content class="align-end">+&nbsp;{{ $dollar.format(giftCardSold.amount) }}</v-list-tile-content>
											</v-list-tile>
											<v-divider inset></v-divider>
											<v-list-tile>
												<v-list-tile-content>Net Technician Sale Total</v-list-tile-content>
												<v-list-tile-content class="align-end">{{ $dollar.format(netTechnicianSaleTotal) }}</v-list-tile-content>
											</v-list-tile>
											<v-list-tile>
												<v-list-tile-content>
													Square Total Collected
												</v-list-tile-content>
												<v-list-tile-content class="align-end">{{ $dollar.format(squareTotalCollected) }}</v-list-tile-content>
											</v-list-tile>
										</v-list>
										<v-card-text :class="[defaultSummaryStyle, summary.class]">
											<span class="title">{{ summary.message }}</span>
										</v-card-text>
									</v-card>
								</v-flex>
								<v-flex md9>
									<existing-technician-sales></existing-technician-sales>
								</v-flex>
							</v-layout>
						</v-flex>
					</v-layout>
				</v-container>
			</v-content>
		</v-app>
	</div>

</template>

<script>
import TopNavigationBar from "Components/TopNavigationBar";
import SaleDatePicker from "Components/SaleDatePicker";
import ExistingTechnicianSales from "Components/ExistingTechnicianSales";

export default {
	name: "UpdateTechnicianSales",
	components: { TopNavigationBar, SaleDatePicker, ExistingTechnicianSales },
	data () {

		return {
			defaultSummaryStyle: "text-md-center white--text"
		};

	},
	computed: {
		title () {

			return this.$route.meta.title;

		},
		date () {

			return this.$store.getters["date"];

		},
		technicianSaleTotal () {

			return this.$store.getters["UpdateTechnicianSales/technicianSaleTotal"];

		},
		squareTotalCollected () {

			return this.$store.getters["Square/totalCollected"];

		},
		convenienceFee () {

			return this.$store.getters["Square/convenienceFee"];

		},
		giftCardRedeem () {

			return this.$store.getters["Square/giftCardRedeem"];

		},
		netTechnicianSaleTotal () {

			return this.technicianSaleTotal + parseFloat(this.convenienceFee.amount) - parseFloat(this.giftCardRedeem.amount) + parseFloat(this.giftCardSold.amount)

		},
		giftCardSold () {

			return this.$store.getters["Square/giftCardSold"];

		},
		summary () {

			let style = {};
			if (this.netTechnicianSaleTotal === this.squareTotalCollected) {

				style.message = "Match";
				style.class = "text-md-center white--text success";

			} else {

				style.message = "No Match " + this.$dollar.format(this.netTechnicianSaleTotal - this.squareTotalCollected);
				style.class = "text-md-center white--text warning";

			}
			return style;

		},
		hasSquareReceipts () {

			return this.$store.getters["Square/hasReceipts"];

		},

	},
	watch: {
		date () {

			this.$store.dispatch("UpdateTechnicianSales/init");

		}
	},
	created () {

		this.$store.dispatch("UpdateTechnicianSales/init");

	},
	methods: {

	},
};
</script>

<style scoped>

</style>
