export default {

	hasReceipts (state) {

		return state.receipts;

	},
	loading (state) {

		return state.loading;

	},
	paymentTypes (state) {

		if (state.receipts) {

			const items = state.receipts.receipt_items;
			return items.filter(function (item) {

				return item.name === "Cash Receipt" || item.name === "Credit Card Receipt" || item.name === "Other Receipt";

			});

		}

	},
	totalCollected (state, getters) {

		if (state.receipts) {

			const paymentTypes = getters.paymentTypes;
			return paymentTypes.reduce(function (sum, item) {

				return sum + parseFloat(item.amount);

			}, 0);

		} else {

			return 0;

		}

	},
	creditCardTip (state) {

		if (state.receipts) {

			const items = state.receipts.receipt_items;
			const tips = items.filter(function (item) {

				return item.name === "Credit Card Tip";

			});

			return tips[0];

		}

	},
	giftCardSold (state) {

		if (state.receipts) {

			const items = state.receipts.receipt_items;
			const giftCardSold = items.filter(function (item) {

				return item.name === "Gift Card Sold";

			});

			return giftCardSold[0];

		} else {

			return {
				name: "Gift Card Sold",
				amount: 0
			};

		}

	},
	giftCardRedeem (state) {

		if (state.receipts) {

			const items = state.receipts.receipt_items;
			const redeem = items.filter(function (item) {

				return item.name === "Gift Card Redeem";

			});

			return redeem[0];

		} else {

			return {
				name: "Gift Card Redeem",
				amount: 0
			};

		}

	},
	convenienceFee (state) {

		if (state.receipts) {

			const items = state.receipts.receipt_items;
			const fee = items.filter(function (item) {

				return item.name === "Convenience Fee";

			});

			return fee[0];

		} else {

			return {
				name: "Convenience Fee",
				amount: 0
			};

		}

	},

	netCash (state) {

		if (state.receipts) {

			const items = state.receipts.receipt_items;
			const net = items.filter(function (item) {

				return item.name === "Credit Card Tip" || item.name === "Cash Receipt";

			});

			return parseFloat(net[1].amount) - parseFloat(net[0].amount);

		} else {

			return 0;

		}

	},

};
