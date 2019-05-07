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

	getTechnicianSalesByPeriod (date) {

		const month = Services.$moment(date);
		const begin = month.startOf("month").format("YYYY-MM-DD");
		const end = month.endOf("month").format("YYYY-MM-DD");
		return Services.apiClient.get("/technician-sales?period=yes&" + "begin=" + begin + "&end=" + end);

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
