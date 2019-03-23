import Vue from "vue";
import Plugins from "../plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	getTechnicians () {

		return Services.apiClient.get("/technicians");

	}
};
