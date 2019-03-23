import Vue from "vue";
import AuthenticationServices from "Services/authentication-services";
import Router from "Router";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	login ({ commit }, credential) {

		commit("SET_IS_AUTHENTICATING", true);

		return AuthenticationServices.login(credential)
			.then(response => {

				commit("SET_AUTHENTICATION", response.data.user);

				Router.push("dashboard");

			})
			.catch(errors => {

				if (errors.response.status === 401) {

					commit("SET_ERROR_MESSAGE", errors.response.data.message);

				}
				AuthenticationServices.removeAuthentication();

			})
			.then(() => {

				commit("SET_IS_AUTHENTICATING", false);

			});

	},

	logout ({ commit }) {

		return AuthenticationServices.logout()
			.then(response => {

				Router.push("logout");

				Services.persistState.remove("authentications");

				commit("RESET_AUTHENTICATION");

			})
			.catch(errors => {

				console.log(errors);

			});

	}
};
