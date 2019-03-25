import Vue from "vue";
import Plugins from "../plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {
	loadTechnicians () {

		if (Services.persistState.load()) {

			const state = Services.persistState.load();
			return state.Technicians;

		} else {

			return "";

		}

	},
	getTechnicians () {

		return Services.apiClient.get("/technicians");

	},
	addTechnician (technician) {

		return Services.apiClient.post("/technicians", technician);

	},
};
