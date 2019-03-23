import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	get () {

		return Services.apiClient.get("/accounts");

	},
	add (account) {
		console.log(account);
		return Services.apiClient.post("/accounts", account);

	},

}
