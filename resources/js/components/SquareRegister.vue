<template>
	<div id="salon-sale">
		<v-card>
			<v-card-title>
				<span class="title">Square Register</span>
			</v-card-title>
			<v-divider></v-divider>
			<v-list v-if="hasReceipts">
				<v-list-tile v-for="paymentType in paymentTypes" :key="paymentType.id">
					<v-list-tile-content>{{ paymentType.name }}</v-list-tile-content>
					<v-list-tile-content class="align-end">{{ $dollar.format(paymentType.amount) }}</v-list-tile-content>
				</v-list-tile>
				<v-divider></v-divider>
				<v-list-tile :class="totalCollectedStyle">
					<v-list-tile-content>Total Collected:</v-list-tile-content>
					<v-list-tile-content class="align-end">{{ $dollar.format(totalCollected) }}</v-list-tile-content>
				</v-list-tile>
				<v-divider></v-divider>
				<v-list-tile>
					<v-list-tile-content>{{ creditCardTip.name }}</v-list-tile-content>
					<v-list-tile-content class="align-end">{{ $dollar.format(creditCardTip.amount) }}</v-list-tile-content>
				</v-list-tile>
				<v-divider></v-divider>
				<v-list-tile>
					<v-list-tile-content>Net Cash:</v-list-tile-content>
					<v-list-tile-content class="align-end">{{ $dollar.format(netCash) }}</v-list-tile-content>
				</v-list-tile>
			</v-list>
			<v-card-text v-else class="text-md-center">
				<span class="headline">No Sales Available</span>
			</v-card-text>
		</v-card>

	</div>
</template>

<script>
export default {
	name: "SquareRegister",
	data () {

		return {

		};

	},
	computed: {
		hasReceipts () {

			return this.$store.getters["Square/hasReceipts"];

		},
		paymentTypes () {

			return this.$store.getters["Square/paymentTypes"];

		},
		totalCollected () {

			return this.$store.getters["Square/totalCollected"];

		},
		creditCardTip () {

			return this.$store.getters["Square/creditCardTip"];

		},

		netCash () {

			return this.$store.getters["Square/netCash"];

		},
		loading () {

			return this.$store.getters["Square/loading"];

		},
		isMatched () {

			return this.$store.getters["AddTechnicianSales/isTechnicianSalesAndSquareMatched"];

		},
		hasNoExistingTechnicianSales () {

			return this.$store.getters["AddTechnicianSales/hasNoExistingTechnicianSales"];

		},
		totalCollectedStyle () {

			return {

				"warning white--text subheading": !this.isMatched

			};

		},
	},
	mounted () {

		this.$validator.localize("en", this.dictionary);

	},
	methods: {

		validate () {

			this.$validator.validateAll().then(result => {

				if (result) {

					this.redeemGiftCard();

				}

			});

		},

	},
};
</script>

<style scoped>

</style>
