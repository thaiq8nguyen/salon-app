import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);
Vue.use(VueRouter);

const router = new VueRouter({

	routes

});

router.beforeEach((to, from, next) => {

	if (to.meta.requiresAuth) {

		const state = Services.persistState.load();
		const isAuthenticated = state.Authentications.authentication.accessToken;

		if (isAuthenticated) {

			next();

		} else {

			next({

				path: "/login"

			});

		}

	} else {

		next();

	}

});

export default router;
