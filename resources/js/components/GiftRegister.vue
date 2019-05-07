<template>
	<div id="gift-register">
		<v-card>
			<v-card-title>
				<span class="title">Gift Register</span>
			</v-card-title>
			<v-divider></v-divider>
			<v-list v-if="hasReceipts">
				<v-list-tile>
					<v-list-tile-avatar><v-icon @click="giftCardRedeemDialog = true">add</v-icon></v-list-tile-avatar>
					<v-list-tile-content>{{ giftCardRedeem.name }}</v-list-tile-content>
					<v-list-tile-content class="align-end">{{ $dollar.format(giftCardRedeem.amount) }}</v-list-tile-content>
				</v-list-tile>
				<v-list-tile>
					<v-list-tile-content>{{ giftCardSold.name }}</v-list-tile-content>
					<v-list-tile-content class="align-end">{{ $dollar.format(giftCardSold.amount) }}</v-list-tile-content>
				</v-list-tile>
			</v-list>
			<v-card-text v-else class="text-md-center">
				<span class="headline">No Sales Available</span>
			</v-card-text>
		</v-card>
		<v-dialog v-model="giftCardRedeemDialog" :max-width="500">
			<v-card>
				<v-card-title>
					<span class="title">Redeem Gift Card</span>
					<v-spacer></v-spacer>
					<v-btn icon @click="giftCardRedeemDialog = false"><v-icon>close</v-icon></v-btn>
				</v-card-title>
				<v-divider></v-divider>
				<v-form @submit.prevent="validate">
					<v-card-text>
						<v-text-field
								v-model.number="redeem.amount"
								v-validate="'required|numeric|between: 1,500'"
								label="Sale"
								type="number"
								:error-messages="errors.collect('amount')"
								data-vv-name="amount"
								name="amount"
								outline
						>
						</v-text-field>
					</v-card-text>
					<v-card-actions>
						<v-btn @click="giftCardRedeemDialog = false">Cancel</v-btn>
						<v-spacer></v-spacer>
						<v-btn class="info" type="submit" :loading="loading">Redeem</v-btn>
					</v-card-actions>
				</v-form>
			</v-card>
		</v-dialog>
	</div>

</template>

<script>
export default {
	name: "GiftRegister",
	data () {

		return {
			giftCardRedeemDialog: false,
			redeem: {
				receiptItemID: "",
				amount: ""
			},
			defaultRedeem: {
				receiptItemID: "",
				amount: ""
			},
			dictionary: {
				custom: {
					amount: {
						required: "Enter a redeem amount",
						numeric: "The redeem amount must be a number",
						between: "The redeem amount must be between $ 1 and $ 500"
					},
				}
			},
			loading: false,
		};

	},
	computed: {
		hasReceipts () {

			return this.$store.getters["Square/hasReceipts"];

		},
		giftCardRedeem () {

			return this.$store.getters["Square/giftCardRedeem"];

		},
		giftCardSold () {

			return this.$store.getters["Square/giftCardSold"];

		},

	},
	mounted () {

		this.$validator.localize("en", this.dictionary);

	},
	methods: {
		validate () {

			this.$validator.validateAll().then((result) => {

				if (result) {

					this.redeemGiftCard();

				}

			});

		},
		redeemGiftCard () {

			this.loading = true;
			this.$store.dispatch("Square/redeemGiftCard", { receiptItemID: this.giftCardRedeem.id, amount: this.redeem.amount })
				.then(response => {

					this.redeem = Object.assign("", this.defaultRedeem);
					this.$validator.reset();
					this.giftCardRedeemDialog = false;
					this.$store.dispatch("Square/getDailyReceipts");

				})
				.catch(errors => {

					console.log(errors);

				})
				.then(() => {

					this.loading = false;

				});

		}
	},
};
</script>

<style scoped>

</style>
