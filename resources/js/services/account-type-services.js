import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	get () {

		return Services.apiClient("/account-types");

	}
}
