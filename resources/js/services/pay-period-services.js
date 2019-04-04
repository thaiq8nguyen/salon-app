import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	getCurrent () {

		return Services.apiClient.get("/pay-periods?filter=current");

	},

};
