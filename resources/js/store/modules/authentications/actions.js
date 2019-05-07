import Vue from "vue";
import AuthenticationServices from "Services/authentication-services";
import Plugins from "Plugins";
import router from "Router";

let Services = new Vue();
Vue.use(Plugins);

export default {

	login ({ commit }, credential) {

		return new Promise((resolve, reject) => {

			return AuthenticationServices.login(credential)
				.then(response => {

					commit("SET_AUTHENTICATION", response.data.user);
					resolve(true);

				})
				.catch(errors => {

					if (errors.response) {

						if (errors.response.status === 401) {

							reject(errors.response.data.message);

						}

					}

					Services.persistState.remove();

				});

		});

	},

	logout ({ commit }) {

		return AuthenticationServices.logout()
			.then(response => {

				router.push({ name: "Login", query: { action: "logout" } });

				commit("RESET_AUTHENTICATION");

				Services.persistState.remove();

			})
			.catch(errors => {

				console.log(errors);

			});

	},

	register ({ commit }, user) {

		return new Promise((resolve, reject) => {

			return AuthenticationServices.register(user)
				.then(response => {

					resolve(response.data.user);

				})
				.catch(errors => {

					reject(errors);

				});

		});

	}
};
