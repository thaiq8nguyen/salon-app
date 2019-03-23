import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	load () {

		if (Services.persistState.load("authentications")) {

			return Services.persistState.load("authentications");

		} else {

			return "";

		}

	},

	login (credential) {

		return Services.apiClient.post("/login", credential);

	},

	logout () {

		return Services.apiClient.post("/logout");

	},

	user () {

		return Services.apiClient.get("/user");

	},
	removeAuthentication () {

		Services.persistentState.remove("authentications");

	}
};
