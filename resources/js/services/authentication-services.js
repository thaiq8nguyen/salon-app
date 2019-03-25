import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	load () {

		if (Services.persistState.load()) {

			const auth = Services.persistState.load();

			return auth.Authentications.authentication;

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

		Services.persistentState.remove();

	}
};
