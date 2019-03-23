import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";
import Store from "Store";

Vue.use(VueRouter);

const router = new VueRouter({

	routes

});

router.beforeEach((to, from, next) => {

	if (to.meta.requiresAuth) {

		const isAuthenticated = Store.getters["Authentications/isAuthenticated"];

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
