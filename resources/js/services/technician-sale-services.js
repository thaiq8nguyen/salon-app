import Vue from "vue";
import Plugins from "../plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	getTechniciansWithSale (date) {

		return Services.apiClient.get("/technician-sales?date=" + date + "&sales=yes");

	},

	getTechniciansWithNoSale (date) {

		return Services.apiClient.get("/technician-sales?date=" + date + "&sales=no");

	},

	upload (sales) {

		return Services.apiClient.post("/technician-sales", sales);

	},

	updateExistingSale (updatedSale) {

		return Services.apiClient.put("/technician-sales", updatedSale);

	},

	deleteExistingSale (saleID) {

		return Services.apiClient.delete("/technician-sales/" + saleID);

	}
};
