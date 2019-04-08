import Vue from "vue";
import Plugins from "../plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	getUnApprovedUsers () {

		return Services.apiClient.get("/users?filter=unapproved");

	},
	approveUser (userID) {

		return Services.apiClient.post("/users/" + userID + "/approve");

	},

};
