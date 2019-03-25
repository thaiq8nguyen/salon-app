import Vue from "vue";
import Plugins from "../plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {
	load () {

		if (Services.persistState.load("Technicians")) {

			return Services.persistState.load("Technicians");

		} else {

			return "";

		}

	},
	getTechnicians () {

		return Services.apiClient.get("/technicians");

	}
};
