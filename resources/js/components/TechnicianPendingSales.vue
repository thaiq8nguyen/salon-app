<template>
	<div id="technician-pending-sales">
		<v-card>
			<v-card-title>
				<span class="title">Pending Sales</span>
			</v-card-title>
			<v-divider></v-divider>
			<v-card-text>
				<v-list v-if="technicianSales.length">
					<v-list-tile>
						<v-list-tile-content></v-list-tile-content>
						<v-list-tile-action class="secondary_text--text subheading">Sale</v-list-tile-action>
						<v-list-tile-action class="secondary_text--text subheading ml-3">Tip</v-list-tile-action>
					</v-list-tile>
					<v-list-tile v-for="(technicianSale, key) in technicianSales" :key="key">
						<v-list-tile-avatar>
							<v-btn icon @click="deletePendingSale(technicianSale)"><v-icon class="primary--text">delete</v-icon></v-btn>
						</v-list-tile-avatar>
						<v-list-tile-content>{{ technicianSale.fullName }}</v-list-tile-content>
						<v-list-tile-action>
							<span>{{ $dollar.format(technicianSale.amount) }}</span>
						</v-list-tile-action>
						<v-list-tile-action class="ml-3">
							<span>{{ $dollar.format(technicianSale.tipAmount) }}</span>
						</v-list-tile-action>
					</v-list-tile>
					<v-list-tile>
						<v-list-tile-content>Total</v-list-tile-content>
						<v-list-tile-action>{{ $dollar.format(totalSaleAmount) }}</v-list-tile-action>
						<v-list-tile-action class="ml-3">{{ $dollar.format(totalTipAmount) }}</v-list-tile-action>
					</v-list-tile>
				</v-list>
				<v-card-text v-else class="text-md-center">
					<span class="subheading">No Pending Sales</span>
				</v-card-text>
				<v-divider></v-divider>
				<v-list>
					<v-list-tile v-show="existingTotalSaleAmount">
						<v-list-tile-content>Existing Sales</v-list-tile-content>
						<v-list-tile-action>{{ $dollar.format(existingTotalSaleAmount) }}</v-list-tile-action>
						<v-list-tile-action class="ml-3"></v-list-tile-action>
					</v-list-tile>
					<template v-if="hasSquareReceipts">
						<v-list-tile>
							<v-list-tile-content>{{ convenienceFee.name }}</v-list-tile-content>
							<v-list-tile-action>+&nbsp;{{ $dollar.format(convenienceFee.amount) }}</v-list-tile-action>
							<v-list-tile-action class="ml-3"></v-list-tile-action>
						</v-list-tile>
						<v-list-tile v-show="giftCardRedeem.amount > 0">
							<v-list-tile-content>{{ giftCardRedeem.name }}</v-list-tile-content>
							<v-list-tile-action>-&nbsp;{{ $dollar.format(giftCardRedeem.amount) }}</v-list-tile-action>
							<v-list-tile-action class="ml-3"></v-list-tile-action>
						</v-list-tile>
						<v-list-tile v-show="giftCardSold.amount > 0">
							<v-list-tile-content>{{ giftCardSold.name }}</v-list-tile-content>
							<v-list-tile-action>+&nbsp;{{ $dollar.format(giftCardSold.amount) }}</v-list-tile-action>
							<v-list-tile-action class="ml-3"></v-list-tile-action>
						</v-list-tile>
						<v-divider></v-divider>
						<v-list-tile :class="netTotalStyle">
							<v-list-tile-content>Net Total</v-list-tile-content>
							<v-list-tile-action>{{ $dollar.format(netTotalTechnicianSaleAmount) }}</v-list-tile-action>
							<v-list-tile-action class="ml-3"></v-list-tile-action>
						</v-list-tile>
					</template>
				</v-list>
				<v-card-text :class="[defaultSummaryStyle, summary.class]">
					<span class="title">{{ summary.result }}</span>
				</v-card-text>
			</v-card-text>
			<v-card-actions>
				<v-btn :disabled="!technicianSales.length" @click="deleteAllPendingSales">Clear</v-btn>
				<v-spacer></v-spacer>
				<v-btn class="info" :disabled="!technicianSales.length" @click="upload">Submit</v-btn>
			</v-card-actions>
		</v-card>
	</div>
</template>

<script>
export default {
	name: "TechnicianPendingSales",
	data () {

		return {
			defaultSummaryStyle: "text-md-center white--text",
		};

	},
	computed: {

		technicianSales () {

			return this.$store.getters["AddTechnicianSales/sales"];

		},
		totalSaleAmount () {

			return this.$store.getters["AddTechnicianSales/totalSaleAmount"];

		},
		totalTipAmount () {

			return this.$store.getters["AddTechnicianSales/totalTipAmount"];

		},
		existingTotalSaleAmount () {

			return this.$store.getters["AddTechnicianSales/existingTotalSaleAmount"];

		},
		hasSquareReceipts () {

			return this.$store.getters["Square/hasReceipts"];

		},
		convenienceFee () {

			return this.$store.getters["Square/convenienceFee"];

		},
		netTotalTechnicianSaleAmount () {

			return this.$store.getters["AddTechnicianSales/netTotalTechnicianSaleAmount"];

		},
		giftCardRedeem () {

			return this.$store.getters["Square/giftCardRedeem"];

		},
		giftCardSold () {

			return this.$store.getters["Square/giftCardSold"];

		},
		squareTotalCollected () {

			return this.$store.getters["Square/totalCollected"];

		},
		isMatched () {

			return this.$store.getters["AddTechnicianSales/isTechnicianSalesAndSquareMatched"];

		},
		summary () {

			let style = {};
			if (this.isMatched) {

				style.result = "Match";
				style.class = "text-md-center white--text success";

			} else {

				style.result = "No Match " + this.$dollar.format(this.netTotalTechnicianSaleAmount - this.squareTotalCollected);
				style.class = "text-md-center white--text warning";

			}
			return style;

		},
		netTotalStyle () {

			return {
				"warning white--text subheading": !this.isMatched
			}
		}

	},
	methods: {

		deletePendingSale (sale) {

			this.$store.dispatch("AddTechnicianSales/deletePendingSale", sale);

		},
		deleteAllPendingSales () {

			this.$store.dispatch("AddTechnicianSales/deleteAllPendingSales");

		},
		upload () {

			this.$store.dispatch("AddTechnicianSales/upload");

		},
	},
};
</script>

<style scoped>

</style>
