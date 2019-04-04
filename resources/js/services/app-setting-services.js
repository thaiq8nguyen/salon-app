import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	getSettings () {

		return Services.apiClient.get("/settings");

	},

};
