import Vue from "vue";
import Plugins from "../plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	getDailyReceipts (date) {

		return Services.apiClient.get("/square-receipts?date=" + date);

	},

	redeemGiftCard (redeem) {

		return Services.apiClient.put("/square-receipt-items?receiptItemID=" + redeem.receiptItemID + "&amount=" + redeem.amount);

	}
};
